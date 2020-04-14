<?php
include_once "../config/connect.php";

$email = $_GET['user'];
$token = $_GET['token'];

function check_token($email, $token)
{
	$pdo = connect_to_database();
	$check = $pdo->prepare("SELECT COUNT(*) FROM Users where email = ? AND token = ?");
	$check->execute(array(
		$email,
		$token
	));
	$count_user = $check->fetchColumn();
	if ($count_user == 1)
	{
		$confirm = $pdo->prepare("UPDATE Users SET accepted_email = TRUE WHERE email = ?");
		$confirm->execute([$email]);
		return (1);
	}
	$pdo = null;
	return (0);
}

if (check_token($email, $token) == 1) echo "EMAIL_CONFIRMED";
else echo "EMAIL IS NOT CONFIRMED";
header("Location: " . "../index.php"); //добавить сообщение типа успех или нет

