<?php
include_once "config/connect.php";
include_once "tpl/popups--layout.php";
include_once "php/cabinet_functions.php";

if (!isset($_SESSION))
	session_start();

if(!isset($_SESSION['user'])|| $_SESSION['user']==false)
{
	header("Location: index.php");
	exit;
}

function pull_from_base($filename, $pdo)
{
	$check = $pdo->prepare("SELECT * FROM photos where photo = ?");
	$check->execute([$filename]);
	$check_result =$check->fetch();
	return ($check_result);
}

function generate_comments($pdo, $photo)
{
	$result = $pdo->prepare("SELECT * FROM comments where photo_id = ?");
	$result->execute([$photo]);
	$fetch = $result->fetchAll();
	$final= "";
	foreach ($fetch as $item)
	{
		$template = file_get_contents("tpl/comment--layout.php");
		$author_id = $item['comment_author'];

		$smtp = $pdo->prepare("SELECT * FROM users WHERE id = ?");
		$smtp->execute(array($author_id));
		$author = $smtp->fetch()['user'];

		$smtp = $pdo->prepare("SELECT name FROM avatars WHERE id = ?");
		$smtp->execute(array($author_id));
		$user_avatar = $smtp->fetch()['name'];

		$date = $item['date_of_comment'];
		$text = $item['comment_text'];
		$template = str_replace('{comment-author}', $author, $template);
		$template = str_replace('{comment-date}', $date, $template);
		$template = str_replace('{comment-text}', $text, $template);
		$template = str_replace('{user_avatar}', $user_avatar, $template);
		$final.=$template;
	}
	return ($final);
}

function render_inner_content_popup($content)
{
	$pdo = connect_to_database();
	$arrlong= explode("/",$_SERVER['QUERY_STRING']);
	$filename = html_entity_decode($arrlong[count($arrlong) -1]);

	$info = pull_from_base($filename, $pdo);
	if ($info)
	{
		$author_id = $info['author_id'];
		$date = $info['date'];
		$likes = $info['likes'];
		$dislikes = $info['dislikes'];
		$description = $info['description'];
		$img_src = "../img/gallery_photos/$filename";
		$width = "500px";
		$height = "auto";

		$smtp = $pdo->prepare("SELECT * FROM photos WHERE photo = ?");
		$smtp->execute(array($filename));
		$photo_id = $smtp->fetch()['id'];
		$comments = generate_comments($pdo, $photo_id);
		$template = $content;

		$smtp = $pdo->prepare("SELECT * FROM users WHERE id = ?");
		$smtp->execute(array($author_id));
		$author_photo_info = $smtp->fetch();
		$author_name = $author_photo_info['user'];

		$smtp = $pdo->prepare("SELECT * FROM users WHERE user = ?");
		$smtp->execute(array($_SESSION['user']));
		$id_current_user = $smtp->fetch()['id'];

		$smtp = $pdo->prepare("SELECT * FROM avatars WHERE author_id = ?");
		$smtp->execute(array($id_current_user));
		$user_avatar_src = $smtp->fetch()['name'];


		$smtp = $pdo->prepare("SELECT * FROM avatars WHERE author_id = ?");
		$smtp->execute(array($author_id));
		$author_avatar_src = $smtp->fetch()['name'];

		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_alt}', "$filename", $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{likes}', "$likes", $template);
		$template = str_replace('{dislikes}', "$dislikes", $template);
		$template = str_replace('{photo-date}', "$date", $template);
		$template = str_replace('{photo-author_name}', "$author_name", $template);//
		$template = str_replace('{description}', "$description", $template);
		$template = str_replace('{avatar_author_src}', $author_avatar_src, $template);////////////
		$template = str_replace('{current_user_avatar_src}', $user_avatar_src, $template);
		$template = str_replace('{comments}', "$comments", $template);
		return ($template);
	}
	header("Location: "."../gallery.php");
	return (null);
}

$title = "TEMPORARY POPUP";
$header = file_get_contents("tpl/inner_header--layout.php");
$content = file_get_contents("tpl/popup_photo_comments--layout.php");
$content = render_inner_content_popup($content);
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$templates=$photo . $answer;
$scripts = "";
$file = str_replace('{templates}',$templates, $file);
$file = str_replace('{scripts}',$scripts, $file);
print($file);
