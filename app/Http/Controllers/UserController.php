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
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $users = User::query();
        

        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $users=$users->where(function ($query) use ($search) {
                $query->where('fname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('dept', 'like', '%' . $search . '%')
                    ->orWhere('lname', 'like', '%' . $search . '%');
            });
            $request->session()->put('search', $search);
        } else {
            // Reset the search value in the session
            $request->session()->forget('search');
        }

        if ($request->has('filter_role') && $request->input('filter_role') !== '') {
            $filter_roles = $request->input('filter_role');
            $roles=$users->whereIn('role', $filter_roles);
            
            $request->session()->put('filter_role', $filter_roles);
        } else {
            // Reset the filter value in the session
            $request->session()->forget('filter_role');
        }

        if ($request->has('filter_skill') && $request->input('filter_skill') !== '') {
            $filter_skills = $request->input('filter_skill');
            if (is_array($filter_skills) && count($filter_skills) > 0) {
                if (is_array($filter_skills) && count($filter_skills) > 0) {
                    $users=$users->whereHas('skills', function ($query) use ($filter_skills) {
                        $query->whereIn('skill_id', $filter_skills);
                    }, '=', count($filter_skills));
                }
                }
                

            $request->session()->put('filter_skill', $filter_skills);
        } else {
            // Reset the filter value in the session
            $request->session()->forget('filter_skill');
        }

         $users = $users->get();

       
        return view('users.index', compact('users'),[
            'users' => User::all()->sortBy('fname', SORT_NATURAL|SORT_FLAG_CASE),
            'skills' => Skill::all()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE),
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
            'managers' => User::where('role', 'manager')->get(),

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
            'reporting_officer_id' => 'required|string',
            

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
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
