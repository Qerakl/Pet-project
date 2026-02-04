@extends('layouts.app')

@section('title', 'Создание поста')

@section('content')
    <h1>Обновление поста</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   id="title"
                   name="title"
                   value="{{ $post->title }}">
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Текст поста</label>
            <textarea class="form-control @error('body') is-invalid @enderror"
                      id="body"
                      name="body"
                      rows="5">{{ $post->body}}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
@endsection
