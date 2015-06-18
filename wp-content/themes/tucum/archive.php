<?php 
get_header(mapa);
?>
 <div class="bg dark-bg" style="text-align: left" id="blog">
    <div class="container">
        <div class="twelve columns">
            <?php
            $i = 1;
            if(have_posts()) : while(have_posts()) : the_post();
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
<?php get_footer('blog');?>