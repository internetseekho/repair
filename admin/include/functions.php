<?php
function unique_id() {
	return date("YmdHis").uniqid();
}

//Create slug for sef url
function createSlug($str)
{
    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );
    return $str;
}

function generateFormToken($form) {
	$token = md5(uniqid(microtime(),true)).md5(rand(00000,11111));

	$csrf_token_array = (isset($_SESSION[$form.'_csrf_token'])?$_SESSION[$form.'_csrf_token']:'');
	if(empty($csrf_token_array))
		$csrf_token_array = array();

	array_push($csrf_token_array,$token);
	$_SESSION[$form.'_csrf_token'] = $csrf_token_array;
	return $token;
}

function verifyFormToken($form) {
	$csrf_token_array = $_SESSION[$form.'_csrf_token'];

	if(empty($csrf_token_array)) { 
		return false;
    }

	if(!isset($_POST['csrf_token'])) {
		return false;
    }

	if(!in_array($_POST['csrf_token'],$csrf_token_array)) {
		return false;
    }
	
	if(($key = array_search($_POST['csrf_token'], $csrf_token_array)) !== false) {
		unset($csrf_token_array[$key]);
	}
	$_SESSION[$form.'_csrf_token'] = $csrf_token_array;
	
	return true;
}

function writeHackLog($form) {
	$host = gethostbyaddr(USER_IP);
	$date = date("d M Y");

	$logging = 'There was a hacking attempt on your '.$form.' form, Date of Attack: '.$date.', IP-Adress: '.USER_IP.', Host of Attacker: '.$host;
	if($handle = fopen(CP_ROOT_PATH.'/hacklog.log', 'a')) {
		fputs($handle, $logging);
		fclose($handle);
	}
}

//Parse sef url/path
function parse_path() {
	$path = array();
	if(isset($_SERVER['REQUEST_URI'])) {
	  $request_path = explode('?', $_SERVER['REQUEST_URI']);
  
	  $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
	  $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
	  $path['call'] = mb_convert_encoding($path['call_utf8'], 'ISO-8859-1', 'UTF-8');

	//   $path['call'] = utf8_decode($path['call_utf8']);
	  if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
		$path['call'] = '';
	  }
	  $path['call_parts'] = explode('/', $path['call']);
  
	  $path['query_utf8'] = isset($request_path[1]) ? urldecode($request_path[1]) : '';
	//   mb_convert_encoding(urldecode($request_path[1]), 'ISO-8859-1', 'UTF-8');
	  $path['query'] = isset($request_path[1]) ? mb_convert_encoding(urldecode($request_path[1]), 'ISO-8859-1', 'UTF-8') : '';
	  $vars = explode('&', $path['query']);
	  foreach($vars as $var) {
		$t = explode('=', $var);
		$path['query_vars'][$t[0]] = isset($t[1]) ? $t[1] : '';
	  }
	}
  return $path;
  }
// function parse_path() {
// 	$path = array();
// 	if(isset($_SERVER['REQUEST_URI'])) {
// 	  $request_path = explode('?', $_SERVER['REQUEST_URI']);
  
// 	  $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
// 	  $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
// 	  $path['call'] = utf8_decode($path['call_utf8']);
// 	  if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
// 		$path['call'] = '';
// 	  }
// 	  $path['call_parts'] = explode('/', $path['call']);
  
// 	  $path['query_utf8'] = isset($request_path[1]) ? urldecode($request_path[1]) : '';
// 	  $path['query'] = isset($request_path[1]) ? utf8_decode(urldecode($request_path[1])) : '';
// 	  $vars = explode('&', $path['query']);
// 	  foreach($vars as $var) {
// 		$t = explode('=', $var);
// 		$path['query_vars'][$t[0]] = isset($t[1]) ? $t[1] : '';
// 	  }
// 	}
//   return $path;
//   }
  
//Get email template data based on template type
function get_template_data($template_type) {
	global $db;
	$templatedata_query=mysqli_query($db,"SELECT * FROM mail_templates WHERE type='".$template_type."' AND status='1'");
	return mysqli_fetch_assoc($templatedata_query);
}

//Get general settings
function get_general_setting_data() {
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	return mysqli_fetch_assoc($gs_query);
}

//Get admin user data
function get_admin_user_data() {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM admin WHERE type='super_admin' ORDER BY id DESC");
	return mysqli_fetch_assoc($query);
}

function get_admin_staff_user_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM admin ORDER BY id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($user_data=mysqli_fetch_assoc($query)) {
			$response[] = $user_data;
		}
	}
	return $response;
}

//Get user data based on userID
function get_user_data($user_id, $email = "") {
	global $db;
	
	$mysql_q = "";
	if($email!="") {
		$mysql_q .= " OR u.email='".$email."'";
	}
	
	$u_query=mysqli_query($db,"SELECT u.* FROM users AS u WHERE u.id='".$user_id."'".$mysql_q."");
	return mysqli_fetch_assoc($u_query);
}

//Get user data based on userID
function get_contractor_data($contractor_id) {
	global $db;
	$c_query=mysqli_query($db,"SELECT c.* FROM contractors AS c WHERE c.id='".$contractor_id."'");
	return mysqli_fetch_assoc($c_query);
}

//Get order data based on orderID
function get_order_data($order_id) {
	global $db;
	$u_query=mysqli_query($db,"SELECT u.*, o.*, o.date AS order_date, o.status AS order_status FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id WHERE o.order_id='".$order_id."'");
	return mysqli_fetch_assoc($u_query);
}

function get_appt_data($appt_id, $email = "") {
	global $db;

	$mysql_q = "";
	if($email!="") {
		$mysql_q .= " OR a.email='".$email."'";
	}

	$u_query=mysqli_query($db,"SELECT a.*, aps.name AS appt_status_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status WHERE a.appt_id='".$appt_id."'".$mysql_q."");
	return mysqli_fetch_assoc($u_query);
}

function get_payment_history_data($appt_id) {
	global $db;

	$resp = array();
	$list = array();
	$q=mysqli_query($db,"SELECT * FROM payment_history WHERE appt_id='".$appt_id."'");
	while($data = mysqli_fetch_assoc($q)) {
		$list[] = $data;
	}
	$resp['list'] = $list;
	return $resp;
}

//Get order price based on orderID
function get_order_price($order_id) {
	global $db;
	$query=mysqli_query($db,"SELECT SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$data=mysqli_fetch_assoc($query);
	return $data['sum_of_orders'];
}

//Get contractor list
function get_contractor_list() {
	global $db;
	$response_array = array();
	$c_query=mysqli_query($db,"SELECT c.* FROM contractors AS c ORDER BY c.id ASC");
	$num_of_rows = mysqli_num_rows($c_query);
	if($num_of_rows>0) {
		while($contractor_data=mysqli_fetch_assoc($c_query)) {
			$response_array[] = $contractor_data;
		}
	}
	return $response_array;
}

//Get order item list data based on orderID
function get_order_item_list($order_id) {
	global $db;
	$response_array = array();
	$query=mysqli_query($db,"SELECT oi.*, o.`date`, o.`status`, d.title AS device_title, m.title AS model_title, m.model_img FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oi.order_id='".$order_id."' ORDER BY oi.id DESC");
	/*AND o.status='partial'*/
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($order_item_data=mysqli_fetch_assoc($query)) {
			$response_array[] = $order_item_data;
		}
	}
	return $response_array;
}

//Get order item device type, condition based on item id
function get_order_item($item_id, $type) {
	global $db;
	$order_query=mysqli_query($db,"SELECT oi.*, o.`date`, o.`status`, d.title AS device_title, m.title AS model_title, m.models FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oi.id='".$item_id."'");
	$data = mysqli_fetch_assoc($order_query);
	
	$items_name = "";
	$item_name_array = json_decode($data['item_name'],true);
	if(!empty($item_name_array)) {
		foreach($item_name_array as $item_name_data) {
			$items_name .= '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).':</strong> ';
			$items_opt_name = "";
			foreach($item_name_data['opt_data'] as $opt_data) {
				$items_opt_name .= $opt_data['opt_name'].', ';
			}
			$items_name .= rtrim($items_opt_name,', ');
			$items_name .= '<br>';		
		}
	}

	$response_array = array();
	if($data['item_name']) {
		$models_text = $data['models'];
		$models_text = ($models_text?" - ".$models_text:"");

		if($type == "general") {
			//$response_array['device_type'] = $data['model_title'].$models_text.'<br>'.str_replace("::","<br>",$data['item_name']);
			$response_array['device_type'] = str_replace("::","<br>",$data['item_name']);
		} elseif($type == "list") {
			$response_array['device_type'] = $items_name; //str_replace("::","<br>",$data['item_name']);
		} elseif($type == "email") {
			$response_array['device_type'] = str_replace("::","<br>",$data['item_name']);
		} elseif($type == "print") {
			$response_array['device_type'] = str_replace("::","<br>",$data['item_name']);
		}
	}
	$response_array['data'] = $data;
	return $response_array;
}

//Send email as SMTP or PHP mail based on admin email settings
function send_email($to,$subject,$message,$from_name,$from_email,$attachment_data = array()) {
	global $db;
	$get_gsdata=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_detail=mysqli_fetch_assoc($get_gsdata);
	$mailer_type = $general_setting_detail['mailer_type'];
	$smtp_host = $general_setting_detail['smtp_host'];
	$smtp_port = $general_setting_detail['smtp_port'];
	$smtp_security = $general_setting_detail['smtp_security'];
	$smtp_auth = $general_setting_detail['smtp_auth'];
	$smtp_username = $general_setting_detail['smtp_username'];
	$smtp_password = $general_setting_detail['smtp_password'];
	$email_api_key = $general_setting_detail['email_api_key'];
	//$email_api_username = $general_setting_detail['email_api_username'];
	//$email_api_password = $general_setting_detail['email_api_password'];

	if($mailer_type == "sendgrid" && $email_api_key) {
		$from = new SendGrid\Email($from_name, $from_email);
		$subject = $subject;
		$to = new SendGrid\Email($subject, $to);
		
		//Send message as text
		//$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");

		//Send message as html
		$content = new SendGrid\Content("text/html", $message);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		
		if($attachment_data['basename']!="") {
			//$file_info = getimagesize(SITE_URL.$attachment_data['folder'].'/'.$attachment_data['basename']);
			//$mimeType   = $file_info['mime'];
			$file_mime_type = mime_content_type(CP_ROOT_PATH.'/'.$attachment_data['folder'].'/'.$attachment_data['basename']);

			$att1 = new SendGrid\Attachment();
			$att1->setContent(base64_encode(file_get_contents(CP_ROOT_PATH.'/'.$attachment_data['folder'].'/'.$attachment_data['basename'])));
			$att1->setType($file_mime_type);
			$att1->setFilename($attachment_data['basename']);
			$att1->setDisposition("attachment");
			$mail->addAttachment( $att1 );
		}
		
		$apiKey = $email_api_key;
		$sg = new \SendGrid($apiKey);

		$response = $sg->client->mail()->send()->post($mail);
		return '1';
	} elseif($mailer_type == "smtp" && $smtp_host && $smtp_port) {
		$mail = new PHPMailer();

		$mail->Timeout = 30;
		$mail->Host = $smtp_host;
		$mail->Port = ($smtp_port==""?"25":$smtp_port);
		if($smtp_username && $smtp_password) {
			$mail->IsSMTP(); 
			//$mail->SMTPDebug  = 2;
			$mail->SMTPAuth = true;
			$mail->Username = $smtp_username;
			$mail->Password = $smtp_password;
			if($smtp_security=="ssl") {
				$mail->SMTPSecure = 'tls';
			}
			//$mail->From = $smtp_username;
		}

		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to);
		$mail->AddReplyTo($from_email, $from_name);

		//$mail->WordWrap = 50;
		if($attachment_data['basename']!="") {
			$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'].'/'.$attachment_data['basename'], $attachment_data['basename']);
		}
		
		$mail->IsHTML(true);
		
		$mail->Subject = $subject;
		$mail->Body    = $message;

		//error_log('SMTP method based send email...');
		
		if(!$mail->Send()) {
			error_log("SMTP Mailer Error:".$mail->ErrorInfo);
			return '0';
		} else {
			return '1';
		}
	} else {
		if($attachment_data['basename']!="" && $attachment_data['folder']!="") {
			$filename = $attachment_data['basename'];
			$path = CP_ROOT_PATH.'/'.$attachment_data['folder'].'/';

			// array with filenames to be sent as attachment
			$file_path = $path.$filename;

			$headers = "From: $from_email";

			// boundary 
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
			
			// headers for attachment
			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
			
			// multipart boundary 
			$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
			$message .= "--{$mime_boundary}\n";

			// Preparing attachement
			$file = fopen($file_path,"rb");
			$data = fread($file,filesize($file_path));
			fclose($file);
			$data = chunk_split(base64_encode($data));
			$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$filename\"\n" . 
			"Content-Disposition: attachment;\n" . " filename=\"$filename\"\n" . 
			"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			$message .= "--{$mime_boundary}\n";
		} else {
			$headers  = 'MIME-Version: 1.0'."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
			$headers .= "From:".$from_name." <".$from_email.">\r\n";
		}
		
		if(mail($to,$subject,$message,$headers)) {
			return '1';
		} else {
			return '0';
		}
	}
}

//Get amount format, its prefix of amount or postfix of amount
function amount_fomat($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);

	$currency = @explode(",",$general_setting_data['currency']);
	$is_space_between_currency_symbol = $general_setting_data['is_space_between_currency_symbol'];
	$thousand_separator = $general_setting_data['thousand_separator'];
	$decimal_separator = $general_setting_data['decimal_separator'];
	$decimal_number = $general_setting_data['decimal_number'];
	
	$amount = ($amount>0?$amount:0);
	
	$symbol_space = "";
	if($is_space_between_currency_symbol == '1') {
		$symbol_space = " ";
	} else {
		$symbol_space = "";
	}

	if($general_setting_data['disp_currency']=="prefix") {
		//return $currency[1].number_format($amount, 2, '.', '');
		return $currency[1].$symbol_space.number_format($amount, $decimal_number, $decimal_separator, $thousand_separator);
	} elseif($general_setting_data['disp_currency']=="postfix") {
		//return number_format($amount, 2, '.', '').$currency[1];
		return number_format($amount, $decimal_number, $decimal_separator, $thousand_separator).$symbol_space.$currency[1];
	}
}

function amount_format_without_sign($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT thousand_separator, decimal_separator, decimal_number FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);

	$thousand_separator = $general_setting_data['thousand_separator'];
	$decimal_separator = $general_setting_data['decimal_separator'];
	$decimal_number = $general_setting_data['decimal_number'];

	$amount = ($amount>0?$amount:0);
	return number_format($amount, $decimal_number, $decimal_separator, $thousand_separator);
}

//Escape string of mysql query
function real_escape_string($data) {
	global $db;
	return mysqli_real_escape_string($db,trim($data));
}

//Set redirect without message
function setRedirect($url) {
	header("HTTP/1.1 301 Moved Permanently");
	header('Location:'.$url);
	return true;
}

//Set redirect with message, show message based on type (success, info, warning, danger)
function setRedirectWithMsg($url,$msg,$type) {
	header("HTTP/1.1 301 Moved Permanently");
	$_SESSION['msg'] = array('msg'=>$msg,'type'=>$type);
	header('Location:'.$url);
	return true;
}

//For show confirmations message
function getConfirmMessage() {
	//success, info, warning, danger
	$msg = (isset($_SESSION['msg'])?$_SESSION['msg']:'');
	if(empty($msg)) {
		$msg = array('msg'=>'','type'=>'');
	}

	$resp = array();
	$resp_msg = '';
	if($msg['type']) {
		$type = $msg['type'];
		if($type == "error") {
			$type = "danger";
		}
		
		$icons_text = '';
		if($type == "success") {
			$icons_text = '<i class="icon-gift"></i><strong>Well done!</strong>';
		} elseif($type == "info") {
			$icons_text = '<i class="icon-hand-up"></i><strong>Heads up!</strong>';
		} elseif($type == "warning") {
			$icons_text = '<i class="icon-warning-sign"></i><strong>Warning!</strong>';
		} elseif($type == "danger") {
			$icons_text = '<i class="icon-remove-sign"></i><strong>Oh snap!</strong>';
		}
		$icons_text = '';
		$resp_msg = '<div class="alert alert-'.$type.'">';
			$resp_msg .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			$resp_msg .= $icons_text.'&nbsp;'.$msg['msg'];
		$resp_msg .= '</div>';
	}
	$resp['msg'] = $resp_msg;
	unset($_SESSION['msg']);
	return $resp;
}

//For get page list based on menu position type
function get_page_list($type) {
	global $db;
	$page_data_array = array();
	if(trim($type)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE published='1' ORDER BY ordering ASC");
		while($page_data=mysqli_fetch_assoc($query)) {
			$exp_position=(array)json_decode($page_data['position']);
			if($type==$exp_position[$type]) {
				$page_data_array[] = $page_data;
			}
		}
	}
	return $page_data_array;
}

//For get menu list based on menu position
function get_menu_list($position) {
	global $db;
	$menu_data_array = array();

	$sql_params = "";
	if(trim($position)) {
		$sql_params .= "AND m.position='".$position."'";	
	}

	$query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url, p.brand_id, p.cats_in_menu, p.brands_in_menu, p.devices_in_menu, p.models_in_menu, p.fltr_devices_in_menu FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='0' ".$sql_params." ORDER BY m.ordering ASC");
	while($page_data = mysqli_fetch_assoc($query)) {
		$page_data['submenu'] = array();
		$s_query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url, p.brand_id, p.cats_in_menu, p.brands_in_menu, p.devices_in_menu, p.models_in_menu, p.fltr_devices_in_menu FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='".$page_data['id']."' ".$sql_params." ORDER BY m.ordering ASC");
		while($s_page_data = mysqli_fetch_assoc($s_query)) {
			$page_data['submenu'][] = $s_page_data;
		}
		$menu_data_array[] = $page_data;
	}
	return $menu_data_array;
}

function get_menu_brand_data_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT b.* FROM brand AS b WHERE b.published=1 ORDER BY b.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($brand_list=mysqli_fetch_assoc($query)) {
			$response[] = $brand_list;
		}
	}
	return $response;
}

function get_menu_device_data_list($brand_id = 0, $fltr_devices_in_menu = "") {
	global $db;
	$response = array();
	//$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE d.published=1 AND d.brand_id='".$brand_id."' AND b.id='".$brand_id."' ORDER BY d.ordering ASC");
	
	$sql_params = "";
	if($brand_id>0) {
		$sql_params .= " AND m.brand_id='".$brand_id."' AND b.id='".$brand_id."'";	
	}
	if($fltr_devices_in_menu != "") {
		$sql_params .= " AND d.id IN(".$fltr_devices_in_menu.")";
	}
	
	$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 ".$sql_params." GROUP BY m.device_id ORDER BY d.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_list=mysqli_fetch_assoc($query)) {
			$response[] = $device_list;
		}
	}
	return $response;
}

function get_menu_model_data_list($device_id) {
	global $db;
	$response = array();

	$sql_whr = "";
	$sql_whr = "AND m.device_id='".$device_id."'";

	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ".$sql_whr." ORDER BY m.released_year_month DESC, m.ordering ASC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

function get_menu_cats_data_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT c.* FROM categories AS c WHERE c.published=1 ORDER BY c.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($cat_list=mysqli_fetch_assoc($query)) {
			$response[] = $cat_list;
		}
	}
	return $response;
}

//For get inbuild page url
function get_inbuild_page_url($slug) {
	global $db;
	if(trim($slug)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".trim($slug)."'");
		$page_data=mysqli_fetch_assoc($query);
		return $page_data['url'];
	}
}

//For get small content based on words limit of string
function limit_words($string, $word_limit) {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

//Get basket item count & sum of order
function get_basket_item_count_sum($order_id) {
	global $db;
	$response = array();
	$order_basket_count = 0;
	$order_basket_query=mysqli_query($db,"SELECT SUM(quantity) as total_qty, SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$order_basket_data = mysqli_fetch_assoc($order_basket_query);
	$order_basket_count = intval($order_basket_data['total_qty']);
	$sum_of_orders = $order_basket_data['sum_of_orders'];
	
	$order_item_q=mysqli_query($db,"SELECT oi.*, o.status, d.title AS device_title, d.sef_url, m.title AS model_title FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE o.order_id='".$order_id."' AND o.status='partial' ORDER BY oi.id DESC");
	$order_num_of_rows = mysqli_num_rows($order_item_q);
	if($order_num_of_rows>0) {
		while($order_item_data=mysqli_fetch_assoc($order_item_q)) {
			$basket_item_data[] = $order_item_data;
		}
	}
	
	$response['basket_item_count'] = $order_basket_count;
	$response['basket_item_sum'] = $sum_of_orders;
	$response['basket_item_data'] = $basket_item_data;
	return $response;
}

//Get popular device data, it will show only 3 popular device
function get_popular_device_data() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND popular_device=1 LIMIT 3");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get device data list
function get_device_data_list($fltr_devices_in_menu = "", $display_popular_devices_only = 0) {
	global $db;
	
	$sql_params = "";
	if($fltr_devices_in_menu != "") {
		$sql_params .= " AND d.id IN(".$fltr_devices_in_menu.")";
	}
	if($display_popular_devices_only == '1') {
		$sql_params .= " AND d.popular_device='1'";
	}
	
	$response = array();
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.published=1 ".$sql_params." ORDER BY d.ordering");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get top seller data list
function get_top_seller_data_list($top_seller_limit) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT m.*, m.sef_url AS model_sef_url, m.title AS model_title, d.title AS device_title, d.sef_url AS device_sef_url, d.device_img, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.top_seller='1' LIMIT ".$top_seller_limit."");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get popular device data, it will show only 3 popular device
function get_brand_data() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM brand WHERE published=1");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

function get_single_brand_data($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM brand WHERE published=1 AND id='".$id."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$device_data=mysqli_fetch_assoc($query);
		$response = $device_data;
	}
	return $response;
}

//For all searchbox related autocomplete data
function autocomplete_data_search() {
	global $db;
	$response = array();
	$list_of_model = '';
	$top_search_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ORDER BY m.ordering ASC");
	while($top_search_data=mysqli_fetch_assoc($top_search_query)) {
		if($top_search_data['brand_title']) {
			$quote_mk_list[$top_search_data['brand_id']] = $top_search_data['brand_title'];
		}
		
		$name = $top_search_data['brand_title'].' '.$top_search_data['title'];
		$url = SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'];
		$list_of_model .= "{value:'".$name."', url:'".$url."'},";
		
		/*$ts_storage_list = json_decode($top_search_data['storage']);
		foreach($ts_storage_list as $ts_storage) {
			$quote_mk_list[$top_search_data['brand_id']] = $top_search_data['brand_title'];
					
			$name = $top_search_data['brand_title'].' '.$top_search_data['title'].' '.$ts_storage->storage_size;
			$url = SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'].'/'.$ts_storage->storage_size;
			$list_of_model .= "{value:'".$name."', url:'".$url."'},";
		}*/
	}
	$response['list_of_model'] = $list_of_model;
	$response['quote_mk_list'] = $quote_mk_list;
	return $response;
}

function get_brand_single_data_by_sef_url($sef_url) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT b.* FROM brand AS b WHERE b.sef_url='".$sef_url."' AND b.published=1");
	$num_of_brand = mysqli_num_rows($query);
	$brand_single_data=mysqli_fetch_assoc($query);
	$response['num_of_brand'] = $num_of_brand;
	$response['brand_single_data'] = $brand_single_data;
	return $response;
}

//Check if mobile menu & get data of single device based on url
function get_device_single_data($sef_url) {
	global $db;
	$response = array();
	$query = mysqli_query($db,"SELECT d.id AS device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.meta_canonical_url AS d_meta_canonical_url, d.sef_url, d.title AS device_title, d.sub_title AS device_sub_title, d.description, d.long_description, d.missing_product_url, d.device_img, d.header_img AS device_header_img FROM devices AS d WHERE d.sef_url='".$sef_url."' AND d.published=1");
	$num_of_device = mysqli_num_rows($query);
	$device_single_data = mysqli_fetch_assoc($query);
	$response['num_of_device'] = $num_of_device;
	$response['is_mobile_menu'] = $num_of_device;
	$response['device_single_data'] = $device_single_data;
	return $response;
}

function get_device_single_data_by_id($id) {
	global $db;
	$query = mysqli_query($db,"SELECT d.id AS device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.meta_canonical_url AS d_meta_canonical_url, d.sef_url, d.title AS device_title, d.sub_title AS device_sub_title, d.description, d.long_description, d.missing_product_url, d.device_img, d.header_img AS device_header_img FROM devices AS d WHERE d.id='".$id."' AND d.published=1");
	$device_single_data = mysqli_fetch_assoc($query);
	return $device_single_data;
}

function get_mobile_single_data_by_url_id($sef_url,$id = 0) {
	global $db;
	$response = array();
	//$query = mysqli_query($db,"SELECT m.* FROM mobile AS m WHERE m.sef_url='".$sef_url."' AND m.id='".$id."' AND m.published=1");
	$query = mysqli_query($db,"SELECT m.* FROM mobile AS m WHERE m.sef_url='".$sef_url."' AND m.published=1");
	$num_of_model = mysqli_num_rows($query);
	$model_data = mysqli_fetch_assoc($query);
	$response['num_of_model'] = $num_of_model;
	$response['model_data'] = $model_data;
	return $response;
}

//get data of single device based on id
function get_device_single_data_based_on_id($id) {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM devices WHERE id='".$id."'");
	$device_single_data=mysqli_fetch_assoc($query);
	return $device_single_data;
}

//save default status of order when we place order with choose option (print, free)
function save_default_status_when_place_order($args) {
	global $db;
	
	if($args['sales_pack']=="print") {
		$q_params_for_prnt_order = ", approved_date='".$args['approved_date']."', expire_date='".$args['expire_date']."'";
	}
	if($args['order_id'] && $args['status']) {
		$query = mysqli_query($db,"UPDATE `orders` SET `status`='".$args['status']."', `sales_pack`='".$args['sales_pack']."'".$q_params_for_prnt_order." WHERE order_id='".$args['order_id']."'");
	}
	return $query;
}

//Get order messaging data list based on orderID
function get_order_messaging_data_list($order_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM order_messaging WHERE order_id='".$order_id."' ORDER BY id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($order_messaging_dt=mysqli_fetch_assoc($query)) {
			$response[] = $order_messaging_dt;
		}
	}
	return $response;
}

//Get active review list
function get_review_list_data($status = 1, $limit = 0) {
	global $db;

	$sql_limit = "";
	if($limit>0) {
		$sql_limit = "LIMIT ".$limit;
	}

	$response = array();
	$query=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."' ORDER BY id DESC ".$sql_limit."");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($review_data=mysqli_fetch_assoc($query)) {
			$response[] = $review_data;
		}
	}
	return $response;
}

//Get active review list
function get_review_list_data_random($status = 1) {
	global $db;

	$review_id_array = array();
	$query1=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."'");
	$num_of_rows1 = mysqli_num_rows($query1);
	if($num_of_rows1>0) {
		while($review_data1=mysqli_fetch_assoc($query1)) {
			$review_id_array[] = $review_data1['id'];
		}
	}

	$rrk = array_rand($review_id_array);
    $random_review_id = $review_id_array[$rrk];

	$query=mysqli_query($db,"SELECT * FROM reviews WHERE id='".$random_review_id."'");
	$num_of_rows = mysqli_num_rows($query);
	$review_data=mysqli_fetch_assoc($query);
	return $review_data;
}

//Get active category list
function get_category_data_list($status = 1) {
	global $db;

	$response = array();
	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='".$status."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($cat_data=mysqli_fetch_assoc($query)) {
			$response[] = $cat_data;
		}
	}
	return $response;
}

//Get active category list
function get_location_data_list($status = 1) {
	global $db;

	$response = array();
	$query=mysqli_query($db,"SELECT * FROM locations WHERE published='".$status."' ORDER BY id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($location_data=mysqli_fetch_assoc($query)) {
			$response[] = $location_data;
		}
	}
	return $response;
}

//Get active category data
function get_category_data($id) {
	global $db;

	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='1' AND id='".$id."'");
	$review_data=mysqli_fetch_assoc($query);
	return $review_data;
}

//Get home page settings
function get_home_page_data($id = 0, $section_name = '') {
	global $db;
	if($id>0 || $section_name!="") {
		$query=mysqli_query($db,"SELECT * FROM home_settings WHERE status='1' AND (id='".$id."' OR (section_name='".$section_name."' AND section_name!=''))");
		$home_settings_data=mysqli_fetch_assoc($query);
		return $home_settings_data;
	} else {
		$response = array();
		$query=mysqli_query($db,"SELECT * FROM home_settings WHERE status='1' AND section_name!='slider' ORDER BY ordering ASC");
		$num_of_rows = mysqli_num_rows($query);
		if($num_of_rows>0) {
			while($home_settings_data=mysqli_fetch_assoc($query)) {
				$response[] = $home_settings_data;
			}
		}
		if(!$response){
			return [];
		}
		return $response;
	}
}

function lastwordstrongorspan($str, $type='strong') {
	if($type=='strong') {
		return preg_replace("@^(.*?)([^ ]+)\W?$@","$1<strong>$2</strong>",$str);
	} else {
		return preg_replace("@^(.*?)([^ ]+)\W?$@","$1<span>$2</span>",$str);
	}
}

function get_category_single_data_by_sef_url($sef_url) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT c.* FROM categories AS c WHERE c.sef_url='".$sef_url."' AND c.published=1");
	$num_of_category = mysqli_num_rows($query);
	$category_single_data=mysqli_fetch_assoc($query);
	$response['num_of_category'] = $num_of_category;
	$response['category_single_data'] = $category_single_data;
	return $response;
}

//Get model data list based on deviceID
function get_shortcode_model_data_list($device_id) {
	global $db;
	$response = array();
	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND device_id IN(".$device_id.") ORDER BY m.released_year_month DESC, m.ordering ASC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

function getLocationInfoByIp($ip) {
	$result=array();
	
	$country='';
	$city='';
	$region='';
	$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
	if($ip_data && $ip_data->geoplugin_countryName != null) {
		$country= $ip_data->geoplugin_countryName;
		$city = $ip_data->geoplugin_city;
		$region= $ip_data->geoplugin_regionName;
	}
	
	$result['country'] =$country;
	$result['city'] =$city;
	$result['region'] =$region;
		
	return $result;
}

function get_visitor_count(){
	global $db;
	$response = array();
	
	$query = "SELECT count(id) AS visitor_count FROM visitors";
	$stmt=$db->query($query);
	$visitor_data=$stmt->fetch_object();
	
	$response['count'] = $visitor_data->visitor_count;
	return $response;
}

function insert_update_visitor_data(){
	$visitor_session_id=$_SESSION['visitor_session_id'];
	$user_ip=$_SESSION['user_ip'];
	
	global $db;
	$response = array();
	
	$query = "SELECT * FROM visitors WHERE visitor_session_id='".$visitor_session_id."' ";
	$stmt=$db->query($query);
	$visitor_data=$stmt->fetch_object();
	
	$ip_data=getLocationInfoByIp($user_ip);
	
	$country=$ip_data['country'];
	$city=$ip_data['city'];
	$region=$ip_data['region'];
	$date=date('Y-m-d H:i:s');
	
	if(empty($visitor_data)) {
		$_query="INSERT INTO visitors(ip,visitor_session_id,country,city,region,date_time) values('".$db->real_escape_string($user_ip)."','".$db->real_escape_string($visitor_session_id)."','".$db->real_escape_string($country)."','".$db->real_escape_string($city)."','".$db->real_escape_string($region)."','".$date."')";
		$result = $db->query($_query);
		$insert_id=$db->insert_id;
	}else{
		$update_query = "UPDATE visitors SET ip='".$db->real_escape_string($user_ip)."',country='".$db->real_escape_string($country)."',city='".$db->real_escape_string($city)."',region='".$db->real_escape_string($region)."',date_time='".$db->real_escape_string($date)."' WHERE id='".$visitor_data->id."' ";
		$db->query($update_query);
	}
	
	return $response;	
}

function get_promocode_list($type = "") {
	global $db;
	$response = array();
	
	$sql_params = "status=1";
	if($type == "future") {
		$sql_params .= " AND (never_expire='1' OR (never_expire='0' AND to_date>='".date("Y-m-d")."'))";
	}
	
	$query=mysqli_query($db,"SELECT * FROM promocode WHERE ".$sql_params." ORDER BY to_date DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($promocode_data=mysqli_fetch_assoc($query)) {
			$response[] = $promocode_data;
		}
	}
	return $response;
}

function get_curl_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function is_allowed_ip(){
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_data = mysqli_fetch_assoc($gs_query);

	$is_ip_restriction = $general_setting_data['is_ip_restriction'];
	$allowed_ip = $general_setting_data['allowed_ip'];
	
	$allowed_ip_array=explode(',',$allowed_ip);
	$final_allowed_ip_array = array_map('trim',$allowed_ip_array);

	if($is_ip_restriction && $is_ip_restriction=='1'){
		if(!in_array(USER_IP,$final_allowed_ip_array)){
			setRedirect(ADMIN_URL.'unauthorized.php');
		}
	}
}

function admin_staff_logout_redirect() {
	unset($_SESSION['admin_username']);
	unset($_SESSION['is_admin']);
	unset($_SESSION['admin_id']);
	unset($_SESSION['admin_type']);
	unset($_SESSION['auth_token']);
	
	unset($_COOKIE['username']);
	unset($_COOKIE['password']);
	unset($_COOKIE['remember_me']);

	$year = time() - 172800;
	setcookie('username', '', $year, "/");
	setcookie('password', '', $year, "/");
	setcookie('remember_me', '', $year, "/");

	setRedirect(ADMIN_URL);
}

function check_admin_staff_auth($type = "") {
	global $db;
	$auth_token = $_SESSION['auth_token'];
	if($auth_token!="") {
		$query = mysqli_query($db,"SELECT * FROM admin WHERE auth_token!='' AND auth_token = '".$auth_token."'");
		$checkUser=mysqli_num_rows($query);
		if($checkUser > 0) {
			$user_data=mysqli_fetch_assoc($query);
			if($user_data['status'] == '0') {
				$error_msg='Your account is not activated so please contact with support team.';
				if($type=="ajax") {
					$response['message'] = $error_msg;
					$response['status'] = "fail";
					echo json_encode($response);
					exit;
				} else {
					$_SESSION['error_msg']=$error_msg;
					admin_staff_logout_redirect();
					exit;
				}
			}
		} elseif($checkUser <= 0) {
			$error_msg='Your username/password is changed so please login with new password. OR Your account is removed so please contact with support team.';
			if($type=="ajax") {
				$response['message'] = $error_msg;
				$response['status'] = "fail";
				echo json_encode($response);
				exit;
			} else {
				$_SESSION['error_msg']=$error_msg;
				admin_staff_logout_redirect();
				exit;
			}
		} 
	} else {
		$error_msg='Direct access denied';
		if($type=="ajax") {
			$response['message'] = $error_msg;
			$response['status'] = "fail";
			echo json_encode($response);
			exit;
		} else {
			$_SESSION['error_msg']=$error_msg;
			setRedirect(ADMIN_URL);
			exit;
		}
	}
}

function time_diff_from_two_datetime($time1, $time2) {
	//$time1=explode(' ',$time1);
	//$time2=explode(' ',$time2);
	$diff = abs(strtotime($time2) - strtotime($time1));

	$hours   = floor($diff / (60*60)); 
	$minuts  = floor(($diff - $hours*60*60)/ 60);
	$seconds = floor(($diff -$hours*60*60 - $minuts*60));

	$h=sprintf('%02d', $hours);
	$m=sprintf('%02d', $minuts);
	$s=sprintf('%02d', $seconds);
	//$time=$h.':'.$m.':'.$s;
	$time=$h.':'.$m;
	return $time;
}

function sum_of_time_array($times) {
 //$times = array($time1, $time2);
  $seconds = 0;
  foreach ($times as $time)
  {
    @list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  // return "{$hours}:{$minutes}:{$seconds}";
  //return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
  return sprintf('%02d:%02d', $hours, $minutes); // Thanks to Patrick
}

//Get service hours data & info based on per location
function get_service_hours_data($location_id) {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM service_hours WHERE location_id='".$location_id."' AND location_id>0");
	$service_hours_data=mysqli_fetch_assoc($query);

	$service_hours_info = "";
	if(!empty($service_hours_data)) {
		$open_time=json_decode($service_hours_data['open_time'],true);
		$close_time=json_decode($service_hours_data['close_time'],true);
		$closed = json_decode($service_hours_data['is_close'],true);

		$service_hours_k_array = array();
		$service_hours_array = array();
		if($open_time > 0) {
			foreach($open_time as $time_k => $time_v) {
				switch($time_k) {
					case "sunday":
						$day_order=7;
						break;
					case "monday":
						$day_order=1;
						break;
					case "tuesday":
						$day_order=2;
						break;
					case "wednesday":
						$day_order=3;
						break;
					case "thursday":
						$day_order=4;
						break;
					case "friday":
						$day_order=5;
						break;
					case "saturday":
						$day_order=6;
						break;
				}
				if(!@array_key_exists($time_k, $closed)) {
					if($time_v!="" && $close_time[$time_k]!="") {
						$service_hours_k_array[$time_k] = '<p class="nomargin"><span>'.ucfirst(substr($time_k,0,3)).': </span><a class="shop-time" href="javascript:void(0)" class="time_box"> '.$time_v.' - '.$close_time[$time_k].'<i class="fa fa-chevron-down"></i><i class="fa fa-chevron-up"></i></a></p>';
						$service_hours_array[$day_order] = '<p class="nomargin"><span>'.ucfirst(substr($time_k,0,3)).': </span>'.$time_v.' - '.$close_time[$time_k].'</p>';
					}
				}
			}
		}
		
		if(isset($closed) && count($closed) > 0) {
			foreach($closed as $time_k => $time_v) {
				if($time_k!='' && $time_v!='') {
					switch($time_k) {
						case "sunday":
							$day_order=7;
							break;
						case "monday":
							$day_order=1;
							break;
						case "tuesday":
							$day_order=2;
							break;
						case "wednesday":
							$day_order=3;
							break;
						case "thursday":
							$day_order=4;
							break;
						case "friday":
							$day_order=5;
							break;
						case "saturday":
							$day_order=6;
							break;
					}
					$service_hours_k_array[$time_k] = '<p class="sun nomargin"><span>'.ucfirst(substr($time_k,0,3)).': </span><a class="shop-time" href="javascript:void(0)" class="time_box"> Closed<i class="fa fa-chevron-down"></i><i class="fa fa-chevron-up"></i></a></p>';
					$service_hours_array[$day_order] = '<p class="sun nomargin"><span>'.ucfirst(substr($time_k,0,3)).': </span>Closed</p>';
				}
			}
		}

		if(!empty($service_hours_array)) {
			ksort($service_hours_array);
			//$service_hours_info .= '<p>'.$service_hours_k_array[$current_day_name].'</p>';
			//$service_hours_info .= '<div class="time_block">';
				foreach($service_hours_array as $time_k => $time_v) {
					$service_hours_info .= '<div class="col-md-6">'.$time_v.'</div>';
				}
			//$service_hours_info .= '</div>';
		}
	}
	$service_hours_data['service_hours_info'] = $service_hours_info;
	return $service_hours_data;
}

function timeZoneConvert($fromTime, $fromTimezone, $toTimezone,$format = 'Y-m-d H:i:s') {
	// create timeZone object , with fromtimeZone
	$from = new DateTimeZone($fromTimezone);
	// create timeZone object , with totimeZone
	$to = new DateTimeZone($toTimezone);
	// read give time into ,fromtimeZone
	$orgTime = new DateTime($fromTime, $from);
	// fromte input date to ISO 8601 date (added in PHP 5). the create new date time object
	$toTime = new DateTime($orgTime->format("c"));
	// set target time zone to $toTme ojbect.
	$toTime->setTimezone($to);
	// return reuslt.
	return $toTime->format($format);
}

function format_date($date) {
	$data=get_general_setting_data();
	$date_format=$data['date_format'];
	$date=timeZoneConvert($date, 'UTC', TIMEZONE,'Y-m-d H:i:s');
	return date($date_format,strtotime($date));
}

function format_time($date){
	$data=get_general_setting_data();
	$time_format=$data['time_format'];
	$_format="H:i";
	if($time_format=="12_hour"){
		$_format="g:i a";
	}
	$date=timeZoneConvert($date, 'UTC', TIMEZONE,'Y-m-d H:i:s');
	return date($_format,strtotime($date));
}

function format_time_without_timezone($date){
	$data=get_general_setting_data();
	$time_format=$data['time_format'];
	$_format="H:i";
	if($time_format=="12_hour"){
		$_format="g:i a";
	}
	return date($_format,strtotime($date));
}

function get_unique_id_on_load() {
	return md5(uniqid());
}

function get_big_unique_id() {
	return md5(date("YmdHis").uniqid()).rand(0000000000,9999999999);
}

function time_zonelist(){
    $return = array();
    $timezone_identifiers_list = timezone_identifiers_list();
    foreach($timezone_identifiers_list as $timezone_identifier){
        $date_time_zone = new DateTimeZone($timezone_identifier);
        $date_time = new DateTime('now', $date_time_zone);
        $hours = floor($date_time_zone->getOffset($date_time) / 3600);
        $mins = floor(($date_time_zone->getOffset($date_time) - ($hours*3600)) / 60);
        $hours = 'GMT' . ($hours < 0 ? $hours : '+'.$hours);
        $mins = ($mins > 0 ? $mins : '0'.$mins);
        $text = str_replace("_"," ",$timezone_identifier);
		
		$array=array();
		$array['display']=$text.' ('.$hours.':'.$mins.')';
		$array['value']=$timezone_identifier;
        $return[] =$array; 
    }
    return $return;
}

function get_date_format_list(){
    $return = array();

	$return[] = array('display'=>'m/d/Y ex. '.date('m/d/Y'),'value'=>'m/d/Y');
	$return[] = array('display'=>'d-m-Y ex. '.date('d-m-Y'),'value'=>'d-m-Y');
	$return[] = array('display'=>'M/d/Y ex. '.date('M/d/Y'),'value'=>'M/d/Y');
	$return[] = array('display'=>'d-M-Y ex. '.date('d-M-Y'),'value'=>'d-M-Y');

	$return[] = array('display'=>'m/d/y ex. '.date('m/d/y'),'value'=>'m/d/y');
	$return[] = array('display'=>'d-m-y ex. '.date('d-m-y'),'value'=>'d-m-y');
	$return[] = array('display'=>'M/d/y ex. '.date('M/d/y'),'value'=>'M/d/y');
	$return[] = array('display'=>'d-M-y ex. '.date('d-M-y'),'value'=>'d-M-y');

    return $return;
}

function check_sef_url_validation($sef_url, $id, $table_nm) {
	global $db;
	$response = array();

	$response['valid'] = true;

	$brand_sql_params = "";
	$device_sql_params = "";
	$page_sql_params = "";
	$cat_sql_params = "";
	if($table_nm == "brand") {
		$brand_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "devices") {
		$device_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "pages") {
		$page_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "categories") {
		$cat_sql_params .= " AND id!='".$id."'";
	}

	$qry = mysqli_query($db,"SELECT * FROM brand WHERE sef_url='".$sef_url."' AND sef_url!=''".$brand_sql_params);
	$num_of_brand = mysqli_num_rows($qry);
	if($num_of_brand>0) {
		$response['valid'] = false;
	}
	
	$qry_d = mysqli_query($db,"SELECT * FROM devices WHERE sef_url='".$sef_url."' AND sef_url!=''".$device_sql_params);
	$num_of_device = mysqli_num_rows($qry_d);
	if($num_of_device>0) {
		$response['valid'] = false;
	}
	
	$qry_p = mysqli_query($db,"SELECT * FROM pages WHERE url='".$sef_url."' AND url!=''".$page_sql_params);
	$num_of_page = mysqli_num_rows($qry_p);
	if($num_of_page>0) {
		$response['valid'] = false;
	}
	
	$qry_c = mysqli_query($db,"SELECT * FROM categories WHERE sef_url='".$sef_url."' AND sef_url!=''".$cat_sql_params);
	$num_of_cat = mysqli_num_rows($qry_c);
	if($num_of_cat>0) {
		$response['valid'] = false;
	}
	
	return $response;
}

function get_service_data_list($limit = 0) {
	global $db;
	
	$sql_limit = "";
	if($limit>0) {
		$sql_limit = "LIMIT ".$limit;
	}

	$response = array();
	$query = mysqli_query($db,"SELECT * FROM services WHERE published='1' ORDER BY ordering ASC ".$sql_limit);
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($service_data = mysqli_fetch_assoc($query)) {
			$response[] = $service_data;
		}
	}
	return $response;
}
?>