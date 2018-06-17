document.addEventListener( 'DOMContentLoaded', function() {
	var elems = document.querySelectorAll( '.modal' );
	var options = {};
	var instances = M.Modal.init( elems, options );

  elems = document.querySelectorAll( 'select' );
  options = { dropdownOptions: { container: document.body, constrainWidth: true } };
  instances = M.FormSelect.init( elems, options );

  $( '#item_description' ).characterCounter();

	$( '#btn_add_item' ).click( function() {
		var save_btn = $( '#btn_save_item' );
		save_btn.off();
		save_btn.click( function() {
			add_new_item();
		});
		$( '#item_form' )[0].reset();
	});

	$( '.btn-edit-item' ).click( function(e) {
		var data_id = $( e.currentTarget ).data( 'id' );
		var save_btn = $( '#btn_save_item' );
		save_btn.off();
		save_btn.click( function() {
			edit_item( data_id );
		});
		display_item( data_id );
	});


});

function display_item( item_id ) {
	var response = $.ajax({
		type : "GET",
		url : "api/inventory/items/" + item_id,
		success : function ( response ) {
			open_item( JSON.parse( response ) );
		}
	});
	var modal = M.Modal.getInstance( $( '#modal_add_item' ).get( 0 ) );
	modal.open();
}

function open_item( item ) {
	var item_form = $( '#item_form' );
	item_form.find( 'input[name="name"]' ).val( item.name );
	item_form.find( 'input[name="room_id"]' ).val( item.room_id );
	item_form.find( 'input[name="amount"]' ).val( item.amount );
	item_form.find( 'input[name="low_stock_amount"]' ).val( item.low_stock_amount );
	item_form.find( 'textarea[name="description"]' ).val( item.description );
	M.updateTextFields();
}

function add_new_item() {
	var new_item = {};
	var item_values = $( '#item_form' ).serializeArray();
	item_values.forEach( function( input_value ) {
		new_item[ input_value.name ] = input_value.value;
	});
	$.ajax({
		type : "POST",
		url : "api/inventory/items",
		data : JSON.stringify( new_item ),
		success : function ( response ) {
			window.location.reload( true );
		}
	});
}

function edit_item( item_id ) {
	var item = {};
	var item_values = $( '#item_form' ).serializeArray();
	item_values.forEach( function( input_value ) {
		item[ input_value.name ] = input_value.value;
	});
	$.ajax({
		type : "PUT",
		url : "api/inventory/items/" + item_id,
		data : JSON.stringify( item ),
		success : function ( response ) {
			window.location.reload( true );
		}
	});
}
