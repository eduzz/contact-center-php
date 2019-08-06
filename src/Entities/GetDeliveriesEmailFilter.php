<?php

namespace Eduzz\ContactCenter\Entities;

class GetDeliveriesEmailFilter extends GetDeliveriesFilter
{
 public function __construct()
 {
  parent::__construct();
 }

 public function get()
 {
  if (empty($this->filter['_metadata'])) {
   unset($this->filter['_metadata']);
  }

  if (empty($this->filter['date'])) {
   unset($this->filter['date']);
  }

  return $this->filter;
 }

}
