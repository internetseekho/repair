<?php 
$file_name="staff";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT a.*, sg.name AS group_name FROM admin AS a LEFT JOIN staff_groups AS sg ON sg.id=a.group_id WHERE a.type!='super_admin'");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($staff_data=mysqli_fetch_assoc($query)) {
		$data_list[] = $staff_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/staff/staff.php");

//Footer section
require_once("include/footer.php"); ?>
