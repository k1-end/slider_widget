<script>
    jQuery(function($){
    var frame,
        addImgLink = $('.slider_widget_upload_banner_img_<?php echo $this->get_field_id("banner_attach_id"); ?>'),
        imageContainer = $('.slider_widget_wp_media_image_<?php echo $this->get_field_id("banner_attach_id"); ?>');
        
        // ADD IMAGE LINK
  addImgLink.on( 'click', function( event ){
    
    event.preventDefault();
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment URL to our custom image input field.
      imageContainer.html( '<img src="'+attachment.url+'" alt="" width="200" style="max-width:100%;"/>'  );
      $("#<?php echo $this->get_field_id("banner_attach_id"); ?>").val(attachment.id);
      
      $("#<?php echo $this->get_field_id("savewidget") ?>").prop("disabled" , false).val("save");
      



//      // Unhide the remove image link
//      delImgLink.removeClass( 'hidden' );
    });

    // Finally, open the modal on click
    frame.open();
  });
  });
</script>