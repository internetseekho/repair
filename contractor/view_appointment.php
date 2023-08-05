<?php 
$file_name="appointments";

//Header section
require_once("include/header.php");

$query=mysqli_query($db,"SELECT ca.contractor_id, ca.appt_id, ca.amount as c_amount, a.*, aps.name AS status_name, l.name AS location_name, u.name AS customer_name FROM contractor_appt AS ca LEFT JOIN appointments AS a ON a.appt_id=ca.appt_id LEFT JOIN locations AS l ON l.id=a.location_id LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN appointments_status AS aps ON aps.id=a.status WHERE a.id='".$post['id']."' AND ca.contractor_id='".$admin_l_id."' AND ca.contractor_id>0 ORDER BY a.id DESC ".$pages->get_limit()."");

//Fetch details of appointment submitted form
$appointment_data = mysqli_fetch_assoc($query);
if(empty($appointment_data)) {
	setRedirect(CONTRACTOR_URL.'appointment.php');
	exit();
}

$appt_cb_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1' AND contractor='1'");
$num_of_appt_cb_status = mysqli_num_rows($appt_cb_status_query);

$comment_query=mysqli_query($db,"SELECT c.*, aps.name AS status_name FROM comments AS c LEFT JOIN appointments_status AS aps ON aps.id=c.appt_status WHERE c.appt_id='".$appointment_data['appt_id']."' ORDER BY c.id DESC");
$num_of_comment = mysqli_num_rows($comment_query);

$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
$exe_pro = mysqli_query($db,$sql_pro);
$row_pro = mysqli_fetch_assoc($exe_pro);
$product_name = $row_pro['title'];

$items_name = "";
$item_name_array = json_decode($appointment_data['item_name'],true);
if(!empty($item_name_array)) {
	foreach($item_name_array as $item_name_data) {
		$items_name .= '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).':</strong> ';
		$items_opt_name = "";
		foreach($item_name_data['opt_data'] as $opt_data) {
			$items_opt_name .= $opt_data['opt_name'].', ';
		}
		$items_name .= rtrim($items_opt_name,', ');
		//$items_name .= '<br>';		
	}
}
			
//Template file
require_once("views/view_appointment.php");

//Footer section
require_once("include/footer.php"); ?>
