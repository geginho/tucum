<?php
/* 
Template name: Blog ok
*/
get_header(mapa);
global $scrn;
the_post(); 
$nrposts = get_post_meta($post->ID, '_blog_nrposts', true);
$fullwidth = get_post_meta($post->ID, '_blog_fullwidth', true);
$categories = get_post_meta($post->ID, '_blog_categories', true);
?>
 <div class="bg dark-bg" style="text-align: left" id="blog">
    <div class="container">
        <div class="sixteen columns">
            <div class="headline">
                    <h2><span class="lines"><?php $top_title = get_post_meta($post->ID, 'top_title', true); if($top_title != '') echo $top_title; else the_title();?></span></h2>
            </div>
        </div>
        <div class="clear"></div>
        <!-- start sixteen columns -->
        <div class="<?php if($fullwidth == 2) echo 'twelve'; else echo 'sixteen';?> columns">
            <?php
            $args['posts_per_page'] = $nrposts;
            if(count($categories) > 0)
                $args['category__in'] = $categories;
            $paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
            $args['paged'] = $paged;
            query_posts($args);
            $i = 1;
            if(have_posts()) : while(have_posts()) : the_post();
                $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
                <div <?php post_class('post');?>>
                    <?php get_template_part('content');?>
                </div> <!-- end post -->
            <?php endwhile; 
            get_template_part('includes/pagination');
            endif; wp_reset_query();?>
        </div> <!-- end sixteen columns -->

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