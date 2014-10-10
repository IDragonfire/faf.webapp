<?php

namespace Model;

class Vote_Option extends \DB\SQL\Mapper {


  // Instantiate mapper
  function __construct( \DB\SQL $db ) {

    // This is where the mapper and DB structure synchronization occurs
    parent::__construct( $db, 'vote_option');
  }

  function getOptions($vote_id) {
    return $this->find( array(' vote_id = ? ', $vote_id ), array('order' => 'RAND()'));
  }

  function getFormattedOptions($vote_id, $parser) {
    $options = $this->getOptions($vote_id);
    foreach ($options as $value) {
      $value->text = $this->removePTags($parser->text($value->text));
    }
    return $options;
  }

  function removePTags($str) {
    $prefix = '<p>';
    if (substr($str, 0, strlen($prefix)) == $prefix) {
      $str = substr($str, strlen($prefix));
    } 
    $postfix = '</p>';
    if(substr($str, strlen($str) - strlen($postfix)) == $postfix) {
      $str = substr($str, 0, strlen($str) - strlen($postfix));
    }
    return $str;
  }

}
