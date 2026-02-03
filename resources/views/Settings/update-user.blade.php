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

    <form action="{{route('update.user', Auth::user()->id)}}" method="post" autocomplete="off">
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

    <form action="{{ route('update.user.password') }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Текущий пароль</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Новый пароль</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- ОБЯЗАТЕЛЬНОЕ ПОЛЕ ДЛЯ ПРАВИЛА 'confirmed' --}}
        <div class="mb-3">
            <label class="form-label">Подтвердите новый пароль</label>
            <input type="password" class="form-control" name="new_password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Сменить пароль</button>
    </form>


@endsection
