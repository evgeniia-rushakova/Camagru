<?php
include_once "../config/connect.php";
include_once "validity.php";
if(!isset($_SESSION))
	session_start();

function check_errors($err)
{
	if ($err != 0)
	{
		switch ($err) {
			case UPLOAD_ERR_INI_SIZE:
				{
					echo "<script>alert('Error!The uploaded file exceeds the upload_max_filesize directive in php.ini'); location.href='../inner_camagru.php';</script>";
					break;
				}
			case UPLOAD_ERR_FORM_SIZE:
				{
					echo "<script>alert('Error!The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'); location.href='../inner_camagru.php';</script>";
					break;
				}
			case UPLOAD_ERR_PARTIAL:
				{
					echo "<script>alert('Error!The uploaded file was only partially uploaded'); location.href='../inner_camagru.php';</script>";
					break;
				}
			case UPLOAD_ERR_NO_FILE:
				{
					echo "<script>alert('Error!No file was uploaded'); location.href='../inner_camagru.php';</script>";
					break;
				}
			case UPLOAD_ERR_NO_TMP_DIR:
				{
					echo "<script>alert('Error!Missing a temporary folder'); location.href='../inner_camagru.php';</script>";
					break;
				}
			case UPLOAD_ERR_CANT_WRITE:
				{
					echo "<script>alert('Error!Failed to write file to disk'); location.href='../inner_camagru.php';</script>";
					break;
				}
			case UPLOAD_ERR_EXTENSION:
				{
					echo "<script>alert('Error!File upload stopped by extension'); location.href='../inner_camagru.php';</script>";
					break;
				}
			default:
				echo "<script>alert('Upload error'); location.href='../inner_camagru.php';</script>";
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

function check_uploaded_file()
{
	if (is_uploaded_file($_FILES['userfile']['tmp_name']) == true)
	{
		if (is_uploaded_file_valid($_FILES))
			return (true);
	}
	$err = $_FILES['userfile']['error'];
	if (check_errors($err) == true)
		return (false);
	return false;
}

