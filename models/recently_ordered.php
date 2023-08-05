<?php
//Get model data list based on brandID
function get_recently_ordered_data_list($limit) {
	global $db;
	$response = array();
	
	$limit_q = "LIMIT 5";
	if($limit>0) {
		$limit_q = "LIMIT ".$limit;
	}
	
	//GROUP BY a.product_id
	$query=mysqli_query($db,"SELECT a.product_id, m.*, d.title AS device_title, d.sef_url AS d_sef_url, b.title AS brand_title FROM appointments AS a LEFT JOIN mobile AS m ON m.id=a.product_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ORDER BY a.id DESC ".$limit_q."");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}
?>

