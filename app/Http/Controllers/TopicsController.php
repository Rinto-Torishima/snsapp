<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTopicRequest;
use App\Comment;


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

        $topics     = Topic::latest()->paginate(10);
        // $topics     = Topic::paginate(10);

        $context    = ["topics" => $topics, "idd" => $idd];

        return view("index", $context);
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
        // 保存処理
        $topic = new Topic();
        $topic->user_id = $request->user_id;
        $topic->name = $request->name;
        $topic->content = $request->content;
        $topic->save();

        return redirect(route("topics.index"));
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
        $topic  = Topic::find($id);
        $topic->delete();
        $topic->comments()->delete();
        return redirect(route("topics.index"));
    }
}
