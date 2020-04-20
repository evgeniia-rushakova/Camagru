<?php
include_once "file_upload_validity.php";

if(check_uploaded_file() == true)
{
	$dest_dir = "../img/temp_img";
	$file = explode(".", $_FILES['userfile']['name']);
	$typefile = "." . $file[count($file) - 1];
	$name = $_SESSION['user'] . "_temp_file" . $typefile;
	$_SESSION['file'] = $name;
	$res = move_uploaded_file($_FILES['userfile']['tmp_name'], "$dest_dir/$name");
	header("Location: ". "../inner_camagru.php");
}


