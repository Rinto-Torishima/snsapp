@extends('layouts.snsapp')

@section('content')
    <div class="center">
        @if (count($errors))
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
        <div class="form">
            <form action="{{ route('topics.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value={{ $idd }}>
                <input id="ftop" class="form-control" type="text" name="name" value="{{ old('name') }}"
                    placeholder="名前" required>
                <textarea id="ftop" class="form-control" name="content" rows="3" placeholder="コメント" required>{{ old('content') }}</textarea>
                <input class="btn btn-primary" type="submit" value="送信">
            </form>
        </div>
    </div>
@endsection
