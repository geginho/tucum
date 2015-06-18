<?php
/* 
Template name: Page Mapa
*/
get_header(mapa);
the_post(); 
?>
 <div class="bg-mapa">
          <?php the_content();?>
</div>
<?php get_footer('blog');?>