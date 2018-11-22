document.addEventListener( 'DOMContentLoaded', function() {
	$( '#table_items' ).DataTable({
		"scrollY": "420px",
  		"scrollCollapse": false,
		"language": {
    			"lengthMenu": "Show _MENU_"
  		},
		"columnDefs": [
    			{ "orderable": false, "targets": 3 }
  		]
	});

	var elems = document.querySelectorAll( '.modal' );
	var options = {};
	var instances = M.Modal.init( elems, options );

	elems = document.querySelectorAll( 'select' );
	options = { dropdownOptions: { container: document.body, constrainWidth: true } };
	instances = M.FormSelect.init( elems, options );

	$( '#btn_add_item' ).click( function() {
		$( '#item_form' )[0].reset();
		var save_btn = $( '#btn_save_item' );
		save_btn.off();
		save_btn.click( function() {
			add_new_item();
		});
		$( '#item_description' ).characterCounter();
		$( '#btn_delete_item' ).addClass( 'disabled' );
	});

	$( '#table_items' ).on( 'click', '.btn-edit-item', function(e) {
		var data_id = $( e.currentTarget ).data( 'id' );

		var save_btn = $( '#btn_save_item' );
		save_btn.off();
		save_btn.click( function() {
			save_item_changes( data_id );
		});

		var delete_btn = $( '#btn_delete_item' );
		delete_btn.removeClass( 'disabled' );
		delete_btn.click( function() {
			promptbox.prompt_user( 'Are you sure you want to delete this item?', function() {
				delete_item( data_id );
			});
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
		},
		error : function ( xhr, status, error ) {
			$( '#errors' ).html( '' );
			var errors = JSON.parse( xhr.responseText );
			errors.forEach( function( error ) {
				$( '#errors' ).append( '<p class="red-text darken-4">' + error + '</p>' );
			});
		}
	});
}

function open_item( item ) {
	var item_form = $( '#item_form' );
	item_form.find( 'input[name="name"]' ).val( item.name );
	item_form.find( 'input[name="room_id"]' ).val( item.room_id );
	item_form.find( 'input[name="amount"]' ).val( item.amount );
	item_form.find( 'input[name="low_stock_amount"]' ).val( item.low_stock_amount );
	item_form.find( 'textarea[name="description"]' ).val( item.description );
	M.updateTextFields();
	$( '#item_description' ).characterCounter();
	var modal = M.Modal.getInstance( $( '#modal_add_item' ).get( 0 ) );
	modal.open();
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

function save_item_changes( item_id ) {
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

function delete_item( item_id ) {
	$.ajax({
		type : "DELETE",
		url : "api/inventory/items/" + item_id,
		success : function ( response ) {
			window.location.reload( true );
		}
	});
}
