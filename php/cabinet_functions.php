<?php
include_once "php/cabinet_functions.php";
if(!isset($_SESSION))
	session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == false) {
	header("Location: index.php");
	exit;
}

function get_filters($pdo)
{
	$filters_array = scandir("img/filters");

	$filters= '<p class="gallery-container--inner-title" style="font-size: 14px;"> No filters available. </p>';

	if($filters_array)
	{
		$filters = "";
		unset($filters_array[0]);
		unset($filters_array[1]);
		$template = file_get_contents("tpl/filter--layout.php");
		$num = 1;
		foreach ($filters_array as $item)
		{
			$template_cpy = $template;
			$name = $item;
			$src = "img/filters/" . $item;
			$template_cpy = str_replace('{filter_name}', $name, $template_cpy);
			$template_cpy = str_replace('{filter_src}', $src, $template_cpy);
			$template_cpy = str_replace('{num}',$num, $template_cpy);
			$filters .= $template_cpy;
			$num++;
		}
	}
	return ($filters);
}

function get_photos_from_user($id, $pdo)
{
	$smtp = $pdo->prepare("SELECT * FROM photos WHERE author_id = ?");
	$smtp->execute(array($id));
	$result = $smtp->fetchAll();
	$result = array_reverse($result);
	return ($result);
}

function get_comments_from_user($id, $pdo)
{
	$smtp = $pdo->prepare("SELECT * FROM comments WHERE comment_author = ?");
	$smtp->execute(array($id));
	$result = $smtp->fetchAll();
	$result = array_reverse($result);
	return ($result);
}

function get_photos_content($photos, $pdo)
{
	$result = "";
	$width = "150px";
	$height = "auto";
	$template_origin = file_get_contents("tpl/photo_in_gallery--layout.php");
	foreach ($photos as $item) {
		$sql = $pdo->prepare("SELECT description FROM photos WHERE photo = ?");
		$sql->execute([$item['photo']]);
		$img_alt = $sql->fetchColumn();
		$img_src = "../img/gallery_photos/" . $item['photo'];
		$template = $template_origin;
		$template = str_replace('{img_name}', $item['photo'], $template);
		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_alt}', "$img_alt", $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{add_class}', "", $template);
		$template = str_replace('{add_width_class}', "", $template);
		$template = str_replace('{description}', "$img_alt", $template);

		$result .= $template;
	}
	return ($result);
}

function get_comments_content($comments, $pdo)
{
	$final = "";
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

		$width = "70px";
		$height = "auto";

		$img_src = "../img/gallery_photos/" . $photo;


		$date = $item['date_of_comment'];
		$text = $item['comment_text'];
		$template = str_replace('{comment-date}', $date, $template);
		//$template = str_replace('{author_avatar}', $author_avatar, $template)
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
	if(!$photos_content)
		$photos_content = '<p class="profile__value"> No photos yet. </p>';
	if(!$comments_content)
		$comments_content = '<p class="profile__value"> No comments yet. </p>';
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

	$smtp = $pdo->prepare("SELECT name FROM avatars WHERE id = ?");
	$smtp->execute(array($info['id']));
	$user_avatar = $smtp->fetch()['name'];

	$user_content['email'] = $info['email'];
	$user_content['notifications'] = $info['notifications'];
	$user_content['photos'] = get_photos_from_user($user_content['id'], $pdo);
	$user_content['comments'] = get_comments_from_user($user_content['id'], $pdo);
	$user_content['avatar'] = $user_avatar;
	$pdo = null;
	return ($user_content);
}
