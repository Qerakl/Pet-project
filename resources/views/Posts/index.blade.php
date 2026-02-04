@extends('layouts.app')

@section('title', 'Ваши посты')

@section('content')

    <a href="{{route('posts.create')}}">Создать пост</a>
    @foreach($posts as $post)
        <div class="card" style="width: 18rem;">
            <a href="{{route('posts.edit', $post)}}">Обновить</a>
            <form action="{{route('posts.destroy', $post)}}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" style="color: red">Удалить</button>
            </form>
            <div class="card-body">
                <a href="{{route('posts.show', $post)}}"><h5 class="card-title">{{$post->title}}</h5></a>
                <p class="card-text">{{ str($post->body)->limit(15) }} </p>
            </div>
        </div>
    @endforeach

@endsection
