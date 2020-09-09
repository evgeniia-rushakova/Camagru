<?php
include_once "database.php";

$db_dsn =  $DB_DSN;
$db_user = $DB_USER;
$db_name = $DB_NAME;
$db_pass = $DB_PASSWORD;

function connect_to_database()
{
	global $db_dsn;
	global $db_user;
	global $db_name;
	global $db_pass;
	try
	{
		$pdo = new PDO($db_dsn, $db_user, $db_pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$pdo->query("use $db_name");
	}
	catch(PDOException $e)
	{
		die("Database connection failed: " . $e->getMessage());
	}
	return ($pdo);
}
