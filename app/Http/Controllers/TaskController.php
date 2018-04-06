<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\Entry;
use App\Task;
use Validator;

use Illuminate\Http\Request;

const LP='(';

class TaskController extends Controller {

    // constructor
    public function __construct()
    {
//        $this->middleware('auth');
    }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
//		$tasks = Task::orderBy('id', 'desc')->paginate(10);
        $sql = "select tasks.*,entries.title from tasks , entries where tasks.entry_id = entries.id order by id desc limit 10"; 
        $tasks = DB::select($sql);


//        \Log::debug(__METHOD__.print_r($tasks, true));

        return \Response::json($tasks);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// for select box
        $entries = \App\Entry::orderBy('id','desc')->pluck('title', 'id');
		$selected = $entries->keys()->first();

		return view('tasks.create', compact('entries', 'selected'));
	}

	/**
	 * Show the form for copy form id and create a new resource.
	 *
	 * @return Response
	 */
	public function copy($id)
	{

#       \Log::debug(__METHOD__.'():'.__LINE__." id=$id");

		$task = Task::findOrFail($id);

		// for select box
        $entries = \App\Entry::orderBy('id','desc')->pluck('title', 'id');
		$selected = $task->entry_id;

		return view('tasks.copy', compact('task', 'entries', 'selected'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'entry_id' => 'required|numeric|exists:entries,id',
            'log' => 'required|max:255',
            'task_day' => 'required',
            'task_hour' => 'required',
        ])->validate();

		$task = new Task();
		$task->entry_id = $request->input("entry_id");
        $task->log = $request->input("log");
        $task->task_day = $request->input("task_day");
        $task->task_hour = $request->input("task_hour");

		$task->save();

		return redirect()->route('tasks.index')->with('message', trans('created'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$task = Task::findOrFail($id);

		return view('tasks.show', compact('task'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$task = Task::findOrFail($id);

        $entries = \App\Entry::orderBy('id','desc')->pluck('title', 'id');
		$selected = $task->entry_id;

		return view('tasks.edit', compact('task', 'entries', 'selected'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
#       \Log::debug(__METHOD__.LP.RP.C.LP.__LINE__.RP.SP);
       \Log::debug(__METHOD__.'--1');
        $validator = Validator::make($request->all(), [
            'entry_id' => 'required|numeric|exists:entries,id',
            'log' => 'required|max:255',
            'task_day' => 'required',
            'task_hour' => 'required',
        ])->validate();

		$task = Task::findOrFail($id);

		$task->entry_id = $request->input("entry_id");
        $task->log = $request->input("log");
        $task->task_day = $request->input("task_day");
        $task->task_hour = $request->input("task_hour");
#        \Debugbar::info($task->job_date);

		$task->save();

		return redirect()->route('tasks.index')->with('message', trans('updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$task = Task::findOrFail($id);
		$task->delete();

		return redirect()->route('tasks.index')->with('message', trans('deleted'));
	}

	/**
	 * totaling
	 *
	 * @return Response
	 */
	public function total()
	{
        $sql ='select E.id, E.title, E.hour, sum(V.task_hour) as man_hour, count(E.id) as days, E.hour-sum(V.task_hour) as remain, E.pre, E.end, E.status from entries as E, tasks as V where E.id = V.entry_id group by E.id,E.title,E.hour,E.pre,E.end,E.status order by E.id,E.pre';
        $totals = DB::select($sql);
#        var_dump($totals);
        $sql_tasks ='select count(id) as days, sum(task_hour) as hour from tasks';
        $sql_entries ='select sum(hour) as hour from entries';
        $tasks = DB::select($sql_tasks);
        $entries = DB::select($sql_entries);
#        var_dump($tasks);
#        var_dump($entries);

        return view('tasks.total', compact('totals','entries', 'tasks'));
	}
}
