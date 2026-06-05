<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::with([
            'project',
            'assignedUser'
        ])->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $task = Task::create($request->all());

        return response()->json([
            'message' => 'Task Created',
            'data' => $task
        ],201);
    }

            public function show(Task $task)
        {
            return $task->load([
                'project',
                'assignedUser'
            ]);
        }

        public function update(
            Request $request,
            Task $task
        )
        {
            $task->update($request->all());

            return response()->json([
                'message' => 'Task Updated',
                'data' => $task
            ]);
        }

        public function destroy(Task $task)
        {
            $task->delete();

            return response()->json([
                'message' => 'Task Deleted'
            ]);
        }
    }

