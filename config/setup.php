<?php

include_once 'database.php';

$db_dsn =  $DB_DSN;
$db_user = $DB_USER;
$db_name = $DB_NAME;
$db_pass = $DB_PASSWORD;

function add_admins_photo_into_base($pdo)
{
	$photos_array = scandir("../img/gallery_photos");
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

function create_likes_table($pdo)
{
	$table = "CREATE TABLE IF NOT EXISTS likes(
    	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    	photo_id INT (6) UNSIGNED NOT NULL,
    	who_liked_id INT(6) UNSIGNED NOT NULL,
    	value int(6) NOT NULL ,
    	FOREIGN KEY (photo_id) REFERENCES photos(id) ON DELETE CASCADE,
    	FOREIGN KEY (who_liked_id) REFERENCES users(id))ENGINE=INNODB";
	$pdo->exec($table);
}

function create_database()
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
		$pdo->query("CREATE DATABASE IF NOT EXISTS $db_name");
		$pdo->query("use $db_name");
	}
	catch(PDOException $e)
	{
		die("Database connection failed: " . $e->getMessage());
	}
	create_users_table($pdo);
	create_list_of_photos_table($pdo);
	create_comments_table($pdo);
	create_avatars_table($pdo);
	create_likes_table($pdo);
	add_admins_photo_into_base($pdo);
	$pdo = null;
	return (true);
}
create_database();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="preload" href="../css/style.css" as="style">
	<link rel="stylesheet" type="text/css" href="../css/normalize.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>Jslave Camagru - Setup</title>
</head>
<body>
<main>
	<div style="width:300px; margin: 150px auto;">
		<h2 class="profile__title" style="text-align: center;">Database create successfully</h2>
		<h2 class="profile__title" style="text-align: center;">Tables create successfully</h2>
		<form action="../index.php">
			<button class="sign-in-form__submit"autofocus="autofocus" tabindex="1" style="width: 300px; padding: 10px 20px;">go to CamaGru</button>
		</form>
	</div>
</main>
</body>
</html>

