<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Auth;

class TasksController extends Controller
{
    
    private $task = null;
    
    # コンストラクタ
    public function __construct()
    {
        $this->task = new Task;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::check()) {
            // メッセージ一覧を取得
            $tasks = $this->task
                ->where('user_id', Auth::id())
                ->get();

            return view('tasks.index', [
                'tasks' => $tasks,    
            ]);
        } else{
            return view('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $this->task,    
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);

        // メッセージ作成
        $this->task->content = $request->content;
        $this->task->status = $request->status;
        $this->task->user_id = $request->user_id;
        $this->task->save();

        return redirect('/');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->task
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        // nullならばindexメソッドに飛ばす
        if(is_null($task)) {
            return redirect('/');
        }
        
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->task
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
            
        // nullならばindexメソッドに飛ばす
        if(is_null($task)) {
            return redirect('/');
        }
        
        return view('tasks.edit', [
            'task' => $task,    
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required'
        ]);

        $task = $this->task
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->task
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        return redirect('/');
    }
}
