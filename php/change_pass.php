<?php
include_once "../config/connect.php";
include_once "validity.php";

function check_token_and_email()
{
	if(isset($_GET))
	{
		$email = $_GET['email'];
		$token = $_GET['token'];
		$pdo = connect_to_database();;
		$check = $pdo->prepare("SELECT COUNT(*) FROM users where email = ? AND token = ?");
		$check->execute(array(
			$email,
			$token
		));
		$check_result = $check->fetchColumn();
		if ($check_result == 1)
		{
			$smtp = $pdo->prepare("UPDATE users SET token = ? where email = ?");
			$rand_token =bin2hex(random_bytes(20));
			$smtp->execute(array($rand_token, $email));
			$pdo = null;
			return ($email);
		}
	}
	return (NULL);
}

$email = check_token_and_email();
if ($email != NULL) {
	header("Location: " . "../inner_reg.php?act=change_password&email=$email");
}
else
	echo "<script>alert('Error! Get new link by e-mail.'); location.href='../index.php';</script>";

