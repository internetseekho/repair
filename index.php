<?php
/*if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:'.$redirect);
    exit();
}
*/
//Basic config, functions related general files
require_once("admin/_config/config.php");
require_once("admin/include/functions.php");
//require_once("include/functions/faq.php");

//Pagination library
require_once("libraries/pagination/class.paginator.php");

//Here some common data like basket item, session vars, url vars etc...
require_once("include/common.php");

if($maintainance_mode == '1') {
	require_once("views/maintainance.php");
} else {
	//Here pages, views router related code
	require_once("include/route.php");

	include("include/footer.php");
} ?>