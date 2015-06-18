<?php global $teo_data;?>
    <div id="footerblog">
        <div class="container">
            <div class="sixteen columns">
                <div class="copyright">
                    <p>&copy; <?php echo date("Y");?> <?php _e('Tucum Brasil', 'SCRN');?></p>
                </div>
            </div>  
        </div>
    </div>          
          
<!-- JS
    ================================================== -->
  
  <!-- fancybox -->
  <script type="text/javascript">
    function scrollTo(target){
          if(target != 0) {
            var myArray = target.split('#');
              var targetPosition = jQuery('#' + myArray[1]).offset().top;
              jQuery('html,body').animate({ scrollTop: targetPosition}, 'slow');
            }
        }
    jQuery(document).ready(function() {

        <?php 
        if(isset($teo_data['enable_slideshow']) && $teo_data['enable_slideshow']) {
            echo 'jQuery("#intro").backstretch( [';
                for($i=1; $i<=5; $i++) {
                    if(isset($teo_data['bg_image' . $i]['url']) && $teo_data['bg_image' . $i]['url'] != '') {
                        echo '"' . $teo_data['bg_image' . $i]['url'] . '",';
                    }
                }
            echo '], {duration: 3000, fade: 750});';
        }
        else if(isset($teo_data['bg_image1']['url']) && $teo_data['bg_image1']['url'] != '') { 
            echo 'jQuery("#intro").backstretch("' . $teo_data['bg_image1']['url'] . '");';
        }
        ?>

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
          

          jQuery('nav ul#menu-top-menu').mobileMenu({
               defaultText: '<?php _e("Navigate to...", "SCRN");?>',
               className: 'mobile-menu',
               subMenuDash: '&ndash;'
          });

    });
    
  </script>
    
    
<!-- End Document
================================================== -->

<?php 
if(isset($teo_data['integration_footer'])) echo $teo_data['integration_footer'] . PHP_EOL; ?>

 <?php wp_footer(); ?>
 
</body>
</html>