<?php
include_once "tpl/popups--layout.php";
include_once "config/connect.php";
$title = "registration";
if(!isset($_SESSION))
	session_start();
if (isset($_GET) && isset($_GET['act']) && strcmp($_GET['act'], "change_password") == 0)
{
	$title = "Change password";
	$content = file_get_contents("tpl/change_pass--layout.php");

	$pdo = connect_to_database();
	$smtp = $pdo->prepare("SELECT * FROM users WHERE email = ?");
	$smtp->execute(array($_GET['email']));
	$user = $smtp->fetch()['user'];

	$content = str_replace('{user}', $user, $content);

}
else
	$content = file_get_contents("tpl/registration_form--layout.php");
$header = file_get_contents("tpl/main_header--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$templates=$answer;
$scripts = '<script src="js/check_repeated_form_inputs.js"></script>' . '<script type="text/javascript"> waiterForPopupsHandler();</script>';
$file = str_replace('{templates}',$templates, $file);
$file = str_replace('{scripts}',$scripts, $file);
print($file);



