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
	$day_of_week = date( 'N', time() );
?>
<link type="text/css" rel="stylesheet" href="css/weather.css"/>
<h5>Weather Forcasts</h5>
<div class="row">
	<div class="col s12 m4">
		<div class="card">
			<div class="card-content">
				<span class="card-title">Right Now</span>
				<h4><?php echo $forcast_data['currently']['temperature'] ?>˚</h4>
				<p>Feels like <?php echo $forcast_data['currently']['apparentTemperature'] ?>˚</p>
				<p><?php echo $forcast_data['currently']['summary'] ?> in Woodbury, MN</p>
			</div>
		</div>
		<div class="card">
			<div class="card-content">
				<span class="card-title">Precipitation Radar</span>
				<script src='https://darksky.net/map-embed/@radar,44.9422,-92.9494,8.js?embed=true&timeControl=true&fieldControl=false&defaultField=radar'></script>
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
						$first = $forcast_data['daily']['data'][0]['time'];
						foreach ( $forcast_data['daily']['data'] as $day ) {
							if ( $day_of_week > 7 ) {
								$day_of_week = 1;
							}
							$day_name = $first === $day['time'] ? 'Today' : $days[ $day_of_week ];
							$low_temp = $day['temperatureLow'];
							$high_temp = $day['temperatureHigh'];
							$summary = $day['summary'];
							echo "
								<li class='collection-item'>
									<span class='span-weekly-day'>$day_name</span>
									<span class='secondary-content'>" . $low_temp . "˚ - " . $high_temp . "˚</span>
									<br>
									<span>$summary</span>
								</li>
							";
							$day_of_week++;
						}
					?>
			    </ul>
			</div>
		</div>
	</div>
</div>