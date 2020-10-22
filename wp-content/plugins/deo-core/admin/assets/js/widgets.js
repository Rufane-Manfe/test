(function($) {
  "use strict";
  
  /* WordPress Media Uploader
  -------------------------------------------------------*/
  function widgetMediaUpload(type) {
    if ( mediaUploader ) {
      mediaUploader.open();
    }

    var mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Select an Image',
      button: {
        text: 'Use This Image'
      },
      multiple: false
    });

    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('.deo-' + type + '-hidden-input').val(attachment.url).trigger('change');
      $('.deo-' + type + '-media').attr('src', attachment.url);
    });
    mediaUploader.open();
  }


  // Logo Upload
  $('body').on('click', '.deo-logo-upload-button', function() {
    widgetMediaUpload('logo');
  });

  $('body').on('click', '.deo-logo2x-upload-button', function() {
    widgetMediaUpload('logo2x');
  });

  
  // Logo Delete
  $('body').on('click', '.deo-logo-delete-button', function() {
    $('.deo-logo-hidden-input').val('').trigger('change');
    $('.deo-logo-media').attr('src', '');
  });

  $('body').on('click', '.deo-logo2x-delete-button', function() {
    $('.deo-logo2x-hidden-input').val('').trigger('change');
    $('.deo-logo2x-media').attr('src', '');
  });

})(jQuery);