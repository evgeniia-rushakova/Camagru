<?php
include_once "validity.php";
include_once "../config/connect.php";
if(!isset($_SESSION))
	session_start();

function add_info_about_photo($item)
{
	$date = date('Y-m-d-H-i-s');
	$description =clean_data($_GET['description']);
	$photo = $item;
	$photo = str_replace(" ","_", $photo);
	$author = $_SESSION['user'];
	$pdo =  connect_to_database();;
	$smtp= $pdo->prepare("SELECT id FROM users where user = ?");
	$smtp->execute(array($author));
	$id = $smtp->fetch(PDO::FETCH_ASSOC)['id'];

	$sql= "INSERT INTO photos (photo, author_id, date, description, likes, dislikes) VALUES ('$photo', '$id', '$date', '$description', '0', '0')";
	$pdo->exec($sql);
	$pdo = null;
}

function save_photo_to_gallery ($file)
{
	$new_place =  "../img/gallery_photos/" . $file;
	if (rename($file, $new_place))
	{
		add_info_about_photo($file);
		echo "<script>alert('Photo is available in gallery now!');location.href=document.referrer;</script>";
	}

};

function download_photo ($file)
{
	if ( file_exists($file)) {
		if (ob_get_level()) {
			ob_end_clean();
		}
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		unlink($file);
	}
}

if (isset($_GET))
{
	$referer = explode("=", $_SERVER['HTTP_REFERER']);
	$file = $referer[count($referer) - 1];
	$filetype_arr = explode(".", $file);
	$filetype = $filetype_arr[count($filetype_arr) - 1];
	$new_file = $_SESSION['user'] . date("Ymdhis") . "." .$filetype;
	copy($file, $new_file);
	if (strcmp($_GET['act'], "gallery") == 0)
		save_photo_to_gallery($new_file);
	if(strcmp($_GET['act'], "download") == 0)
		download_photo($new_file);
}