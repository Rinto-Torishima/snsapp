$( function (){
    $('#pan').on('click',function() {
var id = 123; //thanksを送りたい回答の主キー"id"
var messege = "こんにちは";

$.ajax({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //④
    },
    url: '/likes',
    type: 'POST', //①
    dataType: 'json', //②
    data: { //③
        id: id,
        messege: messege,
    },
}).done(function(json) {
    //成功した時の処理

  
        alert(json['responseData']);
}).fail(function(json) {
    //失敗した時の処理
    alert('jj');

});
})

})
// //いいね機能
$(function () {
  
    let likeCommentId; 
    $(document).on('click','.like-toggle', function () { //onはイベントハンドラー
      let $this = $(this); //this=イベントの発火した要素＝iタグを代入
      likeCommentId = $this.data('comment-id'); //iタグに仕込んだdata-review-idの値を取得
      $.ajax({
        headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
        url: '/like', //通信先アドレスで、このURLをあとでルートで設定します
        method: 'POST', 
        data: { //サーバーに送信するデータ
          'comment_id': likeCommentId //いいねされた投稿のidを送る
        },
      })
      //通信成功した時の処理
      .done(function (data) {
        $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
        $this.next('.like-counter').html(data.comment_likes_count);
      })
      //通信失敗した時の処理
      .fail(function () {
        console.log('fail'); 
      });
    });
    });
