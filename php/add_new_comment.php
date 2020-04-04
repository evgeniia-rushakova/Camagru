<?php
include_once "databases.php";
include_once "validity.php";

session_start();
add_new_comment();

function send_mail_to_user_about_new_comment($author_email, $comment_author, $photo, $comment_text)
{
	$subject = "New comment to yur photo!";
	$to = $author_email;
	$link = "http://localhost/add_popup_photo.php?../gallery_photos/" . $photo;

	$message = "Hello! User $comment_author commented your <a href=$link>photo</a>: $comment_text";
	//echo $message;
	$headers = array(
		'From' => 'cat_lover@list.ru',
		'Reply-To' => 'cat_lover@list.ru'
	);
	mail($to, $subject, $message, $headers);
}

function add_new_comment()
{
	/*$mydb = "mydb";
	$pdo = connect_to_database($mydb);
	$user = $_SESSION['user'];
	$comment_text = clean_data($_GET['comment']);
	$comment_date = date("F j, Y, g:i a");
	$photo = $_GET['main-photo'];
	$author_photo = $_GET['author_photo'];

	$email_sql_author = $pdo->prepare("SELECT email FROM Users2 WHERE user = ?");
	$email_sql_author->execute(array($user));
	$comment_author = $email_sql_author->fetch()['email'];

	$sql = "INSERT INTO comments (photo, photo_author, date_of_comment, comment_author, comment_text) VALUES ('$photo', '$author_photo', '$comment_date', '$user', '$comment_text')";
	$pdo->exec($sql);
	$email_sql = $pdo->prepare("SELECT email FROM Users2 WHERE user = ?");
	$email_sql->execute(array($author_photo));
	$author_email = $email_sql->fetch()['email'];
	//send_mail_to_user_about_new_comment($author_email, $comment_author, $photo, $comment_text);*/
///////////////////////////////////////////////////////NO TABLE USERS
	$user = $_SESSION['user'];
	$mydb = "mydb";
	$pdo = connect_to_database($mydb);
	$name_of_author_photo=  $_GET['author_photo'];
	$photo_name = $_GET['main-photo'];
	$comment_text = clean_data($_GET['comment']);
	$photo = $_GET['main-photo'];
	$dbname ="test_keys";
	$pdo->query("use $dbname");

	$smtp = $pdo->prepare("SELECT * FROM photos where photo = ?");
	$smtp->execute(array($photo_name));
	$result = $smtp->fetch();
	$author_of_photo_email_id = $result['author_id'];
	$photo_id = $result['id'];

	$smtp = $pdo->prepare("SELECT * FROM users where id = ?");
	$smtp->execute(array($author_of_photo_email_id));

	$author_of_photo_email = $smtp->fetch()['email'];
	$smtp = $pdo->prepare("SELECT * FROM users where user = ?");
	$smtp->execute(array($user));
	$author_of_comment_id = $smtp->fetch()['id'];
	$date = date('Y-m-d-H-i-s');
	$sql = "INSERT INTO comments (photo_id, date_of_comment, comment_author, comment_text) VALUES ($photo_id, '$date', $author_of_comment_id, '$comment_text')";
	$pdo->exec($sql);

	send_mail_to_user_about_new_comment($author_of_photo_email, $user, $photo, $comment_text);
/// ////////////////////////////////////////////
///
///
header("Location: " . $_SERVER["HTTP_REFERER"]);
}

