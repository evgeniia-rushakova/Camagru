<?php
session_start();
if(!isset($_SESSION['user'])|| $_SESSION['user']==false)
{
	header("Location: "."../index.php");
	exit;
}
session_destroy();
header("Location: "."../index.php");