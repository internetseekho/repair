<?php
//Get device data list based on brandID
function get_b_device_data_list($brand_id) {
	global $db;
	$response = array();
	//$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE d.published=1 AND d.brand_id='".$brand_id."' AND b.id='".$brand_id."' ORDER BY d.ordering ASC");
	$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.brand_id='".$brand_id."' AND b.id='".$brand_id."' GROUP BY m.device_id ORDER BY d.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_list=mysqli_fetch_assoc($query)) {
			$response[] = $device_list;
		}
	}
	return $response;
}
?>

