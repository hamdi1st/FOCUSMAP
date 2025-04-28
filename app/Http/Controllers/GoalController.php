<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    
    
    public function index(Request $request)

     {
         $visibility = $request->query('visibility'); // Get filter from URL query parameter, if any

         $goals = Goal::where('user_id', Auth::id());
         if ($visibility) {
             $goals->where('visibility', $visibility);
         }

         $goals = $goals->get();
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
            'visibility' => 'required|in:private,public', // <-- Added validation for visibility
        ]);

        Goal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'progress' => 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'visibility' => $request->visibility, // <-- Save visibility
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

      public function destroy(Goal $goal)
       {
          // Make sure the user is the owner
          if ($goal->user_id !== Auth::id()) {
              abort(403, 'Unauthorized action.');
          }
      
          $goal->delete();
      
          return redirect()->route('goals.index')->with('success', 'Goal deleted successfully!');
        }
      
    
        public function edit(Goal $goal)
        {
            // Check if the user owns the goal
            if ($goal->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        
            return view('goals.edit', compact('goal'));
        }
    
    
        public function update(Request $request, Goal $goal)
        {
            if ($goal->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'nullable',
                'deadline' => 'nullable|date',
                'visibility' => 'required|in:private,public',
            ]);
        
            $goal->update([
                'title' => $request->title,
                'description' => $request->description,
                'deadline' => $request->deadline,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'visibility' => $request->visibility,
            ]);
        
            return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
        }

        public function mindmap(Goal $goal)
    {
        $goal->load('steps'); // Load steps with the goal
        return view('goals.mindmap', compact('goal'));
    }

        

}
