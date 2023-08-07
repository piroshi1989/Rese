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
                <a class="menu-nav__link" href="/shop/register">Registration</a>
            </li>
            <li class="menu-nav__item">
                <a class="menu-nav__link" href="/shop/reservation">Reservation</a>
            </li>
        </ul>
    </nav>
</div>
@endsection