/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/_ajaxlike.js ***!
  \***********************************/
// app.js
$(document).ready(function () {
  $('.like-toggle').each(function () {
    var $this = $(this);
    var shopId = $this.data('shop-id');
    var userId = $this.data('user-id');
    var likeId = $this.data('like-id');
    var isLiked = likeId !== '';

    // ローカルストレージからお気に入りの状態を取得
    var localStorageKey = "like_".concat(shopId, "_").concat(userId);
    var storedLikeId = localStorage.getItem(localStorageKey);
    if (storedLikeId !== null) {
      $this.addClass('liked');
    }
    $this.on('click', function () {
      // Ajaxリクエストを送信
      $.ajax({
        type: isLiked ? 'DELETE' : 'POST',
        url: isLiked ? "/like/".concat(likeId) : '/like',
        data: {
          shop_id: shopId,
          user_id: userId,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(data) {
          // 成功時の処理
          if (data.liked) {
            $this.addClass('liked');
            localStorage.setItem(localStorageKey, data.like_id); // ローカルストレージに保存
          } else {
            $this.removeClass('liked');
            localStorage.removeItem(localStorageKey); // ローカルストレージから削除
          }

          $this.data('like-id', data.liked ? data.like_id : '');
        },
        error: function error(_error) {
          // エラー時の処理
          console.log(_error);
        }
      });
    });
  });
});
/******/ })()
;