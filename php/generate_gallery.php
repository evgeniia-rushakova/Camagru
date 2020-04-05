<?php
include_once "databases.php";
//if (isset($_REQUEST[session_name()])) session_start();
session_start();
function get_gallery_photos()
{
	$photos_array = scandir("gallery_photos");
	unset($photos_array[0]);
	unset($photos_array[1]);
	$result = "";
	$width = "150px";
	$height = "150px";
	$template_origin = file_get_contents("tpl/photo_in_gallery--layout.php");
	$mydb="mydb";
	$pdo =  connect_to_database($mydb);
	foreach ($photos_array as $item)
	{
		$sql = $pdo->prepare("SELECT description FROM photos WHERE photo = ?") ;
		$sql->execute([$item]);
		$img_alt = $sql->fetchColumn();
		$img_src = "../gallery_photos/$item";
		$template = $template_origin;
		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_alt}', "$img_alt", $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{description}', "$img_alt", $template);
		$result .= $template;
	}
	$pdo = null;
	return ($result);
}