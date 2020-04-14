<?php
include_once "tpl/popups--layout.php";
$title = "registration";
$content = file_get_contents("tpl/registration_form--layout.php");
$header = file_get_contents("tpl/main_header--layout.php");
$file = file_get_contents("tpl/meta-footer--layout.php");
$file = str_replace('{title}', $title, $file);
$file = str_replace('{header}', $header, $file);
$file = str_replace('{content}', $content, $file);
$templates=$answer;
$scripts = "";
$file = str_replace('{templates}',$templates, $file);
$file = str_replace('{scripts}',$scripts, $file);
print($file);



