document.addEventListener( 'DOMContentLoaded', function() {
	var elems = document.querySelectorAll( '.fixed-action-btn' );
	var options = { hoverEnabled: false };
	var instances = M.FloatingActionButton.init( elems, options );

	elems = document.querySelectorAll( '.modal' );
	options = {};
	instances = M.Modal.init( elems, options );

	elems = document.querySelectorAll( 'select' );
	options = { dropdownOptions: { container: document.body, constrainWidth: true } };
	instances = M.FormSelect.init( elems, options );

	$( '#btn-run-test' ).click( function() {
		run_speed_test( this );
	});

	pagination.init_table( '#table-log', log_records );
});

function run_speed_test( runButton ) {
	$( runButton ).hide();
	$( '#contain-select-server' ).hide();
	$( '#progress-run-test' ).show();

	var server_id = $( '#select-server-id' ).val();
	$.ajax({
		type : "POST",
		url : "api/speedlogs",
		data : JSON.stringify({
			server_id : server_id
		}),
		success : function ( response ) {
			window.location.reload( true );
		}
	});
}