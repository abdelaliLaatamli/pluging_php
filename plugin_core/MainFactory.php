<?php 


namespace Core\Pluging\Loader;

use Core\Pluging\Loader\Factories\ConsumeFactoryMethod;
use Core\Pluging\Loader\Factories\ProssesFactoryMethod;
use Core\Pluging\Loader\Factories\StoreFactoryMethod;

class MainFactory {

    private $storeFactory;
    private $prossesFactory;
    private $consumerFactory;

    public function __construct()
    {
        $this->storeFactory   = new StoreFactoryMethod();
        $this->prossesFactory = new ProssesFactoryMethod();
        $this->consumerFactory = new ConsumeFactoryMethod();
    }


    public function makeObjects( string $storeParam , string $prossesParam , string $consumerParam ){


        $consumer = $this->consumerFactory->makeObject( $consumerParam );
        $prosses  = $this->prossesFactory->makeObject( $prossesParam , $consumer );
        $store    = $this->storeFactory->makeObject( $storeParam , $prosses);

        

        
       
        // return [ $consumer , $prosses , $store ] ;
        return $store ;

    }





}