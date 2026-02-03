@extends('layouts.app')

@section('title', 'Регистрация')

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
    <form action="{{route('register')}}" method="post">
        @csrf

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Имя</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Подтвердитель пароль</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-primary">Регистрация</button>
    </form>

@endsection
