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

            $pluginUploader->moveUpload() ;

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