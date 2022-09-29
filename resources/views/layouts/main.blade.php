<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/js/app.js')
    <title>ПДУ</title>
</head>
<body>
<div id="app"></div>
<div class="container">
    @if(session()->has('success'))
        <div class="bg-success">{{ session()->get('success') }}</div>
    @endif
    @if(session()->has('errors'))
        <div class="bg-danger">{{ session()->get('errors') }}</div>
    @endif
</div>
@yield('content')
</body>
</html>
