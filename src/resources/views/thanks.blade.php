@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
        <a class="icon-link rese" href="/menu">
            <i class="bi bi-list" id="menu__icon" aria-hidden="true"></i>Rese</a>
        </div>
    </div>
</header>
@can('superadmin')
<div class="text__content">
    <p>店舗管理者を登録できました</p>
    <div class="return__button"><a href="/">ログインする</a></div>
</div>
@endcan
@can('user')
<div class="text__content">
    <p>会員登録ありがとうございます</p>
    <div class="return__button"><a href="/">ログインする</a></div>
</div>
@endcan

@endsection