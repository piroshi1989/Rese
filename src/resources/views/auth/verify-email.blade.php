@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card py-4">
                <div class="card-body">
                    {{--Inform user after click resend verification email button is successful <--- this  --}} 
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success text-center">新しいメール認証リンクが送信されました！</div>
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
                {{--// Optional: Add this link to let user clear browser cache <--- this  --}}
            </div>
        </div>
    </div>
</div>
@endsection