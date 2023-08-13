@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
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
<main class= "reservation__content">
    <div class="reservation-table">
        <table class="reservation-table__inner">
            <h3>{{ $today }}の予約情報</h3>
            <tr class="reservation-table__row">
                <th class="reservation-table__header">
                <span class="reservation-table__header-span">user</span>
                </th>
                {{--  <th class="reservation-table__header">
                <span class="reservation-table__header-span">date</span>
                </th>--}}
                <th class="reservation-table__header">
                <span class="reservation-table__header-span">time</span>
                </th>
                <th class="reservation-table__header">
                <span class="reservation-table__header-span">number</span>
                </th>
            </tr>
            @if($todayReservations->isNotEmpty())
            @foreach ($todayReservations as $todayReservation)
            <tr class="reservation-table__row">
                <td class="reservation-table__item">
                    {{ $todayReservation->user->name }}
                </td>
                {{--  <td class="reservation-table__item">
                    {{ $reservation->date }}
                </td>--}}
                <td class="reservation-table__item">
                    {{ $todayReservation->time }}
                </td>
                <td class="reservation-table__item">
                    {{ $todayReservation->number }}人
                </td>
            </tr>
            @endforeach
            @endif
        </table>
    </div>
    {{ $todayReservations->links() }}
</main>

@endsection