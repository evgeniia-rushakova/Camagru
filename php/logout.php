<?php
include_once "delete_temp_photos.php";
if (!isset($_SESSION))
	session_start();
if(!isset($_SESSION['user'])|| $_SESSION['user']==false)
{
	header("Location: "."../index.php");
	exit;
}
delete_temp_photos();
session_destroy();
header("Location: "."../index.php");