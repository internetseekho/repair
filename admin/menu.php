<?php 
$file_name="menu";

//Header section
require_once("include/header.php");

$menu_position = $post['position'];

function get_parent_menu_data($id) {
	global $db;
	$query = mysqli_query($db,"SELECT m.*, p.title AS page_title, p.url AS page_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.id='".$id."'");
	$parent_data = mysqli_fetch_assoc($query);
	return $parent_data;
}

$data_list = array();
$query=mysqli_query($db,"SELECT m.*, p.title AS page_title, p.url AS page_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.position='".$menu_position."' ORDER BY m.ordering ASC");
$num_rows = mysqli_num_rows($query);
if($num_rows>0) {
	while($menu_data=mysqli_fetch_assoc($query)) {
		$parent_menu_id = $menu_data['parent'];
		if($parent_menu_id>0) {
			$parent_menu_data = get_parent_menu_data($parent_menu_id);
			$menu_data['p_menu_name'] = $parent_menu_data['menu_name'];
		} else {
			$menu_data['p_menu_name'] = "";
		}
		$data_list[] = $menu_data;
	}
}
$json_data_list = json_encode($data_list);

//Template file
require_once("views/menu/menu.php");

//Footer section
require_once("include/footer.php"); ?>