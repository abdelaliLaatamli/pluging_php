<?php 

namespace Core\Pluging\Loader\Factories;

use Exception;
use Pipline\Interfaces\IProsses;

class StoreFactoryMethod extends AbstractFactoryMethod {


    function makeObject( string $param , IProsses $prosses = null ) {


        $storeRegistredPluging = $this->filtreRegisterPlugins("store") ;

        if( array_key_exists( $param , $storeRegistredPluging ) )
        {   
            if( !isset($storeRegistredPluging[$param]["classloader"]) ){
                throw new Exception("No Data enaght to instance this class");
            }
            // instancat object 
            return new $storeRegistredPluging[$param]["classloader"]( $prosses );
        }

        if( $param === "default" ){
            return new \Pipline\Models\Store( $prosses ); 
        }

        throw new Exception( $param . " Have No Class");
    
    }
}