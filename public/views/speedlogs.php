<script type="text/javascript">
	<?php
		$formatted_logs = array();
		foreach ( $logs as $log ) {
			$formatted_record = array();
			$formatted_record['down'] = $log->get_download_speed( true );
			$formatted_record['up'] = $log->get_upload_speed( true );
			$formatted_record['time'] = $log->get_time()->format( 'Y-m-d H:i' );
			$formatted_record['host_name'] = $log->get_host()->get_name();
			$formatted_record['location'] = $log->get_host()->get_location();
			$formatted_logs[] = $formatted_record;
		}

		echo "var log_records = " . json_encode( $formatted_logs );
	?>
</script>
<link type="text/css" rel="stylesheet" href="css/speedlogs.css"/>
<script type="text/javascript" src="js/speedlogs.js"></script>
<script type="text/javascript" src="js/pagination.js"></script>
<h5>Logs</h5>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="input-field col s6">
			<select>
				<option value="0">Last 7 Days</option>
				<option value="1">Custom Range</option>
			</select>
			<label>Date Range</label>
		</div>
	</div>
	<div class="row">
		<table id="table-log" class="striped centered responsive-table">
			<thead>
				<tr>
					<th>Download</th>
					<th>Upload</th>
					<th>Log Time</th>
					<th>Host</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	<div class="row">
		<ul id="page-selectors" class="pagination right">
		</ul>
	</div>
</div>
<div class="divider"></div>
<div class="fixed-action-btn click-to-toggle">
	<a class="btn-floating btn-large blue-grey">
		<i class="large material-icons">build</i>
	</a>
	<ul>
		<li><a class="modal-trigger btn-floating" href="#modal-run-test"><i class="material-icons">add</i></a></li>
		<li><a class="btn-floating"><i class="material-icons">arrow_downward</i></a></li>
	</ul>
</div>
<div id="modal-run-test" class="modal">
	<div class="modal-content">
		<h5>Run Speed Test</h5>
		<div class="divider"></div>
		<p>Run a speedtest using speedtest-cli on the Dashboard server.  Currently, only ethernet tests are available.</p>
		<div class="section">
			<div id="contain-select-server" class="input-field col s12">
				<select id="select-server-id">
					<option value="0" selected>Default</option>
					<?php
						foreach ( $hosts as $host ) {
							$server_id = $host->get_server_id();
							$location = $host->get_location();
							$company = $host->get_name();
							echo "
								<option value='$server_id'>$location - $company</option>
							";
						}
					?>
				</select>
				<label for="select-server-id">Speedtest Server</label>
			</div>
			<a class="waves-effect waves-light btn" id="btn-run-test">Run</a>
			<div id="progress-run-test" class="progress" style="display: none;">
				<div class="indeterminate"></div>
			</div>
		</div>
	</div>
</div>
