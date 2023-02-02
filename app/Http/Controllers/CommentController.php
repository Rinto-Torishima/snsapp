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
    // ajax
    public function like(Request $request)
    {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $comment_id = $request->comment_id; //2.投稿idの取得
        $already_liked = Like::where('user_id', $user_id)->where('comment_id', $comment_id)->first(); //3.

        if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            $like = new Like; //4.Likeクラスのインスタンスを作成
            $like->comment_id = $comment_id; //Likeインスタンスにreview_id,user_idをセット
            $like->user_id = $user_id;
            $like->save();
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
            Like::where('comment_id', $comment_id)->where('user_id', $user_id)->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $comment_likes_count = Comment::withCount('likes')->findOrFail($comment_id)->likes_count;
        $param = [
            'comment_likes_count' => $comment_likes_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }
}
