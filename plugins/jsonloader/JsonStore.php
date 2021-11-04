<?php


namespace Plugins\Jsonloader;

use Pipline\Interfaces\IDataSet;
use Pipline\Interfaces\IProsses;
use Pipline\Interfaces\IStore;
use Pipline\Models\Prosses;

class JsonStore implements IStore  {
    
    private $data = [];

    public function __construct( IProsses $prosses  )
    {
        $this->prosses = $prosses ;

    }


    public function loadData( $jsonfile ): IProsses
    {
        if( $jsonfile != null ){
            $this->data = json_decode( file_get_contents( $jsonfile ) , false );
        }

        $this->prosses->setData( $this->data );

        

        return $this->prosses;
    }

}