@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <a class="icon-link rese" href="/menu">
            <i class="bi bi-list" id="menu__icon" aria-hidden="true"></i>Rese</a>
        </div>
        <form method="GET" action="/" id="form">
            <div class="sort-form__content">
                <input type="hidden" name="form__type" value="sort__form">
                <label for="sort">並び替え:</label>
                <select name="sort" id="sort" class="sort">
                    <option value="" selected disabled>選択してください</option>
                    <option value="random" {{ request()->input('sort') === 'random' ? 'selected' : '' }}>ランダム</option>
                    <option value="rating_desc" {{ request()->input('sort') === 'rating_desc' ? 'selected' : '' }}>評価が高い順</option>
                    <option value="rating_asc" {{ request()->input('sort') === 'rating_asc' ? 'selected' : '' }}>評価が低い順</option>
                </select>
            </div>
        </form>
        <div class="search__form">
            <form action="/search" method="get">
                @csrf
                <select name="area" class="area">
                    <option value="">都道府県を選択</option>
                    @foreach($areas as $area)
                    <option value={{ $area['id'] }}>{{ $area['name'] }}</option>
                    @endforeach
                </select><select name="genre">
                    <option value="">ジャンルを選択</option>
                    @foreach($genres as $genre)
                    <option value={{ $genre['id'] }}>{{ $genre['name'] }}</option>
                    @endforeach
                </select><input type="text" class="keyword" name="keyword" placeholder="Search..."><button type="submit" class="search__icon"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</header>

<main class="shop__main">
    @if(empty($searchedShops))
    @foreach($shops as $shop)
    <div class="shop__content">
        <div class="shop__photo">
            <img src="{{asset($shop['imagePath'])}}">
        </div>
        <div class="shop__info">
            <p class="shop__title">{{ $shop['name'] }}</p>
            <p class="shop__area">#{{ $shop->area->name }}</p>
            <p class="shop__genre">#{{ $shop->genre->name }}</p>
            <div class="shop__bottom">
                <div class="shop__detail__button">
                    <a href="{{ asset('/detail/'. $shop['id'])}}">詳しくみる</a>
                </div>
                @auth
                <div class="likes">
                    <i class="bi bi-heart-fill like-toggle"
                    data-like-id="{{ $shop['like_id']}}"
                    data-shop-id="{{ $shop['id'] }}"
                    data-user-id="{{ Auth::id() }}"></i>
                </div>
                {{--  平均評価数確認用 --}}
                {{ $shop->average_rating }}
                @endauth
            </div>
        </div>
    </div>
    @endforeach
    @else
    @foreach($searchedShops as $shop)
    <div class="shop__content">
        <div class="shop__photo">
            <img src="{{asset($shop['imagePath'])}}">
        </div>
        <div class="shop__info">
            <p class="shop__title">{{ $shop['name'] }}</p>
            <p class="shop__area">#{{ $shop->area->name }}</p>
            <p class="shop__genre">#{{ $shop->genre->name }}</p>
            <div class="shop__bottom">
                <div class="shop__detail__button">
                    <a href="{{ asset('/detail/'. $shop['id'])}}">詳しくみる</a>
                </div>
                @auth
                <div class="likes">
                    <i class="bi bi-heart-fill like-toggle"
                    data-like-id="{{ $shop['like_id']}}"
                    data-shop-id="{{ $shop['id'] }}"
                    data-user-id="{{ Auth::id() }}"></i>
                </div>
                {{--  平均評価数確認用 --}}
                {{-- { $shop->average_rating }}  --}}
                @endauth
            </div>
        </div>
    </div>
    @endforeach
    @endif
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/ajaxlike.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterForm = document.getElementById("form");
        const selectBox = document.getElementById("sort");

        selectBox.addEventListener("change", function() {
            form.submit();
            });
    });
</script>
@endsection