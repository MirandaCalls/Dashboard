var promptbox = {

  prompt_user : function( message, callback ) {
    $( '#prompt_text' ).text( message );

    var accept_btn = $( '#btn_accept' );
    accept_btn.off();
    accept_btn.click( function() {
      callback();
      var modal = M.Modal.getInstance( $( '#modal_prompt' ).get( 0 ) );
      modal.close();
    });

    var modal = M.Modal.getInstance( $( '#modal_prompt' ).get( 0 ) );
    modal.open();
  }

}
