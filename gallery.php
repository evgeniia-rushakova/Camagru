<?php
include_once "php/generate_gallery.php";
if (!isset($_SESSION))
	session_start();

$title = "Gallery";
$pagination = generate_pagination($_GET['page']);
$gallery = get_gallery_photos($_GET['page']);
if(isset($_SESSION['user']) && $_SESSION['user'])
	$header = file_get_contents("tpl/inner_header--layout.php");
else
	$header = file_get_contents("tpl/main_header--layout.php");
$content = file_get_contents("tpl/gallery_main--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$file = str_replace('{gallery-photos}', $gallery, $file);
$file = str_replace('{pagination}', $pagination, $file);
$file = str_replace('{templates}', "", $file);
$file = str_replace('{scripts}', "", $file);

print($file);