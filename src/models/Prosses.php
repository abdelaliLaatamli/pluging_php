<?php

namespace Pipline\Models;

use Pipline\Interfaces\IConsume;
use Pipline\Interfaces\IDataSet;
use Pipline\Interfaces\IProsses;

class Prosses implements IProsses , IDataSet {

    private $data ;

    private $operations = [];

    private $consumer ;

    public function __construct( IConsume $consumer )
    {
        $this->consumer = $consumer;
    }

    public function setData( $data ): IDataSet {

        $this->data = $data;
        
        return $this;
    }

    
    public function convert( callable $e ): IProsses {
        // DO SOMETHING
        $this->operations [] = [ "convert" , $e ] ;
        return $this;
    }
    public function clean( callable $e  ): IProsses {
        // DO SOMETHING
        $this->operations [] = [ "clean" , $e ] ;
        return $this;
    }
    public function analyze( callable $e  ): IProsses {
        // DO SOMETHING
        $this->operations [] = [ "analyze" , $e ];
        return $this;
        
    }

    public function prosses( ): IConsume {
        // DO SOMETHING

        $data = $this->exceuteProsses();

        $this->consumer->setData( $data );

        return $this->consumer;
    }

    private function exceuteProsses(): array {

        $data = $this->data;

        foreach( $this->operations as $op ){

            switch( $op[0] ){

                case 'convert': 
                    $data = array_map( $op[1] , $data );
                    break;

                case 'clean': 
                    $data = array_filter( $data , $op[1] );
                    break;

                
                case 'analyze': 
                    $data = $op[1]($data) ;
                    break;
            }
           
        }

        return $data ;

    }


}