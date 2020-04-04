<?php
include_once "validity.php";
include_once "databases.php";

check_registration_for_user();


function open_session($user)
{
	$mydb="mydb";
	$pdo = connect_to_database($mydb);;
	$find_user= $pdo->prepare("SELECT user FROM users2 WHERE user = ?");
	$find_user->execute([$user]);
	$user = $find_user->fetchColumn();
	$pdo = null;
	session_start();
		$_SESSION['user'] = $user;
	header("Location: "."../inner_camagru.php");
}

function check_registration_for_user()
{
	$mydb="mydb";
	$pdo = connect_to_database($mydb);;
	$arr = check_validity();
	if ($arr != NULL) {
		$user = $arr[0];
		$pass = $arr[1];

		$smtp_email = $pdo->prepare("SELECT COUNT(*) FROM users2 WHERE user = ? AND accepted_email = ?");
	 	$smtp_email->execute(array($user, "1"));
		$count_email = $smtp_email->fetchColumn();

		$smtp_pass =  $pdo->prepare("SELECT password FROM users2 WHERE user = ? AND accepted_email = ?");
		$smtp_pass->execute(array($user, "1"));
		//$pass_hash=$smtp_pass->fetch()['password'];
		$pass_hash = $smtp_pass->fetch()['password'];
		$check_pass = password_verify($pass, $pass_hash);
		if ($check_pass == false)
		{
			echo "wrong pass";
			exit;
		}
		if ($count_email == 1 && $check_pass == true)
		{
			open_session($user);
		}
		else
			echo "problem!email not confirmed";
	}
	$pdo = null;
}