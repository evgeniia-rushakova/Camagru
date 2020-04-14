<?php
include_once "config/connect.php";
session_start();
function get_gallery_photos()
{
	$photos_array = scandir("img/gallery_photos");
	unset($photos_array[0]);
	unset($photos_array[1]);
	$result = "";
	$width = "150px";
	$height = "auto";
	$template_origin = file_get_contents("tpl/photo_in_gallery--layout.php");
	$pdo =  connect_to_database();
	foreach ($photos_array as $item)
	{
		$sql = $pdo->prepare("SELECT description FROM photos WHERE photo = ?") ;
		$sql->execute([$item]);
		$img_alt = $sql->fetchColumn();
		$img_src = "../img/gallery_photos/" . $item;
		$template = $template_origin;
		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_name}', $item, $template);
		$template = str_replace('{img_alt}', $img_alt, $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{description}', $img_alt, $template);
		$result .= $template;
	}
	$pdo = null;
	return ($result);
}