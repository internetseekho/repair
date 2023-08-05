<?php
require_once("_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");

//Set pagination limit
if(isset($_GET['pagination_limit']) && $_GET['pagination_limit']>0) {
	$pagination_limit = $_GET['pagination_limit'];
	$page_list_limit = $pagination_limit;
	$_SESSION['pagination_limit'] = $pagination_limit;
	setRedirect(SITE_URL.ltrim($_SERVER['SCRIPT_NAME'],'/'));
	exit();
} elseif(isset($_SESSION['pagination_limit']) && $_SESSION['pagination_limit']>0) {
	$page_list_limit = $_SESSION['pagination_limit'];
}

//Get library for pagination
include(CP_ROOT_PATH."/admin/libraries/pagination/class.paginator.php");
$pages = new Paginator($page_list_limit,'p');

//If session expired then it will redirect to login page
if(empty($_SESSION['is_contractor']) || empty($_SESSION['contractor_username'])) {
    setRedirect(CONTRACTOR_URL);
	exit();
} else {
	$admin_l_id = $_SESSION['contractor_id'];
	//$admin_type = $_SESSION['contractor_type'];

	$query=mysqli_query($db,"SELECT * FROM contractors WHERE id = '".$admin_l_id."'");
	$loggedin_user_data = mysqli_fetch_assoc($query);
	$loggedin_user_name = $loggedin_user_data['name'];

	if(!isset($post['id'])) {
		$post['id'] = "";
	}
	if(!isset($post['filter_by'])) {
		$post['filter_by'] = "";
	}

	//START access level based on loggedin user
	/*if($admin_type=="admin") {
		$access_file_name_array = array('general_settings','staff','location');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
	}*/ //END access level based on loggedin user
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Admin Panel" />
<title><?=ucfirst(str_replace('_',' ',$file_name))?> | Contractor Panel</title>

<!-- jQuery TagsInput Styles -->
<link rel='stylesheet' type='text/css' href='css/plugins/jquery.tagsinput.css'>

<!-- jQuery prettyCheckable Styles -->
<link rel='stylesheet' type='text/css' href='css/plugins/prettyCheckable.css'>

<!-- jQuery jWYSIWYG Styles -->
<link rel='stylesheet' type='text/css' href='css/plugins/jquery.jwysiwyg.css'>

<!-- Bootstrap wysihtml5 Styles -->
<link rel='stylesheet' type='text/css' href='css/plugins/bootstrap-wysihtml5.css'>

<!-- Date range picker Styles -->
<link rel='stylesheet' type='text/css' href='css/plugins/daterangepicker.css'>

<!-- Bootstrap Timepicker Styles -->
<link rel='stylesheet' type='text/css' href='css/plugins/bootstrap-timepicker.css'>

<!-- Styles -->
<link rel='stylesheet' type='text/css' href='css/sangoma-red.css'>

<link rel="stylesheet" href="../css/intlTelInput.css">

<!-- NEW ADDED -->
<link href="css/icons.css" rel="stylesheet" type="text/css" />

<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> 

<!-- JS Libs -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery.js"><\/script>')</script>

<script src="js/libs/modernizr.js"></script>
<script src="js/libs/selectivizr.js"></script>

<script>
$(document).ready(function(){
	// Tooltips
	$('[title]').tooltip({
		placement: 'top',
		container: 'body'
	});

	// Tabs
	$('.demoTabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
});
</script>
</head>

<body>
