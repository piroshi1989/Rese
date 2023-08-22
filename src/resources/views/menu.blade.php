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
            @guest
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/index">Home</a>
            </li>
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/register">Registration</a>
            </li>
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/login">Login</a>
            </li>
            @endguest
            @auth
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/">Home</a>
            </li>
            <li class="menu-nav__item">
                <form class="form" action="/logout" method="post">
                    @csrf
                    <button class="menu-nav__button" type="submit">Logout</button>
                </form>
            </li>
            @can('superadmin')
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/admin/register">AdminRegistration</a>
            </li>
            @endcan
            @can('admin')
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/management">Management</a>
            </li>
            @endcan
            @can('user')
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/mypage">Mypage</a>
            </li>
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/payment">Payment</a>
            </li>
            @endcan
            @endauth
        </ul>
    </nav>
</div>
@endsection