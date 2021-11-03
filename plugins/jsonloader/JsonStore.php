<?php


namespace Plugins\Jsonloader;

use Pipline\Interfaces\IProsses;
use Pipline\Interfaces\IStore;
use Pipline\Models\Prosses;

class JsonStore implements IStore {
    
    private $data = [];

    public function __construct( string $jsonfile = null )
    {
        if( $jsonfile != null ){
            $this->data = json_decode( file_get_contents( $jsonfile ) , false );
        }
    }


    public function loadData( $data = null ): IProsses
    {
        if( $data != null ){
            $this->data = $data;
        }

        $prosses = new Prosses( $this->data );
        return $prosses;
    }

}