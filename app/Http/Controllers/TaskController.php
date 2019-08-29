<?php

namespace App\Http\Controllers;

use App\models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::latest()->FirmId()->paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $task = new Task;
        $task->user_id = Auth::id();
        $task->firm_id = Auth::user()->firm_id;
        $task->event = $request->task;
        $task->task = $request->task;
        $task->description = $request->description;
        $task->assigned_to = $request->assigned_to;
        $task->case = $request->case;
        $task->priority = $request->priority;
        $task->event_date = Carbon::parse($request->due_date);
        $task->save();
        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Task::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $task = Task::find($id);
        $task->task = $request->task;
        $task->assigned_to = $request->assigned_to;
        $task->case = $request->case;
        $task->priority = $request->priority;
        $task->event_date = Carbon::parse($request->due_date);
        $task->firm_id = Auth::user()->firm_id;
        $task->save();
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
    }
}
