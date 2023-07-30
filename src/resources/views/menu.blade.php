@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endsection

@section('content')
<header class="header">
<a class="icon-link" href="javascript:history.back()">
  <i class="bi bi-x-square-fill" id="close__icon" aria-hidden="true"></i>
</a>
</header>

<div class="nav__content">
    <nav>
        <ul class="menu-nav">
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/">Home</a>
            </li>
            @if (Auth::guest())
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/register">Registration</a>
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/login">Login</a>
            </li>
            @endif
            @if(Auth::check())
            <li class="menu-nav__item">
                <form class="form" action="/logout" method="post">
                    @csrf
                    <button class="menu-nav__button" type="submit">Logout</button>
                </form>
            </li>
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/mypage">Mypage</a>
            </li>
            @endif
        </ul>
    </nav>
</div>
@endsection