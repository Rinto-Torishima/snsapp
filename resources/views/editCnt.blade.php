@extends('layouts.snsapp')

@section('content')
    <div class="center">
        @if (count($errors))
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif


        @if ($idd === $comment->user_id)
            <div class="form">
                <form action="{{ route('cnt.update', $comment->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input id="ftop"class="form-control" type="text" name="comment_name" placeholder="名前"
                        value="{{ $comment->comment_name }}" required>
                    <textarea id="ftop" class="form-control" name="comment_message" rows="3" placeholder="コメント" required>{{ $comment->comment_message }}</textarea>
                    <input class="btn btn-outline-primary" type="submit" value="送信">
                </form>
            </div>
        @endif

    </div>
@endsection
