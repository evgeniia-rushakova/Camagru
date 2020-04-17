<?php
include_once "../config/connect.php";
session_start();

mix_photo();

function mix_photo()
{
	$filters = array();
	foreach ($_POST as $item)
	{
		if(strstr($item, "filter_"))
		{
			$filters[] = $item;
		}
	}
	if (strcmp($_POST['file_type'], "camera") == 0)
	{
		$img = $_POST['photo'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$photo =  "../img/temp_img/" . $_SESSION['user'] . "_raw_photo.png";
		file_put_contents($photo, $data);
		$photo_id = imagecreatefrompng($photo);
		$new_photo_name = "../img/temp_img/" . "result_" . $_SESSION['user'] . ".png";
	}
	else if(strcmp($_POST['file_type'],"upload") == 0)
	{
		$photo = "../img/temp_img/" . $_SESSION['file'];
		$photo_id = imagecreatefromjpeg($photo);
		$new_photo_name = "../img/temp_img/" . "result_" . $_SESSION['file'] ;
	}


		if(!$filters)
		{
			copy($photo, $new_photo_name);
		}
		else
			foreach ($filters as $filter)
		{
			$filter_id = imagecreatefrompng("../img/filters/" . $filter);
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
			imagedestroy($filter_id);
			imagejpeg ($photo_id, $new_photo_name, 75);
		}
		imagedestroy($photo_id);

		header("Location: ". "../inner_camagru.php?". "copy=success&result=" . $new_photo_name);
/*
	else
		header("Location: ". "../inner_camagru.php" . "copy=fail");*/
}