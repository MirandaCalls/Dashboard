<?php

namespace Dashboard\Controller;

use \DateTime;
use \DateInterval;
use Dashboard\Entity\Host;
use Dashboard\Entity\SpeedLog;

class Controller_SpeedLog {

	private $entity_manager;
	
	public function __construct( $entity_manager ) {
		$this->entity_manager = $entity_manager;
	}

	/**
	 * Add Speed Test Host
	 * 
	 * @param  string $company
	 * @param  string $location
	 *
	 * @return Host
	 */
	public function add_speedtest_host( $server_id, $company, $location ) {
		$new_host = new Host();
		$new_host->set_server_id( (int) $server_id );
		$new_host->set_company( $company );
		$new_host->set_location( $location );
		
		$this->entity_manager->persist( $new_host );
		$this->entity_manager->flush();
		
		return $new_host;
	}
	
	/**
	 * Get Speed Test Host
	 * 
	 * @param  string $company
	 * @param  string $location
	 * 
	 * @return Host
	 */
	public function get_speedtest_host( $server_id ) {
		$dql = 'SELECT h FROM \Dashboard\Entity\Host h WHERE h.server_id = ?1';
		
		$query = $this->entity_manager->createQuery( $dql );
		$query->setParameter( 1, $server_id );
		$result = $query->getResult();
		
		if ( 0 == count( $result ) ) {
			return false;
		}
	
		return $result[0];
	}

	public function get_speedtest_hosts() {
		$repository = $this->entity_manager->getRepository( 'Dashboard\Entity\Host' );
		return $repository->findAll();
	}
	
	/**
	 * Run Speed Test
	 * 
	 * @return void
	 */
	public function run_speed_test( $serverId = false ) {
		$command = 'speedtest-cli --csv';
		if ( false !== $serverId ) {
			$command .= ' --server ' . $serverId;
		}

		$test_run = shell_exec( $command );
		$test_results = str_getcsv( trim( $test_run ) );
		
		$server_id = $test_results[0];
		$company_name = $test_results[1];
		$location = $test_results[2];
		$time = new DateTime();
		$down = (float) $test_results[6];
		$up = (float) $test_results[7];

		$host = $this->get_speedtest_host( $server_id );
		if ( false === $host ) {
			$host = $this->add_speedtest_host( $server_id, $company_name, $location );
		}

		$new_log = new SpeedLog();
		$new_log->set_host( $host );
		$new_log->set_connection_type( SpeedLog::CONN_ETHERNET_TYPE );
		$new_log->set_upload_speed( $up );
		$new_log->set_download_speed( $down );
		$new_log->set_time( $time );
		
		$this->entity_manager->persist( $new_log );
		$this->entity_manager->flush();
	}

	public function get_speed_logs() {
		$dql = 'SELECT s FROM \Dashboard\Entity\SpeedLog s WHERE s.time > :date ORDER BY s.time DESC';
		$query = $this->entity_manager->createQuery( $dql );

		$now = new DateTime();
		$now->sub( new DateInterval( 'P07D' ) );
		$query->setParameter( 'date', $now->format( 'Y-m-d' ) );
		return $query->getResult();
	}

}