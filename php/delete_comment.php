<?php
include_once "../config/connect.php";

session_start();
check_user_is_parent_of_comment();

function delete_comment_from_base($comment_id)
{
	$pdo = connect_to_database();

	$email_sql_author = $pdo->prepare("DELETE FROM comments WHERE id = ?");
	$email_sql_author->execute(array($comment_id));
	$pdo=null;
	header("Location: ".$_SERVER["HTTP_REFERER"]);
}

function check_user_is_parent_of_comment()
{
	$user = $_SESSION['user'];
	$pdo = connect_to_database();
	$comment_text = $_GET['text'];
	$comment_date = strtotime('Y-m-d-H-i-s',$_GET['date']);
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
		header("Location: ".$_SERVER["HTTP_REFERER"]);
}

