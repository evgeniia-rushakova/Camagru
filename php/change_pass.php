<?php
include_once "../config/connect.php";
include_once "validity.php";

$addr = $_SERVER['HTTP_REFERER'];
$pass1 = $_GET['password'];
$pass2 = $_GET['password2'];
session_start();

function check_token_and_email($addr)
{
	$str = explode("?", $addr) [1];
	$email = explode("=", explode("&", $str) [0]) [1];
	$token = explode("=", $str) [2];
	$pdo = connect_to_database();;
	$check = $pdo->prepare("SELECT COUNT(*) FROM Users where email = ? AND token = ?");
	$check->execute(array(
		$email,
		$token
	));
	$check_result = $check->fetchColumn();
	$pdo = null;
	if ($check_result == 1) return ($email);
	return (NULL);
}

function change_password($pass1, $email)
{

		$arr = check_validity();
		if ($arr == NULL) echo "password is bad";
		else
		{
			$pdo = connect_to_database();
			$newwuserpass = password_hash($pass1, PASSWORD_BCRYPT);
			$change_pass = $pdo->prepare("UPDATE Users SET password = ? WHERE email = ?");
			$change_pass->execute(array(
				md5($newwuserpass) ,
				$email
			));
			$pdo = null;
			return (1);
		}

	return (0);
}

if (($email = check_token_and_email($addr)) != NULL)
{
	if (change_password($pass1, $pass2, $email) == 1)
		echo "password changed successfully";
	else echo "password not changed";
}

