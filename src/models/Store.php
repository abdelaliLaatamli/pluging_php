<?php 


namespace Pipline\Models;

use Pipline\Interfaces\IDataSet;
use Pipline\Interfaces\IProsses;
use Pipline\Interfaces\IStore;

class Store implements IStore , IDataSet {

    private $data = [];

    private $prosses ;

    public function __construct( IProsses|IDataSet $prosses )
    {
        $this->prosses = $prosses ;
    }



    public function setData( $data ): IDataSet {

        $this->data = $data;
        
        return $this;
    }
    
    public function loadData():IProsses
    {

        // load data

        $this->prosses->setData( $this->data );


        return $this->prosses;
    }

}