(function( root, $, undefined ) {
	"use strict";



	$(function () {

    $(document).ready(function(){

      console.log(mindModalSettings.show);

      var mindModal = new bootstrap.Modal(document.getElementById('mindModal'), {
        keyboard: false
      });
      if(mindModalSettings.show) {
        mindModal.show();
      }








    });


  });


} ( this, jQuery ));
