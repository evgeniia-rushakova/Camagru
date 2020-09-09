<?php
include_once "../config/connect.php";
if (!isset($_SESSION))
	session_start();

function get_table_with_likes($photo_info)
{
	$pdo = connect_to_database();
	$photo_id = $photo_info['id'];
	$sql = $pdo->prepare("SELECT * FROM likes WHERE photo_id =?");
	$sql->execute(array($photo_id));
	$array_with_likes = $sql->fetchAll();
	$likes = 0;
	$dislikes = 0;
	foreach ($array_with_likes as $item)
	{
		if($item['value'] == 1)
			$likes++;
		else if ($item['value'] == -1)
			$dislikes++;
	}
	$result = [];
	$result['likes'] = $likes;
	$result['dislikes'] = $dislikes;
	$result = json_encode($result);

	echo $result;
}

function get_like($photo_info, $likes_table, $user_id)
{
	$pdo = connect_to_database();
	$photo_id = $photo_info['id'];
	if ($likes_table == null) {
		$newstringintable = "INSERT INTO  likes (photo_id, who_liked_id, value) VALUES ('$photo_id', '$user_id', 1)";
		$pdo->exec($newstringintable);
		$smtp = $pdo->prepare("UPDATE photos SET likes = ? WHERE id = ?");
		$smtp->execute(array(1, $photo_id));
	} else if ($likes_table['value'] == -1) {
		$smtp = $pdo->prepare("UPDATE likes SET VALUE = ? WHERE photo_id = ? AND who_liked_id = ?");
		$smtp->execute(array('1', $photo_id, $user_id));

		$dislikes = $photo_info['dislikes'] - 1;
		$likes = $photo_info['likes'] + 1;

		$smtp = $pdo->prepare("UPDATE photos SET likes = ? WHERE id = ?");
		$smtp->execute(array($likes, $photo_id));
		$smtp = $pdo->prepare("UPDATE photos SET dislikes = ? WHERE id = ?");
		$smtp->execute(array($dislikes, $photo_id));
	}
}

function get_dislike($photo_info, $likes_table, $user_id)
{
	$pdo = connect_to_database();
	$photo_id = $photo_info['id'];
	if ($likes_table == null) {
		$newstringintable = "INSERT INTO  likes (photo_id, who_liked_id, value) VALUES ('$photo_id', '$user_id', '-1')";
		$pdo->exec($newstringintable);
		$smtp = $pdo->prepare("UPDATE photos SET dislikes = ? WHERE id = ?");
		$smtp->execute(array(1, $photo_id));
	} else if ($likes_table['value'] == 1) {
		$smtp = $pdo->prepare("UPDATE likes SET VALUE = ? WHERE photo_id = ? AND who_liked_id = ?");
		$smtp->execute(array('-1', $photo_id, $user_id));

		$dislikes = $photo_info['dislikes'] + 1;
		$likes = $photo_info['likes'] - 1;

		$smtp = $pdo->prepare("UPDATE photos SET likes = ? WHERE id = ?");
		$smtp->execute(array($likes, $photo_id));
		$smtp = $pdo->prepare("UPDATE photos SET dislikes = ? WHERE id = ?");
		$smtp->execute(array($dislikes, $photo_id));
	}
}

function get_likes_from_table($photo_id, $user_id)
{
	$pdo = connect_to_database();

	$smtp = $pdo->prepare("select * from likes where photo_id = ? AND who_liked_id = ?");
	$smtp->execute(array($photo_id, $user_id));
	$likes_table = $smtp->fetch();
	return ($likes_table);
}

function ajax_like() {
	$pdo = connect_to_database();
	if (isset($_SESSION['user']) && isset($_GET['photo']))
		$photo_name = $_GET['photo'];
	else
	{
		$arr = explode("?",$_SERVER['HTTP_REFERER']);
		$photo_name = $arr[count($arr) - 1];
	}
	$sql = $pdo->prepare("SELECT * FROM photos WHERE photo = ?");
	$sql->execute(array($photo_name));
	$photo_info = $sql->fetch();

	if (isset($_GET['value']))
	{
		$smtp = $pdo->prepare("SELECT * FROM users WHERE user = ?");
		$smtp->execute(array($_SESSION['user']));
		$user_id = $smtp->fetch()['id'];
		$likes_table = get_likes_from_table($photo_info['id'], $user_id);
		if($_GET['value'] == 1)
			get_like($photo_info, get_likes_from_table($photo_info['id'], $user_id), $user_id);
		else if ($_GET['value'] == -1)
			get_dislike($photo_info, get_likes_from_table($photo_info['id'], $user_id), $user_id);
	}
	return get_table_with_likes($photo_info);
}

ajax_like();




