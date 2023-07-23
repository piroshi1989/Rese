@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
        <a class="icon-link rese" href="/menu">
            <i class="bi bi-list" id="menu__icon" aria-hidden="true"></i>Rese
        </a>
        </div>
    </div>
</header>
<div class="form__content">
    <div class="form__heading">
        <p>Login</p>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <i class="bi bi-envelope-fill"></i>
                <input type="email" name="email" class="email" placeholder="Email" value="{{ old('email') }}">
            </div>
            <div class="form__error">
            @error('email')
            {{ $message }}
            @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-content">
                <i class="bi bi-lock-fill"></i>
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="form__error">
            @error('password')
            {{ $message }}
            @enderror
            </div>
        </div>
        <div class="form__button">
        <button class="form__button-submit" type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection