<?php
function mpfy_batch_add_admin_page() {
	add_submenu_page('mapify.php', 'Batch Upload', 'Batch Upload', 'manage_options', 'mpfy-import', 'mpfy_batch_upload_admin_page');
}
add_action('admin_menu', 'mpfy_batch_add_admin_page');

function mpfy_batch_upload_admin_page() {
	include_once('admin/batch-upload.php');
}

function mpfy_batch_bool_value($value) {
	$true_values = array(1, '1', 'true', 'y', 'yes');
	$value = trim(strtolower($value));
	return (bool) (in_array($value, $true_values));
}

function mpfy_batch_trigger_hook() {
	/*
	Title
	Description
	Enable Pop-up? Y/N
	Enable Tooltip? Y/N
	Close Tooltip Automatically/Manually
	Include Location Information? Y/N
	Include Directions? Y/N
	Tooltip Content
	Include on Selected Map(s) Location  List? Y/N
	Short Description (appears in Interactive List)
	Video Embed code
	Phone Number
	Street Address
	State
	City
	Zip
	Country
	*/


	$r = array_map('trim', $_POST['row']);
	$action = 'add';

	$already_existing = get_page_by_title($r[0], OBJECT, 'map-location');
	if ($already_existing) {
		$action = 'update';
		$new_post_id = $already_existing->ID;
		$location = new Mpfy_Map_Location($new_post_id);
		$maps = $location->get_maps();
		$maps[] = intval($_POST['map_id']);
		$maps = array_filter(array_unique($maps));
		update_post_meta($new_post_id, '_map_location_map', implode(',', $maps));
	} else {
		$new_post = array(
			'post_type'=>'map-location',
			'post_status'=>'publish',
			'post_title'=>$r[0],
			'post_content'=>$r[1],
		);
		$new_post_id = wp_insert_post($new_post);
		update_post_meta($new_post_id, '_map_location_map', intval($_POST['map_id']));
	}

	$tooltip_close_method = trim(strtolower($r[4]));
	$tooltip_close_method = (in_array($tooltip_close_method, array('auto', 'automatically'))) ? 'auto' : 'manual';
	update_post_meta($new_post_id, '_map_location_tooltip_enabled', mpfy_batch_bool_value($r[2]) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_tooltip_show', mpfy_batch_bool_value($r[3]) ? 'yes' : 'no');
	update_post_meta($new_post_id, '_map_location_tooltip_close', $tooltip_close_method);
	update_post_meta($new_post_id, '_map_location_popup_location_information', mpfy_batch_bool_value($r[5]) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_popup_directions', mpfy_batch_bool_value($r[6]) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_tooltip', $r[7]);
	update_post_meta($new_post_id, '_map_location_mll_include', mpfy_batch_bool_value($r[8]) ? 'y' : 'n' );
	update_post_meta($new_post_id, '_map_location_mll_description', $r[9]);
	update_post_meta($new_post_id, '_map_location_video_embed', $r[10]);
	update_post_meta($new_post_id, '_map_location_phone', $r[11]);
	update_post_meta($new_post_id, '_map_location_address', $r[12]);
	update_post_meta($new_post_id, '_map_location_state', $r[13]);
	update_post_meta($new_post_id, '_map_location_city', $r[14]);
	update_post_meta($new_post_id, '_map_location_zip', $r[15]);
	update_post_meta($new_post_id, '_map_location_country', $r[16]);

	$full_address = implode(', ', array_filter(array($r[12], $r[14], $r[13], $r[15], $r[16])));

	$url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($full_address) . '&sensor=false';
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	$data = json_decode($response);
	$found_address = false;

	if (isset($data->results) && isset($data->results[0])) {
		$found_address = true;
		$latlng = $data->results[0]->geometry->location->lat . ',' . $data->results[0]->geometry->location->lng;
		update_post_meta($new_post_id, '_map_location_google_location', $latlng);
		update_post_meta($new_post_id, '_map_location_google_location-lat', $data->results[0]->geometry->location->lat);
		update_post_meta($new_post_id, '_map_location_google_location-lng', $data->results[0]->geometry->location->lng);
		update_post_meta($new_post_id, '_map_location_google_location-address', $full_address);
	}

	if ($found_address) {
		echo ($action == 'add' ? 'Added' : 'Updated') . ' <em>' . $r[0] . ' (' . $r[12] . ')</em>';
	} else {
		echo ($action == 'add' ? 'Added' : 'Updated') . ' <em>' . $r[0] . ' (' . $r[12] . ')</em>. <span style="color: red;">Google Maps failed to retrieve exact location (manual entry is required).</span>';
	}
	exit;
}
add_action('wp_ajax_mpfy_batch_upload', 'mpfy_batch_trigger_hook', 1000);
