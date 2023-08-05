<?php 
$file_name="staff_group";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable appt_ticket_status data
$appt_q=mysqli_query($db,'SELECT * FROM staff_groups WHERE id="'.$id.'"');
$staff_group_data=mysqli_fetch_assoc($appt_q);
$permissions_array = json_decode($staff_group_data['permissions'], true);

if(!isset($permissions_array['order_view'])) {
	$permissions_array['order_view'] = 0;
}
if(!isset($permissions_array['order_add'])) {
	$permissions_array['order_add'] = 0;
}
if(!isset($permissions_array['order_edit'])) {
	$permissions_array['order_edit'] = 0;
}
if(!isset($permissions_array['order_delete'])) {
	$permissions_array['order_delete'] = 0;
}
if(!isset($permissions_array['order_invoice'])) {
	$permissions_array['order_invoice'] = 0;
}
if(!isset($permissions_array['model_view'])) {
	$permissions_array['model_view'] = 0;
}
if(!isset($permissions_array['model_add'])) {
	$permissions_array['model_add'] = 0;
}
if(!isset($permissions_array['model_edit'])) {
	$permissions_array['model_edit'] = 0;
}
if(!isset($permissions_array['model_delete'])) {
	$permissions_array['model_delete'] = 0;
}
if(!isset($permissions_array['device_view'])) {
	$permissions_array['device_view'] = 0;
}
if(!isset($permissions_array['device_add'])) {
	$permissions_array['device_add'] = 0;
}
if(!isset($permissions_array['device_edit'])) {
	$permissions_array['device_edit'] = 0;
}
if(!isset($permissions_array['device_delete'])) {
	$permissions_array['device_delete'] = 0;
}
if(!isset($permissions_array['brand_view'])) {
	$permissions_array['brand_view'] = 0;
}
if(!isset($permissions_array['brand_add'])) {
	$permissions_array['brand_add'] = 0;
}
if(!isset($permissions_array['brand_edit'])) {
	$permissions_array['brand_edit'] = 0;
}
if(!isset($permissions_array['brand_delete'])) {
	$permissions_array['brand_delete'] = 0;
}
if(!isset($permissions_array['category_view'])) {
	$permissions_array['category_view'] = 0;
}
if(!isset($permissions_array['category_add'])) {
	$permissions_array['category_add'] = 0;
}
if(!isset($permissions_array['category_edit'])) {
	$permissions_array['category_edit'] = 0;
}
if(!isset($permissions_array['category_delete'])) {
	$permissions_array['category_delete'] = 0;
}
if(!isset($permissions_array['customer_view'])) {
	$permissions_array['customer_view'] = 0;
}
if(!isset($permissions_array['customer_add'])) {
	$permissions_array['customer_add'] = 0;
}
if(!isset($permissions_array['customer_edit'])) {
	$permissions_array['customer_edit'] = 0;
}
if(!isset($permissions_array['customer_delete'])) {
	$permissions_array['customer_delete'] = 0;
}
if(!isset($permissions_array['page_view'])) {
	$permissions_array['page_view'] = 0;
}
if(!isset($permissions_array['page_add'])) {
	$permissions_array['page_add'] = 0;
}
if(!isset($permissions_array['page_edit'])) {
	$permissions_array['page_edit'] = 0;
}
if(!isset($permissions_array['page_delete'])) {
	$permissions_array['page_delete'] = 0;
}
if(!isset($permissions_array['menu_view'])) {
	$permissions_array['menu_view'] = 0;
}
if(!isset($permissions_array['menu_add'])) {
	$permissions_array['menu_add'] = 0;
}
if(!isset($permissions_array['menu_edit'])) {
	$permissions_array['menu_edit'] = 0;
}
if(!isset($permissions_array['menu_delete'])) {
	$permissions_array['menu_delete'] = 0;
}
if(!isset($permissions_array['contractor_view'])) {
	$permissions_array['contractor_view'] = 0;
}
if(!isset($permissions_array['contractor_add'])) {
	$permissions_array['contractor_add'] = 0;
}
if(!isset($permissions_array['contractor_edit'])) {
	$permissions_array['contractor_edit'] = 0;
}
if(!isset($permissions_array['contractor_delete'])) {
	$permissions_array['contractor_delete'] = 0;
}
if(!isset($permissions_array['invoice_view'])) {
	$permissions_array['invoice_view'] = 0;
}
if(!isset($permissions_array['invoice_add'])) {
	$permissions_array['invoice_add'] = 0;
}
if(!isset($permissions_array['invoice_edit'])) {
	$permissions_array['invoice_edit'] = 0;
}
if(!isset($permissions_array['invoice_delete'])) {
	$permissions_array['invoice_delete'] = 0;
}

//Template file
require_once("views/staff_group/edit_staff_group.php");

//Footer section
require_once("include/footer.php"); ?>
