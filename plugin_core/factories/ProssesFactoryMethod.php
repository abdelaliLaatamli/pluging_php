<?php 

namespace Core\Pluging\Loader\Factories;

use Exception;
use Pipline\Interfaces\IConsume;

class ProssesFactoryMethod extends AbstractFactoryMethod {


    function makeObject( string $param , IConsume $consumer = null ) {

        $prossesRegistredPluging = $this->filtreRegisterPlugins("prosses") ;

        if( array_key_exists( $param , $prossesRegistredPluging ) )
        {   
            if( !isset($prossesRegistredPluging[$param]["classloader"]) ){
                throw new Exception("No Data enaght to instance this class");
            }
            // instancat object 
            return new $prossesRegistredPluging[$param]["classloader"]( $consumer);
        }

        if( $param === "default" ){
            return new \Pipline\Models\Prosses( $consumer ); 
        }

        throw new Exception( $param . " Have No Class");
    }
    
}
