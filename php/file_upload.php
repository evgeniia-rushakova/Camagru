<?php
include_once "databases.php";
include_once "validity.php";
session_start();

function check_errors($err)
{
	if ($err != 0)
	{
		switch ($err) {
			case UPLOAD_ERR_INI_SIZE:
				echo 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			case UPLOAD_ERR_FORM_SIZE:
				echo 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			case UPLOAD_ERR_PARTIAL:
				echo 'The uploaded file was only partially uploaded';
			case UPLOAD_ERR_NO_FILE:
				echo 'No file was uploaded';
			case UPLOAD_ERR_NO_TMP_DIR:
				echo 'Missing a temporary folder';
			case UPLOAD_ERR_CANT_WRITE:
				echo 'Failed to write file to disk';
			case UPLOAD_ERR_EXTENSION:
				echo 'File upload stopped by extension';
			default:
				echo 'Unknown upload error';
		}
		return (true);
	}
	return (false);
}
function is_uploaded_file_valid($file)
{
	$type = explode("/",$file['userfile']['type'])[0];
	$err = $file['userfile']['error'];

	if (check_errors($err) == true)
		return (false);
	if ($file['userfile']['size'] == 0 || $file['userfile']['name'] == null )
		return (false);
	if (strcmp($type, "image") != 0)
		return (false);
	return (true);
}

function add_info_about_photo($item)
{
	$mydb="mydb";
	$pdo =  connect_to_database($mydb);;
	$photo = $item;
	$author = $_SESSION['user'];
	$date = date("F j, Y, g:i a");
	$description =clean_data($_POST['description']);
	$sql= "INSERT INTO photos (photo, author, date, description, likes, dislikes) VALUES ('$photo', '$author', '$date', '$description', '0', '0')";
	$pdo->exec($sql);
	header("Location: ".$_SERVER["HTTP_REFERER"]);
}

if (is_uploaded_file($_FILES['userfile']['tmp_name']) == true)
{
	$dest_dir = "../gallery_photos";
	$name = $_FILES['userfile']['name'];
	if (is_uploaded_file_valid($_FILES))
	{
		$res = move_uploaded_file($_FILES['userfile']['tmp_name'], "$dest_dir/$name");
		add_info_about_photo($name);
	}
}
else
	echo "error";
