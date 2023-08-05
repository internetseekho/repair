<?php 
$file_name="email_template";

//Header section
require_once("include/header.php");

//Get fixed template type with respective template constants
require_once("include/template_type_with_constants.php");

//Gather mail template data from fixed type (template_type_with_constants.php)
$already_added_template_type = array();
$get_already_added_template_type_query = mysqli_query($db,'SELECT type FROM mail_templates');
while($get_already_added_template_type_row=mysqli_fetch_assoc($get_already_added_template_type_query)) {
	$already_added_template_type[$get_already_added_template_type_row['type']] = $get_already_added_template_type_row['type'];
}
$template_type_final_array = array_diff_key($template_type_array, $already_added_template_type);

$data_list = array();
$query=mysqli_query($db,"SELECT * FROM mail_templates ORDER BY id ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($tmpl_data=mysqli_fetch_assoc($query)) {
		if(in_array($tmpl_data['type'],$to_admin_tmpl_array)) {
			$filter_by = "to_admin";
		} elseif(in_array($tmpl_data['type'],$to_customer_tmpl_array)) {
			$filter_by = "to_customer";
		}
		
		$type = $template_type_array[$tmpl_data['type']];
		$subject = ucfirst($tmpl_data['subject']);
		
		$data_list[] = array('id'=>$tmpl_data['id'],'type'=>$type,'subject'=>$subject,'status'=>$tmpl_data['status'],'filter_by'=>$filter_by);
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/email_template/email_templates.php");

//Footer section
require_once("include/footer.php"); ?>
