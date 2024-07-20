@extends('layouts.snsapp')

@section('content')
<div class="center">
    @if (Auth::user() && !Auth::user()->hasVerifiedEmail())
        @if (session('resent'))
            <div class="alert alert-success" style="margin-top: 1rem" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 mb-1 align-baseline">{{ __('click here to request another')
                }}</button>
        </form>
    @endif
    {{-- 0pxにする親要素 --}}
    <div class="concon">
        @guest
            <a style="margin-right: 3px" class="btn btn-outline-primary" href="{{ route('login') }}">ログイン</a>
            <a style="margin-right: 3px" class="btn btn-outline-primary" href="{{ route('register') }}">新規登録</a>
        @endguest
        @auth
            <form action="{{ route('logout') }}" method="POST" style="display:inline-block;">
                @csrf
                <input class="btn btn-outline-primary log" type="submit" value="ログアウト">
            </form>
        @endauth

        <a class="btn btn-outline-success" href="{{ route('topics.create') }}">＋ トピックを作る</a>
    </div>

    @if (session('status'))
        <div style="margin-top: 8px" class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{route('topics.search')}}" method="GET">
        <input type="text" name="keyword" value="" placeholder="投稿者名かスレッド名で検索" class="form-control my-2">
        <button type="submit" class="btn btn-outline-primary">検索</button>
    </form>
    @forelse($topics as $topic)
        <div class="topic">
            <div class="text-secondary">{{ $topic->name }} さん</div>
            <hr>
            <div class="p-2">{!! nl2br(e($topic->content)) !!}</div>
            <div class="text-secondary">投稿日：{{ $topic->created_at }}</div>
            <div class="text-secondary"> コメント数：{{ $topic->comments->count() }}</div>
            {{-- 横並びにさせる --}}
            <div style="display: flex">
                <a style="margin-right: 3px" class="btn btn-outline-primary"
                    href="{{ route('topics.show', $topic->id) }}">詳細</a>

                @if ($idd === $topic->user_id)
                    {{-- 0pxにする親要素 --}}
                    <div class="concon">
                        <a class="btn  btn-outline-success" style="margin-right: 3px;"
                            href="{{ route('topics.edit', $topic->id) }}">編集</a>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            {{ method_field('delete') }}
                            <input class="btn btn-outline-danger log" type="submit" value="削除"></button>
                    </div>

                    </form>
                @endif
            </div>
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