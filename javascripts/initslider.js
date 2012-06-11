(function(){
    var init = function(){
      setupSliderPlugin();
      setupSlidingWithArrows();
    }

     var setupSliderPlugin = function(){
          var onSliderIndexUpdate = function(index,currentItem){
             // set active page
             jQuery('#frontpage-carousel-items a').removeClass('active');
             jQuery('#frontpage-carousel-items a:eq('+index+')').addClass('active');
          };

           var onSliderIndexUpdateStart = function(index,currentItem){
             // display active
             jQuery('#frontpage-carousel li').find('.carousel-blur').css("display","");
             jQuery(currentItem).find('.carousel-blur').css("display","none");
          };

          jQuery('#frontpage-carousel').slider( {
             'indexUpdateStart' : onSliderIndexUpdateStart,
             'indexUpdate' : onSliderIndexUpdate
          });
     }

    // enable the use of keys to navigate the carousel/slider
     var setupSlidingWithArrows = function(){

       var keys = {
          left_arrow:37,
          right_arrow:39
       };

       jQuery(document).keydown(function(e){
          if (e.keyCode == keys.left_arrow) {
              jQuery.slider.slide('left');
          } else if (e.keyCode == keys.right_arrow) {
             jQuery.slider.slide('right');
          }
      });
    }

    jQuery(document).ready( init );

}());

