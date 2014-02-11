<?php

namespace Model;

class Seen_Messages extends \DB\SQL\Mapper {

  const SEEN_TYPE_UNREAD = 0; // default value, normally no need to set 
  const SEEN_TYPE_READ = 1;
  const SEEN_TYPE_DELETED = 2;

  // Instantiate mapper
  function __construct( \DB\SQL $db ) {
  
    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'seen_messages');
  }
    
}
