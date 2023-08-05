<?php 
$file_name="page";

//Header section
require_once("include/header.php");

function saved_inbuild_page_data($slug) {
	global $db;
	$i_query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".$slug."'");
	$saved_inbuild_page_data=mysqli_fetch_assoc($i_query);
	return $saved_inbuild_page_data;
}

//Array of inbuild pages so we can set fix condition of those pages
$inbuild_page_array = array(
	array('name'=>'Home','title'=>'Home','slug'=>'home','url'=>''),
	array('name'=>'Repair my mobile','title'=>'Repair my mobile','slug'=>'repair-my-mobile','url'=>'repair-my-mobile'),
	array('name'=>'Reviews','title'=>'Reviews','slug'=>'reviews','url'=>'reviews'),
	array('name'=>'Affiliates','title'=>'Affiliates','slug'=>'affiliates','url'=>'affiliates'),
	array('name'=>'Contact us','title'=>'Contact us','slug'=>'contact','url'=>'contact'),
	array('name'=>'Signup','title'=>'Signup','slug'=>'signup','url'=>'signup'),
	array('name'=>'Login','title'=>'Login','slug'=>'login','url'=>'login'),
	array('name'=>'Blog','title'=>'Blog','slug'=>'blog','url'=>'blog'),
	array('name'=>'Terms & Conditions','title'=>'Terms & Conditions','slug'=>'terms-and-conditions','url'=>'terms-and-conditions'),
	array('name'=>'Review Form','title'=>'Review Form','slug'=>'review-form','url'=>'review-form'),
	array('name'=>'Bulk Order Form','title'=>'Bulk Order Form','slug'=>'bulk-order-form','url'=>'bulk-order-form'),
	array('name'=>'Get A Quote','title'=>'Get A Quote','slug'=>'get-quote','url'=>'get-quote'),
	array('name'=>'Branches','title'=>'Branches','slug'=>'branches','url'=>'branches'),
	array('name'=>'Contractor Form','title'=>'Contractor Form','slug'=>'contractor-form','url'=>'contractor-form'),
	array('name'=>'Order Track','title'=>'Order Track','slug'=>'order-track','url'=>'order-track'),
	array('name'=>'Offers','title'=>'Offers','slug'=>'offers','url'=>'offers'),
	array('name'=>'Missing Product Form','title'=>'Missing Product Form','slug'=>'missing-product-form','url'=>'missing-product-form'),
	array('name'=>'Repair Price','title'=>'Repair Price','slug'=>'repair-price','url'=>'repair-price'),
	array('name'=>'Services','title'=>'Services','slug'=>'services','url'=>'services',
	array('name'=>'Instant Repair Model','title'=>'Instant Repair Model','slug'=>'instant-repair-model','url'=>'instant-repair-model'))
);

foreach($inbuild_page_array as $inbuild_page_data) {
	$inbuild_page_slug[] = $inbuild_page_data['slug'];
}

$p_type = $_GET['p_type'];
$msql_params = " AND type='inbuild'";
if($p_type=="custom") {
	$p_type = "custom";
	$msql_params = " AND type!='inbuild'";
} else {
	$p_type = "system";
}
 
$data_list = array();
$query = mysqli_query($db,"SELECT * FROM pages WHERE 1 ".$msql_params." ORDER BY type DESC, id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($page_data=mysqli_fetch_assoc($query)) {
		if(in_array($page_data['slug'],$inbuild_page_slug)) {
			$page_data['is_inbuild_page'] = '1';
			$brw_slug_param = "&slug=".$page_data['slug'];
		} else {
			$page_data['is_inbuild_page'] = '0';
			$brw_slug_param = "";
		}
		
		if($page_data['is_custom_url'] == '1') {
			$page_data['url_link'] = $page_data['url'];
		} else {
			$page_data['url_link'] = SITE_URL.$page_data['url'];
		}
		
		$page_data['brw_slug_param'] = $brw_slug_param;
		$page_data['content'] = '';
		$page_data['status'] = $page_data['published'];
		$data_list[] = $page_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/page/page.php");

//Footer section
require_once("include/footer.php"); ?>