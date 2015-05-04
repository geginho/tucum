<?php 
global $scrn;
if(isset($_POST['submit']))
{
    if( !$_POST['name'] || !$_POST['email'] || !$_POST['comment'] || $_POST['name'] == '' || $_POST['email'] == ''|| $_POST['comment'] == '')
    {
        $error = 'Please fill in all the required fields';
    }
    else 
    {
            $absolute_path = __FILE__;
            $path_to_file = explode( 'wp-content', $absolute_path );
            $path_to_wp = $path_to_file[0];

            // Access WordPress
            require_once( $path_to_wp . '/wp-load.php' );
            $scrn = get_option('scrn');
            $name = esc_html($_POST['name']);
            $email = esc_html($_POST['email']);
            $comment = esc_html($_POST['comment']);
            $msg = esc_attr('Name: ', 'SCRN') . $name . PHP_EOL;
            $msg .= esc_attr('E-mail: ', 'SCRN') . $email . PHP_EOL;
            $msg .= esc_attr('Message: ', 'SCRN') . $comment;
            $to = $scrn['email'];
            $sitename = get_bloginfo('name');
            $subject = '[' . $sitename . ']' . ' New Message';
            $headers = 'From: ' . $name . ' <' . $email . '>' . PHP_EOL;
            //wp_mail($to, $subject, $msg, $headers);
    }
}
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
        $loop = new WP_Query ( array( 'post_type' => 'page', 'post__in' => $include, 'posts_per_page' => count($include), 'orderby' => 'post__in' ) );
    }
    else
    {
        if(isset($scrn['pages_topmenu']) && $scrn['pages_topmenu'] != '' )
            $loop = new WP_Query (array( 'post_type' => 'page', 'post__in' => $scrn['pages_topmenu'], 'posts_per_page' => count($scrn['pages_topmenu']), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
        else
            $loop = new WP_Query (array( 'post_type' => 'page', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
    }
    $i = 1;
    while($loop->have_posts() ) : $loop->the_post();
        $style = get_post_meta($post->ID, '_page_style', true);
        $bgimage = get_post_meta($post->ID, '_page_bgimage', true);
        $bgcolor = get_post_meta($post->ID, '_page_bgcolor', true);
        $slogantext = get_post_meta($post->ID, '_page_slogantext', true);
        $sloganimg = get_post_meta($post->ID, '_page_sloganimg', true);
    ?>
        <div class="bg <?php if($style == 2) echo 'dark-bg';?>" id="<?php echo $post->post_name;?>"
            <?php if($style == 3) { echo 'style="';
            if($bgcolor != '#') echo 'background-color: ' . $bgcolor; 
            else if($bgimage != '') echo 'background-image: url(\'' . $bgimage . '\')'; echo '"'; } ?>>
            <div class="container">
                

                 <div class="clear"></div>

            <?php global $more; $more = 0; the_content('');?>
            <?php if (($post->post_name) == 'tecendo-a-rede') { ?>
                <div id="main_container">
                <div id="load_posts_container">
                   <?php
                    // if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
                    // elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
                    // else { $paged = 1; }
                    if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }
                    // $curpage = $paged ? $paged : 1;
                    $type = 'projetos';
                    $args = array(
                        'post_type' => $type,
                        // 'orderby' => 'post_date',
                        // 'posts_per_page' => 4,
                        // // 'paged' => $paged
                        // 'paged' => $paged
                    );
                    $my_query = new WP_Query($args);
                    if($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
                    ?>
                      <div class="item-projeto">
                            <div class="thumbnail">
                                <a href="<?php the_permalink() ?>" rel="bookmark" title="Ler mais sobre <?php the_title_attribute(); ?>"><?php the_post_thumbnail('thumb-projetos');?></a>
                            </div>
                            <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Ler mais sobre <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                            <div class="descricao">
                              <?php echo the_excerpt( __( 'Continued&amp;hellip;' ) ); ?>
                            </div>
                        </div>
                    <?php
                    endwhile; ?>
                    </div>

<!--                     <?php
                        // if(function_exists('wp_pagenavi')) { wp_pagenavi( array( 'query' => $my_query ) ); }
                    ?> -->
                    <!-- <?php echo $my_query->max_num_pages; ?> -->
                    <!-- <p><?php var_dump($my_query); ?></p> -->
                    <?php endif;
                     wp_reset_postdata(); ?>
            </div>
             <?php } ?>
            </div> <!-- end container -->
        </div> <!-- end bg -->
        <div id="separator_<?php echo $i;?>" class="separator1">
            <div class="bg<?php echo ($i+1); echo ' bg';?>" style="<?php if($sloganimg != '') echo 'background-image: url(\'' . $sloganimg . '\')';?> "></div>
            <p class="separator"><?php if($slogantext != '') echo $slogantext;?></p>
        </div>
    <?php $i++; endwhile; wp_reset_query(); ?>

    <div id="contact" class="dark-bg">
        <div class="container">
        
            <div class="sixteen columns">
                <h2 class="white"><span class="lines"><?php _e('Contact', 'SCRN');?></span></h2>
            </div> <!-- end sixteen columns -->

            <?php if(isset($scrn['contact_description']) && $scrn['contact_description'] != '') { ?>
                <div class="sixteen columns">
                    <p><?php echo esc_attr($scrn['contact_description']);?></p>
                </div> <!-- end sixteen columns -->
            <?php } ?>
            
            <div class="clear"></div>
            
            <div class="eight columns">
                <div class="contact-form">

                    <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
                    if(is_plugin_active('contact-form-7/wp-contact-form-7.php') && isset($scrn['contactform7']) && $scrn['contactform7'] != '') { 
                        echo do_shortcode($scrn['contactform7']);
                    } else { ?>
                    
                        <div class="done">
                            <?php _e('<b>Thank you!</b> I have received your message.', 'SCRN');?> 
                        </div>
                    
                        <form method="post" action="process.php">
                            <p><?php _e('name', 'SCRN');?></p>
                            <input type="text" name="name" class="text" />
                            
                            <p><?php _e('email', 'SCRN');?></p>
                            <input type="text" name="email" class="text" id="email" />

                            <p><?php _e('message', 'SCRN');?></p>
                            <textarea name="comment" class="text"></textarea>

                            <input type="submit" id="submit" value="<?php _e('send', 'SCRN');?>" class="submit-button" />
                        </form>
                    <?php } ?>
                        
                </div> <!-- end contact-form -->
            </div> <!-- end eight columns -->
            
            <div class="eight columns">
                
                <div class="contact-info">
                    
                    <!-- <h5><?php _e('Contact Info', 'SCRN');?></h5> -->
                
                    <?php if(isset($scrn['phone']) && $scrn['phone'] != '') { ?><p class="white"><img src="<?php echo get_template_directory_uri();?>/images/icn-phone.png" alt="" /> <?php echo $scrn['phone'];?></p><?php } ?>
                    <?php if(isset($scrn['email']) && $scrn['email'] != '') { ?><p class="white"><img src="<?php echo get_template_directory_uri();?>/images/icn-email.png" alt="" /> <a href="mailto:<?php echo $scrn['email'];?>"><?php echo encEmail($scrn['email']);?></a></p><?php } ?>
                    <?php if(isset($scrn['location']) && $scrn['location'] != '') { ?><p class="white"><img src="<?php echo get_template_directory_uri();?>/images/icn-address.png" alt="" /> <?php echo $scrn['location'];?></p><?php } ?>
                    <p class="white">Loja aberta de 3ª a sábado de 10h às 21h<br />2ª de 14h às 18h, domingo de 14h às 20h.</p>
                </div> <!-- end contact-info -->
                
                <div class="social">
                    <ul>
                        <?php if(isset($scrn['twitter_username'])  && $scrn['twitter_username'] != '') { ?><li><a target="_blank" href="http://twitter.com/<?php echo $scrn['twitter_username'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-twitter2.png" alt="Twitter icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['facebook_url'])  && $scrn['facebook_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['facebook_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-facebook-intro.png" alt="Facebook icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['instagram_url']) && $scrn['instagram_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['instagram_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-instagram-intro.png" alt="Instagram icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['gplus_url'])  && $scrn['gplus_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['gplus_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-gplus.png" alt="Google+ icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['linkedin_url'])  && $scrn['linkedin_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['linkedin_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-linkedin.png" alt="LinkedIn icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['forrst_url'])  && $scrn['forrst_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['forrst_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-forrst.png" alt="Forrst icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['skype_url'])  && $scrn['skype_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['skype_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-skype.png" alt="Skype icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['dribbble_url'])  && $scrn['dribbble_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['dribbble_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-dribbble.png" alt="Dribbble icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['pinterest_url'])  && $scrn['pinterest_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['pinterest_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-pinterest.png" alt="Pinterest icon" /></a></li><?php } ?>
                        <?php if(isset($scrn['vimeo_url'])  && $scrn['vimeo_url'] != '') { ?><li><a target="_blank" href="<?php echo $scrn['vimeo_url'];?>"><img src="<?php echo get_template_directory_uri();?>/images/icn-vimeo.png" alt="Vimeo icon" /></a></li><?php } ?>
                    </ul>
                </div> <!-- end social -->
                <iframe width="!00%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.br/maps?f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=ua+Paschoal+Carlos+Magno,+100+-+Santa+Teresa,+Rio+de+Janeiro,+RJ.+BRASIL&amp;aq=&amp;sll=-22.921192,-43.187091&amp;sspn=0.011977,0.02105&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=R.+Paschoal+Carlos+Magno,+100+-+Santa+Teresa,+Rio+de+Janeiro,+20240-290&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
                
            </div> <!-- end eight columns -->
            
            <div class="clear"></div>
            
            
        </div> <!-- end container -->
        
    </div> <!-- end contact -->

    
    
<?php get_footer();?>