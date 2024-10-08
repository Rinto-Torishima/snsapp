<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTopicRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\MessageBag;


class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idd = Auth::id();
        $topics = Topic::latest()->paginate(10);
        $context = ["topics" => $topics, "idd" => $idd];
        return view("index", $context);
    }
    public function welcome()
    {
        return redirect(route("topics.index"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idd = Auth::id();
        $context = ["idd" => $idd];
        return view("create", $context);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTopicRequest $request)
    {
        DB::beginTransaction();
        try {
            $topic = new Topic();
            $topic->user_id = $request->user_id;
            $topic->name = $request->name;
            $topic->content = $request->content;
            $topic->save();
    
            DB::commit();
    
            return redirect(route("topics.index"))->with('success', 'トピックが正常に作成されました。');
    
        } catch (Exception $e) {
            DB::rollBack();
    
            Log::error('トピックの作成に失敗しました: ' . $e->getMessage());

            $errors = ['トピックの作成中にエラーが発生しました。'];
            return redirect()->back()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idd = Auth::id();
        $topic = Topic::findOrFail($id);
        $context = ["idd" => $idd, "topic" => $topic];
        return view("show", $context);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idd = Auth::id();
        $topic = Topic::find($id);
        $context = ["topic" => $topic, "idd" => $idd];
        return view("edit", $context);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTopicRequest $request, $id)
    {
        Topic::find($id)->update($request->all());
        return redirect(route("topics.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);
        $topic->delete();
        $topic->comments()->delete();
        return redirect(route("topics.index"));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $idd = Auth::id();
        $query = Topic::latest();
        // 投稿者名かスレッド名で検索
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }        
        $topics = $query->paginate(10);
        $context = ["topics" => $topics, "idd" => $idd];
        return view("index", $context);
    }
}
