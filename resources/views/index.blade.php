@extends('layouts.main')
@section('content')
<div class="container  mt-5 pt-5">
    <div class="d-flex justify-content-center">
        <p class="display-3 text-center">Добро пожаловать <br>
            на Платформу дистанционного обучения
        </p>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <a href="{{ route('auth') }}" class="btn btn-secondary btn-lg fs-1">приступить</a>
    </div>

</div>
@endsection
