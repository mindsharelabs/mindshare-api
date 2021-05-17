(function( root, $, undefined ) {
	"use strict";



	$(function () {

    $(document).ready(function(){
			console.log(sliderDots);
      $('.image-slider').slick({
				dots : sliderDots,
				arrows : sliderArrows,
        // setting-name: setting-value
        prevArrow : '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
        nextArrow : '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>'
      });
    });


  });


} ( this, jQuery ));
