    <div id="footer">
        <div class="container">
            <div class="sixteen columns rodape">
                <div class="copyright sixteen columns">
                    <div class="centro nine columns">
                      <p>&copy; <?php the_time("Y");?> <?php _e('Tucum', 'SCRN');?></p>
                      <?php //wp_nav_menu( array( 'menu' => 'rodape', 'sort_column' => 'menu_order' ) ); ?>
                    </div>
                </div>
            </div>  
        </div>
    </div>          
          
<!-- JS
    ================================================== -->
  
  <!-- fancybox -->
  <script type="text/javascript">
    function scrollTo(target){
          var myArray = target.split('#');
          var targetPosition = jQuery('#' + myArray[1]).offset().top;
          jQuery('html,body').animate({ scrollTop: targetPosition}, 'slow');
        }
    jQuery(document).ready(function() {

        jQuery("nav").sticky({topSpacing:0});

        /* This is basic - uses default settings */
      
        jQuery("a[class^='prettyPhoto']").prettyPhoto({
            social_tools: false,
            theme: 'light_square'
          });
      
        /* Using custom settings */
      
        jQuery('.proj-img').hover(function() {
            jQuery(this).find('i').stop().animate({
              opacity: 0.8
            }, 'fast');
            jQuery(this).find('a').stop().animate({
              "top": "0"
            });
          }, function() {
            jQuery(this).find('i').stop().animate({
              opacity: 0
            }, 'fast');
            jQuery(this).find('a').stop().animate({
              "top": "-600px"
            });
        });

          jQuery('.flexslider').flexslider({
            animation: "slide",
            slideshow: true,
            slideshowSpeed: 3500,
            animationSpeed: 1000
          });

          jQuery('nav ul').mobileMenu({
               defaultText: '<?php _e("Navigate to...", "SCRN");?>',
               className: 'mobile-menu',
               subMenuDash: '&ndash;'
          });

    });
    
  </script>
    
    
<!-- End Document
================================================== -->

<?php global $scrn;
if(isset($scrn['integration_footer'])) echo $scrn['integration_footer'] . PHP_EOL; ?>

 <?php wp_footer(); ?>
 
</body>
</html>