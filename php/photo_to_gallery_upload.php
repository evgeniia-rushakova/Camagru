<?php
include_once "file_upload_validity.php";

function add_info_about_photo($item)
{
	$date = date('Y-m-d-H-i-s');
	//$description =clean_data($_POST['description']);
	$description="description later";
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
	header("Location: ".$_SERVER["HTTP_REFERER"]);
}


if(check_uploaded_file() == true)
{
		$dest_dir = "../img/gallery_photos";
		$name = str_replace(" ", "_",$_FILES['userfile']['name']);
		$res = move_uploaded_file($_FILES['userfile']['tmp_name'], "$dest_dir/$name");
		add_info_about_photo($name);
}

