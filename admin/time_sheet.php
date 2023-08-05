<?php 
$file_name="time_sheet";

//Header section
require_once("include/header.php");

$mysql_q = "";
if($post['staff_id']) {
	$mysql_q .= " AND t.staff_id='".$post['staff_id']."'";
}

if($post['order_id']) {
	$mysql_q .= " AND t.order_id='".$post['order_id']."'";
}

if($post['from_date'] != "" && $post['to_date'] != "") {
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	
	$mysql_q .= " AND (DATE_FORMAT(t.clock_in_datetime,'%Y-%m-%d')>='".$from_date."' AND DATE_FORMAT(t.clock_in_datetime,'%Y-%m-%d')<='".$to_date."')";
} elseif($post['from_date'] != "") {
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	$mysql_q .= " AND DATE_FORMAT(t.clock_in_datetime,'%Y-%m-%d')='".$from_date."'";
} elseif($post['to_date'] != "") {
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	$mysql_q .= " AND DATE_FORMAT(t.clock_in_datetime,'%Y-%m-%d')='".$to_date."'";
}

$data_list = array();
$total_hours_array = array();

if($admin_type == "super_admin") {
	$timesheet_q = "SELECT t.*, st.name AS staff_name FROM time_sheet AS t LEFT JOIN admin AS st ON st.id=t.staff_id WHERE 1 ".$mysql_q." ORDER BY t.clock_out_datetime ASC";
	$orderid_q = "SELECT t.*, st.name AS staff_name FROM time_sheet AS t LEFT JOIN admin AS st ON st.id=t.staff_id GROUP BY t.order_id DESC";
} else {
	$timesheet_q = "SELECT t.*, st.name AS staff_name FROM time_sheet AS t LEFT JOIN admin AS st ON st.id=t.staff_id WHERE t.staff_id='".$admin_l_id."'".$mysql_q." ORDER BY t.id DESC";
	$orderid_q = "SELECT t.*, st.name AS staff_name FROM time_sheet AS t LEFT JOIN admin AS st ON st.id=t.staff_id WHERE t.staff_id='".$admin_l_id."' GROUP BY t.order_id DESC";
}
$query=mysqli_query($db,$timesheet_q);
$order_id_q=mysqli_query($db,$orderid_q);

$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($time_sheet_data=mysqli_fetch_assoc($query)) {
		$clock_in_datetime = $time_sheet_data['clock_in_datetime'];
		$clock_out_datetime = $time_sheet_data['clock_out_datetime'];
		$f_clock_out_datetime = "";
		if($clock_out_datetime!="" && $clock_out_datetime!="0000-00-00 00:00:00") {
			$f_clock_out_datetime = format_date($clock_out_datetime).' '.format_time($clock_out_datetime);//date("m/d/Y h:i A",strtotime($clock_out_datetime));
		}
		$time_sheet_data['clock_in_datetime'] = format_date($clock_in_datetime).' '.format_time($clock_in_datetime);//date("m/d/Y h:i A",strtotime($clock_in_datetime));
		$time_sheet_data['clock_out_datetime'] = ($f_clock_out_datetime?$f_clock_out_datetime:"Pending");

		if(!$f_clock_out_datetime) {
			$time_sheet_data['total_hm'] = ' -- ';
		} else {
			$time_diff = time_diff_from_two_datetime($clock_in_datetime,$clock_out_datetime);
			$time_sheet_data['total_hm'] = $time_diff;
			$total_hours_array[] = $time_diff;
		}
		$data_list[] = $time_sheet_data;
	}
}
$json_data_list = json_encode($data_list);
			
//Template file
require_once("views/time_sheet.php");

//Footer section
require_once("include/footer.php"); ?>