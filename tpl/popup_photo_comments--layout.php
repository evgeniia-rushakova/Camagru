<div class="popup photo__container"style="border: 2px solid purple;
min-width: 200px;
min-height: 200px;
margin: auto;
padding: 10px;
display: flex;
flex-direction: column;
justify-content: space-between;
margin-bottom: 50px;">
	<div class="photo__src">
        <img src="{img_src}" alt={img_alt} width={img_width} height={img_height}>
    </div>
	<div class="photo__reactions">
		<p class="photo__like_counter"><a class="photo__like_icon" href="#"><3</a>{likes}</p>
		<p class="photo__like_counter"><a class="photo__dislike_icon" href="#"><*3</a>{dislikes}</p>
	</div>
	<div class="photo__description-container">
		<p class = "photo__date">{photo-date}</p>
		<p class="photo__author">author: <a href="">{photo-author}</a></p>
		<p class="photo__description">{description}</p>
	</div>
	<div class="photo__comments-container">
		{comments}
	</div>
	<div class="photo__comment-form">
		<form action="../php/add_new_comment.php">
			<input type="hidden" name="main-photo" value={img_alt}>
			<input type="hidden" name="author_photo" value={photo-author}>
			<label for=""><textarea name="comment" id="" cols="30" rows="10" placeholder="your comment"></textarea></label>
			<button type="submit">send</button>
		</form>
	</div>
</div>

