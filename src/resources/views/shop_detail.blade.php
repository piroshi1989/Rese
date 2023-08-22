@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
@endsection

@section('content')
<main class="shop__detail__contant">
    <div class= "left__content__shop">
        <div class="header__inner">
            <div class="header-utilities">
            <a class="icon-link rese" href="/menu">
            <i class="bi bi-list" id="menu__icon" aria-hidden="true"></i>Rese</a>
            </div>
        </div>
        @if (session('message'))
        <div class="alert">
        {{session('message')}}
        </div>
        @endif
        <div class="shop__content">
            <div class="shop__content-top">
                <a class="icon-link" href="javascript:history.back()">
                <i class="bi bi-chevron-left" id="reverse__icon"></i>
                </a>
                <h2 class="shop__title">{{ $shop['name'] }}</h2>
            </div>
            <div class="shop__photo">
                <img src="{{asset($imagePath)}}">
            </div>
            <div class="shop__info">
                <p class="shop__area">#{{ $shop->area->name}}</p>
                <p class="shop__genre">#{{ $shop->genre->name }}</p>
                <div class="shop__detail">
                    <p>{{ $shop['detail'] }}</p>
                </div>
            </div>
            @can('user')
            @if ($reservations->isNotEmpty())
            <div class="star-rating">
                <form action="/review"  method='post'>
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="form_type" value="review_form">
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                    <input type="radio" name="rating" value="1" id="star1">
                    <label for="star1" data-label-num="1"></label>
                    <input type="radio" name="rating" value="2" id="star2">
                    <label for="star2" data-label-num="2"></label>
                    <input type="radio" name="rating" value="3" id="star3">
                    <label for="star3" data-label-num="3"></label>
                    <input type="radio" name="rating" value="4" id="star4">
                    <label for="star4" data-label-num="4"></label>
                    <input type="radio" name="rating" value="5" id="star5">
                    <label for="star5" data-label-num="5"></label>

                    <textarea id="comment" name="comment" rows="4" cols="30"></textarea>
                    @if(empty($userReview))
                    <button class="form__button-submit" type="submit">評価する</button>
                    @else
                    <button class="form__button-submit" type="submit">評価を更新する</button>
                    @endif
                </form>
            </div>
            <div class="form__error">
                @error('rating')
                <p>ERROR</p>
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
            @endif
            @endcan
        </div>
        @if($adminShopId == $shop->id)
        @can('admin')
        <div class="card">
            <div class="card-header">
                <h2>Todays Reservation</h2>
            </div>
            <div class="card-body">
                <a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate("/today_reservation")) !!}">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate("/today_reservation")) !!}" alt="QR Code">
                </a>
            </div>
        </div>
        @endcan
        @endif
    </div>
    @can('user')
    <div class = "right__content__reservation">
        <h2 class="reservation__content__title">予約</h2>
        <form action="{{ 'shop_detail' }}" method="post">
            @csrf
            <div class="reservation__input__field">
                <input type="hidden" name="form_type" value="reservation_form">
                <input class="reservation__date" type="date"  name="date" min="{{ $today }}" >
                <select name="time" class="reservation__time" >
                    <option value="">予約時間</option>
                    @foreach($options as $option)
                    <option class="reservation__time__option" value="{{ $option }}">
                    {{ $option }}
                    </option>
                    @endforeach
                </select>
                <select name="number" class="reservation__number" >
                    <option value="">予約人数</option>
                    @foreach($numbers as $number)
                    <option class="reservation__number__option" value="{{ $number}}">
                        {{ $number. '人' }}
                    </option>
                    @endforeach
                </select>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                <input type="hidden" name="form_type" value="reservation_form">
            </div>
            <div class="reservation__table">
                <table>
                    <tr>
                        <th class="reservation__th">Shop</th>
                        <td class="reservation__td">{{ $shop['name'] }}</td>
                    </tr>
                    <tr>
                        <th class="reservation__th">Date</th>
                        <td class="reservation__td" id="selected_date"></td>
                    </tr>
                    <tr>
                        <th class="reservation__th">Time</th>
                        <td class="reservation__td" id="selected_time"></td>
                    </tr>
                    <tr>
                        <th class="reservation__th">Number</th>
                        <td class="reservation__td" id="selected_number"></td>
                    </tr>
                </table>
            </div>
            <div class="form__error">
                @error('date')
                <p>ERROR</p>
                <p class="error">{{ $message }}</p>
                @enderror
                @error('time')
                <p>ERROR</p>
                <p class="error">{{ $message }}</p>
                @enderror
                @error('number')
                <p>ERROR</p>
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="reservation__botttom">
                <input type="submit" value="予約する">
            </div>
        </form>
    @endcan
    @guest
    <h2 class="arart__message">予約される方はログインしてください</h2>
    @endguest
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/reservation.js') }}"></script>
<script src="{{ asset('js/star.js') }}"></script>
@endsection