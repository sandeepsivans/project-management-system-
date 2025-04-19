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

class TaskController extends Controller
{

    public function show($id)
{
    $task = Task_Management::where('project_id', $id)->get();

    return response()->json($task);
}

  
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer', 
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
        $task = Task_Management::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'project_id' =>$data['project_id'],
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer', 
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'nullable|string|max:50',
            'remark' => 'nullable|string|max:1000',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = Task_Management::findOrFail($id);
       
      

        $data = $validator->validated();

        $updateData = [
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ];
        
        if (isset($data['status'])) {
            $updateData['status'] = $data['status'];
        }
        $task->update($updateData);

        if (!empty($data['remark'])) {
            Task_Remarks::create([
                'task_id' => $task->id,
                'remarks' => $data['remark'], 
            ]);
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ], 200);
    }

    public function destroy($id)
    {

        $task = Task_Management::findOrFail($id);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    // Task Remarks----------------------------------



    public function remark_show($id)
    {
        $task_remark = Task_Remarks::where('task_id', $id)->get();
    
        return response()->json($task_remark);
    }
    
      
        public function remark_create(Request $request)
        {
    
            $validator = Validator::make($request->all(), [
                'task_id' => 'required|integer', 
                'remarks' => 'required|string|max:1000',
             
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $data = $validator->validated();
            $task_remark = Task_Remarks::create([
             
                'remarks' => $data['remarks'],
                'task_id' =>$data['task_id'],
            ]);
    
            return response()->json([
                'message' => 'Task remark created successfully',
                'task' => $task_remark,
            ], 201);
        }
    
        public function remark_update(Request $request, $id)
        {
    
            $validator = Validator::make($request->all(), [
                'task_id' => 'required|integer', 
                'remarks' => 'required|string|max:1000',
            ]);
    
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $task_remark = Task_Remarks::findOrFail($id);
           
          

            $data = $validator->validated();
    
            $task_remark->update($data);
            return response()->json([
                'message' => 'Task remark updated successfully',
                'task_remark' => $task_remark,
            ], 200);
        }
    
        public function remark_destroy($id)
        {
    
            $task_remark = Task_Remarks::findOrFail($id);
    
            $task_remark->delete();
    
            return response()->json(['message' => 'Task remark deleted successfully']);
        }

}
