<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function fetch(){
        $tasks = Task::select('content' , 'id' )->get();
        return response()->json($tasks);
    }

    public function create(Request $request){

        if($request->ajax())
        {
            $task = $request['task'];
            $temp = new Task();
            $temp->content = $task['content'];
            $temp->user_id = $request['id'];
            $temp->save();
            return response()->json($temp->only(['content' , 'id']));
        }
    }
    public function index($id)
    {
        $user = User::find($id);
        return view('dashboard.calendar', compact('user'));
    }

    public function destroy(Request $request)
    {
        if($request->ajax()) {
            Task::where('id', $request['id'])->delete();

        }
    }
}
