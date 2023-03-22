@extends('layouts.snsapp')

@section('content')
    <div class="center">
        <a href="{{ route('topics.index') }}">掲示板に戻る</a>
        <div style="background-color: rgb(231, 243, 234)" class="topic">
            <div class="text-secondary">{{ $topic->name }} さん</div>
            <hr>
            <div class="p-2">{!! nl2br(e($topic->content)) !!}</div>
            <div class="text-secondary">投稿日：{{ $topic->created_at }}</div>
            <div class="text-secondary"> コメント数：{{ $topic->comments->count() }}</div>
            @guest
                <div class="text-secondary"> いいねを押すには<a href="{{ route('login') }}">ログイン</a>する必要があります</div>
            @endguest
        </div>
        @forelse ($topic->comments as $comment)
            <div class="topic">
                <div class="text-secondary">{{ $comment->comment_name }} さん</div>
                <hr>
                <div class="p-2">{{ $comment->comment_message }}</div>
                <div class="tutumi">
                    @auth
                        <!-- Review.phpに作ったisLikedByメソッドをここで使用 -->
                        @if (!$comment->isLikedBy(Auth::user()))
                            <div class="likes">
                                <i class="fa-solid fa-heart like-toggle" data-comment-id="{{ $comment->id }}"></i>
                                <span class="like-counter badge bg-primary">{{ $comment->likes->count() }}</span>
                            </div><!-- /.likes -->
                        @else
                            <div class="likes">
                                <i class="fa-solid fa-heart like-toggle liked" data-comment-id="{{ $comment->id }}"></i>
                                <span class="like-counter badge bg-primary">{{ $comment->likes->count() }}</span>
                            </div><!-- /.likes -->
                        @endif
                    @endauth
                    @guest
                        <div class="likes">
                            <i class="fa-solid fa-heart"></i>
                            <span class="like-counter badge bg-primary">{{ $comment->likes->count() }}</span>
                        </div><!-- /.likes -->

                    @endguest
                    @if ($idd === $comment->user_id)
                        <div class="right ">
                            <a style="margin-right: 3px" class="btn btn-outline-success"
                                href="{{ route('cnt.edit', $comment->id) }}">編集</a>
                            <form action="{{ route('cmt.destroy', $comment->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                {{ method_field('delete') }}
                                <input class="btn btn-outline-danger log" type="submit" value="削除"></button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="topic">
                <div class="p-3">
                    <p style="font-weight: bold">コメントはありません</p>
                </div>
            </div>
        @endforelse


        {{-- 送信 --}}
        @if (!Auth::check())
            <div class="card">
                <div style="text-align: center" class="card-body bg-light">
                    ログインするとコメントを送信することができます
                </div>
            </div>
        @elseif(Auth::user() && !Auth::user()->hasVerifiedEmail())
            <div class="card">
                <div style="text-align: center" class="card-body bg-light">
                    メール認証を完了するとコメントを送信することができます
                </div>
            </div>
        @else
            <div class="form">
                <h2>コメント送信</h2>
                <form action="{{ route('cmt.store') }}" method="POST">
                    @csrf
                    @if (count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <input type="hidden" name="user_id" value={{ $idd }}>
                    <input type="hidden" name="topic_id" value={{ $topic->id }}>
                    <input id="ftop" class="form-control" value="{{ old('comment_name') }}" type="text"
                        name="comment_name" placeholder="投稿者" required>
                    <textarea id="ftop" rows="3" class="form-control" name="comment_message" placeholder="投稿内容" required>{{ old('comment_message') }}</textarea>
                    <input class="btn btn-outline-primary" type="submit" value="返信">
                </form>
            </div>
        @endif
    </div>

@endsection
