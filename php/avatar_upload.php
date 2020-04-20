<?php

include_once("file_upload_validity.php");
include_once "../config/connect.php";
if(!isset($_SESSION))
	session_start();
if (check_uploaded_file() == true)
{
	$file = explode(".", $_FILES['userfile']['name']);
	$typefile = "." . $file[count($file) - 1];
	$new_filename= "avatar_" .  $_SESSION['user'] . $typefile;
	$name = $_FILES['userfile']['name'];
	$dest_dir = "../img/avatars/";
	move_uploaded_file($_FILES['userfile']['tmp_name'], "$dest_dir/$new_filename");
	$pdo = connect_to_database();

	$smtp = $pdo->prepare("SELECT id FROM users WHERE user = ?");
	$smtp->execute(array($_SESSION['user']));
	$author = $smtp->fetch()['id'];

	$smtp = $pdo->prepare("UPDATE avatars SET name = ? WHERE author_id = ?");
	$smtp->execute(array($new_filename, $author));
	$pdo = null;
	header("Location: " . "../cabinet.php");
}