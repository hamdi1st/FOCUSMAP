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

        $goal->updateProgress();

        return redirect()->route('goals.show', $goal)->with('success', 'Step added successfully!');
    }

    public function toggle(Goal $goal, Step $step)
    {
        $step->is_completed = !$step->is_completed;
        $step->save();

        $goal->updateProgress();

        return redirect()->route('goals.show', $goal)->with('success', 'Step updated.');
    }

    public function destroy(Goal $goal, Step $step)
    {
        $step->delete();

        $goal->updateProgress();

        return redirect()->route('goals.show', $goal)->with('success', 'Step deleted successfully.');
    }
}
