<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;




class TaskController extends Controller
{
    
    public function index()
    {
        // Retrieve tasks only for the authenticated user
        $tasks = Auth::user()->tasks()->orderBy('created_at', 'desc')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|in:pending,in_progress,completed',
    ]);

    // Create a new task instance with the validated data
    $task = new Task();
    $task->title = $validatedData['title'];
    $task->description = $validatedData['description'];
    $task->status = $validatedData['status'];

    // Associate the task with the authenticated user
    Auth::user()->tasks()->save($task);

    // Optionally, you might want to redirect somewhere after saving
    return redirect()->route('tasks.index')
                     ->with('success', 'Task created successfully!');
}

    public function edit(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Update the task instance with the validated data
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->status = $validatedData['status'];
        $task->save();

        // Optionally, you might want to redirect somewhere after updating
        return redirect()->route('tasks.index')
                         ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        // Optionally, you might want to redirect somewhere after deleting
        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully!');
    }

    // Other methods as needed
    
    //
}
