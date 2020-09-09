<?php
include_once ("../config/connect.php");
include_once "validity.php";
function generate_comments($pdo, $photo_info)
{

	$result = $pdo->prepare("SELECT * FROM comments INNER JOIN users ON comments.comment_author=users.id INNER JOIN avatars ON users.id=avatars.author_id where photo_id = ?");
	$result->execute(array($photo_info['id']));
	$fetch = $result->fetchAll();
	$final= "";
	foreach ($fetch as $item)
	{
		$template = file_get_contents("../tpl/comment--layout.php");
		$author = $item['user'];
		$user_avatar = $item['name'];
		$date = $item['date_of_comment'];
		$text = $item['comment_text'];
		$template = str_replace('{comment-author}', $author, $template);
		$template = str_replace('{comment-date}', $date, $template);
		$template = str_replace('{comment-text}', $text, $template);
		$template = str_replace('{user_avatar}', $user_avatar, $template);
		$final.=$template;
	}
	$pdo = null;
	echo ($final);
}

function send_mail_to_user_about_new_comment($author_email, $comment_author, $photo, $comment_text)
{
	$subject = "New comment to yur photo!";
	$to = $author_email;
	$link =  "http://" . $_SERVER['HTTP_HOST'] . "/photo_page.php?" . $photo;

	$message = "Hello! User $comment_author commented your <a href='$link'>photo</a>: $comment_text";
	$headers =
		'From: Camagru <21@extech.ru>'
		. "\r\n" . 'Reply-To: <21@extech.ru>'
		. "\r\n" . 'Content-Type: text/html; charset=utf-8';
	mail($to, $subject, $message, $headers);
}

function add_new_comment($pdo, $photo_info)
{
	$user = $_SESSION['user'];
	$sql = $pdo->prepare("SELECT * FROM photos INNER JOIN users ON photos.author_id=users.id WHERE photo = ?");
	$sql->execute(array($photo_info['photo']));
	$photo_info2 = $sql->fetch();
	$photo_name = $_POST['main-photo'];
	$comment_text = clean_data($_POST['comment']);
	$smtp = $pdo->prepare("SELECT * FROM users where user = ?");
	$smtp->execute(array(
		$user
	));

	$user_info =  $smtp->fetch();
	$author_of_comment_id = $user_info['id'];
	$author_of_photo_email = $photo_info2['email'];
	$need_notificate = $photo_info2['notifications'];
	$photo_id = $photo_info['id'];
	$date = date('Y-m-d-H-i-s');
	$sql = "INSERT INTO comments (photo_id, date_of_comment, comment_author, comment_text) VALUES ($photo_id, '$date', $author_of_comment_id, '$comment_text')";
	$pdo->exec($sql);

	if ($need_notificate == 1)
		send_mail_to_user_about_new_comment($author_of_photo_email, $user, $photo_name, $comment_text);
	echo generate_comments($pdo, $photo_info);
}

function delete_comment_ajax($pdo, $photo_info)
{
	if(isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		$comment_date = $_POST['comment-date'];
		$smtp = $pdo->prepare("SELECT * FROM users WHERE user = ?");
		$smtp->execute(array($user));
		$user_id = $smtp->fetch()['id'];

		$smtp = $pdo->prepare("SELECT * FROM comments WHERE date_of_comment = ?");
		$smtp->execute(array($comment_date));
		$result = $smtp->fetch();
		$comment_author_id = $result['comment_author'];
		$comment_id = $result['id'];

		if (strcmp($user_id, $comment_author_id) == 0 || strcmp($user, "admin") == 0) {
			$del = $pdo->prepare("DELETE FROM comments WHERE id = ?");
			$del->execute(array($comment_id));
		}
	}
	echo generate_comments($pdo, $photo_info);
}

if(!isset($_SESSION))
	session_start();
$pdo = connect_to_database();
$arr = explode("?",$_SERVER['HTTP_REFERER']);
$photo_name = $arr[count($arr) - 1];
$sql = $pdo->prepare("SELECT * FROM photos  WHERE photo = ?");
$sql->execute(array($photo_name));
$photo_info = $sql->fetch();
if(isset($_POST) && isset($_POST['act']))
{
	if($_POST['act']== 'add' && isset($_POST['main-photo']) && isset($_POST['comment']))
		add_new_comment($pdo, $photo_info);
	else if ($_POST['act'] == 'delete' && isset($_POST['comment-date']) && isset($_POST['comment-text']))
		delete_comment_ajax($pdo, $photo_info);
}
else
	generate_comments($pdo, $photo_info);
