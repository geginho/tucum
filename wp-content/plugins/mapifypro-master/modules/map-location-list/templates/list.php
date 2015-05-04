<div class="mpfy-mll">
	<div class="mpfy-mll-list">
		<?php foreach ($locations as $l) : ?>
			<?php
			$include_location = mpfy_meta_to_bool($l->get_id(), '_map_location_mll_include', true);
			if (!$include_location) {
				continue;
			}

			$tags = $l->get_tags();
			$pin = $l->get_pin_image();
			$pin = ($pin['url'] ? $pin['url'] : plugins_url('assets/images/google-pin.png', MAPIFY_PLUGIN_FILE));
			$formatted_address = $l->get_formatted_address(array(
				array('address'),
				array('city', 'state', 'zip'),
			));
			?>
			<div class="mpfy-mll-location" data-id="<?php echo $l->get_id(); ?>">
				<div class="mpfy-mll-l-heading">
					<div class="mpfy-mll-l-pin" style="background-image: url(<?php echo $pin; ?>);"></div>
					<div class="mpfy-mll-l-title">
						<?php echo $l->get_title(); ?>

						<?php if ($tags) : ?>
							<span class="mpfy-mll-l-categories">
								<?php foreach ($tags as $t) : ?>
									<a href="#" data-mpfy-action="set_map_tag" data-mpfy-value="<?php echo $t->term_id; ?>"><?php echo esc_attr($t->name); ?></a>
								<?php endforeach; ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
				<div class="mpfy-mll-l-content">
					<?php if ($formatted_address) : ?>
						<p><strong><?php echo $formatted_address; ?></strong></p>
					<?php endif; ?>
					<?php echo wpautop(get_post_meta($l->get_id(), '_map_location_mll_description', true)); ?>
					
					<div class="mpfy-mll-l-buttons">
						<?php if ($l->get_popup_enabled()) : ?>
							<a href="#" data-mpfy-action="open_popup" data-mpfy-value="<?php echo $l->get_id(); ?>"><?php echo esc_html(__('More Details', 'mpfy')); ?></a>
						<?php endif; ?>

						<?php if ($map->get_mode() == 'google_maps') : ?>
							<a href="<?php echo $l->get_directions_url(); ?>" target="_blank"><?php echo esc_html(__('Get Directions', 'mpfy')); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="mpfy-mll-paging">
		<a href="#" class="mpfy-mll-button mpfy-mll-button-prev"><?php echo esc_html(__('Previous', 'mpfy')); ?></a>
		<a href="#" class="mpfy-mll-button mpfy-mll-button-next" style="float: right;"><?php echo esc_html(__('Next', 'mpfy')); ?></a>
		<div class="mpfy-mll-paging-status"><?php echo sprintf(__('Page %1$s of %2$s', 'mpfy'), '<span class="mpfy-mll-paging-current-page">1</span>', '<span class="mpfy-mll-paging-max-page">1</span>'); ?></div>
	</div>
</div>