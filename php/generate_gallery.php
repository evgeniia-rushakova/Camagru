<?php
include_once "config/connect.php";
if(!isset($_SESSION))
	session_start();

function calculate_pages_info($current_page)
{
	$info = array();
	$pdo =  connect_to_database();
	$smtp = $pdo->prepare("SELECT photo FROM photos");
	$smtp->execute();
	$photos_array = $smtp->fetchAll();
	$photos_array = array_reverse($photos_array);
	$count_photos = count($photos_array);
	$photos_per_page = 12;

	$pages = ceil($count_photos / $photos_per_page);
	$info['pages'] = $pages;
	$first_photo_index = $current_page == 1 ? 0 : ($current_page-1) * $photos_per_page;
	$sliced_arr = array_splice($photos_array,$first_photo_index, $photos_per_page);
	$info['photos'] = $sliced_arr;
	return($info);
}

function generate_pagination($current_page)
{
	$pages = calculate_pages_info($current_page)['pages'];
	$gallery = '../gallery.php?page=' ;
	$template = '    <div class="gallery__pagination pagination">
        <a href={prev_page} class="pagination__link pagination__arrow pagination__arrow--back"></a>
        {pages}
        <a href={next_page} class="pagination__link pagination__arrow pagination__arrow--next"></a>
    </div>';
	$prev = $current_page - 1 >= 1 ? ($current_page - 1) : 1;
	$next = $current_page + 1 <= $pages ? ($current_page + 1) : $pages;

	$template = str_replace( '{prev_page}',$gallery . $prev, $template);
	$template = str_replace( '{next_page}',$gallery .$next, $template);
	$template_page = ' <a href={page_link} class="pagination__link {current}">{page_value}</a>';
	$links = "";
	for ($page = 1; $page <= $pages; $page++)
	{
		$copy_template = $template_page;
		$current_class = $page == $current_page ? 'pagination__link--current' : "";
		$copy_template = str_replace('{page_link}',$gallery . $page,   $copy_template);
		$copy_template = str_replace('{current}', $current_class,  $copy_template);
		$copy_template = str_replace('{page_value}',$page,  $copy_template);
		$links.=$copy_template;
	}
	$template = str_replace('{pages}',$links,  $template);
	return ($template);
}

function get_gallery_photos($current_page)
{
	$pdo =  connect_to_database();
	$result = "";
	$width = "250px";
	$height = "auto";
	$template_origin = file_get_contents("tpl/photo_in_gallery--layout.php");

	$photos_array = calculate_pages_info($current_page)['photos'];

	foreach ($photos_array as $value)
	{
		$item = $value['photo'];
		$sql = $pdo->prepare("SELECT description FROM photos WHERE photo = ?") ;
		$sql->execute([$item]);
		$img_alt = $sql->fetchColumn();
		$img_src = "../img/gallery_photos/" . $item;
		$template = $template_origin;
		$template = str_replace('{img_src}', $img_src, $template);
		$template = str_replace('{img_name}', $item, $template);
		$template = str_replace('{img_alt}', $img_alt, $template);
		$template = str_replace('{img_width}', $width, $template);
		$template = str_replace('{img_height}', $height, $template);
		$template = str_replace('{description}', $img_alt, $template);
		$template = str_replace('{add_class}', "gallery--item__img--main", $template);
		$template = str_replace('{add_width_class}', "gallery--item__img--main", $template);
		$result .= $template;
	}
	$pdo = null;
	return ($result);
}