<?php 
global $teo_data;
get_header(); ?>    
    <?php 
    if ( ( $locations = get_nav_menu_locations() ) && $locations['top-menu'] ) {
        $menu = wp_get_nav_menu_object( $locations['top-menu'] );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $include = array();
        foreach($menu_items as $item) {
            if($item->object == 'page')
                $include[] = $item->object_id;
        }
        $query = new WP_Query( array( 'post_type' => 'page', 'post__in' => $include, 'posts_per_page' => count($include), 'orderby' => 'post__in' ) );
    }
    else
    {
        if(isset($teo_data['pages_topmenu']) && $teo_data['pages_topmenu'] != '' )
            $query = new WP_Query(array( 'post_type' => 'page', 'post__in' => $teo_data['pages_topmenu'], 'posts_per_page' => count($teo_data['pages_topmenu']), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
        else
            $query = new WP_Query(array( 'post_type' => 'page', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
    }
    $i = 1;
    while($query->have_posts() ) : $query->the_post(); 
        $template_file = get_post_meta($post->ID,'_wp_page_template',TRUE);
        $style = get_post_meta($post->ID, '_page_style', true);
        $bgimage = get_post_meta($post->ID, '_page_bgimage', true);
        $bgcolor = get_post_meta($post->ID, '_page_bgcolor', true);
        $slogantext = get_post_meta($post->ID, '_page_slogantext', true);
        $sloganimg = get_post_meta($post->ID, '_page_sloganimg', true);
        if($template_file == 'page-template-blog.php') {
            $style = 2;
        }
    ?>
        <div class="bg <?php if($style == 2) echo 'dark-bg';?>" id="<?php echo $post->post_name;?>"
            <?php if($style == 3) { echo 'style="';
            if($bgcolor != '#') echo 'background-color: ' . $bgcolor; 
            else if($bgimage != '') echo 'background-image: url(\'' . $bgimage . '\')'; echo '"'; } ?>>
            <div class="container">
                <div class="sixteen columns">
                        <h2>
                            <span class="lines">
                                <?php $top_title = get_post_meta($post->ID, 'top_title', true); 
                                if($top_title != '') echo $top_title; else the_title();?>
                            </span>
                        </h2>
                 </div> <!-- end sixteen columns -->

                 <div class="clear"></div>

            <?php global $more; $more = 0; the_content('');?>

            <?php
            //****** Blog page template *******//
            if($template_file == 'page-template-blog.php') {  
            $nrposts = get_post_meta($post->ID, '_blog_nrposts', true);
            $fullwidth = get_post_meta($post->ID, '_blog_fullwidth', true);
            $categories = get_post_meta($post->ID, '_blog_categories', true);
            $permalink = get_permalink();
            ?>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat […]</p>

                <div class="<?php if($fullwidth == 2) echo 'twelve'; else echo 'sixteen';?> columns bg-blog">
                    <?php
                    $args = array();
                    $args['posts_per_page'] = $nrposts;
                    if(count($categories) > 0) {
                        $args['category__in'] = $categories;
                    }
                    $qquery = new WP_Query($args);
                    while($qquery->have_posts() ) : $qquery->the_post();
                        $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
                        <div class="post">
                            <?php if(has_post_thumbnail() ) { ?>
                                <a href="<?php the_permalink();?>">
                                    <?php
                                    $thumb = aq_resize($thumbnail, 1000, 300, true);
                                    if($thumb == '' && $fullwidth != 2) {
                                        //trying to resize it to smaller dimensions
                                        $thumb = aq_resize($thumbnail, 700, 250, true);
                                    }
                                    if($thumb == '') {
                                        //too small image, we keep the original one
                                        $thumb = $thumbnail;
                                    }
                                    ?>
                                    <img src="<?php echo $thumb;?>" class="scale-with-grid" alt="<?php the_title();?>" />
                                </a>
                            <?php } ?>
                            <a href="<?php the_permalink();?>">
                                <p class="post-title"><?php the_title();?></p>
                                    <p class="post-info">
                                        <?php
                                        _e('por', 'SCRN'); echo ' '; the_author_posts_link(); echo ' ';
                                        _e('|', 'SCRN'); echo ' '; the_time("d M, Y"); echo ' | '; 
                                        
                                        ?>
                                        <a class='tags'>
                                        <?php _e('', 'SCRN');; echo ' '; the_tags('',', ',''); ?>
                                        </a>

                                    </p>
                            </a>
                            <p><?php the_excerpt();?></p>
                            <a href="<?php the_permalink();?>">
                                <div class="button1"><?php _e('Ler mais', 'SCRN');?></div>
                            </a>
                        </div> <!-- end post -->
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <?php if($fullwidth == 2) { ?>
                    <div class="four columns">
                        <div class="sidebar">
                            <?php dynamic_sidebar("Right sidebar"); ?>
                        </div> <!-- end sidebar -->
                    </div> <!-- end four columns -->
            <?php }
            ?>
            <div class="sixteen columns">
                <div style="text-align: center">
                    <a href="<?php echo $permalink;?>">
                        <div class="button1"><?php _e('View all blog posts', 'SCRN');?></div>
                    </a>
                </div>
            </div>
            <?php }
            //****** Blog page template *******//
            ?>
                
            </div> <!-- end container -->
        </div> <!-- end bg -->
        <div id="separator_<?php echo $i;?>" class="separator1">
            <div class="bg<?php echo ($i+1); echo ' bg';?>" style="<?php if($sloganimg != '') echo 'background-image: url(\'' . $sloganimg . '\')';?> "></div>
            <p class="separator"><?php if($slogantext != '') echo $slogantext;?></p>
        </div>
    <?php $i++; endwhile; wp_reset_postdata(); ?>

    <div id="contact" class="dark-bg">
        <div class="container">
        
            <div class="sixteen columns">
                <h2 class="white"><span class="lines"><?php _e('Contact', 'SCRN');?></span></h2>
            </div> <!-- end sixteen columns -->

            <?php if(isset($teo_data['contact_description']) && $teo_data['contact_description'] != '') { ?>
                <div class="sixteen columns">
                    <p><?php echo esc_attr($teo_data['contact_description']);?></p>
                </div> <!-- end sixteen columns -->
            <?php } ?>
            
            <div class="clear"></div>
            
            <div class="eight columns">
                <div class="contact-form">

                    <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
                    if(is_plugin_active('contact-form-7/wp-contact-form-7.php') && isset($teo_data['contactform7']) && $teo_data['contactform7'] != '') { 
                        echo do_shortcode($teo_data['contactform7']);
                    } else { ?>
                    
                        <div class="done">
                            <?php _e('<b>Thank you!</b> I have received your message.', 'SCRN');?> 
                        </div>
                    
                        <form method="post" action="process.php">
                            <p><?php _e('nome', 'SCRN');?></p>
                            <input type="text" name="name" class="text" />
                            
                            <p><?php _e('email', 'SCRN');?></p>
                            <input type="text" name="email" class="text" id="email" />

                            <p><?php _e('mensagem', 'SCRN');?></p>
                            <textarea name="comment" class="text"></textarea>

                            <input type="submit" id="submit" value="<?php _e('enviar', 'SCRN');?>" class="submit-button" />
                        </form>
                    <?php } ?>
                        
                </div> <!-- end contact-form -->
            </div> <!-- end eight columns -->
            
            <div class="eight columns">
                
                <div class="contact-info">
                    
                    <h5><?php _e('', 'SCRN');?></h5>
                
                    <?php if(isset($teo_data['phone']) && $teo_data['phone'] != '') { ?><p class="white"><img src="<?php echo get_template_directory_uri();?>/images/icn-phone.png" alt="" /> <?php echo $teo_data['phone'];?></p><?php } ?>
                    <?php if(isset($teo_data['email']) && $teo_data['email'] != '') { ?><p class="white"><img src="<?php echo get_template_directory_uri();?>/images/icn-email.png" alt="" /> <a href="mailto:<?php echo $teo_data['email'];?>"><?php echo encEmail($teo_data['email']);?></a></p><?php } ?>
                    <?php if(isset($teo_data['location']) && $teo_data['location'] != '') { ?><p class="white"><img src="<?php echo get_template_directory_uri();?>/images/icn-address.png" alt="" /> <?php echo $teo_data['location'];?></p><?php } ?>

<p class="white">Loja aberta <br />Terça a Sábado 12:00 às 21:00<br />Domingo e segunda 14:00 às 20:00.</p>                </div> <!-- end contact-info -->
                
                <div class="social">
                    <ul>
                        <?php if(isset($teo_data['twitter_username'])  && $teo_data['twitter_username'] != '') { ?><li><a target="_blank" href="http://twitter.com/<?php echo $teo_data['twitter_username'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-twitter2.png" alt="Twitter icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['facebook_url'])  && $teo_data['facebook_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['facebook_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-facebook2.png" alt="Facebook icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['gplus_url'])  && $teo_data['gplus_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['gplus_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-gplus.png" alt="Google+ icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['linkedin_url'])  && $teo_data['linkedin_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['linkedin_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-linkedin.png" alt="LinkedIn icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['forrst_url'])  && $teo_data['forrst_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['forrst_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-forrst.png" alt="Forrst icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['skype_url'])  && $teo_data['skype_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['skype_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-skype.png" alt="Skype icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['dribbble_url'])  && $teo_data['dribbble_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['dribbble_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-dribbble.png" alt="Dribbble icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['pinterest_url'])  && $teo_data['pinterest_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['pinterest_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-pinterest.png" alt="Pinterest icon" /></a></li><?php } ?>
                        <?php if(isset($teo_data['vimeo_url'])  && $teo_data['vimeo_url'] != '') { ?><li><a target="_blank" href="<?php echo $teo_data['vimeo_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-vimeo.png" alt="Vimeo icon" /></a></li><?php } ?>
                    </ul>
                </div> <!-- end social -->
                
            </div> <!-- end eight columns -->
            
            <div class="clear"></div>
            
            
        </div> <!-- end container -->
        
    </div> <!-- end contact -->

    
    
<?php get_footer();?>