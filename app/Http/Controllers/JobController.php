<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('jobs.index', [
            'jobs' => Job::where([
                ['status', '=', JobStatus::Open],
                ['deadline', '>', now()],
            ])->get()->sortBy('deadline'),
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'deadline' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')],
            'skills' => 'required'
        ]);

        $validated['status'] = JobStatus::Open;

        $job = $request->user()->jobs()->create($validated);

        foreach ($request->skills as $skill) {
            $skill = Skill::find($skill);
            if ($skill != null) {
                $job->skills()->attach($skill);
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
            'skills' => 'required'
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
}
