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
    <div class= "left__reservations__content">
    <div class="reservation__content">
        <h2 class="reservation__title">予約状況</h2>
@if($reservations->isNotEmpty())
@foreach($reservations as $reservation)
        <div class="reservation__table">
            <form action="/mypage/delete" method="post">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="{{ $reservation['id'] }}">
            <i class="bi bi-clock"></i><a class="reservation__td">予約{{ ($reservations->currentPage())}}</a><i class="bi bi-x-circle delete-form__button-submit" onclick="this.parentNode.submit()"></i>
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
{{ $reservations->links() }}
@endif
 @if (session('message'))
    </div class="reservation__alert">
   {{session('message')}}
    </div>
    @endif
    </div>
    </div>

    <div class = "right__favorites__content">
        <h3 class="user__name">{{ $user_name }}さん</h3>

    </div>

    </main>

@endsection