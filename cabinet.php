<?php
include_once "php/databases.php";
session_start();
/*
if(!isset($_SESSION['user'])){
	header("Location: index.php");
	exit;
}*/

function get_photos_from_user($id, $pdo)
{
	$smtp = $pdo->prepare("SELECT * FROM photos WHERE author_id = ?");
	$smtp->execute(array($id));
	$result = $smtp->fetchAll();

	return ($result);
}

function get_comments_from_user($id, $pdo)
{
	$smtp = $pdo->prepare("SELECT * FROM comments WHERE comment_author = ?");
	$smtp->execute(array($id));
	$result = $smtp->fetchAll();
	return ($result);
}

function get_photos_content($photos, $pdo)
{
	$result = "";
	$width = "150px";
	$height = "150px";
	$template_origin = file_get_contents("tpl/photo_in_gallery--layout.php");
	foreach ($photos as $item)
	{
		$sql = $pdo->prepare("SELECT description FROM photos WHERE photo = ?") ;
		$sql->execute([$item['photo']]);
		$img_alt = $sql->fetchColumn();
		$img_src = "../gallery_photos/" . $item['photo'];
		$template = $template_origin;
		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_alt}', "$img_alt", $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{description}', "$img_alt", $template);
		$result .= $template;
	}
	return ($result);
}

function get_comments_content($comments, $pdo)
{
	$final= "";
	foreach ($comments as $item) {
		$template = file_get_contents("tpl/comment_in_cabinet--layout.php");

		$smtp = $pdo->prepare("SELECT * FROM photos WHERE id = ?");
		$smtp->execute(array($item['photo_id']));
		$info = $smtp->fetch();
		$photo = $info['photo'];
		$parent_id = $info['author_id'];
		$img_alt = $info['description'];
		$smtp = $pdo->prepare("SELECT * FROM users WHERE id = ?");
		$smtp->execute(array($parent_id));
		$parent = $smtp->fetch()['user'];

		$width="70px";
		$height = "70px";

		$img_src = "../gallery_photos/" . $photo;


		$date = $item['date_of_comment'];
		$text = $item['comment_text'];
		$template = str_replace('{comment-date}', $date, $template);
		$template = str_replace('{author}', $parent, $template);
		$template = str_replace('{comment-text}', $text, $template);
		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_alt}', "$img_alt", $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{description}', "$img_alt", $template);
		$final .= $template;
	}
	return ($final);
}

function generate_profile_content($content, $info, $pdo)
{
	$content = str_replace('{username}', $info['user'], $content);
	$content = str_replace('{useremail}', $info['email'], $content);
	if ($info['notifications'] == false)
		$content = str_replace('{notif}', "no", $content);
	else
		$content = str_replace('{notif}', "yes", $content);
	$photos_content = get_photos_content($info['photos'], $pdo);
	$comments_content = get_comments_content($info['comments'], $pdo);
	$content = str_replace('{gallery}', $photos_content, $content);
	$content = str_replace('{comments}', $comments_content, $content);
	return ($content);
}

function get_user_info($pdo)
{
	$user = $_SESSION['user'];
	$smtp = $pdo->prepare("SELECT * FROM Users WHERE user = ?");
	$smtp->execute(array($user));
	$info = $smtp->fetch();
	$user_content = array();
	$user_content['user'] = $user;
	$user_content['id'] = $info['id'];
	$user_content['email'] = $info['email'];
	$user_content['notifications'] = $info['notifications'];
	$user_content['photos'] = get_photos_from_user($user_content['id'], $pdo);
	$user_content['comments'] = get_comments_from_user($user_content['id'], $pdo);
	$pdo = null;
	return ($user_content);
}

$mydb = "mydb";
$pdo = connect_to_database($mydb);
$title = "Settings";
$header = file_get_contents("tpl/inner_header--layout.php");
$content = file_get_contents("tpl/cabinet--layout.php");
$info = get_user_info($pdo);
$content = generate_profile_content($content, $info, $pdo);
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
print($file);