<div id="mpfy-map-<?php echo $mpfy_instances; ?>" class="mpfy-fullwrap">
	<?php if ($errors) : ?>
		<p>
			<?php foreach ($errors as $e) : ?>
				<?php echo $e; ?><br />
			<?php endforeach; ?>
		</p>
	<?php else : ?>
		
		<div class="mpfy-controls-wrap">
			<div class="mpfy-controls <?php echo ( ($filters_enabled && $map_tags) && $search_enabled) ? 'mpfy-controls-all' : ''; ?>" style="<?php echo ( (!$filters_enabled || !$map_tags) && !$search_enabled) ? 'display: none;' : ''; ?>">
				
				<form class="mpfy-search-form" method="post" action="" style="<?php echo (!$search_enabled) ? 'display: none;' : ''; ?>">
					<div class="mpfy-search-wrap">
						<input type="text" name="mpfy_search" class="mpfy_search" value="" placeholder="<?php echo esc_attr(__('Enter city or zip code', 'mpfy')); ?>" />
						<a href="#" class="mpfy-clear-search">&nbsp;</a>
						<input type="submit" name="" value="<?php echo esc_attr(__('Search', 'mpfy')); ?>" class="mpfy_search_button" />
					</div>
				</form>

				<div class="mpfy-filter" style="<?php echo (!$filters_enabled || !$map_tags) ? 'display: none;' : ''; ?>">
					<label class="mpfy-filter-label"><?php echo esc_html(__('Filter Results by', 'mpfy')); ?></label>
					<div class="select">
						<span class="select-value"></span>
						<select name="mpfy_tag" class="mpfy_tag_select">
							<option value="0"><?php echo esc_html(__('Default View', 'mpfy')); ?></option>
							<?php foreach ($map_tags as $t) : ?>
								<option value="<?php echo $t->term_id; ?>"><?php echo $t->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>	

			<?php if ($zoom_enabled || $map_google_ui_enabled) : ?>
				<a href="#" class="mpfy-zoom-in"></a>
				<a href="#" class="mpfy-zoom-out"></a>
			<?php endif; ?>

		</div>

		<div class="mpfy-map-canvas mpfy-mode-<?php echo $mode ?> <?php echo ($map_tags || $search_enabled) ? 'with-controls' : ''; ?>">
			<div style="display: none;">
				<?php foreach ($pins as $p) : ?>
					<?php
					$settings = array(
						'href'=>'#',
						'classes'=>array('mpfy-pin', 'mpfy-pin-id-' . $p->ID, 'no_link'),
					);
					if ($p->popup_enabled) {
						$settings['href'] = add_query_arg('mpfy_map', $map->get_id(), get_permalink($p->ID));
					}
					$settings = apply_filters('mpfy_pin_trigger_settings', $settings, $p->ID);
					?>
					<a href="<?php echo esc_attr($settings['href']); ?>" data-id="<?php echo $p->ID; ?>" class="<?php echo esc_attr(implode(' ', $settings['classes'])); ?>">&nbsp;</a>
				<?php endforeach; ?>
			</div>

			<div class="mpfy-map-canvas-wrap">
				<div id="custom-mapping-google-map-<?php echo $mpfy_instances; ?>" style="height: <?php echo $height; ?>px; overflow: hidden;"></div>
				<span class="mpfy-scroll-handle"></span>
			</div>

			<?php if ($filters_list_enabled) : ?>
				<div class="mpfy-tags-list">
					<div class="cl">&nbsp;</div>
					<a href="#" class="mpfy-tl-item" data-tag-id="0">
						<span class="mpfy-tl-i-icon"></span>
						<?php echo esc_html(__('Default View', 'mpfy')); ?>
					</a>
					<?php foreach ($map_tags as $t) : ?>
						<?php
						$image = wp_get_attachment_image_src(carbon_get_term_meta($t->term_id, 'mpfy_location_tag_image'), 'mpfy_location_tag');
						?>
						<a href="#" class="mpfy-tl-item" data-tag-id="<?php echo $t->term_id; ?>">
							<?php if ($image) : ?>
								<span class="mpfy-tl-i-icon" style="background-image: url('<?php echo $image[0]; ?>');"></span>
							<?php endif; ?>
							<?php echo $t->name; ?>
						</a>
					<?php endforeach; ?>
					<div class="cl">&nbsp;</div>
				</div>
			<?php endif; ?>

			<?php do_action('mpfy_template_after_map', $map->get_id()); ?>
		</div>
	<?php endif; ?>
</div>