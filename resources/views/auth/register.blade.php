@extends('layouts.main')
@section('content')
    <div id="register-form">
        <register-form register-route={{ route('register.store') }}></register-form>
    </div>
@endsection
