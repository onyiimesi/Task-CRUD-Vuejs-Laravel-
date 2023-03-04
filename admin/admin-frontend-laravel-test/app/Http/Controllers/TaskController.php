<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $task = TaskResource::collection(Task::where('id', $user->id)->get());

        return [
            'status' => 'true',
            'message' => 'Task List',
            'data' => $task
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $request->validated($request->all());

        $user = Auth::user();

        $task = Task::create([
            'UserId' => $user->id,
            'TaskName' => $request->TaskName,
            'TaskDesc' => $request->TaskDesc,
        ]);

        return [
            'status' => 'true',
            'message' => 'Task created successfully',
            'data' => $task
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $tasks = new TaskResource($task);

        return [
            'status' => 'true',
            'message' => 'Task Details',
            'data' => $tasks
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        $tsk = new TaskResource($task);

        return [
            "status" => 'true',
            "message" => 'Updated Successfully',
            "data" => $tsk
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response(null, 204);
    }
}
