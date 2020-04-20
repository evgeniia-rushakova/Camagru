<?php
include_once "../config/connect.php";
if(!isset($_SESSION))
	session_start();
$pdo = connect_to_database();

function get_like($photo_info, $likes_table, $user_id)
{
	global $pdo;
	$photo_id = $photo_info['id'];
	if ($likes_table == null)
	{
		$newstringintable = "INSERT INTO  likes (photo_id, who_liked_id, value) VALUES ('$photo_id', '$user_id', 1)";
		$pdo->exec($newstringintable);
		$smtp = $pdo->prepare("UPDATE photos SET likes = ? WHERE id = ?");
		$smtp->execute(array(1,$photo_id));
	}
	else if($likes_table['value'] == -1)
	{
		$smtp = $pdo->prepare("UPDATE LIKES SET VALUE = ? WHERE photo_id = ? AND who_liked_id = ?");
		$smtp->execute(array('1', $photo_id, $user_id));

		$dislikes = $photo_info['dislikes'] - 1;
		$likes = $photo_info['likes'] + 1;

		$smtp = $pdo->prepare("UPDATE photos SET likes = ? WHERE id = ?");
		$smtp->execute(array($likes,$photo_id));
		$smtp = $pdo->prepare("UPDATE photos SET dislikes = ? WHERE id = ?");
		$smtp->execute(array($dislikes,$photo_id));

	}
}

function get_dislike($photo_info, $likes_table, $user_id)
{
	global $pdo;
	$photo_id = $photo_info['id'];
	if ($likes_table == null)
	{
		$newstringintable = "INSERT INTO  likes (photo_id, who_liked_id, value) VALUES ('$photo_id', '$user_id', '-1')";
		$pdo->exec($newstringintable);
		$smtp = $pdo->prepare("UPDATE photos SET dislikes = ? WHERE id = ?");
		$smtp->execute(array(1,$photo_id));
	}
	else if($likes_table['value'] == 1)
	{
		$smtp = $pdo->prepare("UPDATE LIKES SET VALUE = ? WHERE photo_id = ? AND who_liked_id = ?");
		$smtp->execute(array('-1', $photo_id, $user_id));

		$dislikes = $photo_info['dislikes'] + 1;
		$likes = $photo_info['likes'] - 1;

		$smtp = $pdo->prepare("UPDATE photos SET likes = ? WHERE id = ?");
		$smtp->execute(array($likes,$photo_id));
		$smtp = $pdo->prepare("UPDATE photos SET dislikes = ? WHERE id = ?");
		$smtp->execute(array($dislikes,$photo_id));
	}
}

function get_likes_from_table($photo_id, $user_id)
{
	global $pdo;

	$smtp =$pdo->prepare("select * from likes where photo_id = ? AND who_liked_id = ?");
	$smtp->execute(array($photo_id, $user_id));
	$likes_table = $smtp->fetch();
	return ($likes_table);
}


if(isset($_SESSION['user']) && isset($_GET['photo']))
{
	$sql = $pdo->prepare("SELECT * FROM photos WHERE photo = ?") ;
	$sql->execute(array($_GET['photo']));
	$photo_info = $sql->fetch();
	$smtp = $pdo->prepare("SELECT * FROM Users WHERE user = ?");
	$smtp->execute(array($_SESSION['user']));
	$user_id = $smtp->fetch()['id'];
	$likes_table = get_likes_from_table($photo_info['id'], $user_id);
}

if (isset($_GET['value']) && $_GET['value'] == 1)
	get_like($photo_info, get_likes_from_table($photo_info['id'], $user_id),$user_id);
else if(isset($_GET['value']) && $_GET['value'] == -1)
	get_dislike($photo_info, get_likes_from_table($photo_info['id'], $user_id), $user_id);

header('Location: http://localhost/photo_page.php?' . $_GET['photo']);