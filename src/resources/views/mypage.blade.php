@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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

<main class="mypage">
    <h2 class="user__name">{{ $user_name }}さん</h2>
    <div class="mypage__content">
        <div class= "left__reservations__content">
            <div class="reservation__content">
                <h3 class="mypage__title">予約状況</h3>
                @if($reservations->isNotEmpty())
                @foreach($reservations as $reservation)
                    <div class="reservation__table">
                        <form action="/mypage/delete" class= "reservation__form" method="post">
                        @method('DELETE')
                        @csrf
                            <input type="hidden" name="id" value="{{ $reservation['id'] }}">
                            <div class= "reservation__form__inner">
                                <i class="bi bi-clock"></i>
                                <a class="reservation__td">予約{{ ($reservations->currentPage())}}</a>
                            </div>
                            <i class="bi bi-x-circle delete-form__button-submit" onclick="this.parentNode.submit()"></i>
                        </form>
                        <table>
                            <tr>
                                <th class="reservation__th">Shop</th>
                                <td class="reservation__td">{{ $reservation->shop->name }}</td>
                            </tr>
                            <tr>
                                <th class="reservation__th">Date</th>
                                <td class="reservation__td">{{ $reservation->date }}</td>
                            </tr>
                            <tr>
                                <th class="reservation__th">Time</th>
                                <td class="reservation__td">{{ $reservation->time }}</td>
                            </tr>
                            <tr>
                                <th class="reservation__th">Number</th>
                                <td class="reservation__td">{{ $reservation->number }}人</td>
                            </tr>
                        </table>
                        </form>
                    </div>
                @endforeach
                @endif
                {{ $reservations->links() }}
                @if (session('message'))
                <div class="reservation__alert">
                {{session('message')}}
                </div>
                @endif
            </div>
        </div>

        <div class = "right__liked__content">
            <h3 class="mypage__title">お気に入り店舗</h3>
            @if($likedShops->isNotEmpty())
            <div class= "liked__shops">
                @foreach($likedShops as $likedShop)
                <div class="shop__content">
                    <div class="shop__photo">
                        <img src="{{asset($likedShop['imagePath'])}}">
                    </div>
                    <div class="shop__info">
                        <p class="shop__title">{{ $likedShop['name'] }}</p>
                        <a class="shop__area">#{{ $likedShop->area->name }}</a>
                        <a class="shop__genre">#{{ $likedShop->genre->name }}</a>
                        <div class="shop__bottom">
                            <div class="shop__detail__button">
                                <a href="{{ asset('shop_all' . '/'. $likedShop['id']) }}">詳しくみる</a>
                            </div>
                            <span class="likes">
                                <i class="bi bi-heart-fill"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
            </div>
        </div>
    </div>
</main>
@endsection