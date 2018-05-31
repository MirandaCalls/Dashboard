<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

date_default_timezone_set( 'America/Chicago' );

/* Create a simple "default" Doctrine ORM configuration for Annotations */
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration( array( __DIR__ . "/src/Entity" ), $isDevMode );

/* Database configuration parameters */
$conn = array(
	'driver' => 'pdo_sqlite',
	'path' => '/home/pi/Data/homedashboard.sqlite'
);

$entity_manager = EntityManager::create( $conn, $config );