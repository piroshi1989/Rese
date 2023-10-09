@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<main class="main">
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="icon-link rese" href="/menu">
                    <i class="bi bi-list" id="menu__icon" aria-hidden="true"></i>Rese
                </a>
            </div>
        </div>
    </header>
    @if (session('message'))
    <div class="alert">
        {{session('message')}}
    </div>
    @endif
    <div class="review__content">
    <div class= "left__content">
        <h3 class="review__h3">
            今回のご利用はいかがでしたか？
        </h3>
        <div class="shop__content">
            <div class="shop__photo">
                <img src="{{asset($imagePath)}}">
            </div>
            <div class="shop__info">
                <p class="shop__title">{{ $shop['name'] }}</p>
                <p class="shop__area">#{{ $shop->area->name }}</p>
                <p class="shop__genre">#{{ $shop->genre->name }}</p>
                <div class="shop__bottom">
                    <div class="shop__detail__button">
                        <a href="{{ asset('/detail/'. $shop['id'])}}">詳しくみる</a>
                    </div>
                    @auth
                    <div class="likes">
                        <i class="bi bi-heart-fill like-toggle"
                        data-like-id="{{ $shop['like_id']}}"
                        data-shop-id="{{ $shop['id'] }}"
                        data-user-id="{{ Auth::id() }}"></i>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div class="vertical-line"></div>
    <div class="right__content">
            @if ($reservations->isNotEmpty())
            @if(!empty($userReview))
                <form action="/review"  method='post' enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="star-rating">
                        <p class="form-content__title">体験を評価してください</p>
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <input type="hidden" name="form_type" value="review_form">
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                    @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}"
                    {{ $userReview->rating == $i ? 'checked' : '' }}>
             <label for="star{{ $i }}" data-label-num="{{ $i }}" class="{{ $userReview->rating >= $i ? 'fill' : '' }}">
                 <i class="bi bi-star-fill"></i>
             </label>
@endfor
                </div>
                <div class="review__textarea">
                    <p class="form-content__title">口コミを投稿</p>
                    <textarea class="textarea" name="comment" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ $userReview->comment }}</textarea>
                    <p class="char-count"><span id="char-count">0</span>/400文字(最高文字数)</p>
                </div>
                @else
                <form action="/review"  method='post' enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="star-rating">
                        <p class="form-content__title">体験を評価してください</p>
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <input type="hidden" name="form_type" value="review_form">
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                    @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
             <label for="star{{ $i }}" data-label-num="{{ $i }}">
                 <i class="bi bi-star-fill"></i>
             </label>
@endfor
                </div>
                <div class="review__textarea">
                    <p class="form-content__title">口コミを投稿</p>
                    <textarea class="textarea" name="comment" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット"></textarea>
                    <p class="char-count"><span id="char-count">0</span>/400文字(最高文字数)</p>
                </div>
                @endif
                <div class="upload-photo__content">
                    <p class="form-content__title">画像の追加</p>
                    <div class="upload__area" id="uploadArea">
                        <label for="fileInput" class="upload__image-button">
                            @if(!empty($userReview))
                    <img id="imagePreview" src="{{ asset($userReview->image_url) }}" alt="画像プレビュー">
                        <p id="imagePreviewText">クリックして写真を追加
                        <br>またはドロップアンドドロップ</p>
                        @else
                        <img id="imagePreview" src="" alt="画像プレビュー"  style="display: none;">
                        <p id="imagePreviewText">クリックして写真を追加
                        <br>またはドロップアンドドロップ</p>
                        @endif
                    <input type="file" name="image" id="fileInput" style="display: none;">
                    </div>
                    </label>
                </div>
                <p id="previewedText" @if (empty($userReview->image_url)) style="display: none;" @endif>画像を変更するには再度クリックまたはドラッグアンドドロップしてください</p>
            </div>
    </div>
    <div class="form__error">
        @error('image')
        {{ $message }}
        @enderror
    </div>
    <div class="form__error">
        @error('rating')
        <p>ERROR</p>
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-button__content">
        @if(empty($userReview))
        <button class="review-form__button-submit" type="submit">口コミを投稿</button>
        @else
        <button class="review-form__button-submit" type="submit">評価を更新する</button>
        @endif
                </form>
            @endif
        </div>
</div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/star.js') }}"></script>
<script src="{{ asset('js/ajaxlike.js') }}"></script>
<script src="{{ asset('js/charCount.js') }}"></script>
<script src="{{ asset('js/fileUpload.js') }}"></script>

@endsection