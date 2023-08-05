<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['c_id'])) {
	$qry=mysqli_query($db,"SELECT * FROM devices WHERE id='".$post['c_id']."'");
	$device_data=mysqli_fetch_assoc($qry);
	$device_data['title'] = $device_data['title'].' - Copy';
	$device_data['published'] = 0;
	$device_data['device_img'] = '';
	$sef_url = createSlug($device_data['title']);
	$device_data['sub_title'] = real_escape_string($device_data['sub_title']);
	$device_data['description'] = real_escape_string($device_data['description']);
	$device_data['long_description'] = real_escape_string($device_data['long_description']);
	
	$svd_query = mysqli_query($db,"INSERT INTO devices(`sef_url`, `meta_title`, `meta_desc`, `meta_keywords`, `title`, `price`, `device_img`, `header_img`, `sub_title`, `description`, `long_description`, `popular_device`, `published`, `ordering`) values ('".$sef_url."','".$device_data['meta_title']."','".$device_data['meta_desc']."','".$device_data['meta_keywords']."','".$device_data['title']."','".$device_data['price']."','".$device_data['device_img']."','".$device_data['header_img']."','".$device_data['sub_title']."','".$device_data['description']."','".$device_data['long_description']."','".$device_data['popular_device']."','".$device_data['published']."','".$device_data['ordering']."')");
	if($svd_query == '1') {
		$last_insert_id = mysqli_insert_id($db);
		$msg="Device has been successfully cloned.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_device.php?id='.$last_insert_id);
	exit();
} elseif(isset($post['d_id'])) {
	$device_q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$post['d_id'].'"');
	$device_data=mysqli_fetch_assoc($device_q);
	
	$query=mysqli_query($db,'DELETE FROM devices WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($device_data['device_img']!="")
			unlink('../../images/device/'.$device_data['device_img']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$device_q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$id_v.'"');
			$device_data=mysqli_fetch_assoc($device_q);
			if($device_data['device_img']!="")
				unlink('../../images/device/'.$device_data['device_img']);

			$query=mysqli_query($db,'DELETE FROM devices WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE devices SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$sub_title=real_escape_string($post['sub_title']);
	$sef_url=createSlug(real_escape_string($post['sef_url']));
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$meta_canonical_url=real_escape_string($post['meta_canonical_url']);
	$price=real_escape_string($post['price']);
	$description=real_escape_string($post['description']);
	$long_description=real_escape_string($post['long_description']);
	$missing_product_url=real_escape_string($post['missing_product_url']);
	//$brand_id = $post['brand_id'];
	$published = $post['published'];
	
	//Check Valid SEF URL
	$is_valid_sef_url_arr = check_sef_url_validation($sef_url, $post['id'], "devices");
	if($is_valid_sef_url_arr['valid']!=true) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($post['id']) {
			setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
		} else {
			setRedirect(ADMIN_URL.'edit_device.php');
		}
		exit();
	}
	
	if($_FILES['device_img']['name']) {
		if(!file_exists('../../images/device/'))
			mkdir('../../images/device/',0777);
			
		$image_ext = pathinfo($_FILES['device_img']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/device/'.$post['old_image']);
		
			$image_tmp_name=$_FILES['device_img']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', device_img="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/device/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_device.php');
			}
			exit();
		}
	}
	
	if($_FILES['header_img']['name']) {
		if(!file_exists('../../images/device/'))
			mkdir('../../images/device/',0777);
			
		$h_image_ext = pathinfo($_FILES['header_img']['name'],PATHINFO_EXTENSION);
		if($h_image_ext=="png" || $h_image_ext=="jpg" || $h_image_ext=="jpeg" || $h_image_ext=="gif") {
			if($post['old_h_image']!="")
				unlink('../../images/device/'.$post['old_h_image']);
		
			$h_image_tmp_name=$_FILES['header_img']['tmp_name'];
			$h_image_name='h_'.date('YmdHis').'.'.$h_image_ext;
			$h_image_update=', header_img="'.$h_image_name.'"';
			move_uploaded_file($h_image_tmp_name,'../../images/device/'.$h_image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_device.php');
			}
			exit();
		}
	}
	
	if($post['id']) {
		//brand_id="'.$brand_id.'", 
		$query=mysqli_query($db,'UPDATE devices SET title="'.$title.'", sub_title="'.$sub_title.'", sef_url="'.$sef_url.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", meta_canonical_url="'.$meta_canonical_url.'", price="'.$price.'" '.$imageupdate.''.$h_image_update.', description="'.$description.'", popular_device="'.$post['popular_device'].'", published="'.$published.'", long_description="'.$long_description.'", missing_product_url="'.$missing_product_url.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Device has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
	} else {
		//brand_id, 
		//"'.$brand_id.'", 
		$query=mysqli_query($db,'INSERT INTO devices(title, sub_title, sef_url, meta_title, meta_desc, meta_keywords, meta_canonical_url, price, device_img, header_img, description, popular_device, published, long_description, missing_product_url) values("'.$title.'","'.$sub_title.'","'.$sef_url.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$meta_canonical_url.'","'.$price.'","'.$image_name.'","'.$h_image_name.'","'.$description.'","'.$post['popular_device'].'","'.$published.'","'.$long_description.'","'.$missing_product_url.'")');
		if($query=="1") {
			$msg="Device has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'device.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_device.php');
		}
	}
} elseif($post['r_img_id']) {
	$get_behand_data=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$post['r_img_id'].'"');
	$device_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE devices SET device_img="" WHERE id='.$post['r_img_id']);
	if($device_data['device_img']!="")
		unlink('../../images/device/'.$device_data['device_img']);

	setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
} elseif($post['r_h_img_id']) {
	$get_behand_data=mysqli_query($db,'SELECT header_img FROM devices WHERE id="'.$post['r_h_img_id'].'"');
	$device_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE devices SET header_img="" WHERE id='.$post['r_h_img_id']);
	if($device_data['header_img']!="")
		unlink('../../images/device/'.$device_data['header_img']);

	setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE devices SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} else {
	setRedirect(ADMIN_URL.'device.php');
}
exit();
?>