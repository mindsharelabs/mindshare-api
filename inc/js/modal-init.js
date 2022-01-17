(function( root, $, undefined ) {
	"use strict";



	$(function () {

    $(document).ready(function(){
      var mindModal = new bootstrap.Modal(document.getElementById('mindModal'), {
        keyboard: false
      });
      if(mindModalSettings.show) {
				var modalCookie = Cookies.get('mind-notice-modal');
				var modalid = $('#mindModal').data('modalid');
				if(modalCookie != modalid) {
					mindModal.show();
					Cookies.set('mind-notice-modal', modalid, { expires: 1 })
				}

      }



    });


  });


} ( this, jQuery ));
