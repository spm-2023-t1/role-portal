<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\User;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Rules\UniqueId;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;


class JobController extends Controller
{
    // protected $signature = 'listings:update-status';
    /**
     * Display a listing of the resource.
     */
    // public function index(): View
    // {
    //     return view('jobs.index', [
    //         'jobs' => Job::all()->sortBy('deadline'),
    //         // ['user_name' => User::with('user_id')->get()]
    //     ]); // for reference: return view('jobs.index', ['jobs' => Job::where([['listing_status', '=', JobStatus::Open],['deadline', '>', now()],])->get()->sortBy('deadline'),]);
    // }

    public function index(Request $request)
    {
        $jobs = Job::query();
        // $skills = Skill::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);

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
                // Example: $jobs->whereIn('category', $filters);
            
            $request->session()->put('filter_role_type', $filter_role_types);
        } else {
            // Reset the filter value in the session
            $request->session()->forget('filter_role_type');
        }
        
        if ($request->has('filter_listing_status') && $request->input('filter_listing_status') !== '') {
            $filter_listing_statuses = $request->input('filter_listing_status');
            $jobs=$jobs->whereIn('listing_status', $filter_listing_statuses);
                // Example: $jobs->whereIn('category', $filters);
            
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
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Job::class);

        return view('jobs.create', [
            'skills' => Skill::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE),
            'viewers' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE)
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
            'deadline' => ['required', 'date', 'after:now'],
            'skills' => 'required',
            'role_type' => 'required',
            'listing_status' => 'required',
        ]); // for reference: 'deadline' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')],

        // ensure all Job Listings created are Open - might wanna make changes to the workflow logic
        $validated['listing_status'] = JobStatus::Open;

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
            'viewers' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE)
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
            'deadline' => ['required', 'date', 'after:now'],
            'skills' => 'required',
            'role_type' => 'required',
            'listing_status' => 'required',
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
        if (!(new Carbon($job->deadline))->isPast()) {
            $job->applicants()->attach($request->user());

            return redirect(route('jobs.index'))->with('status', 'job-applied');
        }
        
        
        return redirect(route('jobs.index'));

        // if(!$job->applicants->contains($request->user()) && !(new Carbon($job->deadline))->isPast()) {
        //     dd($request);
        //     $job->applicants()->attach($request->user());
            
        //     return redirect(route('jobs.index'))->with('status', 'job-applied');
        // }

        // return redirect(route('jobs.index'));
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
