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

	function get_weather_icon( $icon_name ) {
		switch ( $icon_name ) {
			case 'cloudy':
			case 'partly-cloudy-day':
			case 'partly-cloudy-night':
				return 'img/weather/cloudy.png';
			case 'rain':
				return 'img/weather/rainy.png';
			case 'wind':
				return 'img/weather/windy.png';
			default:
				return 'img/weather/sunny.png';
		}
	}
?>
<link type="text/css" rel="stylesheet" href="css/weather.css"/>
<script type="text/javascript" src="js/weather.js"></script>
<h5>Weather Forcasts</h5>
<div class="row">
	<div class="col s12 m4">
		<div class="card">
			<div class="card-content">
				<span class="card-title">Right Now</span>
				<div class="now-temp-container">
					<?php
					 	$icon = get_weather_icon( $forcast_data['currently']['icon'] );
						$temp_str = round( $forcast_data['currently']['temperature'] ) . '˚';
						echo "
							<img class='now-icon' src='$icon'/>
							<h4>$temp_str</h4>
						";
					?>
				</div>
				<p>Feels like <?php echo round( $forcast_data['currently']['apparentTemperature'] ) ?></p>
				<p><?php echo $forcast_data['currently']['summary'] ?> in Woodbury, MN</p>
			</div>
		</div>
		<div class="card">
			<div class="card-content">
				<span class="card-title">Next 12 Hours</span>
				<ul class="collection">
					<?php
						foreach ( $forcast_data['hourly']['data'] as $i => $hour ) {
							if ( $i > 11 ) {
								break;
							}

							$hour_str = date( 'g:i a', $hour['time'] );
							$icon = get_weather_icon( $hour['icon'] );
							$temp_str = round( $hour['temperature'] ) . '˚';
							echo "
								<li class='collection-item'>
									<img class='hourly-icon' src='$icon'/>
									<span>$hour_str</span>
									<span class='secondary-content'>$temp_str</span>
								</li>
							";
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col m8">
		<div class="card">
			<div class="card-content">
				<span class="card-title">Weekly Forcast</span>
				<p><?php echo $forcast_data['daily']['summary'] ?></p>
				<ul class="collapsible">
					<?php
						$first = $forcast_data['daily']['data'][0]['time'];
						foreach ( $forcast_data['daily']['data'] as $day ) {
							if ( $day_of_week > 7 ) {
								$day_of_week = 1;
							}
							$day_name = $first === $day['time'] ? 'Today' : $days[ $day_of_week ];
							$low_temp = round( $day['temperatureLow'] );
							$high_temp = round( $day['temperatureHigh'] );
							$summary = $day['summary'];
							$icon = get_weather_icon( $day['icon'] );
							$sunrise_time = date( 'g:i a', $day['sunriseTime'] );
							$sunset_time = date( 'g:i a', $day['sunsetTime'] );
							$precipitation_type = '' != $day['precipType'] ? '(' . $day['precipType'] . ')' : '';
							$precipication = ( $day['precipProbability'] * 100 ) . '% ' . $precipitation_type;
							$humidity = ( $day['humidity'] * 100 ) . '%';
							echo "
								<li class='collection-item'>
									<div class='collapsible-header'>
										<div class='forecast-icon-column'>
										     <img class='forecast-icon' src='$icon'/>
										</div>
										<div class='forecast-summary-column'>
											<span class='secondary-content right-align'>" . $low_temp . "˚ - " . $high_temp . "˚</span>
											<span>$day_name</span>
											<br>
											<span>$summary</span>
										</div>
									</div>
 									<div class='collapsible-body'>
										<p>Sunrise: $sunrise_time</p>
										<p>Sunset: $sunset_time</p>
										<p>Precipitation: $precipication</p>
										<p>Humidity: $humidity</p>
									</div>
								</li>
							";
							$day_of_week++;
						}
					?>
			    </ul>
			</div>
		</div>
		<div class="card">
			<div class="card-content">
				<span class="card-title">Precipitation Radar</span>
				<script src='https://darksky.net/map-embed/@radar,44.9422,-92.9494,8.js?embed=true&timeControl=true&fieldControl=false&defaultField=radar'></script>
			</div>
		</div>
	</div>
</div>
