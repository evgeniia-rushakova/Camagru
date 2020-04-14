<?php
include_once "config/connect.php";
include_once "php/cabinet_functions.php";
include_once "tpl/popups--layout.php";
//session_start();

if(!isset($_SESSION['user'])|| $_SESSION['user']==false)
{
	header("Location: index.php");
	exit;
}

$pdo = connect_to_database();
$title = "Settings";
$header = file_get_contents("tpl/inner_header--layout.php");
$content = file_get_contents("tpl/cabinet--layout.php");
$info = get_user_info($pdo);
$content = generate_profile_content($content, $info, $pdo);
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$file = str_replace('{user_avatar}', $info['avatar'], $file);
$templates=$change_username . $change_password . $change_email . $answer;
$scripts = '<script src="js/popup_listeners.js"></script>';
$file = str_replace('{templates}',$templates, $file);
$file = str_replace('{scripts}',$scripts, $file);
print($file);