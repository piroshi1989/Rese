@extends('layouts.app')

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

<div class="text__content">
    <p>ご予約ありがとう<br>ございます</p>
    <div class="return__button">
        <a href="/mypage">予約状況確認</a>
    </div>
</div>
@endsection