<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$service_q=mysqli_query($db,'SELECT image FROM services WHERE id="'.$post['d_id'].'"');
	$service_data=mysqli_fetch_assoc($service_q);
	
	$query=mysqli_query($db,'DELETE FROM services WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($service_data['image']!="")
			unlink('../../images/service/'.$service_data['image']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'service.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$service_q=mysqli_query($db,'SELECT image FROM services WHERE id="'.$id_v.'"');
			$service_data=mysqli_fetch_assoc($service_q);
			if($service_data['image']!="")
				unlink('../../images/service/'.$service_data['image']);

			$query=mysqli_query($db,'DELETE FROM services WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'service.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE services SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'service.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$description=real_escape_string($post['description']);
	$published = $post['published'];

	if($_FILES['image']['name']) {
		if(!file_exists('../../images/service/'))
			mkdir('../../images/service/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/service/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/service/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_service.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_service.php');
			}
			exit();
		}
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE services SET title="'.$title.'" '.$imageupdate.', description="'.$description.'", published="'.$published.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="service has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_service.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO services(title, image, description, published) values("'.$title.'","'.$image_name.'","'.$description.'","'.$published.'")');
		if($query=="1") {
			$msg="service has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'service.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_service.php');
		}
	}
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE services SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'service.php');
} elseif($post['r_img_id']) {
	$q=mysqli_query($db,'SELECT image FROM services WHERE id="'.$post['r_img_id'].'"');
	$service_data=mysqli_fetch_assoc($q);

	$del_logo=mysqli_query($db,'UPDATE services SET image="" WHERE id='.$post['r_img_id']);
	if($service_data['image']!="")
		unlink('../../images/service/'.$service_data['image']);

	setRedirect(ADMIN_URL.'edit_service.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'service.php');
}
exit();
?>