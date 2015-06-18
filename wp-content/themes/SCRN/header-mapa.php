<?php global $teo_data; ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html style="margin-top: 0 !important" class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html style="margin-top: 0 !important" class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html style="margin-top: 0 !important" class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <!--<![endif]-->
<html style="margin-top: 0 !important" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('-');?></title>
    <!-- Mobile Specific Metas
      ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--[if IE]>
        <link href="<?php echo get_template_directory_uri() . '/css/ie.css';?>" rel='stylesheet' type='text/css'>
    <![endif]-->
   
    
    <script type="text/javascript">
    var templateDir = "<?php echo get_template_directory_uri(); ?>";
    </script>


    <?php global $teo_data;  
    if(isset($teo_data['integration_header'])) echo $teo_data['integration_header'] . PHP_EOL;
    wp_head(); ?>
</head>
<body <?php body_class();?>>
 
<!-- Primary Page Layout
    ================================================== -->

    

    <nav>
        <?php wp_nav_menu(array(
                                'theme_location' => 'top-menu',
                                'container' => '',
                                'fallback_cb' => 'show_top_menu',
                                'menu_id' => 'menu-top-menu',
                                'echo' => true,
                                'walker' => new description_walker(),
                                'depth' => 1 ) );
            ?>
    </nav>