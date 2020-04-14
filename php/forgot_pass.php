<?php

include_once "../config/connect.php";
$email = $_GET['email'];

send_mail_to_user_change_pass($email);

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

function send_mail_to_user_change_pass($email)
{
	$newtoken = zero_password_and_create_new_token($email);
	$to = $email;
	$subject = 'change_pass';
	$link = "http://localhost/change_pass.html?email=$to&token=$newtoken";
	$message = "Hello! If you want to change your paswword, please get this <a href='$link'>link</a>!";
	echo $message;
	$headers = array(
		'From' => 'cat_lover@list.ru',
		'Reply-To' => 'cat_lover@list.ru'
	);
	$result = mail($to, $subject, $message, $headers);
	return ($result);
}
