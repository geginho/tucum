<?php 

add_image_size('thumb-projetos',250, 160, true);
add_image_size('slider-projetos',960, 370, true);

add_theme_support( 'post-thumbnails' );


/**
 * Modify home query to only show 3 posts
 *
 * @param WP_Query $query
 * @return WP_Query
 */
function depo_limit_home_posts_per_page( $query = '' ) {
 
    // Bail if not home, not a query, not main query, or no featured posts
    if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
        return;
 
    // Home only gets 3 posts
    $query->set( 'posts_per_page', 10 );
}
add_action( 'pre_get_posts', 'depo_limit_home_posts_per_page' );


add_filter('wp_title', 'vp_filter_wp_title', 9, 3);

function vp_filter_wp_title( $old_title, $sep, $sep_location ) {
	$ssep = ' ' . $sep . ' ';
	if (is_home() ) {
		return get_bloginfo('name');
	}
	elseif(is_single() || is_page() )
	{
		return get_the_title();
	}
	elseif( is_category() ) $output = $ssep . 'Category';
	elseif( is_tag() ) $output = $ssep . 'Tag';
	elseif( is_author() ) $output = $ssep . 'Author';
	elseif( is_year() || is_month() || is_day() ) $output = $ssep . 'Archives';
	else $output = NULL;
	 
	// get the page number we're on (index)
	if( get_query_var( 'paged' ) )
	$num = $ssep . 'page ' . get_query_var( 'paged' );
	 
	// get the page number we're on (multipage post)
	elseif( get_query_var( 'page' ) )
	$num = $ssep . 'page ' . get_query_var( 'page' );
		 
	// else
	else $num = NULL;
		 
	// concoct and return new title
	return get_bloginfo( 'name' ) . $output . $old_title . $num;
}

//This function shows the top menu if the user didn't create the menu in Appearance -> Menus.
if( !function_exists( 'show_top_menu') )
{
	function show_top_menu() {
		global $scrn;
		echo '<ul>';
		if(isset($scrn['pages_topmenu']) && $scrn['pages_topmenu'] != '' )
			$pages = get_pages( array('include' => $scrn['pages_topmenu'], 'sort_column' => 'menu_order', 'sort_order' => 'ASC') );
		else
			$pages = get_pages('number=4&sort_column=menu_order&sort_order=ASC');
		$count = count($pages);
		if($scrn['menu_homelink'] == '1') 
			echo '<li><a href="' . get_home_url() . '/#intro">Home</a>';
		for($i = 0; $i < $count; $i++)
		{
			echo '<li><a href="' . get_home_url() . '/#' . $pages[$i]->post_name . '">' . $pages[$i]->post_title . '</a></li>' . PHP_EOL;
		}
		if(isset($scrn['blog_page']) && $scrn['blog_page'] != '')
			echo '<li><a href="' . get_permalink($scrn['blog_page'][0]) . '">Blog</a></li>';
		echo '<li><a href="' . get_home_url() . '/#contact">Contato</a></li>';
		echo '</ul>';
	}
}

add_action('wp_head', 'vp_customization');
//This function handles the Colorization tab of the theme options
if(! function_exists('vp_customization'))
{
	function vp_customization() {
		//favicon
		global $scrn;

		//Loading the google web fonts on the page.
		$loaded[] = 'Oswald';
		$loaded[] = 'Source+Sans+Pro';
		if(!in_array($scrn['body_font'], $loaded))
		{
			echo '<link id="' . $scrn['body_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['body_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['body_font'];
		}

		if(isset($scrn['top_headertext_font']) && !in_array($scrn['top_headertext_font'], $loaded))
		{
			echo '<link id="' . $scrn['top_headertext_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['top_headertext_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['top_headertext_font'];
		}

		if(isset($scrn['top_smalltext_font']) && !in_array($scrn['top_smalltext_font'], $loaded))
		{
			echo '<link id="' . $scrn['top_smalltext_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['top_smalltext_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['top_smalltext_font'];
		}

		if(isset($scrn['top_smallertext_font']) && !in_array($scrn['top_smallertext_font'], $loaded))
		{
			echo '<link id="' . $scrn['top_smallertext_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['top_smallertext_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['top_smallertext_font'];
		}

		if(isset($scrn['nav_font']) && !in_array($scrn['nav_font'], $loaded))
		{
			echo '<link id="' . $scrn['nav_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['nav_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;	
			$loaded[] = $scrn['nav_font'];
		}

		if(isset($scrn['pagetitle_font']) && !in_array($scrn['pagetitle_font'], $loaded))
		{
			echo '<link id="' . $scrn['pagetitle_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['pagetitle_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['pagetitle_font'];
		}	
		if(isset($scrn['subheader_font']) && !in_array($scrn['subheader_font'], $loaded))
		{
			echo '<link id="' . $scrn['subheader_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['subheader_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['subheader_font'];
		}	
		if(isset($scrn['h3_font']) && !in_array($scrn['h3_font'], $loaded))
		{
			echo '<link id="' . $scrn['h3_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['h3_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['h3_font'];
		}
		if(isset($scrn['h4_font']) && !in_array($scrn['h4_font'], $loaded))
		{
			echo '<link id="' . $scrn['h4_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['h4_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['h4_font'];
		}
		if(isset($scrn['separator_font']) && !in_array($scrn['separator_font'], $loaded))
		{
			echo '<link id="' . $scrn['separator_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['separator_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['separator_font'];
		}
		if(isset($scrn['footer_font']) && !in_array($scrn['footer_font'], $loaded))
		{
			echo '<link id="' . $scrn['footer_font'] . '" href="http://fonts.googleapis.com/css?family=' . $scrn['footer_font'] . '" rel="stylesheet" type="text/css" />' . PHP_EOL;
			$loaded[] = $scrn['footer_font'];
		}

		if(isset($scrn['favicon']) && $scrn['favicon'] != '')
			echo '<link rel="shortcut icon" href="' . $scrn['favicon'] . '" />';
		echo "\n<style type='text/css'> \n";

		if(isset($scrn['bg_image']) && $scrn['bg_image'] != '')
		{ 
			echo "#intro .bg1 { background-image: url('" . $scrn['bg_image'] . "'); } \n";
		}
		if(isset($scrn['bg_color']) && $scrn['bg_color'] != '') 
		{
			echo "#intro .bg1 { background-image: none; background-color: " . $scrn['bg_color'] . "; } \n";
		}

		//add custom CSS as per the theme options only if custom colorization was enabled.
		if(isset($scrn['enable_colorization']) && $scrn['enable_colorization'] == 1)
		{
			$loaded = array();
			echo '
			p, body { font-size: ' . $scrn['body_size'] . 'px; color: ' . $scrn['body_color_white'] . '; font-family: \'' . str_replace('+', ' ', $scrn['body_font']) . '\',sans-serif; }
			.dark-bg p, .dark-bg { color: ' . $scrn['body_color_dark'] . '; }
			h1 { font-size: ' . $scrn['top_headertext_size'] . 'px;}
			#intro h1 { color: ' . $scrn['top_headertext_color'] . '; font-family: \'' . str_replace('+', ' ', $scrn['top_headertext_font']) . '\',sans-serif; }
			#intro h1.small { font-size: ' . $scrn['top_smalltext_size'] . 'px; color: ' . $scrn['top_smalltext_color'] . '; font-family: \'' . str_replace('+', ' ', $scrn['top_smalltext_font']) . '\',sans-serif; }
			.title p { font-size: ' . $scrn['top_smallertext_size'] . 'px; color: ' . $scrn['top_smallertext_color'] . '; font-family: \'' . str_replace('+', ' ', $scrn['top_smallertext_font']) . '\',sans-serif; }
			nav a { font-size: ' . $scrn['nav_size'] . 'px; color: ' . $scrn['nav_color'] . ' !important; font-family: \'' . str_replace('+', ' ', $scrn['nav_font']) . '\',sans-serif; }
			nav a:hover { color: ' . $scrn['nav_hovercolor'] . ' !important; }
			h2 { font-size: ' . $scrn['pagetitle_size'] . 'px; color: ' . $scrn['pagetitle_color'] . '; font-family: \'' . str_replace('+', ' ', $scrn['pagetitle_font']) . '\',sans-serif; }
			.action p { font-size: ' . $scrn['subheader_size'] . 'px; color: ' . $scrn['subheader_color'] . '; font-family: \'' . str_replace('+', ' ', $scrn['subheader_font']) . '\',sans-serif; }
			h3 { color: ' . $scrn['h3_color'] . '; font-size: ' . $scrn['h3_size'] . 'px; font-family: \'' . str_replace('+', ' ', $scrn['h3_font']) . '\',sans-serif; }
			h4 { color: ' . $scrn['h4_color'] . '; font-size: ' . $scrn['h4_size'] . 'px; font-family: \'' . str_replace('+', ' ', $scrn['h4_font']) . '\',sans-serif; }
			p.separator { font-size: ' . $scrn['separator_size'] . 'px !important; color: ' . $scrn['separator_color'] . ' !important; font-family: \'' . str_replace('+', ' ', $scrn['separator_font']) . '\',sans-serif !important; }
			.copyright  p, .copyright  a { font-size: ' . $scrn['footer_size'] . 'px; color: ' . $scrn['footer_color'] . '; font-family: \'' . str_replace('+', ' ', $scrn['footer_font']) . '\',sans-serif; }
			';
		}
		echo '</style>';
	}
}
?>