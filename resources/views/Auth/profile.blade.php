@extends('layouts.app')

@section('title', 'Профиль')

@section('content')

Имя: {{$name}} <br>
Почта: {{$email}} <br>

@endsection
