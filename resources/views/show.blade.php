@extends('layouts.snsapp')

@section('content')
    <button id="pan">おして</button>
    <div class="center">

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
                @auth
                    <!-- Review.phpに作ったisLikedByメソッドをここで使用 -->
                    @if (!$comment->isLikedBy(Auth::user()))
                        <span class="likes">
                            <i class="fa-solid fa-heart like-toggle" data-comment-id="{{ $comment->id }}"></i>
                            <span class="like-counter">{{ $comment->likes->count() }}</span>

                        </span><!-- /.likes -->
                    @else
                        <span class="likes">
                            <i class="fa-solid fa-heart like-toggle liked" data-comment-id="{{ $comment->id }}"></i>
                            <span class="like-counter">{{ $comment->likes->count() }}</span>
                        </span><!-- /.likes -->
                    @endif
                @endauth
                @guest
                    <span class="likes">
                        <i class="fa-solid fa-heart"></i>
                        <span class="like-counter">{{ $comment->likes->count() }}</span>
                    </span><!-- /.likes -->
                @endguest
                @if ($idd === $comment->user_id)
                    <a class="btn btn-outline-success" href="{{ route('cnt.edit', $comment->id) }}">編集</a>
                    <form action="{{ route('cmt.destroy', $comment->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        {{ method_field('delete') }}
                        <button class="btn btn-outline-danger" type="submit">削除</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="topic">
                <div class="p-3">
                    <p style="font-weight: bold">コメントはありません</p>
                </div>
            </div>
        @endforelse


        {{-- 送信 --}}
        <div class="form">
            <h2>コメント送信</h2>
            <form action="{{ route('cmt.store') }}" method="POST">
                @csrf
                @if (count($errors))
                    @foreach ($errors->all() as $error)
                        {{ $error }}
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
    </div>

@endsection
