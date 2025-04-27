<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function store(Request $request, Goal $goal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $goal->steps()->create([
            'title' => $request->title,
            'is_completed' => false,
        ]);

        return redirect()->route('goals.show', $goal)->with('success', 'Step added successfully!');
    }

    public function toggle(Goal $goal, Step $step)
    {
    $step->update([
        'is_completed' => !$step->is_completed,
    ]);

    return redirect()->route('goals.show', $goal);
    }

}
