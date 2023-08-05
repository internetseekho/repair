<?php 
$file_name="page";

//Header section
require_once("include/header.php");

$id = $post['id'];
if($id<=0 && $prms_page_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_page_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

$p_type = $_GET['p_type'];
$msql_params = " AND type='inbuild'";
if($p_type=="custom") {
	$p_type = "custom";
	$msql_params = " AND type!='inbuild'";
} else {
	$p_type = "system";
}

//Fetch single page data based on page id
$query=mysqli_query($db,"SELECT * FROM pages WHERE id='".$id."' ".$msql_params);
$page_data=mysqli_fetch_assoc($query);
$exp_position=(array)json_decode((isset($page_data['position'])?$page_data['position']:''));

//Array of inbuild pages so we can set fix condition of those pages
$inbuild_page_array = array(
	'home'=>array('name'=>'Home','title'=>'Home','slug'=>'home','url'=>''),
	'repair-my-mobile'=>array('name'=>'Repair my mobile','title'=>'Repair my mobile','slug'=>'repair-my-mobile','url'=>'repair-my-mobile'),
	'reviews'=>array('name'=>'Reviews','title'=>'Reviews','slug'=>'reviews','url'=>'reviews'),
	'affiliates'=>array('name'=>'Affiliates','title'=>'Affiliates','slug'=>'affiliates','url'=>'affiliates'),
	'contact'=>array('name'=>'Contact us','title'=>'Contact us','slug'=>'contact','url'=>'contact'),
	'signup'=>array('name'=>'Signup','title'=>'Signup','slug'=>'signup','url'=>'signup'),
	'login'=>array('name'=>'Login','title'=>'Login','slug'=>'login','url'=>'login'),
	'blog'=>array('name'=>'Blog','title'=>'Blog','slug'=>'blog','url'=>'blog'),
	'terms-and-conditions'=>array('name'=>'Terms & Conditions','title'=>'Terms & Conditions','slug'=>'terms-and-conditions','url'=>'terms-and-conditions'),
	'get-quote'=>array('name'=>'Get A Quote','title'=>'Get A Quote','slug'=>'get-quote','url'=>'get-quote'),
	'branches'=>array('name'=>'Branches','title'=>'Branches','slug'=>'branches','url'=>'branches'),
	'contractor-form'=>array('name'=>'Contractor Form','title'=>'Contractor Form','slug'=>'contractor-form','url'=>'contractor-form'),
	'order-track'=>array('name'=>'Order Track','title'=>'Order Track','slug'=>'order-track','url'=>'order-track'),
	'offers'=>array('name'=>'Offers','title'=>'Offers','slug'=>'offers','url'=>'offers'),
	'missing-product'=>array('name'=>'Missing Product Form','title'=>'Missing Product Form','slug'=>'missing-product-form','url'=>'missing-product-form'),
	'repair-price'=>array('name'=>'Repair Price','title'=>'Repair Price','slug'=>'repair-price','url'=>'repair-price'),
	'services'=>array('name'=>'Services','title'=>'Services','slug'=>'services','url'=>'services')
);
$inbuild_page_data = @$inbuild_page_array[$post['slug']];

$menu_name = isset($page_data['menu_name'])?$page_data['menu_name']:'';
$title = isset($page_data['title'])?$page_data['title']:'';
$url = isset($page_data['url'])?$page_data['url']:'';
$finl_url = ($url?$url:$inbuild_page_data['url']);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');
$devices_list_arr = array();
while($devices_list=mysqli_fetch_assoc($devices_data)) {
	$devices_list_arr[] = $devices_list;
}

//Template file
require_once("views/page/edit_page.php");

//Footer section
require_once("include/footer.php"); ?>