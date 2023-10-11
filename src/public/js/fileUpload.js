var isClicking = false; // クリックフラグを初期化

// アップロードエリアをクリックしたときの処理
$("#uploadArea").click(function() {
    if (!isClicking) { // クリック中でない場合にのみ処理を実行
        isClicking = true; // クリック中のフラグを設定
        // ここでファイル選択ダイアログを表示せず、代わりにchangeイベントで表示する
    }
});

// ファイルが選択されたときの処理
$("#fileInput").change(function() {
    isClicking = false; // クリック中のフラグを解除
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#imagePreview").attr("src", e.target.result);
            $("#imagePreview").css("display", "block");
            // 画像が読み込まれたら、テキストを変更
            $("#imagePreviewText").css("display", "none");
            $("#previewedText").css("display", "block");
        };
        reader.readAsDataURL(file);
    }
});


    
    // ドラッグアンドドロップの処理
    $("#uploadArea").on("dragover", function(event) {
        event.preventDefault();
        $(this).addClass("dragover");
    });
    
    $("#uploadArea").on("dragleave", function(event) {
        event.preventDefault();
        $(this).removeClass("dragover");
    });
    
    $("#uploadArea").on("drop", function(event) {
        event.preventDefault();
        $(this).removeClass("dragover");
    
        var file = event.originalEvent.dataTransfer.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result);
                $("#imagePreview").css("display", "block");
            };
            reader.readAsDataURL(file);
        }
    });
    