<?php


namespace Plugins\Jsonloader;

use Pipline\Interfaces\IDataSet;
use Pipline\Interfaces\IProsses;
use Pipline\Interfaces\IStore;

class JsonStore implements IDataSet  {
    
    private $data = [];

    public function __construct( IDataSet $prosses  )
    {
        $this->prosses = $prosses ;

    }


    
    public function setData( $jsonfile ): IDataSet {

        if( $jsonfile != null ){
            $this->data = json_decode( file_get_contents( $jsonfile ) , false );
        }

        $this->prosses->setData( $this->data );

    
        return $this->prosses;

    }


}