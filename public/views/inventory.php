<script type="text/javascript" src="js/inventory.js"></script>
<h5>Inventory</h5>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="input-field col s6">
			<i class="material-icons prefix">search</i>
			<input id="search-item-name" type="text">
			<label for="search-item-name">Search for item</label>
		</div>
		<div class="input-field col s6 right-align">
			<a id="btn_add_item" class="waves-effect waves-light btn modal-trigger" href="#modal_add_item"><i class="material-icons left">add</i>Add Item</a>
		</div>
	</div>
	<ul id="item_list" class="collection">
		<?php
			foreach ( $items as $item ) {
				$id = $item->get_id();
				$name = $item->get_name();
				$amount = $item->get_amount();
				$room_name = $item->get_room()->get_name();
				echo "
					<li class='collection-item avatar'>
						<span class='title'>$name</span>
						<p>Amount: $amount<br>
					 	  <i>$room_name</i>
						</p>
						<a href='#!' data-id='$id' class='btn-edit-item secondary-content'><i class='material-icons'>edit</i></a>
					</li>
				";
			}
		?>
	</ul>
</div>
<div id="modal_add_item" class="modal">
	<div class="modal-content">
		<div class="row">
			<h5 class="modal-header">Edit Item</h5>
			<span class="modal-close right"><i class="material-icons">close</i></span>
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
								$name = $room->get_name();
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
			<a id="btn_save_item" class="waves-effect waves-light btn"><i class="material-icons left">save</i>Save</a>
		</div>
	</div>
</div>
