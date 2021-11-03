<?php 


namespace Pipline\Models;

use Pipline\Interfaces\IProsses;
use Pipline\Interfaces\IStore;
use Pipline\Models\Prosses;

class Store implements IStore {

    private $data = [];

    public function __construct(array $data= null)
    {
        if( $data != null ){
            $this->data = $data;
        }
    }
    
    public function loadData(array $data = null ):IProsses
    {
    
        if( $data != null ){
            $this->data = $data;
        }

        $prosses = new Prosses( $this->data );
        return $prosses;
    }

}