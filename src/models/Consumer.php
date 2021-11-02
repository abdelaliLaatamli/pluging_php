<?php

namespace Pipline\Models;

use Pipline\Interfaces\IConsume;

class Consumer implements IConsume {

    private $data;

    public function __construct( $data  )
    {
        $this->data = $data ;
    }

    public function consume() {
        // TODO: impelement consumer
        return $this->data;
    }
    
}