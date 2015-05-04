<?php
// Add relevant admin fields
function mpfy_pld_map_location_custom_fields($custom_fields) {

	$custom_fields = mpfy_array_push_key($custom_fields, 'map_location_tooltip_close', array(
		'map_location_popup_location_information'=>Carbon_Field::factory('select', 'map_location_popup_location_information', 'Include Location Information')
			->add_options(array( 'yes' => 'Yes', 'no' => 'No' ))
			->help_text('Shows or hides the location information in the location popup.'),
		'map_location_popup_directions'=>Carbon_Field::factory('select', 'map_location_popup_directions', 'Include Directions')
			->add_options(array( 'yes' => 'Yes', 'no' => 'No' ))
			->help_text('Shows or hides the directions button in the location popup.'),
	));

	$custom_fields = mpfy_array_push_key($custom_fields, 'map_location_separator_4', array(
		'map_location_phone'=>Carbon_Field::factory('text', 'map_location_phone', 'Phone'),
	));

	$custom_fields = mpfy_array_push_key($custom_fields, 'position_after_address', array(
		'map_location_links'=>Carbon_Field::factory('complex', 'map_location_links', 'Links')
			->add_fields(array(
				Carbon_Field::factory('text', 'url', 'URL'),
				Carbon_Field::factory('text', 'text', 'Text'),
				Carbon_Field::factory('select', 'target', 'Open in New Window')
					->add_options(array(
						'_top'=>'No',
						'_blank'=>'Yes',
					)),
			)),
	));

	return $custom_fields;
}
add_filter('mpfy_map_location_custom_fields', 'mpfy_pld_map_location_custom_fields');

// Add directions button to popup
function mpfy_pld_display_button($location_id, $map_id) {
	$map = new Mpfy_Map($map_id);
	$map_location = new Mpfy_Map_Location($location_id);
	
	$map_mode = $map->get_mode();

	$popup_directions = mpfy_meta_to_bool($location_id, '_map_location_popup_directions', true);
	$popup_location_information = mpfy_meta_to_bool(get_the_ID(), '_map_location_popup_location_information', true);
	
	// directions
	$directions_url = $map_location->get_directions_url();

	// location information
	$address_lines = array(
		array(
			$map_location->get_address(),
		),
		array(
			$map_location->get_address_line_2(),
		),
		array(
			$map_location->get_city(),
			$map_location->get_state(),
			$map_location->get_zip(),
			$map_location->get_country(),
		),
		array(
			get_post_meta($map_location->get_id(), '_map_location_phone', true),
		),
	);

	$address_lines_formatted = '';
	foreach ($address_lines as $line) {
		$contents = implode(' ', array_filter(array_values($line)));
		if (!$contents) { continue; }
		$address_lines_formatted .= $contents . '<br />';
	}

	$links = carbon_get_post_meta(get_the_ID(), 'map_location_links', 'complex');

	$tags = wp_get_object_terms(get_the_ID(), 'location-tag');
	?>
	<?php if ($popup_directions && $map_mode === 'google_maps') : ?>
		<aside class="mpfy-p-widget mpfy-p-widget-direction <?php echo ($popup_location_information) ? 'mpfy-p-widget-direction-with-location' : 'mpfy-p-widget-direction-without-location'; ?>">
			<a href="<?php echo $directions_url; ?>" target="_blank" class="mpfy-p-bg-gray mpfy-p-color-accent-background"><?php echo esc_html(__('Directions to this location', 'mpfy')); ?></a>
		</aside>
	<?php endif; ?>
	<?php if ($popup_location_information) : ?>
		<aside class="mpfy-p-widget mpfy-p-widget-location">
			<div class="mpfy-p-holder">
				<h5 class="mpfy-p-widget-title"><?php echo esc_html(__('Location information', 'mpfy')); ?></h5>
				<?php if ($address_lines_formatted) : ?>
					<div class="mpfy-p-entry">
						<p>
							<?php echo $address_lines_formatted; ?>
						</p>
					</div>
				<?php endif; ?>
				<?php if ($links) : ?>
					<div class="mpfy-p-links">
						<ul>
							<?php foreach ($links as $o) : ?>
								<li>
									<a href="<?php echo esc_attr($o['url']); ?>" target="<?php echo $o['target']; ?>" class=" mpfy-p-color-accent-color"><?php echo esc_attr($o['text']); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<?php if ($tags) : ?>
				<div class="mpfy-p-tags">
					<?php foreach ($tags as $t) : ?>
						<a href="#" data-mpfy-action="set_map_tag" data-mpfy-value="<?php echo $t->term_id; ?>"><?php echo esc_attr($t->name); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="cl">&nbsp;</div>
		</aside>
	<?php endif; ?>
	<?php
}
add_action('mpfy_popup_location_information', 'mpfy_pld_display_button', 10, 2);
