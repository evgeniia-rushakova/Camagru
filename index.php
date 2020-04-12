<?php
include_once "php/databases.php";
create_database();
//ob_start();
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
print($file);
//ob_get_clean();

