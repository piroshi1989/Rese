@extends('layouts.app')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_all.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
        <a class="icon-link rese" href="/menu">
            <i class="bi bi-list" id="menu__icon" aria-hidden="true"></i>Rese</a>
        </div>
        <div class="search__form">
            <form action="/search" method="get">
                <select name="area" class="area">
                    @foreach($areas as $area)
                    <option value={{ $area['id'] }}>{{ $area['name'] }}</option>
                    @endforeach
                </select><select name="genre">
                    @foreach($genres as $genre)
                    <option value={{ $genre['id'] }}>{{ $genre['name'] }}</option>
                    @endforeach
                </select><input type="text" class="" name="keyword" placeholder="Search..."><button type="submit" class="search__icon"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</header>

<main class="shop__main">
    @foreach($shops as $shop)
    <div class="shop__content">
        <div class="shop__photo">
            <img src="{{asset($shop['imagePath'])}}">
        </div>
        <div class="shop__info">
            <p class="shop__title">{{ $shop['name'] }}</p>
            <a class="shop__area">#{{ $shop->area->name }}</a>
            <a class="shop__genre">#{{ $shop->genre->name }}</a>
            <div class="shop__bottom">
                <div class="shop__detail__button">
                    <a href="{{ asset('shop_all' . '/'. $shop['id']) }}">詳しくみる</a>
                </div>
                @auth
                    <span class="likes">
                        <i class="bi bi-heart-fill like-toggle"
                           data-like-id="{{ $shop->isLikedBy(Auth::id()) ? $shop->likes->where('user_id', Auth::id())->first()->id : null }}"
                           data-shop-id="{{ $shop['id'] }}"
                           data-user-id="{{ Auth::id() }}"></i>
                    </span>
                @endauth
                @guest
                    <span class="likes">
                        <i class="bi bi-heart-fill"></i>
                    </span>
                @endguest
            </div>
        </div>
    </div>
    @endforeach
</main>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection