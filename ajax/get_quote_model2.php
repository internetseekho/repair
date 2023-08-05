<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.brand_id='".$post['brand_id']."' AND m.device_id='".$post['device_id']."' ORDER BY m.id DESC");
echo '<option value="">-- Select --</option>';
while($top_search_data=mysqli_fetch_assoc($query)) {
  $models_text = $top_search_data['models'];
  $models_text = ($models_text?" - ".$models_text:"");
	
  echo '<option value="'.$top_search_data['id'].'">'.$top_search_data['title'].$models_text.'</option>';
} ?>