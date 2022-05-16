(function( root, $, undefined ) {
	"use strict";



	$(function () {

    $(document).ready(function(){
			$('.mind-image-slider .mapi-slider-container').each(function(i, e) {
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


			$('.mind-logo-slider .mapi-slider-container').each(function(i, e) {

				var sliderID = $(e).attr('data-id');

				$(e).slick({
					dots : false,
					arrows : false,
					infinite : true,
					slidesToShow: 6,
					slidesToScroll: 3,
					// setting-name: setting-value
					responsive: [
				    {
				      breakpoint: 1024,
				      settings: {
				        slidesToShow: 4,
				        slidesToScroll: 2,
				        infinite: true,
				        dots: false
				      }
				    },
				    {
				      breakpoint: 600,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 1
				      }
				    },

				    // You can unslick at a given breakpoint now by adding:
				    // settings: "unslick"
				    // instead of a settings object
				  ]
				});
			});




    });


  });


} ( this, jQuery ));
