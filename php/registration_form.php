<?php
include_once "databases.php";
include_once "validity.php";

$mydb="mydb";
$pdo = connect_to_database($mydb);

function send_mail_to_user_confirm_email($arr)
{
	$to = $arr[1];
	$user = $arr[0];
	$subject = 'confirmation';
	$token =$arr[3];
	$link = "http://localhost/php/check_token.php?user=$to&token=$token";
	$message = "Hello, $user! If you want to confirm your email, please get this <a href=$link>link</a>!";
	$headers = array(
		'From' => 'cat_lover@list.ru',
		'Reply-To' => 'cat_lover@list.ru'
	);
	$result = mail($to, $subject, $message, $headers);
	return ($result);
}

function add_user_into_table($pdo, $arr)
{
	$newuser = $arr[0];
	$newwuseremail = $arr[1];
	$newwuserpass = password_hash($arr[2], PASSWORD_BCRYPT);
	$token =bin2hex(random_bytes(20));
	$arr[] = $token;
	$newstringintable = "INSERT INTO Users (user, email, password, accepted_email, token, notifications) VALUES ('$newuser','$newwuseremail', '$newwuserpass', false, '$token', true)";
	$pdo->exec($newstringintable);

	$smtp = $pdo->prepare("SELECT id FROM users WHERE user = ?");
	$smtp->execute(array($newuser));
	$author = $smtp->fetch()['id'];

	$new_filename = "empty__avatar.png";
	$smtp = "INSERT INTO avatars (name, author_id) VALUES ('$new_filename', '$author')";
	$pdo->exec($smtp);

	if (send_mail_to_user_confirm_email($arr) == false)
		echo "EMAIL NOT SENDED!\n";
	else
	{
		header("Location: "."../index.php");//добавить сообщение типа проверь почту
		print("  <script>alert( 'Подтвержденоо' );</script>");
	}
}

function is_this_is_new_user($pdo, $arr)
{
	$sql = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user = ? AND  email= ?");
	$sql->execute(array($arr[0], $arr[1]));
	$count = $sql->fetchColumn();

	if ($count > 0)
		return (false);
	return (true);
}

if ($result_arr = check_validity())
{
	if (is_this_is_new_user($pdo, $result_arr) == true)
	{
		add_user_into_table($pdo, $result_arr);
	}
	else
		echo "USER IS ALREADY IN TABLE" . PHP_EOL;//add popup
	$pdo = null;
}
else
	echo "BAD DATA\n";
