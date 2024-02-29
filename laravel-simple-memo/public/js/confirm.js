//メモ削除時に確認するためのメソッド
function deleteHandle(event) {
    //フォームの動きを止める
    event.preventDefault();

    //削除OKならフォームを再開
    if(window.confirm('本当に削除してもいいですか？')) {
        document.getElementById('delete-form').submit();
    } else {
        alert('キャンセルしました');
    }
}
