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

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('jobs.index', [
            'jobs' => Job::all()->sortBy('deadline'),
        ]); // for reference: return view('jobs.index', ['jobs' => Job::where([['listing_status', '=', JobStatus::Open],['deadline', '>', now()],])->get()->sortBy('deadline'),]);
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
            'date_of_creation' => ['required', 'date', 'date_equals:' . now()->format('Y-m-d\TH:i')],
            'deadline' => ['required', 'date', 'after:date_of_creation'],
            'skills' => 'required',
            'role_type' => 'required',
            'listing_status' => 'required',
        ]); // for reference: 'deadline' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')],

        // ensure all Job Listings created are Open - might wanna make changes to the workflow logic
        $validated['listing_status'] = JobStatus::Open;

        $job = $request->user()->jobs()->create($validated);

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

        return redirect(route('jobs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
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
            'flags' => 'required',
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', Job::class);

        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'deadline' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')],
            'skills' => 'required',
            'role_type' => 'required',
            'flags' => 'required'
        ]);

        $job->update($validated);

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

        return redirect(route('jobs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }

    public function apply(Request $request, Job $job): RedirectResponse
    {
        if (!(new Carbon($job->deadline))->isPast()) {
            $job->applicants()->attach($request->user());

            return redirect(route('jobs.index'))->with('status', 'job-applied');
        }

        return redirect(route('jobs.index'));
    }
}
