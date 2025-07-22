<?php
// app/Http/Controllers/TaskController.php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query  = Task::query();

        if (in_array($status, ['todo', 'inprogress', 'done'])) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return view('tasks.index', compact('tasks', 'status'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment'  => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        Task::create($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:todo,inprogress,done',
            'attachment'  => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            // delete old file
            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $task->update($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if ($task->attachment) {
            Storage::disk('public')->delete($task->attachment);
        }
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Task deleted successfully.');
    }
}