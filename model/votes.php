<?php

namespace Model;

class Votes extends \DB\SQL\Mapper {

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'votes ');
  }
}
