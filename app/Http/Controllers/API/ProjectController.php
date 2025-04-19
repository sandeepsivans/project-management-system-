<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project_Management;
use App\Models\Task_Management;
use App\Models\Task_Remarks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project_Management::with('tasks', 'tasks.remarks')->where('user_id', Auth::id())->get();

        return response()->json($projects);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }


        $data = $validator->validated();
        $project = Project_Management::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project,
        ], 201);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $project = Project_Management::findOrFail($id);
     
        if ($project->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }




        $data = $validator->validated();

        $project->update($data);
        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project,
        ], 200);
    }


    public function destroy($id)
    {

        $project = Project_Management::findOrFail($id);

        if ($project->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }



    public function report($id)
    {
        $project = Project_Management::with(['tasks', 'tasks.remarks'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'project' => $project,
            'tasks' => $project->tasks,
            'daily_remarks' => $project->dailyRemarks
        ]);
    }
}
