@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mail_confirm.css') }}">
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
<main>
    <div class="confirm__content">
        <div class="confirm__heading">
            <h2>メール内容確認</h2>
        </div>
        <form class="form" action="/mail/send" method="post">
            @csrf
            <div class="confirm-table">
                <table class="confirm-table__inner">
                    <tr class="confirm-table__row">
                        <th class="confirm-table__header">Title</th>
                        <td class="confirm-table__text">
                            <input type="text" name="title" class="title"  value="{{ $emails['title'] }}" readonly>
                        </td>
                    </tr>
                    <tr class="confirm-table__row">
                        <th class="confirm-table__header">Main Text</th>
                        <td class="confirm-table__text">
                            <input type="text" name="body" value="{{ $emails['body'] }}" readonly/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit" name="action" value="back">入力内容修正</button>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit" name="action" value="submit">送信</button>
            </div>
        </form>
    </div>
</main>
@endsection

