(function( root, $, undefined ) {
	"use strict";



	$(function () {

    $(document).ready(function(){
			$('.mapi-slider-container').each(function(i, e) {

				var sliderDots = JSON.parse($(e).attr('dots'));
				var sliderArrows = JSON.parse($(e).attr('arrows'));
				var sliderID = $(e).attr('data-id');

				$(e).slick({
					dots : sliderDots,
					arrows : sliderArrows,
	        // setting-name: setting-value

					nextArrow: $('#' + sliderID + ' .mapi-slide-next'),
					prevArrow: $('#' + sliderID + ' .mapi-slide-prev'),
					appendDots: $('#' + sliderID + ' .mapi-slide-dots'),
	      });
			});

    });


  });


} ( this, jQuery ));
