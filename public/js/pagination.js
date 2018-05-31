var pagination = {

	table_id : '',

	current_page : 0,

	row_per_page : 10,

	table_data : [],

	init_table : function( tableId, dataArray ) {
		this.table_id = tableId;
		var total_pages = this.process_data( dataArray );
		this.init_selectors( total_pages );
		this.show_page( 1 );

		$( '.link-page' ).click( function() {
			page_num = $( this ).data( 'id' );
			$( '.link-page' ).parent().removeClass( 'active blue-grey' );
			$( this ).parent().addClass( 'active blue-grey' );
			pagination.show_page( page_num );
		});
	},

	init_selectors : function( pagesNum ) {
		var page_controls = $( '#page-selectors' );
		for( i = 1; i <= pagesNum; i++ ) {
			page_controls.append( '<li class="' + ( 1 == i ? 'active blue-grey' : '' ) + '"><a class="link-page" data-id="' + i + '">' + i + '</a></li>' );
		}
	},

	process_data : function( records ) {
		var total_pages = Math.floor( ( records.length + this.row_per_page - 1 ) / this.row_per_page );
		for( i = 1; i <= total_pages; i++ ) {
			var subset = records.splice( 0, this.row_per_page );
			this.table_data[ i ] = subset;
		}
		return total_pages;
	},

	show_page : function ( pageNum ) {
		this.clear_rows();
		this.add_rows( this.table_data[ pageNum ] );
	},

	add_rows : function( records ) {
		var new_rows_html = '';
		records.forEach( function( record ) {
			new_rows_html += '<tr>';
			new_rows_html += '<td>' + record.down + '</td>';
			new_rows_html += '<td>' + record.up + '</td>';
			new_rows_html += '<td>' + record.time + '</td>';
			new_rows_html += '<td>' + record.host_name + '</td>';
			new_rows_html += '<td>' + record.location + '</td>';
			new_rows_html += '</tr>';
		});
		$( this.table_id + ' > tbody' ).append( new_rows_html );
	},

	clear_rows : function() {
		$( this.table_id + ' > tbody' ).empty();
	}
}