$( document ).ready( function() {
     $( '.tabs' ).tabs();

     $( '.save-config-btn' ).click( function() {
          var input_class = $( this ).data( 'class' );
          var config_key = $( this ).data( 'key' );
          var data = JSON.stringify( getConfigData( input_class ) );
          save_config( config_key, data );
     });
});

function getConfigData( fieldClass ) {
     var inputs = $( '.' + fieldClass ).toArray();
     var data = {};
     inputs.forEach( function( input ) {
          if ( 'checkbox' === $( input ).attr('type') ) {
               data[ input.name ] = $( input ).is( ':checked' );
          } else {
               data[ input.name ] = input.value;
          }
     });

     return data;
}

function save_config( key, data ) {
     $( '.chip' ).remove();
	$.ajax({
		type : "PUT",
		url : "api/configuration",
		data : JSON.stringify( { config_key: key, config_data: data } ),
          success : function ( response ) {
               $( '#container_chips' ).append('<div class="chip teal darken-2 white-text">Updated Successfully<i class="close material-icons">check</i></div>');
		}
	});
}
