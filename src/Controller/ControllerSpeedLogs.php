<?php

use Dashboard\View\ViewSpeedLogs;
use Dashboard\Model\ModelSpeedLog;

$klein->respond( 'GET', '/speedlogs', function( $request ) {
	$log_controller = new ModelSpeedLog();
	$logs = $log_controller->get_speed_logs();
	$hosts = $log_controller->get_speedtest_hosts();
	$view = new ViewSpeedLogs( $logs, $hosts );
	return $view->generate_html_for_page();
});

$klein->respond( 'POST', '/api/speedlogs', function( $request ) {
	$params = json_decode( $request->body(), true );
	$server_id = $params['server_id'] != 0 ? $params['server_id'] : false;
	$log_controller = new ModelSpeedLog();
	$log_controller->run_speed_test( $server_id );
});