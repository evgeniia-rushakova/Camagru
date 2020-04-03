<?php
$title = "registration";
$content = file_get_contents("tpl/forgot-password-form--layout.php");
$header = file_get_contents("tpl/inner_header--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
print($file);