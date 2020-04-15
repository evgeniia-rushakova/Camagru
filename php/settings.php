<?php
include_once "../config/connect.php";
include_once "validity.php";
session_start();


function change_password_outside_cabinet()
{
	$user = $_GET['user'];
	$pass = $_GET['password'];
	global $pdo;
	$arr = check_validity();
	if ($arr == NULL)
		echo "<script>alert('Error! Bad data.'); location.href='../cabinet.php';</script>";
	else
	{
		$newwuserpass = password_hash($pass, PASSWORD_BCRYPT);
		$change_pass = $pdo->prepare("UPDATE Users SET password = ? WHERE user = ?");
		$change_pass->execute(array(
			$newwuserpass,
			$user
		));
		$pdo = null;
		echo "<script>alert('Password changed!'); location.href='../cabinet.php';</script>";
		return;
	}
	echo "<script>alert('Error!Please, try again.'); location.href='../cabinet.php';</script>";
}

$pdo = connect_to_database();

function get_user_info_arr($user)
{
	global $pdo;
	$smtp = $pdo->prepare("SELECT * FROM users where user = ?");
	$smtp->execute(array($user));
	$info = $smtp->fetch();
	return ($info);
}

function send_mail_about_changing_settings($to, $subject, $message)
{
	$headers = array(
		'From' => 'cat_lover@list.ru',
		'Reply-To' => 'cat_lover@list.ru'
	);
	mail($to, $subject, $message, $headers);
}

function change_username()
{
	global $info;
	global $pdo;

	if (check_validity() != null && password_verify($_GET['password'], $info['password']) == 1)
	{
		$newusername = $_GET['newusername'];
		$smtp = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user = ?");
		$smtp->execute(array($newusername));
		$is_new_username_unique = $smtp->fetchColumn();
		if ($is_new_username_unique == 0)
		{
			$smtp = $pdo->prepare("UPDATE users SET user = ? where id = ?");
			$smtp->execute(array($newusername, $info['id']));
			$user = $_SESSION['user'];
			$_SESSION['user'] = $newusername;
			$message = "Hello, $user! Your username is changed successfully! Now your username is $newusername. Enjoy Camagru!";
			send_mail_about_changing_settings($info['email'], "Change username", $message);
			echo "<script>alert('Username successfully changed.'); location.href='../cabinet.php';</script>";
		}
		else
			echo "<script>alert('this username is already busy. Please, choose other username.'); location.href='../cabinet.php';</script>";
		exit;
	}
	echo "<script>alert('Wrong password! Try again.'); location.href='../cabinet.php';</script>";
}

function change_email()
{
	global $info;
	global $pdo;

	if (check_validity() != null && password_verify($_GET['password'], $info['password']) == 1)
	{
		$newemail = $_GET['email'];
		$smtp = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user = ?");
		$smtp->execute(array($newemail));
		$is_new_email_unique = $smtp->fetchColumn();
		if ($is_new_email_unique == 0)
		{
			$smtp = $pdo->prepare("UPDATE users SET email = ? where id = ?");
			$smtp->execute(array($newemail, $info['id']));
			$user = $_SESSION['user'];
			$message = "Hello, $user! Your email is changed successfully! Now your email is $newemail. Enjoy Camagru!";
			send_mail_about_changing_settings($info['email'], "Changing email", $message);
			$message = "Hello, $user! Your email is changed successfully! This is your main email. Enjoy Camagru!";
			send_mail_about_changing_settings($newemail, "Your new email", $message);
			echo "<script>alert('E-mail successfully changed.'); location.href='../cabinet.php';</script>";
		}
		else
			echo "<script>alert('this e-mail is already busy. Please, choose other username.'); location.href='../cabinet.php';</script>";
		exit;
	}
	echo "<script>alert('Wrong password! Try again.'); location.href='../cabinet.php';</script>";
}

function change_password_inside_cabinet()
{
	global $info;
	global $pdo;

	if (check_validity() != null && password_verify($_GET['password'], $info['password']) == 1)
	{
		$user = $info['user'];
		$email = $info['email'];
		$newpassword = password_hash($_GET['newpassword'], PASSWORD_BCRYPT);
		$smtp = $pdo->prepare("UPDATE users SET password = ? where id = ?");
		$smtp->execute(array($newpassword, $info['id']));
		$message = "Hello, $user! Your password is changed successfully! Enjoy Camagru!";
		send_mail_about_changing_settings($email, "Password changed", $message);
		echo "<script>alert('Password successfully changed.'); location.href='../cabinet.php';</script>";
	}
	echo "<script>alert('Wrong password! Try again.'); location.href='../cabinet.php';</script>";
}

function change_notifications()
{
	global $info;
	global $pdo;

	if ($info['notifications'] == 0)
		$val = 1;
	else
		$val = 0;
	$smtp = $pdo->prepare("UPDATE users SET notifications = ? where id = ?");
	$smtp->execute(array($val, $info['id']));
	header("Location: ".$_SERVER["HTTP_REFERER"]);
}

function zero_password_and_create_new_token($email)
{
	$pdo = connect_to_database();;
	$fakepass=NULL;
	$newtoken =bin2hex(random_bytes(20));
	$zeropass = $pdo->prepare("UPDATE Users SET password = ? WHERE email = ?");
	$zeropass->execute(array($fakepass,$email));
	$change_token = $pdo->prepare("UPDATE Users SET token = ? WHERE email = ?");
	$change_token->execute(array($newtoken, $email));
	$pdo = null;
	return ($newtoken);
}

function forgot_password()
{
	$email = $_GET['email'];
	$pdo = connect_to_database();
	$smtp = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
	$smtp->execute(array($email));
	$user = $smtp->fetchColumn();
	$pdo = null;
	if ($user == 1)
	{
		$newtoken = zero_password_and_create_new_token($email);
		$to = $email;
		$subject = 'change_pass';
		$link = "http://localhost/php/change_pass.php?email=$to&token=$newtoken";
		$message = "Hello! If you want to change your paswword, please get this <a href='$link'>link</a>!";
		$headers = array(
			'From' => 'cat_lover@list.ru',
			'Reply-To' => 'cat_lover@list.ru'
		);
		mail($to, $subject, $message, $headers);
		echo "<script>alert('Please, check your e-mail!'); location.href='../index.php';</script>";
	}
	echo  "<script>location.href='../index.php';alert('Error!There is no users with such e-mail. Try again'); </script>";

}


	if (strcmp($_GET['act'], "forgot_password") == 0)
		forgot_password();
	else if (strcmp($_GET['act'], "change_password_outside") == 0)
		change_password_outside_cabinet();
	else {
		$user = $_SESSION['user'];
		$info = get_user_info_arr($user);
		if ($info != false && $user != false) {
			if (strcmp($_GET['act'], "change_username") == 0)
				change_username();
			else if (strcmp($_GET['act'], "change_email") == 0)
				change_email();
			else if (strcmp($_GET['act'], "change_password") == 0)
				change_password_inside_cabinet();
			else if (strcmp($_GET['act'], "notifications") == 0)
				change_notifications();
		}
	}



