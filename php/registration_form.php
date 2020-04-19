<?php
include_once "../config/connect.php";
include_once "validity.php";

$pdo = connect_to_database();

function send_mail_to_user_confirm_email($arr)
{
	$to = $arr[1];
	$user = $arr[0];
	$subject = 'confirmation';
	$token =$arr[3];
	$link = "http://localhost/php/check_token.php?user=$to&token=$token";
	$message = "Hello, $user! If you want to confirm your email, please get this <a href=$link>link</a>!";
	$headers = array(
		'From' => 'cat_lover@list.ru',
		'Reply-To' => 'cat_lover@list.ru'
	);
	$result = mail($to, $subject, $message, $headers);
	return ($result);
}

function add_user_into_table($pdo, $arr)
{
	$newuser = $arr[0];
	$newwuseremail = $arr[1];
	$newwuserpass = password_hash($arr[2], PASSWORD_BCRYPT);
	$token =bin2hex(random_bytes(20));
	$arr[] = $token;
	$newstringintable = "INSERT INTO Users (user, email, password, accepted_email, token, notifications) VALUES ('$newuser','$newwuseremail', '$newwuserpass', false, '$token', true)";
	$pdo->exec($newstringintable);

	$smtp = $pdo->prepare("SELECT id FROM users WHERE user = ?");
	$smtp->execute(array($newuser));
	$author = $smtp->fetch()['id'];

	$new_filename = "empty_avatar.png";
	$smtp = "INSERT INTO avatars (name, author_id) VALUES ('$new_filename', '$author')";
	$pdo->exec($smtp);

	if (send_mail_to_user_confirm_email($arr) == false)
		echo "<script>alert('Error!E-mail is not sended.'); location.href='../index.php';</script>";
	else
		echo "<script>alert('Please, check your e-mail!'); location.href='../index.php';</script>";

}

function is_this_is_new_user($pdo, $arr)
{
	$sql = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user = ? AND  email= ?");
	$sql->execute(array($arr[0], $arr[1]));
	$count = $sql->fetchColumn();

	if ($count > 0)
		return (false);
	return (true);
}

if ($result_arr = check_validity())
{
	if (is_this_is_new_user($pdo, $result_arr) == true)
	{
		add_user_into_table($pdo, $result_arr);
	}
	else
		echo "<script>alert('Error!This username or e-mail is busy.Try another.'); location.href='../index.php';</script>";
	$pdo = null;
}
else
	echo "<script>alert('Error!Bad data'); location.href='../index.php';</script>";
