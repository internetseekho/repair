<?php
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");
check_admin_staff_auth("ajax");

$response = array();

$post = $_REQUEST['post_data'];
$type = $post['type'];
$ids = $post['ids'];

if(!empty($ids) && $type == "remove") {
	$removed_idd = array();
	foreach($ids as $id_k=>$id_v) {
		$removed_idd[] = $id_v;

		$category_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$id_v.'"');
		$model_data=mysqli_fetch_assoc($category_q);
		if($model_data['model_img']!="")
			unlink('../../../images/mobile/'.$model_data['model_img']);

		$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$id_v.'"');
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
		$query=mysqli_query($db,'UPDATE mobile SET published=1 WHERE id="'.$id_v.'"');
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
		$query=mysqli_query($db,'UPDATE mobile SET published=0 WHERE id="'.$id_v.'"');
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
} elseif(!empty($ids) && $type == "order") {
	foreach($ids as $key => $ordering_data) {
		$exp_ordering_data = explode(":",$ordering_data);
		if($exp_ordering_data[0]>0 && $exp_ordering_data[1]>0) {
			$query = mysqli_query($db,"UPDATE mobile SET ordering='".$exp_ordering_data[1]."' WHERE id='".$exp_ordering_data[0]."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
		$response['message'] = $msg;
		$response['status'] = "success";
	}
} elseif($type == "export") {
	$ids = implode(",",$ids);

	$filter_by = "";
	if($post['filter_by']) {
		$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
	}
	
	if($post['status']!='') {
		$filter_by .= " AND m.published = '".$post['status']."'";
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
		$filter_by .= " AND m.id IN(".$ids.")";
	}

	// AND m.id IN(58,59)
	$query=mysqli_query($db,"SELECT m.*, c.title AS cat_title, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE 1 ".$filter_by." ORDER BY m.id ASC");
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		//$fp = fopen('php://output', 'w');
		$fp = fopen('../../uploaded_file/'.$filename, 'w');	
		//header('Content-type: application/csv');
		//header('Content-Disposition: attachment; filename='.$filename);

		$header = array('Model_ID','Brand','Model_Title','Device','Model_Price','Field_ID','Field_Title','Field_Item_ID','Field_Item_Title','Field_Item_Price');
		fputcsv($fp, $header);

		$data_to_csv_array = array();
		while($model_data=mysqli_fetch_assoc($query)) {
			$data_to_csv = array();
			$sql_pr_fld = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$model_data['id']."' ORDER BY sort_order");
			$no_of_pr_fld = mysqli_num_rows($sql_pr_fld);
			if($no_of_pr_fld>0) {
				while($product_fields_data = mysqli_fetch_assoc($sql_pr_fld)) {
					if($model_data['id']!=$model_tmp_id) {
						$data_to_csv['Model_ID'] = $model_data['id'];
						$data_to_csv['Brand'] = $model_data['brand_title'];
						$data_to_csv['Model_Title'] = $model_data['title'];
						$data_to_csv['Device'] = $model_data['device_title'];
						$data_to_csv['Model_Price'] = $model_data['price'];
					} else {
						$data_to_csv['Model_ID'] = '';
						$data_to_csv['Brand'] = '';
						$data_to_csv['Model_Title'] = '';
						$data_to_csv['Device'] = '';
						$data_to_csv['Model_Price'] = '';
					}

					$sql_pr_opt = mysqli_query($db,"SELECT * FROM product_options WHERE product_field_id = '".$product_fields_data['id']."' ORDER BY sort_order");
					$no_of_pr_opt = mysqli_num_rows($sql_pr_opt);
					if($no_of_pr_opt>0) {
						while($product_option_data = mysqli_fetch_assoc($sql_pr_opt)) {
							if($product_fields_data['id']!=$product_fields_tmp_id) {
								$data_to_csv['Field_ID'] = $product_fields_data['id'];
								$data_to_csv['Field_Title'] = $product_fields_data['title'];
							} else {
								$data_to_csv['Model_ID'] = '';
								$data_to_csv['Brand'] = '';
								$data_to_csv['Model_Title'] = '';
								$data_to_csv['Device'] = '';
								$data_to_csv['Model_Price'] = '';
								$data_to_csv['Field_ID'] = '';
								$data_to_csv['Field_Title'] = '';
							}
							
							$data_to_csv['Field_Item_ID'] = $product_option_data['id'];
							$data_to_csv['Field_Item_Title'] = $product_option_data['label'];
							$data_to_csv['Field_Item_Price'] = $product_option_data['price'];
							$data_to_csv_array[] = $data_to_csv;
	
							$product_fields_tmp_id = $product_fields_data['id'];
						}
					} else {
						if($product_fields_data['id']!=$product_fields_tmp_id) {
							$data_to_csv['Field_ID'] = $product_fields_data['id'];
							$data_to_csv['Field_Title'] = $product_fields_data['title'];
						} else {
							$data_to_csv['Model_ID'] = '';
							$data_to_csv['Brand'] = '';
							$data_to_csv['Model_Title'] = '';
							$data_to_csv['Device'] = '';
							$data_to_csv['Model_Price'] = '';
							$data_to_csv['Field_ID'] = '';
							$data_to_csv['Field_Title'] = '';
						}
						$data_to_csv['Field_Item_ID'] = '';
						$data_to_csv['Field_Item_Title'] = '';
						$data_to_csv['Field_Item_Price'] = '';
						$data_to_csv_array[] = $data_to_csv;
						
						$product_fields_tmp_id = $product_fields_data['id'];
					}
					$model_tmp_id = $model_data['id'];											
				}
			}
		}
	
		/*echo '<pre>';
		print_r($data_to_csv_array);
		exit;*/

		if(!empty($data_to_csv_array)) {
			foreach($data_to_csv_array as $data_to_csv_data) {
				$f_data_to_csv = array();
				$f_data_to_csv[] = $data_to_csv_data['Model_ID'];
				$f_data_to_csv[] = $data_to_csv_data['Brand'];
				$f_data_to_csv[] = $data_to_csv_data['Model_Title'];
				$f_data_to_csv[] = $data_to_csv_data['Device'];
				$f_data_to_csv[] = $data_to_csv_data['Model_Price'];
				$f_data_to_csv[] = $data_to_csv_data['Field_ID'];
				$f_data_to_csv[] = $data_to_csv_data['Field_Title'];
				$f_data_to_csv[] = $data_to_csv_data['Field_Item_ID'];
				$f_data_to_csv[] = $data_to_csv_data['Field_Item_Title'];
				$f_data_to_csv[] = $data_to_csv_data['Field_Item_Price'];
				fputcsv($fp, $f_data_to_csv);
			}
		}
	}

	/*if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		//$fp = fopen('php://output', 'w');
		$fp = fopen('../../uploaded_file/'.$filename, 'w');	
		//header('Content-type: application/csv');
		//header('Content-Disposition: attachment; filename='.$filename);

		$header = array('ID','Icon','Title','Base Price','Added Date');
		fputcsv($fp, $header);

		while($model_data=mysqli_fetch_assoc($query)) {
			$data_to_csv = array();
			$data_to_csv[] = $model_data['id'];
			$data_to_csv[] = $model_data['model_img'];
			$data_to_csv[] = $model_data['title'];
			$data_to_csv[] = $model_data['price'];
			$data_to_csv[] = $model_data['created_date'];

			fputcsv($fp, $data_to_csv);
		}
	}*/
	
	$response['message'] = "";
	$response['status'] = "csv_success";
	$response['csv_path'] = ADMIN_URL.'uploaded_file/'.$filename;
} elseif($type == "export_meta") {
	$ids = implode(",",$ids);

	$filter_by = "";
	if($post['filter_by']) {
		$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
	}
	
	if($post['status']!='') {
		$filter_by .= " AND m.published = '".$post['status']."'";
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
		$filter_by .= " AND m.id IN(".$ids.")";
	}

	$query=mysqli_query($db,"SELECT m.*, c.title AS cat_title, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE 1 ".$filter_by." ORDER BY m.id ASC");
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		//$fp = fopen('php://output', 'w');
		$fp = fopen('../../uploaded_file/'.$filename, 'w');	
		//header('Content-type: application/csv');
		//header('Content-Disposition: attachment; filename='.$filename);

		$header = array('Model_ID','Title','Sef_Url','Meta_Title','Meta_Keywords','Meta_Description','Meta_Canonical_URL');
		fputcsv($fp, $header);

		$data_to_csv_array = array();
		while($model_data=mysqli_fetch_assoc($query)) {
			$data_to_csv = array();
			$data_to_csv['Model_ID'] = $model_data['id'];
			$data_to_csv['Title'] = $model_data['title'];
			$data_to_csv['Sef_Url'] = $model_data['sef_url'];
			$data_to_csv['Meta_Title'] = $model_data['meta_title'];
			$data_to_csv['Meta_Keywords'] = $model_data['meta_keywords'];
			$data_to_csv['Meta_Description'] = $model_data['meta_desc'];
			$data_to_csv['Meta_Canonical_URL'] = $model_data['meta_canonical_url'];
			$data_to_csv_array[] = $data_to_csv;
		}

		//print_r($data_to_csv_array);
		//exit;

		if(!empty($data_to_csv_array)) {
			foreach($data_to_csv_array as $data_to_csv_data) {
				$f_data_to_csv = array();
				$f_data_to_csv[] = $data_to_csv_data['Model_ID'];
				$f_data_to_csv[] = $data_to_csv_data['Title'];
				$f_data_to_csv[] = $data_to_csv_data['Sef_Url'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Title'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Keywords'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Description'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Canonical_URL'];
				fputcsv($fp, $f_data_to_csv);
			}
		}
	}
	
	$response['message'] = "";
	$response['status'] = "csv_success";
	$response['csv_path'] = ADMIN_URL.'uploaded_file/'.$filename;
}

echo json_encode($response);
exit;
?>