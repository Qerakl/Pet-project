<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>
<body>
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

    <label for="name">Имя</label>
    <input type="text" name="name" id=""><br>

    <label for="email">Почта</label>
    <input type="email" name="email" id=""><br>

    <label for="password">Пароль</label>
    <input type="password" name="password" id=""><br>

    <label for="password_confirmation">Подтвердите Пароль</label>
    <input type="password" name="password_confirmation" id=""><br>

    <button type="submit">
        Регистрация
    </button>
</form>

</body>
</html>
