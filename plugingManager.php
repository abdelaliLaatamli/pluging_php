<?php 



require 'vendor/autoload.php';

use Core\Pluging\Loader\Loader;
use Core\Pluging\Loader\MainFactory;
use Core\Pluging\Loader\PluginUploader;


$loader = new Loader( __DIR__ );

$loader->pluginsLoader();

 
// $request = new Request($_SERVER);
// $request->create();

// $router = new Router($request, 'operation', [
//     Handler::post('get_plugins', function() {
//         $plugingManagerfile = __DIR__."/plugin_core/loader.json";
//         $fileContent        = file_get_contents( $plugingManagerfile );
//         $decodedContent     = json_decode( $fileContent , true );
//         return [ "completed" => true , "data" => $decodedContent  , "error" => null ];
//     }),
//     //Handler::post('get_plugins', 'PluginsController@getPlugins'),
// ]);

// $router->run();

// $dispatcher = new Dispatcher($router);

// $dispatcher->onExcetption( function($ex) {
//     echo json_encode(['error' => $ex->getMessage()]);

// } );

// $dispatcher->dispatch();

$pluginUploader = new PluginUploader( 
    __DIR__."/uploads/"     ,
    __DIR__."/plugins/"     , 
    __DIR__."/plugin_core"  ,
    __DIR__."/bkp_plugins/"
);


    if( isset( $_POST["isFile"] ) && !empty($_POST["isFile"]) ){



        if( isset($_FILES["plugin"]) && !empty($_FILES["plugin"]) ) {

            // $pluginUploader->setFile( $_FILES["plugin"] ) ;

            $t = $pluginUploader->addPlugin( $_FILES["plugin"] );

            // echo "<pre>";
            // var_dump( $t );
            // echo "</pre>";

        }

        
        // die();
    }

    if( isset( $_POST['operation'] ) && !empty( $_POST['operation'] ) ){

        header('Content-Type: application/json');

        $operation = $_POST['operation']; 
        
        $plugingManagerfile = __DIR__."/plugin_core/loader.json";

        switch( $operation ){

            case "get_plugins" : 

                $fileContent        = file_get_contents( $plugingManagerfile );

                $decodedContent     = json_decode( $fileContent , true );

                $response           = [ "completed" => true , "data" => $decodedContent  , "error" => null ];
                
                break;

            case "toggle_plugin":

                $current_status = $_POST["current_status"] ;

                $plugin_name    = $_POST["plugin_name"] ;

                $status         = ( $current_status === "enable" ) ? "disable" : "enable" ;
    
                $fileContent    = file_get_contents( $plugingManagerfile );

                $decodedContent = json_decode( $fileContent , true );

                $newContent     = array_map( function( $item ) use ( $status , $plugin_name ) { 

                    if( $item["name"] == $plugin_name ){
                        $item["status"] = $status ;
                    }

                    return $item;

                } , $decodedContent["plugins"] );

                $decodedContent["plugins"] = $newContent;

                file_put_contents( $plugingManagerfile , json_encode( $decodedContent ) );

                $response = [ "completed" => true , "data" => $decodedContent , "error" => null ];

                break;


            case "delete_plugin":
    
                $plugin_name    = $_POST["plugin_name"] ;
    
                $t = $pluginUploader->removePlugin( $plugin_name ) ;
    
                $response = [ "completed" => true , "data" => $t , "error" => null ];
    
                break;

            case "start_prosses":

                $consumer  = $_POST["consumer"];
                $prosses   = $_POST["prosses"];
                $store         = $_POST["store"]["type"];
                $storeData     = $_POST["store"]["dataStore"];

                $factory = new MainFactory();

                $storeMade = $factory->makeObjects(  $store  ,  $prosses  , $consumer );
  

                $data = $storeMade 
                            ->setData($storeData)
                            ->convert( function ( $item ) { return $item . " test" ; } )
                            ->clean( function ( $item ) { return substr( $item , 0, 1 ) === "a" ;} )
                            ->analyze( function ( $data ) { return array_slice($data, 0 , 3); } )
                            ->prosses()
                            ->consume();

                $response = [ "completed" => true , "data" => $data , "error" => null ];
                break;
            default: 
                $response = [ "completed" => false , "data" => []  , "error" => "this rout not exist" ];
                break;

        }
        echo json_encode($response);
        die();
    }

?>
<?php 
    require_once(__DIR__."/views/plugingManager.inc.php");
?>