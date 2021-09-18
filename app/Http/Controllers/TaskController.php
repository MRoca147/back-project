<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        if($request->hasFile('upload_file')){
            $file = $request->file('upload_file');
            $filename  = 'file_' . uniqid() . '.' .  $file->getClientOriginalExtension();
            $url = Storage::putFileAs('public/uploads/tasks', $file, $filename);
            $request->merge(['file' => $url]);
        }
        $task = Task::create($request->all());
        return $this->response_success($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::with('activity')->find($id);
        return $this->response_success($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);
        if($request->hasFile('upload_file')){
            if($task->file != null){
                Storage::delete($task->file);
            }
            $file = $request->file('upload_file');
            $filename  = 'file_' . uniqid() . '.' .  $file->getClientOriginalExtension();
            $url = Storage::putFileAs('public/uploads/tasks', $file, $filename);
            $request->merge(['file' => $url]);
        }
        $task->update($request->all());
        return $this->response_success($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if($task->file != null){
            Storage::delete($task->file);
        }
        $task->delete();
        return $this->response_success([], 'Eliminado con exito');
    }

    public function completedTask($id)
    {
        $task = Task::with('activity')->find($id);
        if($task->completed == false){
            $task->update(['completed' => true]);
            $this->verifyActivity($task);
        }else{
            $task->update(['completed' => false]);
            $this->verifyActivity($task);
        }
        $task = Task::with('activity.tasks')->find($id);
        return $this->response_success($task);
    }

    public function verifyActivity($task)
    {
        $activity = Activity::with('tasks')->find($task->activity->id);
        $count = count($activity->tasks);
        $completed = 0;
        foreach($activity->tasks as $item){
            if($item->completed == 1){
                $completed++;
            }
        }
        if($completed == $count){
            $activity->update(['completed' => 1, 'completed_at' => today()]);
        }else{
            $activity->update(['completed' => 0, 'completed_at' => null]);
        }
    }
}
