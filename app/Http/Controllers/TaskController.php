<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $tasks = auth()->user()->tasks;
        return view('tasks.index', compact('tasks'));
        

    }

    public function hasTasks()
        {
            return $this->tasks()->exists();
        }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $task->delete();
      return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}