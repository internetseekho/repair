<?php 
$file_name="appointments";

//Header section
require_once("include/header.php");

$device_id = 0;
$devices_id = 0;
$cat_id = 0;
$f_promocode_info = '';

$id = $post['id'];

if($id<=0 && $prms_order_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_order_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch details of appointment submitted form
$query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$id."'");
$appointment_data = mysqli_fetch_assoc($query);

$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");

$user_query=mysqli_query($db,"SELECT * FROM users WHERE status='1'");

$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
$exe_pro = mysqli_query($db,$sql_pro);
$row_pro = mysqli_fetch_assoc($exe_pro);
$product_name = $row_pro['title'];

//Get location data based on locationID
function get_single_location_data($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM locations WHERE published='1' AND id='".$id."'");
	$response = mysqli_fetch_assoc($query);
	return $response;
}

function get_model_data_list() {
	global $db;
	$response = array();
	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ORDER BY m.ordering ASC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

$location_list = get_location_data_list();

if($appointment_data['promocode_id']>0 && $appointment_data['promocode_amt']>0) {
	$promocode_amt = $appointment_data['promocode_amt'];
	$discount_amt_label = "<strong>Promocode Discount:</strong> -";
	if($appointment_data['discount_type']=="percentage")
		$discount_amt_label = "<strong>Promocode Discount (".$appointment_data['discount']."% of Initial Quote):</strong> -";

	$f_promocode_info = '<br>'.$discount_amt_label.amount_fomat($promocode_amt);
}

//Template file
require_once("views/addedit_appointment.php");

//Footer section
include("include/footer.php"); ?>
