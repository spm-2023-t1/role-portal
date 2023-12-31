<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;
use App\Models\Skill;
use App\Rules\AfterOrEqualCreatedDate;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Rules\UniqueId;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{

    public function index(Request $request)
    {
        $jobs = Job::query();
        
        // to sort jobs by deadline - desc
        $jobs = $jobs->orderBy('deadline', 'desc');

        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $jobs=$jobs->where(function ($query) use ($search) {
                $query->where('role_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
            $request->session()->put('search', $search);
        } else {
            // Reset the search value in the session
            $request->session()->forget('search');
        }

        if ($request->has('filter_role_type') && $request->input('filter_role_type') !== '') {
            $filter_role_types = $request->input('filter_role_type');
            $jobs=$jobs->whereIn('role_type', $filter_role_types);
                
            $request->session()->put('filter_role_type', $filter_role_types);
        } else {
            // Reset the filter value in the session
            $request->session()->forget('filter_role_type');
        }
        
        if ($request->has('filter_listing_status') && $request->input('filter_listing_status') !== '') {
            $filter_listing_statuses = $request->input('filter_listing_status');
            $jobs=$jobs->whereIn('listing_status', $filter_listing_statuses);
                
            $request->session()->put('filter_listing_status', $filter_listing_statuses);
        } else {
            // Reset the filter value in the session
            $request->session()->forget('filter_listing_status');
        }
        if ($request->has('filter_skill') && $request->input('filter_skill') !== '') {
            $filter_skills = $request->input('filter_skill');
            if (is_array($filter_skills) && count($filter_skills) > 0) {
                if (is_array($filter_skills) && count($filter_skills) > 0) {
                    $jobs=$jobs->whereHas('skills', function ($query) use ($filter_skills) {
                        $query->whereIn('skill_id', $filter_skills);
                    }, '=', count($filter_skills));
                }
                }
                

            $request->session()->put('filter_skill', $filter_skills);
        } else {
            // Reset the filter value in the session
            $request->session()->forget('filter_skill');
        }

        if ($request->has('start_date') || $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
        
            if (!empty($startDate)) {
                $jobs->where('deadline', '>=', $startDate);
            }
        
            if (!empty($endDate)) {
                $jobs->where('deadline', '<=', $endDate);
            }
        
            $request->session()->put('start_date', $startDate);
            $request->session()->put('end_date', $endDate);
        } else {
            // Reset the date range filter values in the session
            $request->session()->forget(['start_date', 'end_date']);
        }   


        $jobs = $jobs->get();

        return view('jobs.index', compact('jobs'), [
            'skills' => Skill::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE),
            'staff' => User::all()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Job::class);

    

        return view('jobs.create', [
            'job' => Job::all(),
            'skills' => Skill::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE),
            'viewers' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
            'users' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
            'managers' => User::where('role', 'manager')->get(),
            'hrs' => User::where('role', 'hr')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Job::class);
        
        $validated = $request->validate([
            'id' => ['required', 'integer', new UniqueId],
            'role_name' => 'required|string',
            'description' => 'required|string',
            'role_listing_open' => ['required', 'date', 'after_or_equal:now'],
            'deadline' => ['required', 'date', 'after_or_equal:role_listing_open'],
            'skills' => 'required',
            'role_type' => 'required',
            'listing_status' => [
                'required',
               
            ],
            'source_manager_id' => 'required',
            'staff_visibility' => 'required_if:listing_status,private',
            'is_released' => 'required|string'
        ]);

        $job = Job::create($validated);

        foreach ($request->skills as $skill) {
            $skill = Skill::find($skill);
            if ($skill != null) {
                $job->skills()->attach($skill);
            }
        }

        if ($request->staff_visibility) {
            foreach ($request->staff_visibility as $viewer) {
                $viewer = User::find($viewer);
                if ($viewer != null) {
                    $job->viewers()->attach($viewer);
                }
            }
        }

        $job->owner()->associate($request->user());
        $job->updater()->associate($request->user());
        $job->save();
        session()->flash('message', 'Job successfully created.');

        return redirect(route('jobs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show', [
            'job' => $job,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): View
    {
        $this->authorize('update', $job);

        return view('jobs.edit', [
            'job' => $job,
            'skills' => Skill::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE),
            'role_type' => 'required',
            'viewers' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
            'users' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
            'managers' => User::where('role', 'manager')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', Job::class);

        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'role_name' => 'required|string',
            'description' => 'required|string',
            'role_listing_open' => ['required', 'date', new AfterOrEqualCreatedDate($job->id)],
            'deadline' => ['required', 'date', 'after_or_equal:role_listing_open'],
            'skills' => 'required',
            'role_type' => 'required',
            
            'listing_status' => [
                'required',
                
            ],
            'source_manager_id' => 'required',
            'staff_visibility' => 'required_if:listing_status,private',
            'is_released' => 'required|string'
        ]);

        foreach ($job->skills as $skill) {
            $skill = Skill::find($skill);
            $job->skills()->detach($skill);
        }

        foreach ($request->skills as $skill) {
            $skill = Skill::find($skill);
            if ($skill != null) {
                $job->skills()->attach($skill);
            }
        }

        if($job->viewers){
            foreach ($job->viewers as $v) {
                $v = User::find($v);
                $job->viewers()->detach($v);
            }
        }

        if ($request->staff_visibility) {
            foreach ($request->staff_visibility as $viewer) {
                $viewer = User::find($viewer);
                if ($viewer != null) {
                    $job->viewers()->attach($viewer);
                }
            }
        }

        $job->update($validated);
        $job->updater()->associate($request->user());
        $job->save();
        
        session()->flash('message', 'Job successfully updated.');

        return redirect(route('jobs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
{
    $job->delete();
    return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
}

    public function apply(Request $request, Job $job): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'start_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:500',
            'role_app_status' => 'required|in:applied,withdrawn',
        ]);

        $user->applications()->attach($job, [
            'start_date' => $request->start_date,
            'remarks' => $request->remarks,
            'role_app_status' => $request->role_app_status,
        ]);

        
        return redirect()->route('jobs.index')->with('success', 'Job application submitted successfully.');
    }

    public function withdraw(Job $job)
    {
        
        $user = Auth::user();
        
        $applications = collect($user->applications);

        foreach($applications as $application) {
            if($application->id == $job->id) {
                if($application->pivot->role_app_status == 'applied') {
                    $application->pivot->update(['role_app_status' => 'withdrawn']);
                    return redirect()->back()->with('success', 'Application has been withdrawn.');
                }
            }
        }

    }


    public function handle()
    {
        $listings = Job::where('listing_status', 'open')
            ->whereDate('deadline', '<', now())
            ->get();

        foreach ($listings as $listing) {
            $listing->update(['listing_status' => 'closed']);
        }

        $this->info('Listing statuses updated successfully.');
    }

}
