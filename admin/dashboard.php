<?php 
$file_name="dashboard";

//Header section
require_once("include/header.php");

echo '<script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>';

$data_list = array();
$query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders, a.*, ast.id AS status_id, ast.name AS status_name, ast.color AS status_color FROM appointments AS a LEFT JOIN appointments_status AS ast ON ast.id=a.status GROUP BY ast.id");
$num_of_order_rows = mysqli_num_rows($query);

$user_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_users, status FROM users GROUP BY status");
$num_of_user_rows = mysqli_num_rows($user_query);

$contractor_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_contractors, status FROM contractors GROUP BY status");
$num_of_contractor_rows = mysqli_num_rows($contractor_query);

$mobile_query=mysqli_query($db,"SELECT * FROM mobile");
$num_of_mobile_rows = mysqli_num_rows($mobile_query);

$device_query=mysqli_query($db,"SELECT * FROM devices");
$num_of_device_rows = mysqli_num_rows($device_query);

$brand_query=mysqli_query($db,"SELECT * FROM brand");
$num_of_brand_rows = mysqli_num_rows($brand_query);

$category_query=mysqli_query($db,"SELECT * FROM categories");
$num_of_category_rows = mysqli_num_rows($category_query);

//Template file
require_once("views/dashboard.php");

//Footer section
require_once("include/footer.php"); ?>
