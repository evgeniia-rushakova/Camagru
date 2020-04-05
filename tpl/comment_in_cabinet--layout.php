<div class="user-comment" style="
border: 1px solid red;
min-height: 40px;
width: 350px;
margin: 10px;
">
	<div class="user-comment__info">
		<p >You commented {author}'s photo at {comment-date} : </p><br>
		<i>{comment-text}</i>
	</div>
	<a href="../add_popup_photo.php?{img_src}"><img src={img_src} alt={img_alt} width={img_width} height={img_height}></a>

	<form action="../php/delete_comment.php?date={comment-date}&text={comment-text}" method="post">
		<button type="submit" >del</button>
	</form>
</div>