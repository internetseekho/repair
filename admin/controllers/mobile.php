<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['c_id'])) {
	$qry=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$post['c_id']."'");
	$model_data=mysqli_fetch_assoc($qry);
	$model_data['title'] = $model_data['title'].' - Copy';
	$model_data['published'] = 0;
	$model_data['model_img'] = '';
	$sef_url = createSlug($model_data['title']);
	
	$svd_query=mysqli_query($db,"INSERT INTO `mobile`(`title`, `meta_title`, `meta_desc`, `meta_keywords`, `cat_id`, `device_id`, `price`, `model_img`, `tooltip_device`, `top_seller`, `type`, `published`, `cstm_group_id`, `ordering`, `created_date`, `released_year_month`,sef_url) VALUES ('".$model_data['title']."', '".$model_data['meta_title']."', '".$model_data['meta_desc']."', '".$model_data['meta_keywords']."', '".$model_data['cat_id']."', '".$model_data['device_id']."', '".$model_data['price']."', '".$model_data['model_img']."', '".$model_data['tooltip_device']."', '".$model_data['top_seller']."', '".$model_data['type']."', '".$model_data['published']."', '".$model_data['cstm_group_id']."', '".$model_data['ordering']."', '".$model_data['created_date']."', '".$model_data['released_year_month']."','".$sef_url."')");
	if($svd_query == '1') {
		$last_insert_id = mysqli_insert_id($db);
		$pf_qry=mysqli_query($db,"SELECT * FROM product_fields WHERE product_id='".$model_data['id']."'");
		while($product_fields_data=mysqli_fetch_assoc($pf_qry)) {
			$pf_svd_query=mysqli_query($db,"INSERT INTO `product_fields`(`title`, `input_type`, `is_required`, `sort_order`, `tooltip`, `icon`, `product_id`) VALUES ('".$product_fields_data['title']."','".$product_fields_data['input_type']."','".$product_fields_data['is_required']."','".$product_fields_data['sort_order']."','".$product_fields_data['tooltip']."','".$product_fields_data['icon']."','".$last_insert_id."')");
			if($pf_svd_query == '1') {
				$last_pf_insert_id = mysqli_insert_id($db);
				$po_qry=mysqli_query($db,"SELECT * FROM product_options WHERE product_field_id='".$product_fields_data['id']."'");
				while($product_options_data=mysqli_fetch_assoc($po_qry)) {
					mysqli_query($db,"INSERT INTO `product_options`(`label`, `add_sub`, `price_type`, `price`, `sort_order`, `is_default`, `tooltip`, `icon`, `product_field_id`) VALUES ('".$product_options_data['label']."','".$product_options_data['add_sub']."','".$product_options_data['price_type']."','".$product_options_data['price']."','".$product_options_data['sort_order']."','".$product_options_data['is_default']."','".$product_options_data['tooltip']."','".$product_options_data['icon']."','".$last_pf_insert_id."')");
				}
			}
		}

		$msg="Model has been successfully cloned.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}

	setRedirect(ADMIN_URL.'add_product.php?id='.$last_insert_id);
} elseif(isset($post['d_id'])) {
	$behand_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['d_id'].'"');
	$behand_data=mysqli_fetch_assoc($behand_q);

	$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($behand_data['model_img']!="")
			unlink('../../images/mobile/'.$behand_data['model_img']);

		$msg="Delete Successfully.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$mobile_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$id_v.'"');
			$mobile_data=mysqli_fetch_assoc($mobile_q);
			if($mobile_data['model_img']!="")
				unlink('../../images/mobile/'.$mobile_data['model_img']);

			$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE mobile SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['update'])) {
	$device_id = $post['device_id'];
	$cat_id = $post['cat_id'];
	$title=real_escape_string($post['title']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$price=real_escape_string($post['price']);
	$top_seller=real_escape_string($post['top_seller']);
	$unlock_price=real_escape_string($post['unlock_price']);
	$tooltip_device=real_escape_string($post['tooltip_device']);
	$tooltip_condition=real_escape_string($post['tooltip_condition']);
	$tooltip_network=real_escape_string($post['tooltip_network']);
	$tooltip_colors=real_escape_string($post['tooltip_colors']);
	$tooltip_miscellaneous=real_escape_string($post['tooltip_miscellaneous']);
	$tooltip_accessories=real_escape_string($post['tooltip_accessories']);
	$published = $post['published'];

	if(!empty($post['storage_size'])) {
		foreach($post['storage_size'] as $key=>$value) {
			if(trim($value)) {
				$storage[] = array('storage_size'=>$value,'storage_price'=>$post['storage_price'][$key]);
			}
		}
		$storage_data=real_escape_string(json_encode($storage));
	}

	if(!empty($post['condition_name'])) {
		foreach($post['condition_name'] as $c_key=>$c_value) {
			if(trim($c_value)) {
				$condition[] = array('condition_name'=>$c_value,'condition_price'=>$post['condition_price'][$c_key],'condition_terms'=>htmlentities($post['condition_terms'][$c_key]),'disabled_network'=>$post['disabled_network'][$c_key]);
			}
		}
		$condition_data=real_escape_string(json_encode($condition));
	}

	if(!empty($post['color_name'])) {
		foreach($post['color_name'] as $cl_key=>$cl_value) {
			if(trim($cl_value)) {
				$colors[] = array('color_name'=>$cl_value,'color_price'=>$post['color_price'][$cl_key]);
			}
		}
		$colors_data=real_escape_string(json_encode($colors));
	}

	if(!empty($post['accessories_name'])) {
		foreach($post['accessories_name'] as $asr_key=>$asr_value) {
			if(trim($asr_value)) {
				$accessories[] = array('accessories_name'=>$asr_value,'accessories_price'=>$post['accessories_price'][$asr_key]);
			}
		}
		$accessories_data=real_escape_string(json_encode($accessories));
	}

	if(!empty($post['miscellaneous_name'])) {
		foreach($post['miscellaneous_name'] as $m_key=>$m_value) {
			if(trim($m_value)) {
				$miscellaneous[] = array('miscellaneous_name'=>$m_value,'miscellaneous_price'=>$post['miscellaneous_price'][$m_key]);
			}
		}
		$miscellaneous_data=real_escape_string(json_encode($miscellaneous));
	}

	if(!empty($post['network_name'])) {	
		foreach($post['network_name'] as $n_key=>$n_value) {
			$network_price = 0;
			$network_price = ($post['network_price'][$n_key]>0?$post['network_price'][$n_key]:0);
			$network[] = array('network_name'=>$n_value,'network_price'=>$network_price,'most_popular'=>$post['most_popular'][$n_key],'change_unlock'=>$post['change_unlock'][$n_key]);
		}
		$network_data=real_escape_string(json_encode($network));
	}

	if($_FILES['model_img']['name']) {
		if(!file_exists('../../images/mobile/'))
			mkdir('../../images/mobile/',0777);
			
		$image_ext = pathinfo($_FILES['model_img']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/mobile/'.$post['old_image']);

			$image_tmp_name=$_FILES['model_img']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', model_img="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/mobile/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_mobile.php');
			}
			exit();
		}
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE mobile SET title="'.$title.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", device_id="'.$device_id.'", cat_id="'.$cat_id.'", price="'.$price.'" '.$imageupdate.', storage="'.$storage_data.'", conditions="'.$condition_data.'", unlock_price="'.$unlock_price.'", network="'.$network_data.'", tooltip_device="'.$tooltip_device.'", tooltip_condition="'.$tooltip_condition.'", tooltip_network="'.$tooltip_network.'", tooltip_colors="'.$tooltip_colors.'", tooltip_miscellaneous="'.$tooltip_miscellaneous.'", tooltip_accessories="'.$tooltip_accessories.'", top_seller="'.$top_seller.'", published="'.$published.'", colors="'.$colors_data.'", accessories="'.$accessories_data.'", miscellaneous="'.$miscellaneous_data.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Model has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO mobile(title, meta_title, meta_desc, meta_keywords, device_id, cat_id, price, model_img, storage, conditions, unlock_price, network, tooltip_device, tooltip_condition, tooltip_network, tooltip_colors, tooltip_miscellaneous, tooltip_accessories, top_seller, published, colors, accessories, miscellaneous) values("'.$title.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$device_id.'","'.$cat_id.'","'.$price.'","'.$image_name.'","'.$storage_data.'","'.$condition_data.'","'.$unlock_price.'","'.$network_data.'","'.$tooltip_device.'","'.$tooltip_condition.'","'.$tooltip_network.'","'.$tooltip_colors.'","'.$tooltip_miscellaneous.'","'.$tooltip_accessories.'","'.$top_seller.'","'.$published.'","'.$colors_data.'","'.$accessories_data.'","'.$miscellaneous_data.'")');
		if($query=="1") {
			$msg="Model has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'mobile.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_mobile.php');
		}
	}
} elseif($post['r_img_id']) {
	$mobile_data_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['r_img_id'].'"');
	$mobile_data=mysqli_fetch_assoc($mobile_data_q);

	$del_logo=mysqli_query($db,'UPDATE mobile SET model_img="" WHERE id='.$post['r_img_id']);
	if($mobile_data['model_img']!="")
		unlink('../../images/mobile/'.$mobile_data['model_img']);

	setRedirect(ADMIN_URL.'add_product.php?id='.$post['id']);
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE mobile SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['export'])) {
	$ids = $post['ids'];
	
	$filter_by = "";
	if($post['filter_by']) {
		$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
	}

	if($post['cat_id']) {
		$filter_by .= " AND m.cat_id = '".$post['cat_id']."'";
	}

	if($post['brand_id']) {
		$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
	}

	if($post['device_id']) {
		$filter_by .= " AND m.device_title = '".$post['device_id']."'";
	}

	if($ids) {
		$filter_by .= " AND m.id IN(".$ids.")";
	}

	$query=mysqli_query($db,"SELECT m.*, c.title AS cat_title, d.title AS device_title, d.sef_url FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id WHERE 1 ".$filter_by);
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		$fp = fopen('php://output', 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

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
	}
	//setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['import'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'mobile.php');
		exit();
	} else {
		$path = str_replace(' ','_',$_FILES['file_name']['name']);
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		if($ext=="csv" || $ext=="xls" || $ext=="xlsx") {

			$filename=$_FILES['file_name']['tmp_name'];
			move_uploaded_file($filename,'../uploaded_file/'.$path);
			
			//echo '<pre>';
			
			$excel_file_path = '../uploaded_file/'.$path;
			require('../libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
			require('../libraries/spreadsheet-reader-master/SpreadsheetReader.php');
			$excel_file_data_list = new SpreadsheetReader($excel_file_path);
			foreach($excel_file_data_list as $ek=>$excel_file_data)
			{
				//print_r($excel_file_data);
				$Model_ID = $excel_file_data[0];
				$Brand = $excel_file_data[1];
				$Model_Title = $excel_file_data[2];
				$Device = $excel_file_data[3];
				$Model_Price = $excel_file_data[4];
				$Field_ID = $excel_file_data[5];
				$Field_Title = $excel_file_data[6];
				$Field_Item_ID = $excel_file_data[7];
				$Field_Item_Title = $excel_file_data[8];
				$Field_Item_Price = $excel_file_data[9];
				
				if($Model_ID>0) {
					$f_model_id = $Model_ID;
				}
				if($Field_ID>0) {
					$f_field_id = $Field_ID;
				}

				//echo $f_model_id.'::'.$f_field_id;
				//echo '<br>';
				//exit;

				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($Model_Title!="") {
						//echo "<br>INSERT INTO mobile(title, price) VALUES('".$Model_Title."','".$Model_Price."'";echo '<br><br>';
						$qr=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$Model_ID."'");
						$exist_mobile_data=mysqli_fetch_assoc($qr);
						if(empty($exist_mobile_data)) {
							$query = mysqli_query($db,"INSERT INTO mobile(title, price) VALUES('".$Model_Title."','".$Model_Price."')");
							$f_model_id = mysqli_insert_id($db);
						} else {
							$query = mysqli_query($db,"UPDATE mobile SET title='".$Model_Title."', price='".$Model_Price."' WHERE id='".$Model_ID."'");
						}
					}

					if($Field_Title!="") {
						$q_pf=mysqli_query($db,"SELECT * FROM product_fields WHERE id='".$Field_ID."' AND product_id='".$f_model_id."'");
						$exist_product_fields_data=mysqli_fetch_assoc($q_pf);
						if(empty($exist_product_fields_data)) {
							mysqli_query($db,"INSERT INTO product_fields(product_id,title) VALUES('".$f_model_id."','".$Field_Title."')");
							$f_field_id = mysqli_insert_id($db);
						} else {
							mysqli_query($db,"UPDATE product_fields SET title='".$Field_Title."' WHERE id='".$Field_ID."'");
						}
					}

					if($Field_Item_Title!="") {
						$q_pf=mysqli_query($db,"SELECT * FROM product_options WHERE id='".$Field_Item_ID."' AND product_field_id='".$f_field_id."'");
						$exist_product_options_data=mysqli_fetch_assoc($q_pf);
						if(empty($exist_product_options_data)) {
							mysqli_query($db,"INSERT INTO product_options(product_field_id,label,price) VALUES('".$f_field_id."','".$Field_Item_Title."','".$Field_Item_Price."')");
						} else {
							mysqli_query($db,"UPDATE product_options SET label='".$Field_Item_Title."',price='".$Field_Item_Price."' WHERE id='".$Field_Item_ID."'");
						}
					}
				}

				/*$id = $excel_file_data[0];
				$icon = $excel_file_data[1];
				$title = $excel_file_data[2];
				$base_price = $excel_file_data[3];
				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($title!="") {
						$qr=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$id."'");
						$exist_mobile_data=mysqli_fetch_assoc($qr);
						if(empty($exist_mobile_data)) {
							$query = mysqli_query($db,"INSERT INTO mobile(model_img, title, price) VALUES('".$icon."','".$title."','".$base_price."')");
						} else {
							$query = mysqli_query($db,"UPDATE mobile SET model_img='".$icon."', title='".$title."', price='".$base_price."' WHERE id='".$id."'");
						}
					}
				}*/
			}
			//exit;

			if($query == '1') {
				unlink($excel_file_path);
				$msg="Data(s) successfully imported.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong imported failed.';
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['error_msg']=$msg;
		}
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['import_meta'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'mobile.php');
		exit();
	} else {
		$path = str_replace(' ','_',$_FILES['file_name']['name']);
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		if($ext=="csv" || $ext=="xls" || $ext=="xlsx") {

			$filename=$_FILES['file_name']['tmp_name'];
			move_uploaded_file($filename,'../uploaded_file/'.$path);
			
			$data_imported = false;
			$excel_file_path = '../uploaded_file/'.$path;
			require('../libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
			require('../libraries/spreadsheet-reader-master/SpreadsheetReader.php');
			$excel_file_data_list = new SpreadsheetReader($excel_file_path);
			foreach($excel_file_data_list as $ek=>$excel_file_data)
			{
				$Model_ID = $excel_file_data[0];
				$Title = real_escape_string($excel_file_data[1]);
				$Sef_Url = real_escape_string($excel_file_data[2]);
				$Meta_Title = real_escape_string($excel_file_data[3]);
				$Meta_Keywords = real_escape_string($excel_file_data[4]);
				$Meta_Description = real_escape_string($excel_file_data[5]);
				$Meta_Canonical_URL = $excel_file_data[6];

				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($Title!="") {
						$qr=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$Model_ID."'");
						$exist_mobile_data=mysqli_fetch_assoc($qr);
						if(empty($exist_mobile_data)) {
							mysqli_query($db,"INSERT INTO mobile(title, sef_url, meta_title, meta_desc, meta_keywords, meta_canonical_url) VALUES('".$Title."','".$Sef_Url."','".$Meta_Title."','".$Meta_Description."','".$Meta_Keywords."','".$Meta_Canonical_URL."')");
							//$f_model_id = mysqli_insert_id($db);
							$data_imported = true;
						} else {
							mysqli_query($db,"UPDATE mobile SET title='".$Title."', sef_url='".$Sef_Url."', meta_title='".$Meta_Title."', meta_desc='".$Meta_Description."', meta_keywords='".$Meta_Keywords."', meta_canonical_url='".$Meta_Canonical_URL."' WHERE id='".$Model_ID."'");
							$data_imported = true;
						}
					}
				}
			}
			if($data_imported) {
				unlink($excel_file_path);
				$msg="Data(s) successfully imported.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong imported failed.';
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['error_msg']=$msg;
		}
	}
	setRedirect(ADMIN_URL.'mobile.php');
} else {
	setRedirect(ADMIN_URL.'mobile.php');
}
exit();
?>