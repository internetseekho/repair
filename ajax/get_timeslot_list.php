<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$location_id = $post['location_id'];
$calendar_date = ($post['date']?$post['date']:$post['calendar_date']);
//if($calendar_date) {
	$option = $post['option'];
	$current_date = date('Y-m-d');
	
	//if($post['panel'] == "admin") {
	if($calendar_date) {
		$expl_appt_date = explode("/",$calendar_date);
		$calendar_date = $expl_appt_date[2].'-'.$expl_appt_date[0].'-'.$expl_appt_date[1];
	}
	//}
	
	$time_interval   = ($appt_time_interval * 60);
	$start_time = $appt_start_time;
	$end_time   = $appt_end_time;

	$query=mysqli_query($db,"SELECT * FROM locations WHERE published=1 AND id='".$location_id."'");
	$location_data=mysqli_fetch_assoc($query);
	if(count($location_data)>0) {
		$time_interval   = ($location_data['time_interval'] * 60);
		$start_time = trim($location_data['start_time']);
		$end_time   = trim($location_data['end_time']);
	}

	if($time_interval<=0) {
		$time_interval = (60 * 60);
	}
	if($start_time=="") {
		$start_time = "9:00 am";
	}
	if($end_time=="") {
		$end_time = "6:00 pm";
	}

	$start_time = strtotime($start_time);
	$end_time = strtotime($end_time);
	
	$response = array();
	$html = "";
	$is_criteria_match = false;

	if($option == '1') {
		$html .= '<option value=""> - Select - </option>';
		for($i = $start_time; $i<=$end_time; $i+=$time_interval) {
			$time = date('g:i a',$i);
			
			$time_h = date("H",strtotime($range));
			if($calendar_date==$current_date) {
				if(date("H")<$time_h) {
					$html .= "<option value=\"$time\">".format_time_without_timezone($time)."</option>".PHP_EOL;
					$is_criteria_match = true;
				}
			} else {
				$html .= "<option value=\"$time\">".format_time_without_timezone($time)."</option>".PHP_EOL;
				$is_criteria_match = true;
			}
		}

		if($is_criteria_match==false) {
			$response['status'] = false;
		} else {
			$response['status'] = true;
		}
	}

	$response['html'] = $html;
	$response['date_time'] = date("m/d/Y h:i:s a");
	echo json_encode($response);
	exit;
//} ?>