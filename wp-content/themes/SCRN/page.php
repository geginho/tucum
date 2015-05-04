<?php 
get_header();
the_post(); 
$thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$fullwidth = get_post_meta($post->ID, '_individual_fullwidth', true);
?>
 <div class="bg dark-bg" style="text-align: left" id="blog">
    <div class="container">
        <div class="<?php if($fullwidth == 2) echo 'twelve'; else echo 'sixteen';?> columns">
            <div class="single-post">
                <div style="text-align: center">
                    <?php if(has_post_thumbnail() ) { ?>
                        <a href="<?php the_permalink();?>">
                            <?php
                            $thumb = aq_resize($thumbnail, 960, 300, true);
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
                        <?php if(isset($teo_data['show_metainfo']) && $teo_data['show_metainfo'] == false) { ?>
                            <p class="post-info">
                                <?php
                                _e('by', 'SCRN'); echo ' '; the_author_posts_link(); echo ' ';
                                 _e('on', 'SCRN'); echo ' '; the_time("d M, Y"); 
                                ?>
                            </p>
                        <?php } ?>
                    </a>
                </div>
                <?php the_content();?>
                <?php 
                edit_post_link(); 
                echo '<br />';
                ?>
            </div> <!-- end post -->
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