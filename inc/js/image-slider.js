(function( root, $, undefined ) {
	"use strict";



	$(function () {

    $(document).ready(function(){
			console.log(sliderDots);
      $('.mapi-slider-container').slick({
				dots : sliderDots,
				arrows : sliderArrows,
        // setting-name: setting-value

				nextArrow: $('.mapi-slide-next'),
				prevArrow: $('.mapi-slide-prev'),
				appendDots: $(".mapi-slide-dots"),
      });
    });


  });


} ( this, jQuery ));
