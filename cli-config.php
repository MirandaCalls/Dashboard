<?php

use Dashboard\Model\DatabaseInterface;

require_once "bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet( DatabaseInterface::get_instance() );