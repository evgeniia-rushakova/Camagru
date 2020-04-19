<?php
include_once "validity.php";
include_once "../config/connect.php";

check_registration_for_user();
function open_session($user)
{
	$pdo = connect_to_database();;
	$find_user= $pdo->prepare("SELECT user FROM users WHERE user = ?");
	$find_user->execute([$user]);
	$user = $find_user->fetchColumn();
	$pdo = null;
	session_start();
	$_SESSION['user'] = $user;
	header("Location: "."../inner_camagru.php");
}

function check_registration_for_user()
{
	$pdo = connect_to_database();;
	$arr = check_validity();
	if ($arr != NULL) {
		$user = clean_data($arr[0]);
		$pass = $arr[1];

		$smtp_email = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user = ? AND accepted_email = ?");
		$smtp_email->execute(array($user, "1"));
		$count_email = $smtp_email->fetchColumn();
		if ($count_email)
		{
			$smtp_pass =  $pdo->prepare("SELECT password FROM users WHERE user = ? AND accepted_email = ?");
			$smtp_pass->execute(array($user, "1"));
			$pass_hash = $smtp_pass->fetch()['password'];
			$check_pass = password_verify($pass, $pass_hash);
			if ($check_pass == false)
			{
				echo "<script>alert('Incorrect login or password!'); location.href='../index.php';</script>";
				exit;
			}
		}
		if ($count_email == 1 && $check_pass == true)
		{
			open_session($user);
			exit;
		}
	}
	echo "<script>alert('Error!Wrong password or username.'); location.href='../index.php';</script>";
	$pdo = null;
}