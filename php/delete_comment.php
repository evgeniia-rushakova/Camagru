<?php
include_once "../config/connect.php";

if(!isset($_SESSION))
	session_start();
check_user_is_parent_of_comment();

function delete_comment_from_base($comment_id)
{
	$pdo = connect_to_database();

	$del = $pdo->prepare("DELETE FROM comments WHERE id = ?");
	$del->execute(array($comment_id));
	$pdo=null;
	echo "<script>alert('Comment deleted');location.href=location.href=document.referrer;;</script>";}

function check_user_is_parent_of_comment()
{
	if(isset($_SESSION['user']) && isset($_GET['text']) && isset($_GET['date']))
	{
		$user = $_SESSION['user'];
		$pdo = connect_to_database();
		$comment_text = $_GET['text'];
		$comment_date = $_GET['date'];
		$smtp = $pdo->prepare("SELECT * FROM Users WHERE user = ?");
		$smtp->execute(array($user));
		$user_id = $smtp->fetch()['id'];

		$smtp = $pdo->prepare("SELECT * FROM comments WHERE comment_text = ? and date_of_comment = ?");
		$smtp->execute(array($comment_text, $comment_date));
		$result = $smtp->fetch();
		$comment_author_id= $result['comment_author'];
		$comment_id = $result['id'];
		$pdo = null;

		if (strcmp($user_id, $comment_author_id) == 0 || strcmp($user, "admin") == 0)
		{
			delete_comment_from_base($comment_id);
		}
		else
			echo "<script>alert('You can\'t delete other users\'s comment!');location.href=document.referrer;</script>";
	}
}

