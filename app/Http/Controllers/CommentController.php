<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Topic;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;


class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        // 保存処理
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->topic_id = $request->topic_id;
        $comment->comment_name = $request->comment_name;
        $comment->comment_message = $request->comment_message;
        $comment->save();
        // 前の画面に戻る
        return back();
    }
    public function destroy($id)
    {
        $comment  = Comment::find($id);
        $comment->delete();

        return back();
    }
    public function edit($id)
    {
        $idd = Auth::id();
        $comment  = Comment::find($id);
        $context    = ["comment" => $comment, "idd" => $idd];
        return view("editCnt", $context);
    }
    public function update(CommentRequest $request, $id)
    {

        Comment::find($id)->update($request->all());
        $comment  = Comment::find($id);
        $topic = Topic::findOrFail($comment->topic_id);
        $context    = ["topic" => $topic];
        return redirect(route("topics.show", $context));
    }
}
