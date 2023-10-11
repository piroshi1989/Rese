@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/csv_upload.css') }}">
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
<div class="upload__area">
<form method="post" action="/csv.upload" enctype="multipart/form-data">
    @csrf
    <label name="csvFile">csvファイル</label>
    <input type="file" name="csvFile" class="" id="csvFile"/>
    <input type="submit">
</form>
</div>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@endsection