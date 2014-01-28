<?php

namespace iATS;

/**
 * Class Service
 */
class Service {
  public $endpoint = '';
  public $method = '';
  public $result = '';
  public $format = '';
  public $restrictedservers = array();

  /**
   *
   */
  public function __construt(){
    $this->restricted_servers = $this->restrictedservers;
  }
}