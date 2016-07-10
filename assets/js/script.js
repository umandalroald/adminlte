(function ($, Drupal, window, document, undefined) {


// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.bms_theme = {
  attach: function(context, settings) {

    if ($('.view-display-id-manage_employee').length) {
      $('.view-display-id-manage_employee input#edit-name').attr('placeholder', 'Enter Keyword ..');
      $('.view-display-id-manage_employee select#edit-title option:first-child').html('Filter by Area');
    }

  }
};


}(jQuery, Drupal, this, this.document));
