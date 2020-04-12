<?php
function add_admins_photo_into_base($pdo)
{
	$photos_array = scandir("img/gallery_photos");
	unset($photos_array[0]);
	unset($photos_array[1]);
	foreach ($photos_array as $item)
	{
		$sql = $pdo->prepare("SELECT COUNT(*) FROM photos WHERE photo = ?");
		$sql->execute([$item]);
		$img = $sql->fetchColumn();
		$date = $date = date('Y-m-d-H-i-s');
		$description = "from admin";
		if ($img == false)
		{
			$sql = "INSERT INTO photos (photo, author_id, date, description, likes, dislikes) VALUES ('$item', '1', '$date', '$description', '0', '0')";
			$pdo->exec($sql);

		}
	}
}

function create_list_of_photos_table($pdo)
{
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
}

function create_comments_table($pdo)
{
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

function create_users_table($pdo)
{
	$table = "CREATE TABLE IF NOT EXISTS users(
    		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY , 
			user  VARCHAR(30) NOT NULL UNIQUE ,
			email VARCHAR(30) NOT NULL UNIQUE ,
			password VARCHAR(60),
			accepted_email BOOLEAN,
			notifications BOOLEAN,
			token VARCHAR(50) NOT NULL)ENGINE=INNODB";
	$pdo->exec($table);
	$sql = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE user = 'admin'");
	$sql->execute();
	$admin_exists = $sql->fetchColumn();
	$password = password_hash("admin", PASSWORD_BCRYPT);
	if ($admin_exists == false)
	{
		$newstringintable = "INSERT INTO  Users (user, email, password, accepted_email, token, notifications) VALUES ('admin','admin@admin', '$password', true, '0', true)";
		$pdo->exec($newstringintable);
	}
}

function create_avatars_table($pdo)
{
	$table = "CREATE TABLE IF NOT EXISTS avatars(
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	name VARCHAR(50) NOT NULL,
    	author_id INT(6) UNSIGNED NOT NULL,
    	FOREIGN KEY (author_id) REFERENCES users(id))ENGINE=INNODB";
	$pdo->exec($table);
	$sql = $pdo->prepare("SELECT COUNT(*) FROM avatars WHERE author_id = '1'");
	$sql->execute();
	$admin_exists = $sql->fetchColumn();
	if ($admin_exists == false)
	{
		$newstringintable = "INSERT INTO  avatars (name, author_id) VALUES ('admin_avatar.jpg', '1')";
		$pdo->exec($newstringintable);
	}

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
	catch(PDOException $e)
	{
		die("Database connection failed: " . $e->getMessage());
	}
	create_users_table($pdo);
	create_list_of_photos_table($pdo);
	create_comments_table($pdo);
	create_avatars_table($pdo);
	add_admins_photo_into_base($pdo);
	$pdo = null;
}

function connect_to_database($dbname)
{
	$servername = "localhost";
	$adminname = "admin";
	$adminpass = "12345";
	try
	{
		$pdo = new PDO("mysql:host=$servername", $adminname, $adminpass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$pdo->query("use $dbname");
	}
	catch(PDOException $e)
	{
		die("Database connection failed: " . $e->getMessage());
	}
	return ($pdo);
}

