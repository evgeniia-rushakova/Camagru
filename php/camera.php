<?php
include_once "../config/connect.php";
session_start();

mix_photo();

function get_settings_for_filter($photo_id, $filter_id)
{
	$settings = array();
	$sourcefile_width=imageSX($photo_id);
	$sourcefile_height=imageSY($photo_id);
	$watermarkfile_width=imageSX($filter_id);
	switch ($_POST['scale'])
	{
		case  "60":
			{
				$filter_id = imagescale($filter_id, $watermarkfile_width * 0.6);
				break;
			}

		case "30":
			{
				$filter_id = imagescale($filter_id, $watermarkfile_width * 0.3);
				break;
			}
	}
	$settings['filt_w'] = imageSX($filter_id);
	$settings['filt_h'] = imageSY($filter_id);
	$settings['filt_id'] = $filter_id;
	switch ($_POST['position_vert'])
	{
		case  "top":
			{
				$settings['pos_y'] = 0;
				break;
			}

		case "bottom":
			{
				$settings['pos_y'] = $sourcefile_height - $settings['filt_h'];
				break;
			}

		default:
			$settings['pos_y'] = ( $sourcefile_height / 2 ) - ( $settings['filt_h'] / 2 );
	}
	switch ($_POST['position_hor'])
	{
		case  "left":
			{
				$settings['pos_x'] = 0;
				break;
			}

		case "right":
			{
				$settings['pos_x'] = $sourcefile_width - $settings['filt_w'];
				break;
			}

		default:
			$settings['pos_x'] = ( $sourcefile_width / 2 ) - ( $settings['filt_w'] / 2 );
	}
	return ($settings);
}

function get_image_data()
{
	$info = array();

	$filters = array();
	foreach ($_POST as $item)
	{
		if(strstr($item, "filter_"))
			$filters[] = $item;
	}
	$info['filters'] = $filters;
	if (strcmp($_POST['file_type'], "camera") == 0)
	{
		$img = $_POST['photo'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$info['photo'] =  "../img/temp_img/" . $_SESSION['user'] . "_raw_photo.png";
		file_put_contents($info['photo'], $data);
		$info['photo_id'] = imagecreatefrompng($info['photo']);
		$info['photo_name'] = "../img/temp_img/" . "result_" . $_SESSION['user'] . ".png";
	}
	else if(strcmp($_POST['file_type'],"upload") == 0)
	{
		if (!isset($_SESSION['file']))
			return (null);
		$info['photo'] = "../img/temp_img/" . $_SESSION['file'];
		$info['photo_id'] = imagecreatefromjpeg($info['photo']);
		$info['photo_name'] = "../img/temp_img/" . "result_" . $_SESSION['file'] ;
	}
	return ($info);
}

function mix_photo()
{
	$info = get_image_data();

	if (!$_POST || !$info)
	{
		echo "<script>alert('Oops! Something going wrong! Try again, please!'); location.href='../inner_camagru.php';</script>";
		exit;
	}

	$filters = $info['filters'];
	$photo = $info['photo'];
	$new_photo_name = $info['photo_name'];
	$photo_id = $info['photo_id'];
	if(!$filters)
		copy($photo, $new_photo_name);
	else
		foreach ($filters as $filter)
		{
			$filter_id = imagecreatefrompng("../img/filters/" . $filter);
			imageAlphaBlending($filter_id, false);
			imageSaveAlpha($filter_id, true);

			$data = get_settings_for_filter($photo_id, $filter_id);
			imagecopy($photo_id, $data['filt_id'], $data['pos_x'], $data['pos_y'], 0, 0,
				$data['filt_w'], $data['filt_h']);
			imagedestroy($filter_id);
			imagejpeg ($photo_id, $new_photo_name, 75);
		}
	imagedestroy($photo_id);
	header("Location: ". "../inner_camagru.php?". "copy=success&result=" . $new_photo_name);
}