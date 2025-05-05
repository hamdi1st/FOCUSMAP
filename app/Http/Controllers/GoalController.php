<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'visibility' => 'required|in:private,public',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = [
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'progress' => 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'visibility' => $request->visibility,
        ];
    
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('goal_images', 'public');
        }
    
        Goal::create($data);
    
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    $data = [
        'title' => $request->title,
        'description' => $request->description,
        'deadline' => $request->deadline,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'visibility' => $request->visibility,
    ];

    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($goal->image_path) {
            Storage::disk('public')->delete($goal->image_path);
        }

        // Store new image
        $data['image_path'] = $request->file('image')->store('goal_images', 'public');
    }

    $goal->update($data);

    return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
}

        
     public function publicGoals(){

    $publicGoals = Goal::where('visibility', 'public')->latest()->paginate(10);
    return view('goals.public', compact('publicGoals'));
}


}
