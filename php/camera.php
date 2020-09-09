<?php
include_once "../config/connect.php";
if(!isset($_SESSION))
	session_start();

mix_photo();

function get_settings_for_filter($photo_id, $filter_id)
{
	$settings = array();
	$sourcefile_width=imageSX($photo_id);
	$sourcefile_height=imageSY($photo_id);
	$watermarkfile_width=imageSX($filter_id);
	$filter_id = imagescale($filter_id, $watermarkfile_width * $_POST['scale']/100);

	$settings['filt_w'] = imageSX($filter_id);
	$settings['filt_h'] = imageSY($filter_id);
	$settings['filt_id'] = $filter_id;
	$settings['pos_x'] = floor(($sourcefile_width - $settings['filt_w']) * $_POST['position_hor']/100);
	$settings['pos_y'] = floor(($sourcefile_height - $settings['filt_h']) * $_POST['position_vert']/100);
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
		if(!$img)
			return(null);
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		if(!$data)
			return(null);
		$info['photo'] =  "../img/temp_img/" . $_SESSION['user'] . "_raw_photo.png";
		file_put_contents($info['photo'], $data);
		$info['photo_id'] = imagecreatefrompng($info['photo']);
		$info['photo_name'] = "../img/temp_img/" . $_SESSION['user'] . "_result" . "." . "png" ;
		$info['format'] = "png";
	}
	else if(strcmp($_POST['file_type'],"upload") == 0)
	{
		if (!isset($_SESSION['file']))
			return (null);
		$info['photo'] = "../img/temp_img/" . $_SESSION['file'];
		$filetypestring = explode(".", $info['photo']);
		$type = $filetypestring[count($filetypestring) -1];
		$info['format'] = $type;
		switch ($type)
		{
			case "jpeg":
			case "jpg":
			{
				$info['photo_id'] = imagecreatefromjpeg($info['photo']);
				break;
			}
			case "png":
			{
				$info['photo_id'] = imagecreatefrompng($info['photo']);
				break;
			}
			case "bmp":
			{
				$info['photo_id'] = imagecreatefrombmp($info['photo']);
				break;
			}
			case "gif":
			{
				$info['photo_id'] = imagecreatefromgif($info['photo']);
				break;
			}
			case "webp":
			{
				$info['photo_id'] = imagecreatefromwebp($info['photo']);
				break;
			}
			default:
				return (null);
		}
		$info['photo_name'] = "../img/temp_img/" . $_SESSION['user'] . "_result" . "." . $type ;
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
	else
	{
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
				switch ($info['format'])
				{
					case "jpeg":
					case "jpg":
					{
						imagejpeg ($photo_id, $new_photo_name);
						break;
					}
					case "png":
					{
						imagepng($photo_id, $new_photo_name);
						break;
					}
					case "bmp":
					{
						imagebmp($photo_id, $new_photo_name);
						break;
					}
					case "gif":
					{
						imagegif($photo_id, $new_photo_name);
						break;
					}
					case "webp":
					{
						imagewebp($photo_id, $new_photo_name);
						break;
					}
				}
			}
		imagedestroy($photo_id);
		header("Location: ". "../inner_camagru.php?". "copy=success&result=" . $new_photo_name);
	}

}