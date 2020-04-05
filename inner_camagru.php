<?php
include_once "php/generate_gallery.php";

if(!isset($_SESSION['user'])){
	header("Location: index.php");
	exit;
}
$title = "Jslave Camagru";
$header = file_get_contents("tpl/inner_header--layout.php");
$content = file_get_contents("tpl/camagru_mail--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
//$gallery = get_gallery_photos();
//$file.=$gallery;
print($file);