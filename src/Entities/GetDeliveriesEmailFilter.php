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
<<<<<<< HEAD
        if (empty($this->filter['_metadata']))
=======
        if (empty($this->filter['_metadata'])) {
>>>>>>> 9cae77ab06c53d2e41181b430b0ab369a81c6c14
            unset($this->filter['_metadata']);
        }

<<<<<<< HEAD
        if (empty($this->filter['date']))
=======
        if (empty($this->filter['date'])) {
>>>>>>> 9cae77ab06c53d2e41181b430b0ab369a81c6c14
            unset($this->filter['date']);
        }

        return $this->filter;
    }

}
