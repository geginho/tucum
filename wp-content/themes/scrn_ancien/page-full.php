<?php
/* 
Template name: Full width page template
*/
get_header();
the_post(); 
?>
 <div class="bg" style="text-align: left">
    <div class="container">
            <div class="headline">
                    <h2>
                        <span class="lines">
                            <?php $top_title = get_post_meta($post->ID, 'top_title', true); 
                            if($top_title != '') 
                                echo $top_title; 
                            else the_title();?>
                        </span>
                    </h2>
                     <p class="singlemeta">
                        <?php _e('Posted on', 'SCRN');?> 
                        <?php the_time("d M Y");?> 
                        <?php comments_popup_link(esc_html__('0 comments','Tharsis'), esc_html__('1 comment','Tharsis'), '% '.esc_html__('comments','Tharsis')); ?>
                    </p>
            </div>
            <div class="single">
                  <?php the_content();?>
                  <?php 
                  edit_post_link(); 
                  comments_template('', true);?>
             </div>
    </div>
</div>
<?php get_footer();?>