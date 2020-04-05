<?php
include_once "databases.php";
include_once "validity.php";
$addr = $_SERVER['HTTP_REFERER'];
$pass1 = $_GET['password'];
$pass2 = $_GET['password2'];

function check_token_and_email($addr)
{
	$str = explode("?", $addr) [1];
	$email = explode("=", explode("&", $str) [0]) [1];
	$token = explode("=", $str) [2];
	$pdo = $mydb = "mydb";
	connect_to_database($mydb);;
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

function change_password($pass1, $pass2, $email)
{
	if (strcmp($pass1, $pass2) == 0)
	{
		$arr = check_validity();
		if ($arr == NULL) echo "password is bad";
		else
		{
			$mydb = "mydb";
			$pdo = connect_to_database($mydb);
			$newwuserpass = password_hash($pass1, PASSWORD_BCRYPT);
			$change_pass = $pdo->prepare("UPDATE Users SET password = ? WHERE email = ?");
			$change_pass->execute(array(
				md5($newwuserpass) ,
				$email
			));
			$pdo = null;
			return (1);
		}
	}
	else echo "passwords not identical";
	return (0);
}

if (($email = check_token_and_email($addr)) != NULL)
{
	if (change_password($pass1, $pass2, $email) == 1) echo "password changed successfully";
	else echo "password not changed";
}

