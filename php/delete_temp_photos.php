<?php
if (!isset($_SESSION))
	session_start();

delete_temp_photos();

function delete_temp_photos()
{
	if (isset($_SESSION['user']))
	{
		if (isset($_SESSION['file']))
			unset($_SESSION['file']);
		$photos_array = scandir("../img/temp_img");
		unset($photos_array[0]);
		unset($photos_array[1]);
		foreach ($photos_array as $item)
		{
			if (stripos($item, $_SESSION['user']) === 0)
			{
				$full_path = "../img/temp_img/" . $item;
				unlink($full_path);
			}
		}
	}
	if(strcmp($_SERVER['PHP_SELF'], "/php/logout.php") != 0)
		header("Location:" . "../inner_camagru.php");
}