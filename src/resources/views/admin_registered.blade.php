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
    <p>店舗代表者を登録しました</p>
    <div class="return__button">
        <a href="/">ホーム画面に戻る</a>
    </div>
</div>
@endsection