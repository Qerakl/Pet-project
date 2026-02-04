@extends('layouts.app')

@section('title', 'Ваши посты')

@section('content')

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h2 class="card-title">{{$post->title}}</h2>
                <p class="card-text">{{ $post->body }} </p>
            </div>
        </div>

@endsection
