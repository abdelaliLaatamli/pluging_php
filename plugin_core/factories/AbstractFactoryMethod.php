<?php 

namespace Core\Pluging\Loader\Factories;

use Core\Pluging\Loader\Loader;

abstract class AbstractFactoryMethod {
    abstract function makeObject(string $param);


    protected function filtreRegisterPlugins(){
        $consumeRegistredPluging = [] ;

        foreach( Loader::$loadedPluging  as $k => $v ) {

            if( $v["type"] === "consumer" ){
                $consumeRegistredPluging[$k] = $v;
            }

        }

        return $consumeRegistredPluging;
    }
}
