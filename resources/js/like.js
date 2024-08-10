// //いいね機能
$(function () {
    let likeCommentId;
    $(document).on("click", ".like-toggle", function () {
        let $this = $(this);
        likeCommentId = $this.data("comment-id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }, 
            url: "/like",
            method: "POST",
            data: {
                //いいねされた投稿のidを送る
                comment_id: likeCommentId, 
            },
        })
            .done(function (data) {
                $this.toggleClass("liked");
                // いいねの数をリアルタイムで更新
                $this.next(".like-counter").html(data.comment_likes_count);
            })
            .fail(function () {
                alert("いいねの処理に失敗しました。");
            });
    });
});
