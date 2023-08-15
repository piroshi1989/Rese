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

<div class="text__content">
    <p>ご予約ありがとうございます</p>
    <div class="return__button"><a href="javascript:history.back()">戻る</a></div>
</div>
@endsection