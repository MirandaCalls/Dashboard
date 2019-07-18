<?php

namespace Dashboard\Model;

class ModelBase {

    protected $entity_manager;

    public function __construct() {
         $this->entity_manager = DatabaseInterface::get_instance();
    }

}