<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with([
            'user',
            'task'
        ])->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required'
        ]);

        $comment = Comment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        return response()->json([
            'message' => 'Comment Added',
            'data' => $comment
        ],201);
    }

    public function show(Comment $comment)
    {
        return $comment->load([
            'user',
            'task'
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'message' => 'Comment Deleted'
        ]);
    }
}