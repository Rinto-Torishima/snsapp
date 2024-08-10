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
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("いいねの処理に失敗しました。もう一度お試しください。");
                console.log("ajax通信に失敗しました");
                console.log("jqXHR          : " + jqXHR.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
            });
    });
});
