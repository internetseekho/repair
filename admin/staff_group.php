<?php 
$file_name="staff_group";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM staff_groups ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($staff_g_data=mysqli_fetch_assoc($query)) {
		$nn = 0;
		$permissions_array = json_decode($staff_g_data['permissions'], true);
		$permissions = '';
		foreach($permissions_array as $permissions_k=>$permissions_v) {
			if($permissions_v == '1') {
				$permissions .= ucwords(str_replace("_"," ",$permissions_k)).", ";
			}
		}
		$staff_g_data['permissions'] = rtrim($permissions,', ');
		$data_list[] = $staff_g_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/staff_group/staff_group.php");

//Footer section
require_once("include/footer.php"); ?>
