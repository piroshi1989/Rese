    // テキストエリアの要素を取得
    const textarea = document.getElementById('comment');

    // 文字数をカウントし、表示するための要素を取得
    const charCount = document.getElementById('char-count');

    // テキストエリアの入力内容が変更されたときにカウントを更新
    textarea.addEventListener('input', function() {
        const currentCharCount = textarea.value.length;
        charCount.textContent = currentCharCount;
    });