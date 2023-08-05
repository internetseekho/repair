<?php
$address_lit = '';
$location_data_list = get_location_data_list();
$current_day_name = strtolower(date('l'));

/*$gs_data_append_to_lctn_array = array();
$gs_data_append_to_lctn_array['id'] = 'corporate';
$gs_data_append_to_lctn_array['name'] = $company_name;
$gs_data_append_to_lctn_array['address'] = $company_address;
$gs_data_append_to_lctn_array['country'] = $company_country;
$gs_data_append_to_lctn_array['state'] = $company_state;
$gs_data_append_to_lctn_array['city'] = $company_city;
$gs_data_append_to_lctn_array['zipcode'] = $company_zipcode;
$gs_data_append_to_lctn_array['email'] = '';
$gs_data_append_to_lctn_array['phone'] = '';
$gs_data_append_to_lctn_array['lat'] = $company_lat;
$gs_data_append_to_lctn_array['lng'] = $company_lng;
$location_data_list[] = $gs_data_append_to_lctn_array;*/

if(!empty($location_data_list)) {
	foreach($location_data_list as $location_data) {
		$location_city_array[$location_data['city']][$location_data['id']] = $location_data;
	}

	$final_location_adr_array = array();
	$final_location_list = array();
	foreach($location_city_array as $key => $location_city_data) {
		foreach($location_city_data as $final_location_data) {

			//START for service hours
			$service_hours_data = get_service_hours_data($final_location_data['id']);
			$final_location_data['service_hours_info'] = $service_hours_data['service_hours_info'];
			//END for service hours

			$lat = $final_location_data['lat'];
			$lng = $final_location_data['lng'];
			
			$location_name = $final_location_data['name'];
			$location_email = $final_location_data['email'];
			$location_phone = $final_location_data['phone'];
			$location_address = $final_location_data['address'];
			$location_city_name = $final_location_data['city'];
			$location_state_name = $final_location_data['state'];
			$location_country_name = $final_location_data['country'];
			$location_postcode = $final_location_data['zipcode'];
			
			$info = '<strong>'.$location_name.'</strong><br>'.$location_address.'<br> '.$location_city_name.', '.$location_state_name.', '.$location_country_name.' '.$location_postcode.'<br><strong>Email:</strong> '.$location_email.'<br><strong>Phone:</strong> '.$location_phone;
	
			$final_location_adr_array[strtolower(str_replace(" ","_",$key))][] = array($info,$lat,$lng);
			$final_location_list[strtolower(str_replace(" ","_",$key))][] = $final_location_data;
		}
	}
	$address_lit = json_encode($final_location_adr_array);
} ?>


