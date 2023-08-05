<?php
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");

$response = array();

$post = $_REQUEST['post_data'];
$type = $post['type'];
$ids = $post['ids'];

if(!empty($ids) && $type == "remove") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;
		$query=mysqli_query($db,'DELETE FROM fault_price_manager WHERE id="'.$id_v.'"');
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
		
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something went wrong.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
} elseif(!empty($ids) && $type == "published") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;
		$query=mysqli_query($db,'UPDATE fault_price_manager SET status=1 WHERE id="'.$id_v.'"');
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully published.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully published.";
		
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something went wrong.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
} elseif(!empty($ids) && $type == "unpublished") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;
		$query=mysqli_query($db,'UPDATE fault_price_manager SET status=0 WHERE id="'.$id_v.'"');
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully unpublished.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully unpublished.";
		
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something went wrong.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
}

else if($type == "_update") {
	
	$fault_name=trim($post['fault_name']);
	$regular_price=trim($post['regular_price']);
	$is_on_offer=trim($post['is_on_offer']);
	$sale_price=trim($post['sale_price']);
	$offer_start_date=trim($post['offer_start_date']);
	$offer_end_date=trim($post['offer_end_date']);
	$status=$post['status'];
	$fault_id=$post['fault_id'];
	
	$offer_start_date_string='';
	if($offer_start_date!=''){
		$offer_start_date_array=explode('/',$offer_start_date);
		$offer_start_date_string=$offer_start_date_array['2'].'-'.$offer_start_date_array['0'].'-'.$offer_start_date_array['1'];
	}
	
	$offer_end_date_string='';
	if($offer_end_date!=''){
		$offer_end_date_array=explode('/',$offer_end_date);
		$offer_end_date_string=$offer_end_date_array['2'].'-'.$offer_end_date_array['0'].'-'.$offer_end_date_array['1'];
	}
	
	if($fault_id!=''){
		$_query="UPDATE fault_price_manager SET fault_name='".$db->real_escape_string($fault_name)."',regular_price='".$db->real_escape_string($regular_price)."',is_on_offer='".$db->real_escape_string($is_on_offer)."',sale_price='".$db->real_escape_string($sale_price)."',offer_start_date='".$db->real_escape_string($offer_start_date_string)."',offer_end_date='".$db->real_escape_string($offer_end_date_string)."',status='".$status."'  WHERE id='".$fault_id."'";
	}
	$db->query($_query);
	
	
	$msg = "Record successfully updated.";
		
	$_SESSION['success_msg']=$msg;
	$response['message'] = $msg;
	$response['status'] = "success";
}


else if($type == "_update_instant_field") {
	
	$field_name=trim($post['field_name']);
	$field_value=trim($post['field_value']);
	$fault_id=$post['fault_id'];
	
	
	if($fault_id!=''){
		$_query="UPDATE fault_price_manager SET ".$field_name."='".$db->real_escape_string($field_value)."' WHERE id='".$fault_id."'";
	}
	$db->query($_query);
	
	
	$msg = "Record successfully updated.";
		
	$_SESSION['success_msg']=$msg;
	$response['message'] = $msg;
	$response['status'] = "success";
}

else if($type == "export") {
	$ids = implode(",",$ids);
	
	$export_file_type=$post['export_file_type'];
	$export_data_option=$post['export_data_option'];

	$filter_by = "";
	
	
	if($post['filter_by']) {
		$filter_by .= " AND ( (fpm.fault_name LIKE '%".real_escape_string($post['filter_by'])."%') OR (m.title LIKE '%".real_escape_string($post['filter_by'])."%') )";
	}
	
	if($post['status']!='') {
		$filter_by .= " AND fpm.status = '".$post['status']."'";
	}
	
	if($post['cat']) {
		$filter_by .= " AND (c.title LIKE '%".$post['cat']."%')";
	}

	if($post['brand']) {
		$filter_by .= " AND (b.title LIKE '%".$post['brand']."%')";
	}

	if($post['device']) {
		$filter_by .= " AND (d.title LIKE '%".$post['device']."%')";
	}
	
	if($ids) {
		$filter_by .= " AND fpm.id IN(".$ids.")";
	}
	
	$_q="SELECT fpm.*, m.title, d.title AS device_title, d.sef_url, b.title AS brand_title, c.title AS cat_title FROM fault_price_manager AS fpm LEFT JOIN  mobile AS m ON m.id=fpm.model_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE 1 ".$filter_by."";
	
	$query=mysqli_query($db,$_q);
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		
		$data_to_csv_array = array();
		while($model_data=mysqli_fetch_assoc($query)) {
			$_offer_start_date=$model_data['offer_start_date']!=''?date('m/d/Y',strtotime($model_data['offer_start_date'])):'';
			$model_data['_offer_start_date']=$_offer_start_date;
			
			$_offer_end_date=$model_data['offer_end_date']!=''?date('m/d/Y',strtotime($model_data['offer_end_date'])):'';
			$model_data['_offer_end_date']=$_offer_end_date;
			
			$regular_price_display = amount_fomat($model_data['regular_price']);
			$model_data['regular_price_display']=$regular_price_display;
			
			$sale_price_display = ($model_data['sale_price'] && $model_data['sale_price']!='')?amount_fomat($model_data['sale_price']):'';
			$model_data['sale_price_display']=$sale_price_display;
			
			$model_data['is_on_offer_display']=($model_data['is_on_offer']=='1')?'Yes':'No';
			
			$model_data['status_display']=($model_data['status']=='1')?'Published':'Unpublished';
			
			$data_to_csv_array[] = $model_data;
		}
		
		/*echo '<pre>';
		print_r($data_to_csv_array);
		exit;*/
	
		//print_r($data_to_csv_array);
		
		if($export_file_type=="csv"){
			
			$filename = 'faults-'.date("YmdHis").".csv";
			$fp = fopen('../../uploaded_file/'.$filename, 'w');	
			$header = array('Model_ID','Model_Title','Device','fault_id','fault_name','regular_price','is_on_offer','sale_price','offer_start_date','offer_end_date','status');
			fputcsv($fp, $header);
		
			if(!empty($data_to_csv_array)) {
				foreach($data_to_csv_array as $data_to_csv_data) {
					$f_data_to_csv = array();
					$f_data_to_csv[] = $data_to_csv_data['model_id'];
					$f_data_to_csv[] = $data_to_csv_data['title'];
					$f_data_to_csv[] = $data_to_csv_data['device_title'];
					$f_data_to_csv[] = $data_to_csv_data['id'];
					$f_data_to_csv[] = $data_to_csv_data['fault_name'];
					$f_data_to_csv[] = $data_to_csv_data['regular_price'];
					$f_data_to_csv[] = $data_to_csv_data['is_on_offer_display'];
					$f_data_to_csv[] = $data_to_csv_data['sale_price'];
					$f_data_to_csv[] = $data_to_csv_data['offer_start_date'];
					$f_data_to_csv[] = $data_to_csv_data['offer_end_date'];
					$f_data_to_csv[] = $data_to_csv_data['status_display'];
					fputcsv($fp, $f_data_to_csv);
				}
			}
			
			$file_path=ADMIN_URL.'uploaded_file/'.$filename;
		}
		else if($export_file_type=='pdf'){
			
			
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:20px;
  font-weight:bold;
}
</style>
EOF;
				
				$html.='<h2>Fault List</h2>
				<table cellspacing="1" cellpadding="2" border="1" nobr="true">
					<thead>
					  <tr nobr="true">
						<th>Model Title</th>
						<th>Device</th>
						<th>Fault Name</th>
						<th>Regular Price ('.$currency_symbol.')</th>
						<th>On Offer</th>
						<th>Sale Price('.$currency_symbol.')</th>
						<th>Offer Start Date</th>
						<th>Offer End Date</th>
					  </tr>
					</thead>
					<tbody>';
				
					if(!empty($data_to_csv_array)) {
						foreach($data_to_csv_array as $data_to_csv_data) {
							
							$html.='<tr nobr="true">
								<td>'.$data_to_csv_data['title'].'</td>
								<td>'.$data_to_csv_data['device_title'].'</td>
								<td>'.$data_to_csv_data['fault_name'].'</td>
								<td>'.$data_to_csv_data['regular_price'].'</td>
								<td>'.$data_to_csv_data['is_on_offer_display'].'</td>
								<td>'.$data_to_csv_data['sale_price'].'</td>
								<td>'.$data_to_csv_data['_offer_start_date'].'</td>
								<td>'.$data_to_csv_data['_offer_end_date'].'</td>
							</tr>';
						}
					}
					
					$html.='</tbody>
				</table>';
				
				/*echo $html;
				exit;*/
				
				require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
				require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');
				
				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
				
				// set document information
				$pdf->SetCreator($general_setting_data['from_name']);
				$pdf->SetAuthor($general_setting_data['from_name']);
				$pdf->SetTitle($general_setting_data['from_name']);
				
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				
				
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				
				
				// add a page
				$pdf->AddPage();
				
				$pdf->writeHtml($html, true, false, false, false, '');
				
				ob_end_clean();
				
				$file_folder='pdf/export';
				$file_folder_path = CP_ROOT_PATH.'/admin/'.$file_folder;
				if(!file_exists($file_folder_path))
					mkdir($file_folder_path, 0777);
				
				$pdf_name='faults-'.date('Y-m-d-H-i-s').'.pdf';
				$pdf->Output($file_folder_path.'/'.$pdf_name, 'F');
			
				
				$file_path=ADMIN_URL.$file_folder.'/'.$pdf_name;
			
			
		}
		$response['message'] = "";
		$response['status'] = "export_success";
		$response['file_path'] = $file_path;
	}
	else{
		$msg='Sorry! No Records found.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "fail";
	}
}


echo json_encode($response);
exit;
?>