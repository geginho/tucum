<?php 
get_header();
?>
<div class="bg dark-bg" style="text-align: left" id="blog">
    <div class="container">
        <div class="sixteen columns">
            <div class="headline">
                <h2><span class="lines"><?php printf( __( 'Search Results for: %s', 'SCRN' ), get_search_query() ); ?></span></h2>
            </div>
        </div>

        <div class="clear"></div>

        <div class="twelve columns">
            <?php
            $i = 1;
            if(have_posts()) : while(have_posts()) : the_post();
                $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
                <div <?php post_class('post');?>>
                    <?php get_template_part('content');?>
                </div> <!-- end post -->
            <?php endwhile;
            get_template_part('includes/pagination');
            endif; wp_reset_query();?>
        </div> <!-- end twelve columns -->

        <!-- start sidebar -->
        <div class="four columns">
            <div class="sidebar">
                <?php dynamic_sidebar("Right sidebar");?>
            </div>
        </div>
        <!-- end sidebar -->
    </div>
</div>
<?php get_footer();?>