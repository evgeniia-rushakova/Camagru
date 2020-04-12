
<div class="popup photo__container">
	<div class="photo__container--photo_info">
		<div class="photo__src">
			<img src="{img_src}" alt="{img_alt}" class="photo__img" width="{img_width}" height="{img_height}">
		</div>
		<div class="photo__reactions">
			<p class="photo__like_counter"> <a class="photo__like_icon" href="#"><img src="../img/like.png" alt="likes" width="28" height="28"></a><span>{likes} likes</span></p>
			<p class="photo__like_counter"><a class="photo__like_icon" href="#"><img src="../img/dislike.png" alt="dislikes" width="28" height="28"></a><span>{dislikes} dislikes</span></p>
			<form action="../php/delete_photo.php?photo={img_src}" method="post">
				<button type="submit" class="photo__del" aria-label="delete photo"><img src="../img/trash.png" alt="delete" width="35" height="35"></button>
			</form>
		</div>
	</div>
	<div class="photo__container--text_info">
		<div class="photo__container--text">
			<div class="photo__description-container--author">
				<div class="photo__description-container">
					<img src="../img/avatars/{avatar_src}" alt="avatar_author" class="photo__author-avatar" width="48" height="48">
					<div class="photo__info-author">
						<p class="photo__author"> <a href="">{photo-author}</a></p>
						<p class="photo__date">{photo-date}</p>
					</div>
				</div>
				<p class="photo__description">{description}</p>
			</div>
			{comments}
		</div>
		<div class="photo__comment-form">
			<img src="../img/avatars/{user_avatar_src}" alt="avatar" class="photo__author-avatar" width="48" height="48">
			<form action="../php/add_new_comment.php" class="photo__comment-form--form">
				<input type="hidden" name="main-photo" value="{img_alt}">
				<input type="hidden" name="author_photo" value="{photo_author}">
				<label for="comment">
					<input type="text" required="" id="comment" maxlength="300" name="comment" placeholder="Your comment..." class="photo__comment-form--new">
				</label>
				<button type="submit" class="photo__comment-form--send">Send</button>
			</form>
		</div>
	</div>
</div>

