<?php
//START for faqs
function get_faqs_html() {
	global $db;
	$response = array();
	$html = '';
	$data = array();
	$query=mysqli_query($db,"SELECT * FROM faqs WHERE status=1 ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$n = 0;
		$html .= '<div class="col_full nobottommargin">';
			$html .= '<div class="accordion accordion-border clearfix" data-state="closed">';
		//$html .= '<div class="faq-block modern-text slideInRight animated" id="device-prop-area">';
  			//$html .= '<div id="accordion" role="tablist" aria-multiselectable="true">';
			while($faq_data=mysqli_fetch_assoc($query)) {
				$data[] = $faq_data;
				$n = $n+1;
				
				$html .= '<div class="acctitle"><i class="acc-closed icon-question-sign"></i><i class="acc-open icon-question-sign"></i>'.$faq_data['title'].'</div>';
				$html .= '<div class="acc_content clearfix">'.$faq_data['description'].'</div>';
							
				/*$html .= '<div class="panel">';
				  $html .= '<div class="tab-header" role="tab">';
					$html .= '<h4 class="modern-text__area clearfix">';
						$html .= '<a class="clearfix collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$n.'" aria-expanded="false" aria-controls="collapse'.$n.'">';
							$html .= '<span class="modern-text__num clearfix"><b class="modern-num clearfix"><img class="add" src="'.SITE_URL.'images/add.png" alt="plus"><img class="remove" src="'.SITE_URL.'images/remove.png" alt="rmove"></b></span>';
							$html .= '<span class="modern-text__title"> '.$faq_data['title'].' </span>';
						$html .= '</a>';
					$html .= '</h4>';
				  $html .= '</div>';
				  $html .= '<div id="collapse'.$n.'" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 35px;"> '.$faq_data['description'].' </div>';
				$html .= '</div>';*/
			}
			$html .= '</div>';
  		$html .= '</div>';
		$response['data'] = $data;
		$response['html'] = $html;
	}
	return $response;
}
$faqs_data_html = get_faqs_html();
if($faqs_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs]",$faqs_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs]",'',$active_page_data['content']);
} //END for faqs

//START for faqs/groups
function get_faqs_groups_html() {
	global $db;
	$response = array();
	$html = '';
	$data = array();

	$g_query=mysqli_query($db,"SELECT * FROM faqs_groups WHERE status=1 ORDER BY ordering ASC");
	$num_of_g_rows = mysqli_num_rows($g_query);
	if($num_of_g_rows>0) {
		$n = 0;
		
		$html .= '<section id="content"><div class="clearfix">';
		
		while($faq_group_data=mysqli_fetch_assoc($g_query)) {
			$html .= '<div class="col_full nobottommargin"><h4>'.$faq_group_data['title'].'</h4>';
			$html .= '<div class="accordion accordion-border clearfix" data-state="closed">';
				//$html .= '<div id="accordion" role="tablist" aria-multiselectable="true">';
				
				$query=mysqli_query($db,"SELECT * FROM faqs WHERE status=1 AND group_id='".$faq_group_data['id']."' ORDER BY ordering ASC");
				$num_of_rows = mysqli_num_rows($query);
				if($num_of_rows>0) {
					while($faq_data=mysqli_fetch_assoc($query)) {
						$data[] = $faq_data;
						$n = $n+1;
						$html .= '<div class="acctitle"><i class="acc-closed icon-question-sign"></i><i class="acc-open icon-question-sign"></i>'.$faq_data['title'].'</div>';
							$html .= '<div class="acc_content clearfix">'.$faq_data['description'].'</div>';
							
						//$html .= '<div class="acctitle">';
						 // $html .= '<div class="acc_content clearfix">';
							//$html .= '<h4 class="modern-text__area clearfix">';
								//$html .= '<a class="clearfix collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-g-'.$n.'" aria-expanded="false" aria-controls="collapse-g-'.$n.'">';
									//$html .= '<span class="modern-text__num clearfix"><b class="modern-num clearfix"><img class="add" src="'.SITE_URL.'images/add.png" alt="plus"><img class="remove" src="'.SITE_URL.'images/remove.png" alt="rmove"></b></span>';
									//$html .= '<span class="modern-text__title"> '.$faq_data['title'].' </span>';
								//$html .= '</a>';
						//	//$html .= '</h4>';
						 // $html .= '</div>';
						 // $html .= '<div id="collapse-g-'.$n.'" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 35px;"> '.$faq_data['description'].' </div>';
						//$html .= '</div>';
					}
				}
				
				//$html .= '</div>';
			$html .= '</div></div>';
		}
		
		$query=mysqli_query($db,"SELECT * FROM faqs WHERE status=1 AND (group_id='' OR group_id='0') ORDER BY ordering ASC");
		$num_of_rows = mysqli_num_rows($query);
		if($num_of_rows>0) {
			$html .= '<div class="col_full nobottommargin"><h4>Others</h4>';
			$html .= '<div class="accordion accordion-border clearfix" data-state="closed">';
			
			//$html .= '<h2>Others</h2>';
			//$html .= '<div class="faq-block modern-text slideInRight animated" id="device-prop-area">';
				//$html .= '<div id="accordion" role="tablist" aria-multiselectable="true">';

				while($faq_data=mysqli_fetch_assoc($query)) {
					$data[] = $faq_data;
					$n = $n+1;
					
					$html .= '<div class="acctitle"><i class="acc-closed icon-question-sign"></i><i class="acc-open icon-question-sign"></i>'.$faq_data['title'].'</div>';
					$html .= '<div class="acc_content clearfix">'.$faq_data['description'].'</div>';
							
					/*$html .= '<div class="panel">';
					  $html .= '<div class="tab-header" role="tab">';
						$html .= '<h4 class="modern-text__area clearfix">';
							$html .= '<a class="clearfix collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-g-'.$n.'" aria-expanded="false" aria-controls="collapse-g-'.$n.'">';
								$html .= '<span class="modern-text__num clearfix"><b class="modern-num clearfix"><img class="add" src="'.SITE_URL.'images/add.png" alt="plus"><img class="remove" src="'.SITE_URL.'images/remove.png" alt="rmove"></b></span>';
								$html .= '<span class="modern-text__title"> '.$faq_data['title'].' </span>';
							$html .= '</a>';
						$html .= '</h4>';
					  $html .= '</div>';
					  $html .= '<div id="collapse-g-'.$n.'" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 35px;"> '.$faq_data['description'].' </div>';
					$html .= '</div>';*/
				}
				
				$html .= '</div>';
			$html .= '</div>';
		}
		
		$html .= '</div></section>';
		
		$response['data'] = $data;
		$response['html'] = $html;
	}
	return $response;
}
$faqs_groups_data_html = get_faqs_groups_html();
if($faqs_groups_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs_groups]",$faqs_groups_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs_groups]",'',$active_page_data['content']);
} //END for faqs/groups
?>