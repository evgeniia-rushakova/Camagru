<?php
include_once "../config/connect.php";

if(isset($_GET))
{
	$email = $_GET['user'];
	$token = $_GET['token'];
}

function check_token($email, $token)
{
	$pdo = connect_to_database();
	$check = $pdo->prepare("SELECT COUNT(*) FROM users where email = ? AND token = ?");
	$check->execute(array(
		$email,
		$token
	));
	$count_user = $check->fetchColumn();
	if ($count_user == 1)
	{
		$confirm = $pdo->prepare("UPDATE users SET accepted_email = TRUE WHERE email = ?");
		$confirm->execute([$email]);
		$smtp = $pdo->prepare("UPDATE users SET token = ? where email = ?");
		$rand_token =bin2hex(random_bytes(20));
		$smtp->execute(array($rand_token, $email));
		return (1);
	}
	$pdo = null;
	return (0);
}

if (check_token($email, $token) == 1)
	echo "<script>alert('E-mail confirmed!'); location.href='../index.php';</script>";
else
	echo "<script>alert('Token is incorrect!Please get new token by e-mail.'); location.href='../index.php';</script>";

