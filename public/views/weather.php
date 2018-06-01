<?php
	$days = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday'
	);

	$day_of_week = date('N', strtotime());
?>
<h5>Weather Forcasts</h5>
<div class="row">
	<div class="col s12 m4">
		<div class="card">
			<div class="card-content">
				<span class="card-title">Right Now</span>
				<h4><?php echo $forcast_data['currently']['temperature'] ?>˚</h4>
				<p>Feels like <?php echo $forcast_data['currently']['apparentTemperature'] ?>˚</p>
				<p><?php echo $forcast_data['currently']['summary'] ?></p>
			</div>
		</div>
	</div>
	<div class="col m8">
		<div class="card">
			<div class="card-content">
				<span class="card-title">Weekly Forcast</span>
				<p><?php echo $forcast_data['daily']['summary'] ?></p>
				<ul class="collection">
					<?php
						foreach ( $forcast_data['daily']['data'] as $day ) {
							$day_of_week++;
							if ( $day_of_week > 7 ) {
								$day_of_week = 1;
							}
							echo '
								<li class="collection-item">' . $days[ $day_of_week ] . ' - ' . $day['summary'] . '</li>
							';
						}
					?>
			    </ul>
			</div>
		</div>
	</div>
</div>