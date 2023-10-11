<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view('users.index', [
            'users' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
        ]);

        return view('jobs.index', [
            'users' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'skills' => Skill::all()->sortBy('fname', SORT_NATURAL | SORT_FLAG_CASE),
            

        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', User::class);

        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|string',
            'skills' => 'required',
            

        ]);

        $user->update($validated);

        foreach ($user->skills as $skill) {
            $skill = Skill::find($skill);
            $user->skills()->detach($skill);
        }

        foreach ($request->skills as $skill) {
            $skill = Skill::find($skill);
            if ($skill != null) {
                $user->skills()->attach($skill);
            }
        }

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
