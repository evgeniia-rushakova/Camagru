<?php
include_once "../config/connect.php";
session_start();

mix_photo();

function mix_photo()
{
	$filters = array();
	foreach ($_GET as $item)
	{
		if(strstr($item, "filter_"))
		{
			$filters[] = $item;
		}
	}
	if(strcmp($_GET['file_type'],"upload") == 0)
	{
		$photo = "../img/temp_img/" . $_SESSION['file'];
		$filter = "../img/filters/" . $filters[0];
		$photo_id = imagecreatefromjpeg($photo);
		$filter_id = imagecreatefrompng($filter);
		imageAlphaBlending($filter_id, false);
		imageSaveAlpha($filter_id, true);
		$sourcefile_width=imageSX($photo_id);
		$sourcefile_height=imageSY($photo_id);
		$watermarkfile_width=imageSX($filter_id);
		$watermarkfile_height=imageSY($filter_id);

		$dest_x = ( $sourcefile_width / 2 ) - ( $watermarkfile_width / 2 );
		$dest_y = ( $sourcefile_height / 2 ) - ( $watermarkfile_height / 2 );////////
		imagecopy($photo_id, $filter_id, $dest_x, $dest_y, 0, 0,
			$watermarkfile_width, $watermarkfile_height);
	//	header("Content-type: image/jpg");
		$new_photo_name =  "../img/temp_img/" . "result_" . $_SESSION['file'];
		imagejpeg ($photo_id, $new_photo_name, 75);
		imagedestroy($photo_id);
		imagedestroy($filter_id);
		header("Location: ". "../inner_camagru.php?". "copy=success&result=" . $new_photo_name);
		//unset($_SESSION['file']);
	}
	else
		header("Location: ". "../inner_camagru.php" . "copy=fail");
}