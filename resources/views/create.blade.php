@extends('layouts.snsapp')

@section('content')
<div class="center">
    <a href="{{ route('topics.index') }}">掲示板に戻る</a>

    @if (!empty($errors))
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    @if (!Auth::check())
        <div class="card">
            <div style="text-align: center" class="card-body bg-light">
                ログインするとトピックを投稿することができます </div>
        </div>
    @elseif(Auth::user() && !Auth::user()->hasVerifiedEmail() && is_null(Auth::user()->google_id))
        <div class="card">
            <div style="text-align: center" class="card-body bg-light">
                メール認証を完了するとトピックを投稿することができます </div>
        </div>
    @else
        <div class="form">
            <form action="{{ route('topics.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value={{ $idd }}>
                <input id="ftop" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="名前"
                    required>
                <textarea id="ftop" class="form-control" name="content" rows="3" placeholder="コメント"
                    required>{{ old('content') }}</textarea>
                <input class="btn btn-outline-primary" type="submit" value="送信">
            </form>
        </div>
    @endif
</div>
@endsection