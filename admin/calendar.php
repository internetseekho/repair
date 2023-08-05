<?php 
$file_name="calendar";

//Header section
require_once("include/header.php");

echo '<script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>';

$data_list = array();
$query=mysqli_query($db,"SELECT a.*, ast.id AS status_id, ast.name AS status_name, l.name AS location_name, u.name AS customer_name, ca.contractor_id, ca.amount AS contractor_amount, c.name AS contractor_name FROM appointments AS a LEFT JOIN locations AS l ON l.id=a.location_id LEFT JOIN users AS u ON u.id=a.user_id LEFT JOIN contractor_appt AS ca ON ca.appt_id=a.appt_id LEFT JOIN contractors AS c ON c.id=ca.contractor_id LEFT JOIN appointments_status AS ast ON ast.id=a.status ORDER BY a.id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($appointment_data=mysqli_fetch_assoc($query)) {
		$product_name = '';
		$status_id = '';
		$status_name = '';
		$className = '';

		$status_id = $appointment_data['status_id'];
		$status_name = $appointment_data['status_name'];
		if($status_id == '1') {
			$className = 'm-fc-event--success m-fc-event--solid-success';
		} elseif($status_id == '2') {
			$className = 'm-fc-event--brand m-fc-event--solid-brand';
		} elseif($status_id == '3') {
			$className = 'm-fc-event--info m-fc-event--solid-info';
		} elseif($status_id == '4') {
			$className = 'm-fc-event--danger m-fc-event--solid-danger';
		} else {
			$className = 'm-fc-event--success m-fc-event--solid-success';
		}

		$sql_mdl = mysqli_query($db,"SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'");
		$model_data = mysqli_fetch_assoc($sql_mdl);
		$product_name = $model_data['title'];

		$data_list[] = array('id'=>$appointment_data['id'],
							'title'=>$product_name,
							'url'=>ADMIN_URL.'addedit_appointment.php?id='.$appointment_data['id'],
							'start'=>date("Y-m-d H:i:s",strtotime($appointment_data['appt_date'].' '.$appointment_data['appt_time'])),
							//'start'=>date("Y-m-d H:i:s",strtotime("2018-11-14 11:00:00 am")),
							'description'=>$product_name.($status_name?' ('.$status_name.')':''),
							'className'=>$className);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/calendar.php");

//Footer section
require_once("include/footer.php"); ?>
