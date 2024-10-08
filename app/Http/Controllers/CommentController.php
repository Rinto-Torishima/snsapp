<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Topic;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Like;


class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->topic_id = $request->topic_id;
        $comment->comment_name = $request->comment_name;
        $comment->comment_message = $request->comment_message;
        $comment->save();
        return back();
    }
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return back();
    }
    public function edit($id)
    {
        $idd = Auth::id();
        $comment = Comment::find($id);
        $context = ["comment" => $comment, "idd" => $idd];
        return view("editCnt", $context);
    }
    public function update(CommentRequest $request, $id)
    {

        Comment::find($id)->update($request->all());
        $comment = Comment::find($id);
        $topic = Topic::findOrFail($comment->topic_id);
        $context = ["topic" => $topic];
        return redirect(route("topics.show", $context));
    }
    public function like(Request $request)
    {
        $user_id = Auth::user()->id;
        $comment_id = $request->comment_id;
        // すでにいいねを押しているかをチェック
        $already_liked = Like::where('user_id', $user_id)->where('comment_id', $comment_id)->first();
        if (!$already_liked) {
            $like = new Like;
            $like->comment_id = $comment_id;
            $like->user_id = $user_id;
            $like->save();
        } else {
            Like::where('comment_id', $comment_id)->where('user_id', $user_id)->delete();
        }
        // この投稿の最新の総いいね数を取得
        $comment_likes_count = Comment::withCount('likes')->findOrFail($comment_id)->likes_count;
        $param = [
            'comment_likes_count' => $comment_likes_count,
        ];
        return response()->json($param);
    }
}
