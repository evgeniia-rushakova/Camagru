<?php
include_once("file_upload_validity.php");
if(!isset($_SESSION))
	session_start();

if (check_uploaded_file() == true)
{
	$filters_array = scandir("../img/filters");
	unset($filters_array[0]);
	unset($filters_array[1]);

	$file = explode(".", $_FILES['userfile']['name']);
	$typefile = "." . $file[count($file) - 1];
	if ($typefile === '.png')
	{
		$filter_counter = count($filters_array) + 1;
		$new_filename= "filter_(" .  $filter_counter . ")". $typefile;
		$name = $_FILES['userfile']['name'];
		$dest_dir = "../img/filters/";
		$filename = $_FILES['userfile']['tmp_name'];
		list($width, $height) = getimagesize($filename);
		if($width > 480)
			$percent = $width/480;
		else
			$percent = 1;
		$newwidth = floor($width / $percent);
		$newheight = floor($height / $percent);
		$source = imagecreatefrompng($filename);
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($thumb, false);
		imagesavealpha($thumb, true);
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng($thumb, $dest_dir . $new_filename, 8.5);
		imagedestroy($thumb);
		echo "<script>alert('You add new sticker!'); location.href='../inner_camagru.php';</script>";
	}
	else
		echo "<script>alert('Error with adding sticker!'); location.href='../inner_camagru.php';</script>";
}
