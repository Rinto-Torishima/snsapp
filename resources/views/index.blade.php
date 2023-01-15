@extends('layouts.snsapp')

@section('content')
    <div class="center">
        @if ($idd == false)
            <a id="ftop" class="btn btn-outline-primary" href="{{ route('login') }}">ログイン</a>
            <a id="ftop" class="btn btn-outline-primary" href="{{ route('register') }}">新規登録</a>
        @else
            <form action="{{ route('logout') }}" method="POST" style="display:inline-block;">
                @csrf
                <input id="ftop" class="btn btn-outline-primary" type="submit" value="ログアウト">

            </form>
        @endif
        <a id="ftop" class="btn btn-outline-success" href="{{ route('topics.create') }}">＋ トピックを作る</a>

        @forelse($topics as $topic)
            <div class="topic">
                <div class="text-secondary">{{ $topic->name }} さん</div>
                <hr>
                <div class="p-2">{!! nl2br(e($topic->content)) !!}</div>
                <div class="text-secondary">投稿日：{{ $topic->created_at }}</div>
                <div class="text-secondary"> コメント数：{{ $topic->comments->count() }}</div>
                <a class="btn btn-outline-primary" href="{{ route('topics.show', $topic->id) }}">詳細</a>
                @if ($idd === $topic->user_id)
                    <a class="btn btn-outline-success" href="{{ route('topics.edit', $topic->id) }}">編集</a>
                    <form action="{{ route('topics.destroy', $topic->id) }}/" method="POST" style="display:inline-block;">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button class="btn btn-outline-danger" type="submit">削除</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="topic">
                <div class="p-3">
                    <p style="font-weight: bold">投稿はありません</p>
                </div>
            </div>
        @endforelse
        {{ $topics->links('pagination.bootstrap-4') }}


    </div>
@endsection
