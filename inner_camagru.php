<?php
include_once "php/cabinet_functions.php";
include_once "tpl/popups--layout.php";
include_once "config/connect.php";
if(!isset($_SESSION['user'])|| $_SESSION['user']==false)
{
	header("Location: index.php");
	exit;
}

$pdo= connect_to_database();
$info = get_user_info($pdo);

if(!$info['photos'])
	$gallery = '<p class="gallery-container--inner-title" style="font-size: 14px;"> No photos yet. </p>';
else
{
	if (count($info['photos']) > 5)
		$info['photos'] =array_slice($info['photos'],0, 4);
	$gallery = get_photos_content($info['photos'], $pdo);
}

$title = "Jslave Camagru";
$filters = get_filters($pdo);
$header = file_get_contents("tpl/inner_header--layout.php");
$content = file_get_contents("tpl/camagru_main--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$file = str_replace('{gallery}', $gallery, $file);

$file = str_replace('{filters}', $filters, $file);

$templates=$photo;
if (isset($_SESSION['file']))
	$file = str_replace('{uploaded_img}',"../img/temp_img/". $_SESSION['file'],$file);
$scripts = '<script src="js/camagru.js"></script>';
$file = str_replace('{templates}',$templates, $file);
$file = str_replace('{scripts}',$scripts, $file);
$pdo = null;
print($file);