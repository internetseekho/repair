<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

$p_type = $post['p_type'];

if(isset($post['c_id'])) {
	$qry=mysqli_query($db,"SELECT * FROM pages WHERE id='".$post['c_id']."'");
	$page_data=mysqli_fetch_assoc($qry);

	if($page_data['is_custom_url'] == '1' && $page_data['url']) {
		$page_data['url'] = $page_data['url'];
	} else {
		$page_data['url'] = $page_data['url'].'-'.date("His");
	}

	$page_data['title'] = $page_data['title'].' - Copy';
	$page_data['published'] = 0;
	$query=mysqli_query($db,"INSERT INTO `pages`(`cats_in_menu`, `brands_in_menu`, `cat_id`, `brand_id`, `devices_in_submenu`, `devices_in_menu`, `models_in_menu`, `device_id`, `url`, `is_custom_url`, `is_open_new_window`, `title`, `show_title`, `image`, `image_text`, `meta_title`, `meta_keywords`, `meta_desc`, `content`, `published`, `added_date`, `updated_date`, `type`, `slug`, `css_page_class`) VALUES ('".$page_data['cats_in_menu']."', '".$page_data['brands_in_menu']."', '".$page_data['cat_id']."', '".$page_data['brand_id']."', '".$page_data['devices_in_submenu']."', '".$page_data['devices_in_menu']."', '".$page_data['models_in_menu']."', '".$page_data['device_id']."', '".$page_data['url']."', '".$page_data['is_custom_url']."', '".$page_data['is_open_new_window']."', '".real_escape_string($page_data['title'])."', '".$page_data['show_title']."', '".$page_data['image']."', '".real_escape_string($page_data['image_text'])."', '".real_escape_string($page_data['meta_title'])."', '".real_escape_string($page_data['meta_keywords'])."', '".real_escape_string($page_data['meta_desc'])."', '".real_escape_string($page_data['content'])."', '".$page_data['published']."', '".$page_data['added_date']."', '".$page_data['updated_date']."', '".$page_data['type']."', '".$page_data['slug']."', '".$page_data['css_page_class']."')");
	if($query=="1"){
		$last_insert_id = mysqli_insert_id($db);
		$msg="Page has been successfully cloned.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type.'&id='.$last_insert_id);
} elseif(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM pages WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		$msg="Page has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'page.php?p_type='.$p_type);
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE pages SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'page.php?p_type='.$p_type);
} elseif(isset($post['add_edit'])) {
	$id = $post['id'];
	$is_custom_url=$post['is_custom_url'];
	if($is_custom_url == '1') {
		$url=real_escape_string($post['url']);
	} else {
		$url=createSlug(real_escape_string($post['url']));
	}
	$is_open_new_window=$post['is_open_new_window'];
	$css_page_class=$post['css_page_class'];

	$title=real_escape_string($post['title']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$meta_canonical_url=real_escape_string($post['meta_canonical_url']);
	$content=real_escape_string($post['description']);
	$content = str_replace("<p><br></p>","",$content);
	
	$header_section = $post['header_section'];

	$cats_in_menu='0';
	$brands_in_menu='0';
	$catsbrands_in_menu=$post['catsbrands_in_menu'];
	if($catsbrands_in_menu == "cat") {
		$cats_in_menu='1';
		$brands_in_menu='0';
		$devices_in_menu='0';
	}
	if($catsbrands_in_menu == "brand") {
		$cats_in_menu='0';
		$brands_in_menu='1';
		$devices_in_menu='0';
	}
	if($catsbrands_in_menu == "device") {
		$cats_in_menu='0';
		$brands_in_menu='0';
		$devices_in_menu='1';
	}

	if($cats_in_menu == '1' || $brands_in_menu == '1' || $devices_in_menu == '1') {
		$cat_id='0';
		$brand_id='0';
		$devices_in_submenu='0';
		$models_in_menu='0';
		$device_id = '';
	} else {
		$cat_id=$post['cat_id'];
		$brand_id=$post['brand_id'];
		$devices_in_submenu=$post['devices_in_submenu'];
		$models_in_menu=($devices_in_submenu=='1'?$post['models_in_menu']:'0');
		$device_id = implode(",",$post['device_id']);
	}
	
	if($devices_in_menu == '1') {
		$fltr_devices_in_menu = implode(",",$post['fltr_devices_in_menu']);
	} else {
		$fltr_devices_in_menu = '';
	}
	
	$show_title=$post['show_title'];
	$image_text=real_escape_string($post['image_text']);
	$published = $post['published'];
	$date = date('Y-m-d H:i:s');
	
	$type = '';
	$slug = '';
	if($post['slug']) {
		$type = 'inbuild';
		$slug = $post['slug'];
		$upt_query = ', type="'.$type.'", slug="'.$slug.'"';
	}
	
	if($post['slug']=="home") {
		$url='';
	}

	//Check Valid SEF URL
	$is_valid_sef_url_arr = check_sef_url_validation($url, $id, "pages");
	if($is_valid_sef_url_arr['valid']!=true) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($id) {
			setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type.'&id='.$id.($post['slug']?'&slug='.$post['slug']:''));
		} else {
			setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type);
		}
		exit();
	}
	
	if($_FILES['image']['name']) {
		if(!file_exists('../../images/pages/'))
			mkdir('../../images/pages/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/pages/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/pages/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type.'&id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type);
			}
			exit();
		}
	}
		
	if($id) {
		$query=mysqli_query($db,'UPDATE pages SET cat_id="'.$cat_id.'", brand_id="'.$brand_id.'", cats_in_menu="'.$cats_in_menu.'", brands_in_menu="'.$brands_in_menu.'", devices_in_submenu="'.$devices_in_submenu.'", devices_in_menu="'.$devices_in_menu.'", models_in_menu="'.$models_in_menu.'", device_id="'.$device_id.'", url="'.$url.'", is_custom_url="'.$is_custom_url.'", title="'.$title.'", show_title="'.$show_title.'", image_text="'.$image_text.'"'.$imageupdate.', meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", meta_canonical_url="'.$meta_canonical_url.'", content="'.$content.'", published="'.$published.'", is_open_new_window="'.$is_open_new_window.'", updated_date="'.$date.'", css_page_class="'.$css_page_class.'", fltr_devices_in_menu="'.$fltr_devices_in_menu.'", header_section="'.$header_section.'"'.$upt_query.' WHERE id="'.$id.'"');
		if($query=="1") {
			$msg="Page has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type.'&id='.$id.($post['slug']?'&slug='.$post['slug']:''));
	} else {
		$query=mysqli_query($db,'INSERT INTO pages(cat_id, brand_id, cats_in_menu, brands_in_menu, devices_in_submenu, devices_in_menu, models_in_menu, device_id, url, is_custom_url, title, show_title, image_text, image, meta_title, meta_desc, meta_keywords, meta_canonical_url, content, published, added_date, type, slug, is_open_new_window, css_page_class, fltr_devices_in_menu, header_section) values("'.$cat_id.'","'.$brand_id.'","'.$cats_in_menu.'","'.$brands_in_menu.'","'.$devices_in_submenu.'","'.$devices_in_menu.'","'.$models_in_menu.'","'.$device_id.'","'.$url.'","'.$is_custom_url.'","'.$title.'","'.$show_title.'","'.$image_text.'","'.$image_name.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$meta_canonical_url.'","'.$content.'","'.$published.'","'.$date.'","'.$type.'","'.$slug.'","'.$is_open_new_window.'","'.$css_page_class.'","'.$fltr_devices_in_menu.'","'.$header_section.'")');
		if($query=="1") {
			$msg="Page has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'page.php?p_type='.$p_type);
		} else {
			$msg='Sorry! something wrong save failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type);
		}
	}
} elseif($post['r_img_id']) {
	$query=mysqli_query($db,'SELECT image FROM pages WHERE id="'.$post['r_img_id'].'"');
	$page_data=mysqli_fetch_assoc($query);

	mysqli_query($db,'UPDATE pages SET image="" WHERE id='.$post['r_img_id']);
	if($page_data['image']!="")
		unlink('../../images/pages/'.$page_data['image']);

	setRedirect(ADMIN_URL.'edit_page.php?p_type='.$p_type.'&id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'page.php?p_type='.$p_type);
}
exit();
?>
