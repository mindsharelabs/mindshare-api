(function( root, $, undefined ) {
	"use strict";

	$(function () {

    $('.image-slider').slick({
      dots: true,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: 'linear',
			adaptiveHeight: true,
      nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
      prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
    });

  });


} ( this, jQuery ));
