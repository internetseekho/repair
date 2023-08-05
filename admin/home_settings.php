<?php
$file_name="home_settings";

//Header section
require_once("include/header.php");

//Fetch brands data
$data_list = array();
$query=mysqli_query($db,"SELECT * FROM home_settings ORDER BY ordering ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($home_settings_data=mysqli_fetch_assoc($query)) {
		$data_list[] = array('id'=>$home_settings_data['id'],'title'=>$home_settings_data['title'],'section_name'=>ucwords(str_replace("_"," ",$home_settings_data['section_name'])),'type'=>ucwords(str_replace("_"," ",$home_settings_data['type'])),'ordering'=>$home_settings_data['ordering'],'status'=>$home_settings_data['status']);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/settings/home_settings.php");

//Footer section
require_once("include/footer.php"); ?>

