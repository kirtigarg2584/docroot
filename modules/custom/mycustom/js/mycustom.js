(function ($, window, Drupal) {
 'use strict';


 Drupal.behaviors.mycustom = {
   attach: function (context, settings){
     alert(settings.mycustom.interest);
   }
 };
})(jQuery, window, Drupal);