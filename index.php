<?php
include_once "tpl/popups--layout.php";
if (!isset($_SESSION))
	session_start();
if (isset($_SESSION['user']))
{
	header("Location: "."inner_camagru.php");
	exit();
}

$title = "Jslave Camagru";
$header = file_get_contents("tpl/main_header--layout.php");
$content = file_get_contents("tpl/sign-in-form--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);

$templates=$forgot_password . $answer;
$scripts = '<script src="js/check_repeated_form_inputs.js"></script>' . '<script src="js/popup_listeners.js"></script>';
$file = str_replace('{templates}',$templates, $file);
$file = str_replace('{scripts}',$scripts, $file);

print($file);

