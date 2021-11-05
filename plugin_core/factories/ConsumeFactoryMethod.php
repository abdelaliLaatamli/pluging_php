<?php 

namespace Core\Pluging\Loader\Factories;

use Exception;

class ConsumeFactoryMethod extends AbstractFactoryMethod {


    function makeObject( string $param ) {

        $consumeRegistredPluging = $this->filtreRegisterPlugins("consumer") ;

        if( array_key_exists( $param , $consumeRegistredPluging ) )
        {   
            if(!isset($consumeRegistredPluging[$param]["classloader"])){
                throw new Exception("No Data enough to instance the class.");
            }
            // instancat object 
            return new $consumeRegistredPluging[$param]["classloader"]();
        }

        if( $param === "default" ){
            return new \Pipline\Models\Consumer(); 
        }

        throw new Exception( "$param Have No Class.");
    }
}