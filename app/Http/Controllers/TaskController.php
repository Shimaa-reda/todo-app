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
        $tasks = Task::all();
        $editingTask=null;
        return view('tasks', compact('tasks', 'editingTask'));
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
        $request->validate([
            'title' => 'required|string|max:255|min:4',
            'description' => 'nullable|string',

        ]);
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => false,
        ]);

          return redirect()->route('tasks.index')->with('success', 'task added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $tasks = Task::all();
        $editingTask=$task;
        return view('tasks', compact('tasks', 'editingTask'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

        ]);
        $task=Task::findOrFail($task->id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
        ]);
        return redirect()->route('tasks.index')->with('success', 'task updated successfully');

    }
    public function toggle(Task $task)
{
    $task->update([
        'is_completed' => ! $task->is_completed
    ]);

    return redirect()->route('tasks.index')
        ->with('success', 'Task status updated');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task=Task::findOrFail($task->id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'task deleted successfully');

    }
}
