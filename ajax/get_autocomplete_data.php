<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$list_of_model = '';
$query = $_REQUEST['query'];
if($query) {
	$top_search_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url AS d_sef_url, b.title AS brand_title, b.ordering AS brand_ordering, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND (m.searchable_words LIKE '%".$query."%' OR m.title LIKE '%".$query."%' OR b.title LIKE '%".$query."%') ORDER BY m.ordering ASC");
	while($top_search_data=mysqli_fetch_assoc($top_search_query)) {
		$models_text = $top_search_data['models'];
		$models_text = ($models_text?" - ".$models_text:"");
		
		$name = $top_search_data['brand_title'].' '.$top_search_data['title'].$models_text;
		$url = SITE_URL.$model_details_page_slug.$top_search_data['sef_url'];

		$list_of_model .= '{"value":"'.$name.'", "url":"'.$url.'"},';
	}
}

echo '{
		"query": "Unit",
		"suggestions": ['.rtrim($list_of_model,',').']
	}';
?>