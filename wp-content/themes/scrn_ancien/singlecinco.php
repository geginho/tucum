<?php 

get_header();

the_post(); 

?>

 <div class="bg" style="text-align: left">

    <div class="container">

            <h2><span class="lines"><?php $top_title = get_post_meta($post->ID, 'top_title', true); if($top_title != '') echo $top_title; else the_title();?></span></h2>

            <p class="singlemeta">

                <?php _e('Posted on', 'SCRN');?> 

                <?php the_time("d M Y");?> 

                in <?php the_category(', ') ?> | 

                <?php comments_popup_link(esc_html__('0 comments','Tharsis'), esc_html__('1 comment','Tharsis'), '% '.esc_html__('comments','Tharsis')); ?>

            </p>

            <div class="single">

                  <?php the_content();?>

                  <?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Tharsis').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

                  <div class="tags">

                     <?php the_tags(esc_attr('Tags: ', 'SCRN') . '<div class="button1">', '</div> <div class="button1">', '</div><br />'); ?> 

                  </div>

                  <?php 

                  edit_post_link(); 

                  comments_template('', true);?>

             </div>

    </div>

</div>

<?php get_footer();?>