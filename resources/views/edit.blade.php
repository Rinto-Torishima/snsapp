@extends('layouts.snsapp')

@section('content')
    <div class="center">
        @if (count($errors))
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif


        @if ($idd === $topic->user_id)
            <div class="form">
                <form action="{{ route('topics.update', $topic->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input id="ftop" class="form-control" type="text" name="name" placeholder="名前"
                        value="{{ $topic->name }}" required>
                    <textarea id="ftop" class="form-control" name="content" rows="3" placeholder="投稿内容" required>{{ $topic->content }}</textarea>
                    <input class="btn btn-outline-primary" type="submit" value="送信">
                </form>
            </div>
        @endif
    </div>

@endsection
