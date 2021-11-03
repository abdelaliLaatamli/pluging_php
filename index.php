<?php

header('Content-Type: application/json');

require 'vendor/autoload.php';

// use Core\Pluging\Loader\Loader;

// $loader = new Loader( __DIR__ );

// $loader->pluginsLoader();


// $p = new \Plugins\Jsonloader\JsonStore();


// echo json_encode( "aaaaa" );

use  Pipline\Models\Store;


$store = new Store();
$data = $store
            ->loadData(["aaa" , "bbb" , "ccc" , "adbs" , "abcds" , "ananas" , "ops", "ddddd"])
            ->convert( function ( $item ) { return $item . " test" ; } )
            ->clean( function ( $item ) { return substr( $item , 0, 1 ) === "a" ;} )
            ->analyze( function ( $data ) { return array_slice($data, 0 , 3); } )
            ->prosses()
            ->consume();


var_dump( $data );
