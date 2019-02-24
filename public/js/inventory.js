let data_table = null;
let edited_row = null;
let deleted_rows = {};
let rooms = {};
let units = {};

document.addEventListener( 'DOMContentLoaded', function() {
	data_table = $( '#table_items' ).DataTable({
		scrollY: '420px',
  		scrollCollapse: false,
		language: {
			lengthMenu: 'Show _MENU_'
  		},
		columnDefs: [
			{ orderable: false, targets: 3 },
			{ className: 'dt-body-right', targets: -1 },
			{ className: 'dt-body-center', targets: 1 },
			{ className: 'dt-body-center', targets: 2 },
  		]
	});

	get_rooms();
	get_units();

	var elems = document.querySelectorAll( '.modal' );
	var options = {};
	var instances = M.Modal.init( elems, options );

	elems = document.querySelectorAll( 'select' );
	options = { dropdownOptions: { container: document.body, constrainWidth: true } };
	instances = M.FormSelect.init( elems, options );

	$( '#btn_add_item' ).click( function() {
		$( '#modal_header' ).text( 'Add Item' );
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
		edited_row = this.parentNode.parentNode;

		$( '#modal_header' ).text( 'Edit Item' );
		var data_id = $( e.currentTarget ).data( 'id' );

		var save_btn = $( '#btn_save_item' );
		save_btn.off();
		save_btn.click( function() {
			save_item_changes( data_id );
		});

		var delete_btn = $( '#btn_delete_item' );
		delete_btn.removeClass( 'disabled' );
		delete_btn.off();
		delete_btn.click( function() {
			queue_deletion( data_id );
		});

		display_item( data_id );
	});

});

function display_item( item_id ) {
	var response = $.ajax({
		type: "GET",
		url: "api/inventory/items/" + item_id,
		success: function ( response ) {
			open_item( JSON.parse( response ) );
		},
		error: function ( xhr, status, error ) {
			var errors = JSON.parse( xhr.responseText );
			errors.forEach( function( error ) {
				M.toast({html: 'Error: ' + error});
			});
		}
	});
}

function open_item( item ) {
	var item_form = $( '#item_form' );
	item_form.find( 'input[name="name"]' ).val( item.name );
	item_form.find( 'input[name="amount"]' ).val( item.amount );
	item_form.find( 'input[name="low_stock_amount"]' ).val( item.low_stock_amount );
	item_form.find( 'textarea[name="description"]' ).val( item.description );
	$( '#item_room' ).val( item.room_id ).prop( 'selected', true ).formSelect();
	$( '#unit_type' ).val( item.unit_id ).prop( 'selected', true ).formSelect();
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
			let new_item = JSON.parse( response );
			data_table.row.add([
				new_item.name,
				rooms[ new_item.room_id ].name,
				new_item.amount + ' (' + units[ new_item.unit_id ].abbreviation + ')',
				'<a href="#!" data-id="' + new_item.item_id + '" class="btn-edit-item"><i class="material-icons blue-grey-text darken-3">edit</i></a>'
			]).draw();
			let modal = M.Modal.getInstance( $( '#modal_add_item' ).get( 0 ) );
			modal.close();
			M.toast({html: 'Item Added'});
		},
		error: function ( xhr, status, error ) {
			var errors = JSON.parse( xhr.responseText );
			errors.forEach( function( error ) {
				M.toast({html: 'Error: ' + error});
			});
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
			let item_data = JSON.parse( response );
			data_table.row( edited_row ).data( [
				item_data.name,
				rooms[ item_data.room_id ].name,
				item_data.amount + ' (' + units[ item_data.unit_id ].abbreviation + ')',
				'<a href="#!" data-id="' + item_id + '" class="btn-edit-item"><i class="material-icons blue-grey-text darken-3">edit</i></a>'
			]).draw();
			let modal = M.Modal.getInstance( $( '#modal_add_item' ).get( 0 ) );
			modal.close();
			M.toast({html: 'Item Saved'});
		},
		error: function ( xhr, status, error ) {
			var errors = JSON.parse( xhr.responseText );
			errors.forEach( function( error ) {
				M.toast({html: 'Error: ' + error});
			});
		}
	});
}

function queue_deletion( item_id ) {
	deleted_rows[ item_id ] = edited_row;
	data_table.row( edited_row ).remove().draw();
	let modal = M.Modal.getInstance( $( '#modal_add_item' ).get( 0 ) );
	modal.close();
	M.toast({
		html: 'Deleted Item <button class="btn-flat toast-action" onclick="undo_deletion(this, ' + item_id + ')">Undo</button>',
		completeCallback: function() {
			delete_items();
		}
	});
}

function undo_deletion( event, item_id ) {
	M.Toast.getInstance( event.parentNode ).dismiss();
	data_table.row.add( deleted_rows[ item_id ] ).draw();
	delete deleted_rows[ item_id ];
}

function delete_items() {
	let ids_to_delete = Object.keys( deleted_rows );
	for ( id of ids_to_delete ) {
		$.ajax({
			type : "DELETE",
			url : "api/inventory/items/" + id,
			error: function ( xhr, status, error ) {
				var errors = JSON.parse( xhr.responseText );
				errors.forEach( function( error ) {
					M.toast({html: 'Error: ' + error});
				});
			}
		});
	}
	deleted_rows = {};
}

function get_rooms() {
	$.ajax({
		type: 'GET',
		url: 'api/inventory/rooms',
		success: function ( response ) {
			let json = JSON.parse( response );
			for ( ob of json ) {
				rooms[ ob.room_id ] = ob;
			}
		},
		error: function() {
			M.toast({html: 'Error: Unknown error.'});
		}
	});
}

function get_units() {
	$.ajax({
		type: 'GET',
		url: 'api/inventory/units',
		success: function ( response ) {
			let json = JSON.parse( response );
			for ( ob of json ) {
				units[ ob.unit_id ] = ob;
			}
		},
		error: function() {
			M.toast({html: 'Error: Unknown error.'});
		}
	});
}