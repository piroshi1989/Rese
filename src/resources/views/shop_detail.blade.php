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
                <a class="shop__area">#{{ $shop->area->name}}</a>
                <a class="shop__genre">#{{ $shop->genre->name }}</a>
                <div class="shop__detail">
                    <p>{{ $shop['detail'] }}</p>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::check())
    <div class = "right__content__reservation">
        <h2 class="reservation__content__title">予約</h2>
        <form action="{{ 'shop_detail' }}" method="post">
            @csrf
            <div class="reservation__input__field">
            <input class="reservation__date" type="date" name="date" name="date" min="{{ $today }}" >
            <select name="time" class="reservation__time" >
                @foreach($options as $option)
                <option class="reservation__time__option" value="{{ $option }}">
                    {{ $option }}
                </option>
                @endforeach
            </select>
            <select name="number" class="reservation__number" >
                @foreach($numbers as $number)
                <option class="reservation__number__option" value="{{ $number}}">
                    {{ $number. '人' }}
                </option>
                @endforeach
            </select>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
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
                </div>
            <div class="reservation__botttom">
                <input type="submit" value="予約する">
            </div>
        </form>
    </div>
    @else
        <h2 class="arart__message">予約される方はログインしてください</h2>
    @endif
</main>

@if(Auth::check())
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/reservasion.js') }}"></script>
@endsection
@endif
@endsection