jQuery(window).load(function() {
  jQuery('.filterable_portfolio').isotope({
     // options
      itemSelector : '.item',
  });

  jQuery('.filterable_portfolio').isotope({ filter: "*" });

  //filtering
  jQuery('.filter-categories a').click(function(){
    jQuery('.filter-categories a').removeClass('selected');
      var selector = jQuery(this).attr('data-filter');
      jQuery(this).addClass('selected');
    jQuery('.filterable_portfolio').isotope({ filter: selector });
    return false;
  });

  jQuery("a.portf-load").on('click', function(e) {
    e.preventDefault();
    var url = jQuery(this).attr("href");
    jQuery.get(url, function(data) {
      jQuery(".portfolio_details").show(600).html(data);
      var scrollTarget = jQuery(".portfolio_details").offset().top;
          jQuery('html,body').animate({scrollTop:scrollTarget-80}, 1000, "swing");
    });
  });
}); 

// jQuery(document).ready(function(){

// linkvelho = $(".wp-pagenavi > a").attr('href');
// linknovo = $('.wp-pagenavi > a').href = linkvelho + "#tecendo-a-rede";
//       this.href = this.href.replace(linkvelho, linknovo);
//    $('.wp-pagenavi > a').each(function()
//    { 
//       this.href = this.href.replace(linkvelho, linknovo);
//    });

// }); 

jQuery(window).load(function() {
  // Ajax-fetching "Load more posts"
   $('.wp-pagenavi a').live('click', function(e) {
    e.preventDefault();
    //$(this).addClass('loading').text('Loading...');
           //$('.load_more_text a').html('Loading...');
    $.ajax({
        type: "GET",
        url: $(this).attr('href') + '#main_container',
        dataType: "html",
        success: function(out) {
            result = $(out).find('#load_posts_container .item-projeto');
            nextlink = $(out).find('.wp-pagenavi a').attr('href');
                           //alert(nextlink);
            //$('#boxes').append(result).masonry('appended', result);
                       $('#load_posts_container .item-projeto').replaceWith(result);
            //$('.fetch a').removeClass('loading').text('Load more posts');
                           //$('.load_more_text a').html('Load More');


            // if (nextlink != undefined) {
            //     $('.wp-pagenavi a').attr('href', nextlink);
            // } else {
            //     $('.wp-pagenavi').remove();
            //                        $('#load_posts_container').append('<div class="clear"></div>');
            //                      //  $('.load_more_cont').css('visibilty','hidden');
            // }

            //            if (nextlink != undefined) {
            //                $.get(nextlink, function(data) {
            //                  //alert(nextlink);
            //                  if($(data + ":contains('item-projeto')") != '') {
            //                    //alert('not found');
            //                      //                      $('.load_more_cont').remove();
            //                                            $('#load_posts_container').append('<div class="clear"></div>');        
            //                  }
            //                });                        
            //            }

        }
    });
   });
});