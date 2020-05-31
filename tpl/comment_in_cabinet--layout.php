<div class="comment__photo-min-container">
    <a class="comment__photo-miniature" href="http://localhost/photo_page.php?{img_href}"><img src="{img_src}" alt="duck!!!" width="100" height="auto"></a>
    <div class="photo__description-container--comment comment">
        <div class="comment__container">
            <img src="../img/avatars/{user_avatar}" alt="avatar" class="comment__author-avatar" width="48" height="auto" style="align-self: center;">
            <div class="comment__info-author">
                <p class="comment__author"> <a href="">You</a></p>
                <p class="comment__date">{comment-date}</p>
            </div>
        </div>
        <p class="comment__description">{comment-text}</p>
        <form action="../php/delete_comment.php?date={comment-date}&text={comment-text}" method="post">
            <button type="submit" class="comment__delete-comment comment__delete-comment--profile">delete</button>
        </form>
    </div>
</div>