<?php
include_once "databases.php";
session_start();

function change_username($user)
{

}

function change_email($user)
{

}

function change_password($user)
{

}

function change_notifications($user)
{

}

function delete_profile($user)
{

}

$user = $_SESSION['user'];
if (strcmp($_GET['act'], "change_username") == 0)
	change_username($user);
else if (strcmp($_GET['act'], "change_email") == 0)
	change_email($user);
else if (strcmp($_GET['act'], "change_password") == 0)
	change_password($user);
else if (strcmp($_GET['act'], "notifications") == 0)
	change_notifications($user);
else if (strcmp($_GET['act'], "delete_profile") == 0)
	delete_profile($user);
