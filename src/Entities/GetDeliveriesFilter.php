<?php

namespace Eduzz\ContactCenter\Entities;

abstract class GetDeliveriesFilter
{
  protected $producerId;
  protected $contentId;
  protected $application;
  protected $track;
  protected $initDate;
  protected $endDate;
  protected $status;
  protected $metadata;
  protected $filter;
  
  public function __construct()
  {
    $this->producerId = null;
    $this->contentId = null;
    $this->application = null;
    $this->track = null;
    $this->initDate = null;
    $this->endDate = null;
    $this->status = null;
    $this->metadata = null;

    $this->filter = [];
    $this->filter['_metadata'] = [];
    $this->filter['date'] = [];
  }

  public function byProducerId(string $producerId) 
  {
      $this->producerId = $producerId;
      $this->filter['_metadata']['producer_id'] = $this->producerId;
      return $this;
  }
  
  public function byApplication(string $application) 
  {
      $this->application = $application;
      $this->filter['_metadata']['application'] = $this->application;
      return $this;
  }

  public function byContent(string $contentId) 
  {
      $this->contentId = $contentId;
      $this->filter['_metadata']['content_id'] = $this->contentId;
      return $this;
  }

  public function byTrack(string $track) 
  {
      $this->track = $track;
      $this->filter['_metadata']['track'] = $this->track;
      return $this;
  }

  public function byDate(float $initDate = null, float $endDate = null) 
  {
        if ($initDate) {
            $this->initDate = $initDate;
            $this->filter['date']['init'] = $this->initDate;
        }
        if ($endDate) {
            $this->endDate = $endDate;
            $this->filter['date']['end'] = $this->endDate;
        }
      return $this;
  }

  public function byStatus(string $status) 
  {
      $this->status = $status;
      $this->filter['status'] = $this->status;
      return $this;
  }

  public function byCustomMetadata(array $metadata) 
  {
      $this->metadata = $metadata;
      $this->filter['_metadata'] = array_merge($this->filter['_metadata'], $metadata);
      return $this;
  }

  public function orderBy(array $orderBy) 
  {
      $this->orderBy = $orderBy;
      $this->filter['order_by'] = $this->orderBy;
      return $this;
  }

  public function page(int $page) 
  {
      $this->page = $page;
      $this->filter['page'] = $this->page;
      return $this;
  }

  public function size(int $size) 
  {
      $this->size = $size;
      $this->filter['size'] = $this->size;
      return $this;
  }

  abstract public function get();
  
}