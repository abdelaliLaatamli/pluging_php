<?php


namespace Plugins\Jsonloader;

use Exception;
use Pipline\Interfaces\IDataSet;

class JsonStore implements IDataSet  {
    
    private $data = [];

    public function __construct( IDataSet $prosses  )
    {
        $this->prosses = $prosses ;

    }


    
    public function setData( $jsonfile ): IDataSet {

        if( !file_exists($jsonfile) ){
            throw new Exception("json file [$jsonfile] not found");
        }

        if( $jsonfile != null ){
            $this->data = json_decode( file_get_contents( $jsonfile ) , false );
        }

        $this->prosses->setData( $this->data );

    
        return $this->prosses;

    }


}