<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'deadline' => 'nullable|date',
        ]);

        Goal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'progress' => 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        

        return redirect()->route('goals.index')->with('success', 'Goal created successfully!');
    }

    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    public function map()
      {
        $goals = Goal::where('user_id', Auth::id())
                 ->whereNotNull('latitude')
                 ->whereNotNull('longitude')
                 ->get();

         return view('goals.map', compact('goals'));
      }


}
