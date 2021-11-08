<?php 



require 'vendor/autoload.php';

use Core\Pluging\Loader\PluginUploader;


    if( isset( $_POST["isFile"] ) && !empty($_POST["isFile"]) ){


        $pluginUploader = new PluginUploader( 
            $_FILES["plugin"] ,
            __DIR__."/uploads/" ,
            __DIR__."/plugins/" , 
            __DIR__."/plugin_core" 
        );

        if( isset($_FILES["plugin"]) && !empty($_FILES["plugin"]) ) {

            $t = $pluginUploader->moveUpload() ;
            // echo "<pre>";
            // var_dump( $t );
            // echo "</pre>";

        }


        die();
    }

    if( isset( $_POST['operation'] ) && !empty( $_POST['operation'] ) ){

        header('Content-Type: application/json');

        $operation = $_POST['operation']; 

        switch( $operation ){

            case "get_plugins" : 

                $plugingManagerfile = __DIR__."/plugin_core/loader.json";

                $fileContent        = file_get_contents( $plugingManagerfile );

                $decodedContent     = json_decode( $fileContent , true );

                $response           = [ "completed" => true , "data" => $decodedContent  , "error" => null ];
                break;

            case "toggle_plugin":

                $plugingManagerfile = __DIR__."/plugin_core/loader.json";

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

                $plugingManagerfile = __DIR__."/plugin_core/loader.json";
    
                $plugin_name    = $_POST["plugin_name"] ;
    
        
                $fileContent    = file_get_contents( $plugingManagerfile );
    
                $decodedContent = json_decode( $fileContent , true );

                $newContent     = array_filter( $decodedContent["plugins"] , function ( $item ) use ( $plugin_name ) {
                    return $item["name"] != $plugin_name;
                });
    
    
                $decodedContent["plugins"] = $newContent;
    
                file_put_contents( $plugingManagerfile , json_encode( $decodedContent ) );

                // TODO: remove pluging from loading 
    
                $response = [ "completed" => true , "data" => $decodedContent , "error" => null ];
    
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