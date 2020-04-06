<?php
include_once "php/generate_gallery.php";
/*session_start();
if(!isset($_SESSION['user'])|| $_SESSION['user']==false)
{
	header("Location: index.php");
	exit;
}*/
$title = "Gallery";
$test = get_gallery_photos();
$header = file_get_contents("tpl/inner_header--layout.php");
$content = file_get_contents("tpl/gallery_main--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$file = str_replace('{gallery-photos}', $test, $file);
print($file);