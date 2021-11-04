<?php

namespace Pipline\Models;

use Pipline\Interfaces\IConsume;
use Pipline\Interfaces\IDataSet;

class Consumer implements IConsume , IDataSet {

    private $data;

    
    public function setData( $data ): IDataSet {

        $this->data = $data;
        
        return $this;
    }

    public function consume() {
        // TODO: impelement consumer
        return $this->data;
    }
    
}