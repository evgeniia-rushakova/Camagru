<div class="user-comment" style="
border: 1px solid red;
min-height: 40px;
width: 350px;
margin: 10px;
">
	<p >User <a href="#">{comment-author}</a> at {comment-date} commented this: </p><br>
	<i>{comment-text}</i>
	<form action="../php/delete_comment.php?date={comment-date}&text={comment-text}" method="post">
		<button type="submit" >del</button>
	</form>
</div>
