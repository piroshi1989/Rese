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
            @if ($reservations->isNotEmpty() && empty($userReview))
            <div class="rating">
                <a class= "review__link" href="{{ asset('/review/'. $shop->id)}}">口コミを投稿する</a>
            </div>
            @endif
            @if($reviews->isNotEmpty())
            <div class="review">
                <h3 class="review__title">全ての口コミ情報</h3>
                <hr>
                <div class="review-details">
                    @foreach($reviews as $review)
                    <div class="review-actions">
                        @if($review->user_id == $user_id)
                        <a class= "review__link" href="{{ asset('/review/'. $review['shop_id'])}}">口コミを編集</a>
                        <form action="/review/delete" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="review-delete-form">
                                <input type="hidden" name="id" value="{{ $review['id'] }}">
                                <input type="hidden" name="shop_id" value="{{ $review['shop_id'] }}">
                                <button class="delete-form__button-submit" type="submit">削除</button>
                            </div>
                        </form>
                        @endif
                        @can('superadmin')
                        <form action="/review/delete" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="review-delete-form">
                                <input type="hidden" name="id" value="{{ $review['id'] }}">
                                <input type="hidden" name="shop_id" value="{{ $review['shop_id'] }}">
                                <button class="delete-form__button-submit" type="submit">削除</button>
                            </div>
                        </form>
                        @endcan
                    </div>
                    <h4 class="rating__text">{{ $review->reviewText }}</h4>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star-fill{{ $i <= $review->rating ? ' fill' : '' }}"></i>
                    @endfor
                    <div class="review-comments">
                        {{ $review->comment }}
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
            @endif
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
    </div>
    @endcan
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/reservation.js') }}"></script>
<script src="{{ asset('js/star.js') }}"></script>
@endsection