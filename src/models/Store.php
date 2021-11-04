<?php 


namespace Pipline\Models;

use Pipline\Interfaces\IDataSet;
// use Pipline\Interfaces\IProsses;
// use Pipline\Interfaces\IStore;

class Store implements IDataSet {

    private $data = [];

    private $prosses ;

    public function __construct( IDataSet $prosses )
    {
        $this->prosses = $prosses ;
    }



    public function setData( $data ): IDataSet {

        $this->data = $data;

        $this->prosses->setData( $this->data );

        return $this->prosses;
        
    }



}