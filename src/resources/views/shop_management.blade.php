@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/shop_register.css') }}">
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

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
<main class="main">
<div class="form__content">
    <div class="form__heading">
        <p>ShopInfomation</p>
    </div>
    @if(empty($shop))
    <form class="form" action="/shop/register" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <i class="bi bi-shop"></i>
                <input type="text" name="name" class="name" placeholder="Shopname" value="{{ old('name') }}">
            </div>
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="form__group">
                <div class="form__group-content">
                    <i class="bi bi-tag"></i>
                    <select name="genre_id" class="genre_id">
                        <option class="default__option" value="">Genre</option>
                        @foreach($genres as $genre)
                        <option class="genres__option" value="{{ $genre->id}}">
                            {{ $genre->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('genre_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-content">
                    <i class="bi bi-geo-alt-fill"></i>
                    <select name="area_id" class="area_id">
                        <option class="default__option" value="">Area</option>
                        @foreach($areas as $area)
                        <option class="areas__option" value="{{ $area->id}}">
                            {{ $area->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('area_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-content">
                    <i class="bi bi-card-text"></i><span>Detail</span>
                    <textarea name="detail" rows="4" cols="30"></textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">登録</button>
            </div>
        </div>
    </form>
    @else
    <form class="form" action="/shop/register" method="post">
        @method('PATCH')
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <i class="bi bi-shop"></i>
                <input type="text" name="name" class="name" placeholder="Shopname" value="{{ old('name', $shop->name) }}">
            </div>
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="form__group">
                <div class="form__group-content">
                    <i class="bi bi-tag"></i>
                    <select name="genre_id" class="genre_id">
                        <option class="default__option" value="">Genre</option>
                        @foreach($genres as $genre)
                        <option class="genres__option" value="{{ $genre->id }}"{{ $genre->id == $shop->genre_id ? ' selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('genre_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-content">
                    <i class="bi bi-geo-alt-fill"></i>
                    <select name="area_id" class="area_id">
                        <option class="default__option" value="">Area</option>
                        @foreach($areas as $area)
                        <option class="areas__option" value="{{ $area->id }}"{{ $area->id == $shop->area_id ? ' selected' : '' }}>
                            {{ $area->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('area_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-content">
                    <div class= detail__header>
                    <i class="bi bi-card-text"></i><span>Detail</span>
                    </div>
                    <textarea name="detail" rows="4" cols="30">{{ old('detail', $shop->detail) }}</textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">更新</button>
            </div>
        </div>
    </form>
    @endif
</div>
<div class="reservation-table">
    <h3 class="table__title">Reservation table</h3>
    <table class="reservation-table__inner">
        <tr class="reservation-table__row">
            <th class="reservation-table__header">
                <span class="reservation-table__header-span">user</span>
            </th>
            <th class="reservation-table__header">
                <span class="reservation-table__header-span">date</span>
            </th>
            <th class="reservation-table__header">
                <span class="reservation-table__header-span">time</span>
            </th>
            <th class="reservation-table__header">
                <span class="reservation-table__header-span">number</span>
            </th>
        </tr>
        @if($reservations->isNotEmpty())
        @foreach ($reservations as $reservation)
        <tr class="reservation-table__row">
            <td class="reservation-table__item">
            {{ $reservation->user->name }}
            </td>
            <td class="reservation-table__item">
            {{ $reservation->date }}
            </td>
            <td class="reservation-table__item">
            {{ $reservation->time }}
            </td>
            <td class="reservation-table__item">
            {{ $reservation->number }}人
            </td>
        </tr>
        @endforeach
        @else
        <p>予約情報はありません</p>
        @endif
    </table>
</div>
{{ $reservations->links() }}
</main>
@endsection