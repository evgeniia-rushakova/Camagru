<div class="comment__photo-min-container">
    <a class="comment__photo-miniature" href="http://localhost/add_popup_photo.php?{img_src}"><img src="{img_src}" alt="duck!!!" width="100" height="100"></a>
    <div class="photo__description-container--comment comment">
        <div class="comment__container">
            <img src="../img/avatars/{user_avatar}" alt="avatar" class="comment__author-avatar" width="48" height="48">
            <div class="comment__info-author">
                <p class="comment__author"> <a href="">You</a></p>
                <p class="comment__date">{comment-date}</p>
            </div>
        </div>
        <p class="comment__description">{comment-text}</p>
        <form action="../php/delete_comment.php?date=2020-04-05 15:49:06&text=love you cat" method="post">
            <button type="submit" class="comment__delete-comment comment__delete-comment--profile">delete</button>
        </form>
    </div>
</div>