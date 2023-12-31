<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Skill::class);
        
        $skills = Skill::query();
        
        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $skills=$skills->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
            $request->session()->put('search', $search);
        } else {
            // Reset the search value in the session
            $request->session()->forget('search');
        }

        $skills = $skills->get();

        return view('skills.index', compact('skills'), [
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Skill::class);

        return view('skills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Skill::class);

        $validated = $request->validate([
            'name' => 'required|string',
            'created_by' => 'required',
            'updated_by' => 'required',

        ]);

        Skill::create($validated);

        return redirect(route('skills.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill): View
    {
        $this->authorize('update', $skill);

        return view('skills.edit', [
            'skill' => $skill,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $this->authorize('update', $skill);

        $validated = $request->validate([
            'name' => 'required|string',
            'updated_by' => 'required',
        ]);

        $skill->update($validated);

        return redirect(route('skills.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }
}
