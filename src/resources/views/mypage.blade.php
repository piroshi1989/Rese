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
    @if (session('message'))
    <div class="alert">
        {{session('message')}}
    </div>
    @endif
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
                        <form action="/mypage/update" method="post" class= "reservation__form">
                            @method('PATCH')
                            @csrf
                            <i class="bi bi-arrow-clockwise update-form__button-submit" onclick="this.parentNode.submit()"></i>
                            <table>
                                <tr>
                                    <th class="reservation__th">Shop</th>
                                    <td class="reservation__td">{{ $reservation->shop->name }}</td>
                                </tr>
                                <tr>
                                    <th class="reservation__th">Date</th>
                                    <td class="reservation__td">
                                        <input class="reservation__date" type="date" name="date" name="date" min="{{ $today }}" value="{{ $reservation->date }}"></td>
                                </tr>
                                <tr>
                                    <th class="reservation__th">Time</th>
                                    <td class="reservation__td">
                                        <select name="time" class="reservation__time" value="{{ $reservation->time }}">
                                            @foreach($options as $option)
                                            <option class="reservation__time__option" value="{{ $option }}"
                                                @if ($reservation->time === $option)
                                                    selected
                                                @endif >
                                            {{ $option }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="reservation__th">Number</th>
                                    <td class="reservation__td">
                                        <select name="number" class="reservation__number" value="{{ $reservation->number }}人">
                                            @foreach($numbers as $number)
                                            <option class="reservation__number__option" value="{{ $number}}"
                                                @if ($reservation->number === $number)
                                                    selected
                                                @endif >
                                            {{ $number. '人' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <input type="hidden" name="id" value="{{ $reservation['id'] }}">
                            </table>
                        </form>
                        <div class="form__error">
                            @error('time')
                            <p>ERROR</p>
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
                @else
                <p>予約はありません</p>
                @endif
                {{ $reservations->links() }}
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
                                <a href="{{ asset('/detail/'. $likedShop['id']) }}">詳しくみる</a>
                            </div>
                            <span class="likes">
                                <i class="bi bi-heart-fill"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <p>お気に入り店舗はありません</p>
            @endif
            </div>
        </div>
    </div>
</main>
@endsection