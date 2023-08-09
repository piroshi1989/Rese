@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="card-body">
    {{--Inform user after click resend verification email button is successful <--- this  --}}
        @if (session('status') == 'verification-link-sent')
        <p class="alert alert-success text-center">
        新しいメール認証リンクが送信されました！
        </p>
        @endif
        <div class="text-center mb-5">
            {{--Instructions for new users <--- this  --}}
            <h3>メールアドレスの確認</h3>
            <p>このページにアクセスするには、メールアドレスの確認が必要です。</p>
        </div>
        <form method="POST" action="{{ route('verification.send') }}" class="text-center">
            @csrf
            <button type="submit" class="btn btn-primary">認証メールの送信</button>
        </form>
    </div>
</div>
                {{--// Optional: Add this link to let user clear browser cache <--- this  --}}
@endsection