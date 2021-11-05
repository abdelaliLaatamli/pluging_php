<?php 



require 'vendor/autoload.php';

use Core\Pluging\Loader\PluginUploader;


    if( isset( $_POST["isFile"] ) && !empty($_POST["isFile"]) ){

        // var_dump( [ $_POST , $_FILES ] );

        $pluginUploader = new PluginUploader( $_FILES["plugin"] , __DIR__."/uploads/" , __DIR__."/plugins/" );

        // $target_dir = __DIR__."/uploads/";

        if( isset($_FILES["plugin"]) && !empty($_FILES["plugin"]) ) {


            // TODO: File Validation
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