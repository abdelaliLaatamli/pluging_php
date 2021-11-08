<?php


namespace Plugins\JsonConsumer;

use Pipline\Interfaces\IConsume;
use Pipline\Interfaces\IDataSet;

class JsonConsumer implements IConsume , IDataSet {
    
    private $data = [];

    public function setData($data): IDataSet {
        
        $this->data = $data;
        return $this;

    }
    
    public function consume(){
        return json_encode( $this->data );
    }

}