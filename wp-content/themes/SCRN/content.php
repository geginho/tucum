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
                                    ?>        <img src="<?php echo $thumb;?>" class="scale-with-grid" alt="<?php the_title();?>" />
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
    <div class="button1"><?php _e('Read more', 'SCRN');?></div>
</a>