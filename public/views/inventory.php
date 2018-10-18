<script type="text/javascript" src="js/inventory.js"></script>
<script type="text/javascript" src="js/promptbox.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/inventory.css"/>
<link type="text/css" rel="stylesheet" href="css/datatables.css"/>
<h5>Inventory</h5>
<div class="divider"></div>
<div class="section">
	<div id="errors"></div>
	<div class="row">
		<div class="col s9">
			<div class="card">
				<table id="table_items" class="data-table highlight">
					<thead>
						<tr>
							<th>Name</th>
							<th>Room</th>
							<th>Amount</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ( $items as $item ) {
								$id = $item->get_id();
								$name = $item->get_name();
								$amount = $item->get_amount();
								$room_name = $item->get_room()->get_name();
								echo "
									<tr>
										<td>$name</td>
										<td><i>$room_name</i></td>
										<td>$amount</td>
										<td><a href='#!' data-id='$id' class='btn-edit-item'><i class='material-icons blue-grey-text darken-3'>edit</i></a></td>
									</tr>
								";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col s3">
			<div class="card">
				<div class="collection">
					<p class="collection-item">Preferences</p>
					<a id="btn_add_item" class="collection-item modal-trigger" href="#modal_add_item"><i class="material-icons left">add</i>Add Item</a>
					<a href="#!" class="collection-item"><i class="material-icons left">room</i>Manage Rooms</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modal_add_item" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="row">
			<h5 class="modal-header">Edit Item</h5>
			<span class="modal-close close-popup-btn right"><i class="material-icons">close</i></span>
		</div>
		<div class="divider"></div>
		<div class="section">
			<form id="item_form">
				<div class="input-field col">
			          <input id="item_name" name="name" type="text">
			          <label for="item_name">Name</label>
			     </div>
				<div class="input-field col">
					<select id="item_room" name="room_id">
						<?php
							foreach ( $rooms as $room ) {
								$room_id = $room->get_id();
								$room_name = $room->get_name();
								echo "
									<option value='$room_id'>$room_name</option>
								";
							}
						?>
					</select>
					<label for="item_room">Room</label>
				</div>
				<div class="input-field col">
					<input id="item_amount" name="amount" type="text">
					<label for="item_amount">Amount</label>
				</div>
				<div class="input-field col">
					<input id="item_low_amount" name="low_stock_amount" type="text">
					<label for="item_low_amount">Low Amount</label>
				</div>
				<div class="input-field col">
					<textarea id="item_description" name="description" class="materialize-textarea" data-length="500"></textarea>
					<label for="item_description">Description</label>
				</div>
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<a id="btn_save_item" class="waves-effect waves-light btn left"><i class="material-icons left">save</i>Save</a>
		<a id="btn_delete_item" class="waves-effect waves-light btn red lighten-2 right"><i class="material-icons left">delete</i>Delete</a>
	</div>
</div>
<div id="modal_prompt" class="modal prompt-modal">
	<div class="modal-content">
		<div class="center-align">
			<p id="prompt_text"></p>
			<a id="btn_accept" class="waves-effect waves-light btn"><i class="material-icons left">check</i>Accept</a>
			<a id="btn_cancel" class="modal-close waves-effect waves-light btn red lighten-2"><i class="material-icons left">cancel</i>Cancel</a>
		</div>
	</div>
</div>
