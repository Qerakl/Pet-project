@extends('layouts.app')

@section('title', 'Обновление данных')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger" style="color: red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('update.user', Auth::user()->id)}}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Имя</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" value="{{$name}}">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{$email}}">
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>

@endsection
