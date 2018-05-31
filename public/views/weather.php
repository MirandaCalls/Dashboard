<div class="row">
	<div class="col m4">
		<div class="card">
			<div class="card-content">
				<span class="card-title">Temperature</span>
				<h3><?php echo $forcast_data['currently']['temperature'] ?>˚</h3>
				<p><?php echo $forcast_data['currently']['summary'] ?></p>
				<p>Feels like <?php echo $forcast_data['currently']['apparentTemperature'] ?>˚</p>
			</div>
		</div>
	</div>
</div>