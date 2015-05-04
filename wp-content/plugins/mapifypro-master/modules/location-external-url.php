<?php
// Add relevant admin fields
function mpfy_leu_map_location_custom_fields($custom_fields) {
	
	$custom_fields = mpfy_array_push_key($custom_fields, 'position_after_popup', array(
		'map_location_external_url_enable'=>Carbon_Field::factory('select', 'map_location_external_url_enable', 'Take visitor to another page on clicking location?')
			->add_options(array( 'no' => 'No', 'yes' => 'Yes' )),
		'map_location_external_url_url'=>Carbon_Field::factory('text', 'map_location_external_url_url', 'Enter URL')
			->help_text('This will override the pop-up and take the visitor to a new page when they click on the location marker.'),
	));

	return $custom_fields;
}
add_filter('mpfy_map_location_custom_fields', 'mpfy_leu_map_location_custom_fields');

function mpfy_leu_pin_trigger_settings_filter($settings, $pin_id) {
	$enabled = mpfy_meta_to_bool($pin_id, '_map_location_external_url_enable', true);
	$url = get_post_meta($pin_id, '_map_location_external_url_url', true);
	if ($enabled && $url) {
		$settings['href'] = esc_url($url);
		$settings['classes'][] = 'mpfy-external-link';
	}

	return $settings;
}
add_filter('mpfy_pin_trigger_settings', 'mpfy_leu_pin_trigger_settings_filter', 10, 2);
