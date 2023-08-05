<?php 
$file_name="service";

//Header section
require_once("include/header.php");

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM services ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($service_data=mysqli_fetch_assoc($query)) {
		$data_list[] = array('id'=>$service_data['id'],'title'=>base64_encode($service_data['title']),'description'=>base64_encode($service_data['description']),'image'=>$service_data['image'],'ordering'=>$service_data['ordering'],'status'=>$service_data['published']);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/service/service.php");

//Footer section
require_once("include/footer.php"); ?>
