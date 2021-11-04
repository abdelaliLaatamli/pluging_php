<?php 

namespace Core\Pluging\Loader\Factories;

use Core\Pluging\Loader\Loader;

class ConsumeFactoryMethod extends AbstractFactoryMethod {


function makeObject( string $param ) {

   

    $consumeRegistredPluging = $this->filtreRegisterPlugins() ;
    return  $consumeRegistredPluging ;
    $consumer = null; 

    // switch ( $param ) {

    //     // case "us":
    //     //     // $book = new OReillyPHPBook;
    //     // break;
    //     // case "other":
    //     //     // $book = new SamsPHPBook;
    //     // break;
    //     // default:
    //     //     // $book = new OReillyPHPBook;
    //     // break; 

    // } 
    return Loader::$loadedPluging;
    return $consumer;
}
}