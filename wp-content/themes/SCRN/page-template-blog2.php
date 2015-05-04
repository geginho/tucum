<?php
/* 
Template name: Blog page template
*/
get_header();
global $scrn;
the_post(); 
$nrposts = get_post_meta($post->ID, '_blog_nrposts', true);
$fullwidth = get_post_meta($post->ID, '_blog_fullwidth', true);
$categories = get_post_meta($post->ID, '_blog_categories', true);
?>
 <div class="bg dark-bg" style="text-align: left" id="blog">
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
            <!-- start sidebar -->
            <div class="four columns">
                <div class="sidebar">
                    <?php dynamic_sidebar("Right sidebar"); ?>
                </div>
            </div>
            <!-- end sidebar -->
        <?php } ?>

    </div>
</div>
<?php get_footer();?>