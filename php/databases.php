<?php


function create_list_of_photos_table($pdo)
{
	$table = "CREATE TABLE IF NOT EXISTS photos(
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	photo VARCHAR(50) NOT NULL,
    	author VARCHAR(30) NOT NULL,
    	date varchar(30) NOT NULL,
    	likes INT(6) NOT NULL,
    	dislikes INT(6) NOT NULL, 
    	description VARCHAR(300) NOT NULL)";
	$pdo->exec($table);
}

function create_comments_table($pdo)
{
	$table = "CREATE TABLE IF NOT EXISTS comments(
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	photo VARCHAR(50) NOT NULL,
    	photo_author VARCHAR(30) NOT NULL,
    	date_of_comment varchar(30) NOT NULL,
    	comment_author VARCHAR(30) NOT NULL,
    	comment_text VARCHAR(300) NOT NULL)";
	$pdo->exec($table);
}

function create_users_table($pdo)
{
	$table = "CREATE TABLE IF NOT EXISTS Users2(
    		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
			user VARCHAR(30) NOT NULL,
			email VARCHAR(30) NOT NULL,
			password VARCHAR(60),
			accepted_email BOOLEAN,
			token VARCHAR(50) NOT NULL)";
	$pdo->exec($table);
}

function create_test_table($pdo)
{
	$dbname ="test_keys";
	$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
	$pdo->query("use $dbname");
	$table = "CREATE TABLE IF NOT EXISTS users(
    		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY , 
			user  VARCHAR(30) NOT NULL,
			email VARCHAR(30) NOT NULL,
			password VARCHAR(60),
			accepted_email BOOLEAN,
			token VARCHAR(50) NOT NULL)ENGINE=INNODB";
	$pdo->exec($table);

	$table = "CREATE TABLE IF NOT EXISTS photos(
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	photo VARCHAR(50) NOT NULL,
    	author_id INT(6) UNSIGNED NOT NULL,
    	date datetime NOT NULL,
    	likes INT(6) NOT NULL,
    	dislikes INT(6) NOT NULL, 
    	description VARCHAR(300) NOT NULL,
    	FOREIGN KEY (author_id) REFERENCES users(id))ENGINE=INNODB";
	$pdo->exec($table);
	$table = "CREATE TABLE IF NOT EXISTS comments(
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	photo_id INT(6) UNSIGNED NOT NULL ,
    	date_of_comment DATETIME NOT NULL,
    	comment_author INT UNSIGNED NOT NULL,
    	comment_text VARCHAR(300) NOT NULL,
    	FOREIGN KEY (photo_id) REFERENCES photos(id) ON DELETE CASCADE,
    	FOREIGN KEY (comment_author) REFERENCES users(id))ENGINE=INNODB";
	$pdo->exec($table);
}

function create_database()
{
	$servername = "localhost";
	$adminname = "admin";
	$adminpass = "12345";
	$dbname = "myDB";
	try
	{
		$pdo = new PDO("mysql:host=$servername", $adminname, $adminpass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
		$pdo->query("use $dbname");
	}
	catch (PDOException $e)
	{
		die("Database connection failed: " . $e->getMessage());
	}
	create_users_table($pdo);
	create_comments_table($pdo);
	create_list_of_photos_table($pdo);
	create_test_table($pdo);
	$pdo = null;
}

function connect_to_database($dbname)//mydb or users_keys
{
	$servername = "localhost";
	$adminname = "admin";
	$adminpass = "12345";
	try
	{
		$pdo = new PDO("mysql:host=$servername", $adminname, $adminpass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
		$pdo->query("use $dbname");
	}
	catch (PDOException $e)
	{
		die("Database connection failed: " . $e->getMessage());
	}
	return ($pdo);
}

//add some tables later here!