<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function fetch(){
        $events = Event::select('title' , 'id' , 'start' , 'end' , 'description')->get();
        return response()->json($events);
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            Task::where('id', $request['id'])->delete();

            $event = new Event();
            $event->id = $request['id'];
            $event->title = $request['title'];
            $event->start = $request['start'];
            $event->end = $request['end'];
            $event->description = "";
            $event->user_id = $request['user_id'];
            $event->save();

            return response()->json($event->only(['title', 'description', 'start', 'end', 'id']));
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $event = Event::find($request['id']);
            if ($request->has('description'))
                $event->description = $request['description'];
            else if ($request->has('start')) {
                $event->start = $request['start'];
                $event->end = $request['end'];
            } else
                $event->end = $request['end'];

            $event->save();
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            Task::withTrashed()->where('id', $request['id'])->restore();

            Event::where('id', $request['id'])->forceDelete();
            return response()->json($request['id']);

        }
    }
}
