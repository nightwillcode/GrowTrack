<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // List all tasks for the current user
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        $allStatuses = Status::all();

        return view('tasks.index', compact('tasks','allStatuses'));
    }

    // Show form to create a new task
    public function create()
    {
        return view('tasks.create');
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    // Show one task
    public function show(Task $task)
    {
        $this->authorizeTask($task);
        return view('tasks.show', compact('task'));
    }

    // Show form to edit a task
    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        return view('tasks.edit', compact('task'));
    }

    // Update a task
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    // Delete a task
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    // Private helper to restrict access to user's own task
    private function authorizeTask(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Cek otorisasi
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'status_id' => 'required|exists:status,id',
        ]);

        $task->status_id = $request->status_id;
        $task->save();

        return back()->with('success', 'Task status updated.');
    }

}

