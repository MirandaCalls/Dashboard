<h5>Inventory Items</h5>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="input-field col s9">
			<i class="material-icons prefix">search</i>
			<textarea id="search-item-name" class="materialize-textarea"></textarea>
			<label for="search-item-name">Search for item . . .</label>
			
		</div>
	</div>
	<ul class="collection">
		<?php
			foreach ( $items as $item ) {
				$name = $item->get_name();
				$amount = $item->get_amount();
				$room_name = $item->get_room()->get_name();
				echo "
					<li class='collection-item avatar'>
						<span class='title'>$name</span>
						<p>Amount: $amount<br>
					 	  <i>$room_name</i>
						</p>
						<a href='#!' class='secondary-content'><i class='material-icons'>edit</i></a>
					</li>
				";
			}
		?>
	</ul>
</div>