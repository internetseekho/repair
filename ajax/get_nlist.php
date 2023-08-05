<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$method=$post['m'];
if($method=="") {
	echo '<strong>No Data Found</strong>';
} else {
	if($method=="brand_list"){

		$device_category_id = $post['device_category_id'];
		if($device_category_id!='' && $device_category_id>0) {
			
			$sql_whr = " AND m.cat_id='".$device_category_id."' AND m.brand_id>0";
			$que="SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title, b.image AS brand_image, b.description AS brand_desc, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ".$sql_whr." GROUP BY b.id ORDER BY b.ordering ASC";
			$brand_query=mysqli_query($db,$que);
			$brand_num_of_rows = mysqli_num_rows($brand_query);
			if($brand_num_of_rows>0) {
					echo '<ul class="clearfix">';
					while($brand_data=mysqli_fetch_assoc($brand_query)) {
						$num_query=mysqli_query($db,"SELECT d.id FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.cat_id='".$device_category_id."' AND m.brand_id='".$brand_data['brand_id']."' AND b.id='".$brand_data['brand_id']."' GROUP BY m.device_id ORDER BY d.ordering ASC");
						$num_of_devices = mysqli_num_rows($num_query);
						
					 ?>
						<li class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="brand_id custom-control-input" name="brand_id" id="brand_id_<?=$brand_data['brand_id']?>" value="<?=$brand_data['brand_id']?>" data-value="<?=$brand_data['brand_title']?>" data-device_list="<?=$num_of_devices?>">
							<label for="brand_id_<?=$brand_data['brand_id']?>" class="custom-control-label">
								<div class="imgbox">
								<?php
								if($brand_data['brand_image']) {
									//$md_img_path = SITE_URL.'libraries/phpthumb.php?src='.SITE_URL.'images/brand/'.$brand_data['brand_image'].'&h=100';
									$md_img_path = SITE_URL.'images/brand/'.$brand_data['brand_image'];
									echo '<img src="'.$md_img_path.'" alt="'.$brand_data['brand_title'].'">';
								} ?>
								</div>
								<div class="btnbox"><?=$brand_data['brand_title']?></div>
							</label>
							
						</li>								
					<?php
					}
					echo '</ul>';
			}
			else {
				echo '<strong>Sorry! Brand not exist for this category</strong>';
			}
		}
	}
	else if($method=="device_list"){

		$brand_id = $post['brand_id'];
		$device_category_id = $post['device_category_id'];
		if($brand_id!='' && $brand_id>0) {
			
			$que="SELECT d.* FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.cat_id='".$device_category_id."' AND m.brand_id='".$brand_id."' AND b.id='".$brand_id."' GROUP BY m.device_id ORDER BY d.ordering ASC";
			$device_query=mysqli_query($db,$que);
			$device_num_of_rows = mysqli_num_rows($device_query);
			if($device_num_of_rows>0) {
					echo '<ul class="clearfix">';
					while($device_data=mysqli_fetch_assoc($device_query)) {
						
						/*echo '<pre>';
						print_r($device_data);
						echo '</pre>';*/
						
					 ?>
						<li class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="device_id custom-control-input" name="device_id" id="device_id_<?=$device_data['id']?>" value="<?=$device_data['id']?>" data-value="<?=$device_data['title']?>">
							<label for="device_id_<?=$device_data['id']?>" class="custom-control-label">
								<div class="imgbox">
								<?php
								if($device_data['device_img']) {
									//$md_img_path = SITE_URL.'libraries/phpthumb.php?src='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=100';
									$md_img_path = SITE_URL.'images/device/'.$device_data['device_img'];
									echo '<img src="'.$md_img_path.'" alt="'.$device_data['title'].'">';
								} ?>
								</div>
								<div class="btnbox"><?=$device_data['title']?></div>

							</label>
							
						</li>								
					<?php
					}
					echo '</ul>';
			}
			else {
				echo '<strong>Sorry! Devices not exist for this brand</strong>';
			}
		}
	}
	else if($method=="model_list"){
		
		$device_id = $post['device_id'];
		$brand_id = $post['brand_id'];
		$device_category_id = $post['device_category_id'];
		if($brand_id!='') {
			
			
			$mysql_p = "";
			if($device_category_id>0) {
				$mysql_p .= " AND m.cat_id='".$device_category_id."'";
			}
			
			if($device_id>0) {
				$mysql_p .= " AND m.device_id='".$device_id."'";
			}
			
			$q="SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND b.id='".$brand_id."' ".$mysql_p." ORDER BY m.ordering ASC";
			$query=mysqli_query($db,$q);
			
			$model_num_of_rows = mysqli_num_rows($query);
			if($model_num_of_rows>0) {?>
					<ul class="clearfix">
						<?php
						while($model_list=mysqli_fetch_assoc($query)) {
							/*echo '<pre>';
							print_r($model_list);
							echo '</pre>';*/
							
							$md_img_path="";
							if($model_list['model_img']!='') {
								$md_img_path = SITE_URL.'images/mobile/'.trim($model_list['model_img']);
							}
							
						?>
							<li class="custom-control custom-radio custom-control-inline">
								<input type="radio" class="device_model_id custom-control-input" name="model_id" id="model_id_<?=$model_list['id']?>" value="<?=$model_list['id']?>" data-value="<?=$model_list['title']?>" data-model_image="<?=$md_img_path?>">
								<label class="custom-control-label" for="model_id_<?=$model_list['id']?>">
									<div class="imgbox">
									<?php
									if($md_img_path!='') {
										echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'" width="100px" height="100px">';
									} ?>
									</div>
									<div class="btnbox"><?=$model_list['title']?></div>
								</label>
							</li>
						<?php
						} ?>
					</ul>
			<?php }
			else {
				echo '<strong>Sorry! Model not exist for this brand</strong>';
			}
		}
	}
	
	else if($method=="get_model_field_list"){
		$model_id=$post['model_id'];
		$query = "SELECT m.*, d.title AS device_title, d.sef_url FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id WHERE m.id='".$model_id."'";
		$stmt=$db->query($query);
		$data=$stmt->fetch_object();
		
		$main_img_path=SITE_URL."images/";
		$img_path=$main_img_path."mobile/";

		if($data->model_img!=''){
			$data->image=$img_path.$data->model_img;
		}
		
		$price = $data->price;
		$total_price = $data->price;
		
		//now get product fields related
		$query = "SELECT * FROM product_fields WHERE product_id = '".$model_id."' ORDER BY sort_order";
		$stmt=$db->query($query);
		$fields_list_data=array();
		while($field_data=$stmt->fetch_object()) {
			$input_type=$field_data->input_type;
			$title=$field_data->title;
			$product_field_id=$field_data->id;
			if($field_data->icon!=''){
				$field_data->icon=$main_img_path.$field_data->icon;
			}
			
			//now get field options related
			
			$selected_checkbox_values=array();
			
			$selected_radio_dropdown_value="";
			$po_query = "SELECT * FROM product_options WHERE product_field_id = '".$product_field_id."'";
			$po_stmt=$db->query($po_query);
			$product_options_list=array();
			while($product_options_data=$po_stmt->fetch_object()) {
				if($product_options_data->icon!=''){
					$product_options_data->icon=$main_img_path.$product_options_data->icon;
				}
				
				$checked=false;
				
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = '1';
				if($product_options_data->is_default==1) {
					$total_price = updatePrice_for_model_fields($product_options_data->price,$product_options_data->add_sub,$product_options_data->price_type,$total_price,$price);
					$checked=true;
					if($input_type=='checkbox'){
						$selected_checkbox_values[]=$product_options_data->id;
					}else{
						$selected_radio_dropdown_value=$product_options_data->id;
					}
				}
				
				if($product_options_data->tooltip && $tooltips_of_model_fields == '1') {
					$product_options_data->tooltip = strip_tags($product_options_data->tooltip);
				} else {
					$product_options_data->tooltip = "";
				}
				
				$product_options_data->checked=$checked;
				$product_options_list[] = $product_options_data;
			}
			//END
			
			$field_data->selected_radio_dropdown_value=$selected_radio_dropdown_value;
			$field_data->selected_checkbox_values=$selected_checkbox_values;
			$field_data->product_options_list=$product_options_list;
			
			//add _ to space for title 
			$field_name=str_replace(' ','_',$title);
			$field_data->field_name=$field_name;
			
			$fields_list_data[] = $field_data;
		}
		
		$data->fields_list_data=$fields_list_data;
		$data->total_price=$total_price;
		
		/*echo '<pre>';
		print_r($data);
		print_r($fields_list_data);
		exit;*/
		//END

		$response["data"] = $data;
		$response["error"] = false;
		$response['status'] = 'success';
		echoResponse(200, $response);
	}
	
	else{
		die('Invalid request');
	}
} 

function echoResponse($status_code='',$response='') {
	header('Content-Type: application/json');
    echo json_encode($response);
	http_response_code($status_code);
	exit();
}

function updatePrice_for_model_fields($thisprice='',$add_sub='',$price_type='',$total_price='',$price='') {
	if($price_type==0) {
		$temp_price = ($price*$thisprice)/100;
	} else {
		$temp_price = $thisprice;
	}
	
	if($add_sub=="+") {
		$total_price = $total_price + $temp_price;
	} else {
		$total_price = $total_price - $temp_price;
	}
	return $total_price;
}

?>