<?php 
$file_name="appointments";

//Header section
require_once("include/header.php");

//Fetch details of appointment submitted form
$query=mysqli_query($db,"SELECT a.*, aps.name AS status_name, u.name AS customer_name, l.name AS location_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN locations AS l ON l.id=a.location_id WHERE a.id='".$post['id']."'");
$appointment_data = mysqli_fetch_assoc($query);
if(empty($appointment_data)) {
	setRedirect(ADMIN_URL.'appointment.php');
	exit();
}

$order_files_html = '';
if($appointment_data['item_files']!="") {
	$order_files_list = explode(",",$appointment_data['item_files']);
	foreach($order_files_list as $file_k=>$file_v) {
		if($file_v!="") {
			$order_files_html .= '<a href="'.SITE_URL.'images/orders/files/'.$file_v.'" target="_blank">'.$file_v.'</a><br>';
		}
	}
}

if($appointment_data['promocode_id']>0 && $appointment_data['promocode_amt']>0) {
	$promocode_amt = amount_fomat($appointment_data['promocode_amt']);
	$discount_amt_label = "<strong>Promocode Discount:</strong> -";
	if($appointment_data['discount_type']=="percentage")
		$discount_amt_label = "<strong>Promocode Discount (".$appointment_data['discount']."% of Initial Quote):</strong> -";

	$f_promocode_info = $discount_amt_label.$promocode_amt;
}
if($appointment_data['promocode_amt']>0) {
	$estimate_cost = ($appointment_data['item_amount']-$appointment_data['promocode_amt']);
} else {
	$estimate_cost = $appointment_data['item_amount'];
}

$ac_query=mysqli_query($db,"SELECT c.*, ca.contractor_id, ca.appt_id, ca.amount FROM contractors AS c LEFT JOIN contractor_appt AS ca ON ca.contractor_id=c.id WHERE ca.appt_id='".$appointment_data['appt_id']."'");
$assigned_contractor_data = mysqli_fetch_assoc($ac_query);

$appt_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");
$appt_cb_status_query=mysqli_query($db,"SELECT * FROM appointments_status WHERE status='1'");

$comment_query=mysqli_query($db,"SELECT c.*, aps.name AS status_name FROM comments AS c LEFT JOIN appointments_status AS aps ON aps.id=c.appt_status WHERE c.appt_id='".$appointment_data['appt_id']."' ORDER BY c.id DESC");
$num_of_comment = mysqli_num_rows($comment_query);

$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
$exe_pro = mysqli_query($db,$sql_pro);
$row_pro = mysqli_fetch_assoc($exe_pro);
$product_name = $row_pro['title'];

$last_time_sheet_q=mysqli_query($db,"SELECT * FROM time_sheet WHERE staff_id='".$admin_l_id."' AND order_id='".$appointment_data['appt_id']."' ORDER BY id DESC");
$last_time_sheet_data = mysqli_fetch_assoc($last_time_sheet_q);

$payment_history_list = get_payment_history_data($appointment_data['appt_id'])['list'];

if($admin_type == "super_admin") {
	$time_sheet_data_array = array();
	$staff_list = get_admin_staff_user_list();
	foreach($staff_list as $staff_data) {
		$time_sheet_data_list = array();
		$timesheet_q = "SELECT t.*, st.name AS staff_name FROM time_sheet AS t LEFT JOIN admin AS st ON st.id=t.staff_id WHERE t.staff_id='".$staff_data['id']."' AND t.order_id='".$appointment_data['appt_id']."' ORDER BY t.id DESC";
		$time_sheet_q=mysqli_query($db,$timesheet_q);
		while($time_sheet_data = mysqli_fetch_assoc($time_sheet_q)) {
			$time_sheet_data_list[] = $time_sheet_data;
		}
		if(!empty($time_sheet_data_list)) {
			$staff_data['time_sheet_data'] = $time_sheet_data_list;
			$time_sheet_data_array[] = $staff_data;
		}
	}
} else {
	$timesheet_q = "SELECT t.*, st.name AS staff_name FROM time_sheet AS t LEFT JOIN admin AS st ON st.id=t.staff_id WHERE t.staff_id='".$admin_l_id."' AND t.order_id='".$appointment_data['appt_id']."' ORDER BY t.id DESC";
	$time_sheet_q=mysqli_query($db,$timesheet_q);
}

$template_data = get_template_data('admin_reply_from_order');
$admin_user_data = get_admin_user_data();
$customer_data = get_user_data($appointment_data['user_id']);

$patterns = array(
	'{$logo}',
	'{$admin_logo}',
	'{$admin_email}',
	'{$admin_username}',
	'{$admin_site_url}',
	'{$admin_panel_name}',
	'{$from_name}',
	'{$from_email}',
	'{$site_name}',
	'{$site_url}',
	'{$customer_fname}',
	'{$customer_lname}',
	'{$customer_fullname}',
	'{$customer_phone}',
	'{$customer_email}',
	'{$customer_address_line1}',
	'{$customer_address_line2}',
	'{$customer_city}',
	'{$customer_state}',
	'{$customer_country}',
	'{$customer_postcode}',
	'{$customer_company_name}',
	'{$appt_id}',
	'{$appt_date}',
	'{$appt_time}',
	//'{$appt_status}',
	'{$product_name}',
	'{$amount}',
	'{$current_date_time}');

$replacements = array(
	$logo,
	$admin_logo,
	$admin_user_data['email'],
	$admin_user_data['username'],
	ADMIN_URL,
	$general_setting_data['admin_panel_name'],
	$general_setting_data['from_name'],
	$general_setting_data['from_email'],
	$general_setting_data['site_name'],
	SITE_URL,
	$customer_data['first_name'],
	$customer_data['last_name'],
	$customer_data['name'],
	$customer_data['phone'],
	$customer_data['email'],
	$customer_data['address'],
	$customer_data['address2'],
	$customer_data['city'],
	$customer_data['state'],
	$customer_data['country'],
	$customer_data['postcode'],
	$customer_data['company_name'],
	$appointment_data['appt_id'],
	$appointment_data['appt_date'],
	str_replace("_"," to ",$appointment_data['appt_time']),
	//ucwords(str_replace('_',' ',$appointment_data['status'])),
	$appointment_data['item_name'],
	amount_fomat($appointment_data['item_amount']),
	date('Y-m-d H:i'));

$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);

//Template file
require_once("views/view_appointment.php");

//Footer section
require_once("include/footer.php"); ?>