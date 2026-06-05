<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Project Created',
            'data' => $project
        ],201);
    }

    public function show(Project $project)
    {
        return $project->load('user');
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Project Updated',
            'data' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Project Deleted'
        ]);
    }
}