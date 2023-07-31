$(document).ready(function() {
  $('.like-toggle').each(function() {
    const $this = $(this);
    const shopId = $this.data('shop-id');
    const userId = $this.data('user-id');
    const likeId = $this.data('like-id');
    const isLiked = likeId !== '';

    // ローカルストレージからお気に入りの状態を取得
    const localStorageKey = `like_${shopId}_${userId}`;
    const storedLikeId = localStorage.getItem(localStorageKey);

    if (storedLikeId !== null) {
      $this.addClass('liked');
    }

    $this.on('click', function() {
      // Ajaxリクエストを送信
      $.ajax({
        type: isLiked ? 'DELETE' : 'POST',
        url: isLiked ? `/like/${likeId}` : '/like',
        data: {
          shop_id: shopId,
          user_id: userId,
          _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
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
        error: function(error) {
          // エラー時の処理
          console.log(error);
        },
      });
    });
  });
});