<?php
include_once "../config/connect.php";
include_once "validity.php";
session_start();


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
			return ("Username succesfully changed. Hello," . $newusername . "!");
		}
		else
			return ("this username is already busy. Please, choose other username.");
	}
	return ("Wrong password");
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
			return ("Email succesfully changed. Your new email is:" . $newemail . ".");
		}
		else
			return ("this username is already busy. Please, choose other username.");
	}
	return ("Wrong password");
}

function change_password()
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
	}
	return ("Wrong password");
}

function change_notifications()
{
	global $info;
	global $pdo;
	if (strcmp("yes", $_GET['val']) == 0)
		$val = 0;
	else
		$val = 1;
	$smtp = $pdo->prepare("UPDATE users SET notifications = ? where id = ?");
	$smtp->execute(array($val, $info['id']));
}



	$user = $_SESSION['user'];
	$info = get_user_info_arr($user);
	if ($info != false && $user != false)
	{
		if (strcmp($_GET['act'], "change_username") == 0)
			change_username();
		else if (strcmp($_GET['act'], "change_email") == 0)
			change_email();
		else if (strcmp($_GET['act'], "change_password") == 0)
			change_password();
		else if (strcmp($_GET['act'], "notifications") == 0)
			change_notifications();
		header("Location: ".$_SERVER["HTTP_REFERER"]);
	}
	else
		header("Location: ".$_SERVER["HTTP_REFERER"]);


