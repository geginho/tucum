<?php 

get_header();

the_post(); 

$image1 = get_post_meta($post->ID, '_projetos_image1', 960, true);
$image2 = get_post_meta($post->ID, '_projetos_image2', 960, true);
$image3 = get_post_meta($post->ID, '_projetos_image3', 960, true);
$image4 = get_post_meta($post->ID, '_projetos_image4', 960, true);
$image5 = get_post_meta($post->ID, '_projetos_image5', 960, true);
$image6 = get_post_meta($post->ID, '_projetos_image6', 960, true);
global $wp_embed;
if($image1 != '' || $video1 != '') {

?>

 <div class="bg" style="text-align: left">
  <?php
      if (isset($image1)) {
        $image1 = str_replace('.jpg', '-960x370.jpg', $image1);
      } else {
        $image1 = $image1;
      } 

      if (isset($image2)) {
        $image2 = str_replace('.jpg', '-960x370.jpg', $image2);
      } else {
        $image2 = $image2;
      }
        
      if (isset($image3)) {
        $image3 = str_replace('.jpg', '-960x370.jpg', $image3);
        } else {
          $image3 = $image3;
        }  
        
      if (isset($image4)) {
        $image4 = str_replace('.jpg', '-960x370.jpg', $image4);
        } else {
          $image4 = $image4;
        }  
        
      if (isset($image5)) {
        $image5 = str_replace('.jpg', '-960x370.jpg', $image5);
        } else {
          $image5 = $image5;
        }  
        
      if (isset($image6)) {
        $image6 = str_replace('.jpg', '-960x370.jpg', $image6);
        } else {
          $image6 = $image6;
        }  
  
  ?>
    <div class="container">

            <h2><span class="lines"><?php $top_title = get_post_meta($post->ID, 'top_title', true); if($top_title != '') echo $top_title; else the_title();?></span></h2>

            <div>
              <div class="portfolio-item">
                <div class="flexslider flex-viewport flexslider2">
                  <ul class="slides">
                    <?php
                    if($image1 != '')
                      echo '<li><img src="' . $image1 . '" alt="" /></li>';

                    if($image2 != '')
                      echo '<li><img src="' . $image2 . '" alt="" /></li>';

                    if($image3 != '')
                      echo '<li><img src="' . $image3 . '" alt="" /></li>';

                    if($image4 != '')
                      echo '<li><img src="' . $image4 . '" alt="" /></li>';

                    if($image5 != '')
                      echo '<li><img src="' . $image5 . '" alt="" /></li>';

                    if($image6 != '')
                      echo '<li><img src="' . $image6 . '" alt="" /></li>';
                    ?>
                  </ul>
                </div><!-- end flexslider -->
              </div> <!-- end portfolio-item -->
            </div> <!-- end two-thirds columns -->

            <div class="single eleven columns">

                  <?php the_content();?>

                  <?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Tharsis').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

                  <div class="tags">

                     <?php the_tags(esc_attr('Tags: ', 'SCRN') . '<div class="button1">', '</div> <div class="button1">', '</div><br />'); ?> 

                  </div>

                  <?php 

                  edit_post_link(); 

                  ?>

             </div>
               <!-- start sidebar -->
              <div class="five columns sidebar">
                  <?php dynamic_sidebar("Projetos Sidebar");?>
              </div>
              <!-- end sidebar -->

    </div>

</div>
<?php } ?>
<?php get_footer();?>