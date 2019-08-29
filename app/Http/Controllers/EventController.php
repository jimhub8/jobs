<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Task;
use App\models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function events()
    {
        $events = Event::FirmId()->get();
        // $events = Event::FirmId()->get();
        // return $task_event = array('tasks' => $tasks, 'events' => $events);
        // return array_flatten($task_event);
        // $tasks = DB::table('tasks')->join('events','events.firm_id','=',Auth::user()->firm_id)->get();
        $events->transform(function ($event) {
            $event->title = $event->event;
            $event->details = ($event->priority) ? $event->priority : 'Low';
            $event->date = $event->event_date;
            $event->open = false;
            return $event;
        });
        return $events;
    }
    public function tasks()
    {
        $tasks = Task::FirmId()->get();
        // $events = Event::FirmId()->get();
        // return $task_event = array('tasks' => $tasks, 'events' => $events);
        // return array_flatten($task_event);
        // $tasks = DB::table('tasks')->join('events','events.firm_id','=',Auth::user()->firm_id)->get();
        $tasks->transform(function ($task) {
            $task->title = $task->task;
            $task->details = $task->priority;
            $task->date = $task->event_date;
            $task->open = false;
            return $task;
        });
        return $tasks;
    }
    public function store(Request $request)
    {
        // return $request->all();
        $event = new Event();
        $event->user_id = Auth::id();
        $event->event_date = Carbon::parse($request->event_date);
        $event->event = $request->event;
        $event->case_id = $request->id;
        $event->description = $request->description;
        $event->firm_id = Auth::user()->firm_id;
        $event->save();
        return $event;
    }
}
