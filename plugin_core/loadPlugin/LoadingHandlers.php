<?php 

namespace Core\Pluging\Loader\LoadPlugin;

use Exception;

class LoadingHandlers {

    

    public function validatePlugin( $plugingTempPath ): void {

        if( !file_exists( $plugingTempPath."/info.json" ) ){
            throw new Exception( "File not found info.json inside plugin");
        }

        $infoFile   = file_get_contents( $plugingTempPath."/info.json" );

        $decoded_file = json_decode( $infoFile , true);

        // return true;
        // TODO: Validation config pluging file

        // if( isset $decoded_file )

        // check if already in loader.json  

    }
    

    public function addToPluginManagerFile( $pluginsDir , $pluginCoreDir ){

        $infoPlugin    = $this->getInfoFile( $pluginsDir );

        $pluginManager = file_get_contents( $pluginCoreDir."/loader.json" );

        $decoded       = json_decode( $pluginManager , true );

        $decoded["plugins"][] = $infoPlugin ;

        file_put_contents( 

            $pluginCoreDir."/loader.json" ,

            json_encode(  $decoded , true)

        ); 

        return $pluginManager ;
    }

    private function getInfoFile( $extPath ) {

        $infoFile               = file_get_contents( $extPath."/info.json" );

        $decoded_file           = json_decode( $infoFile , true);

        $decoded_file["status"] = "enable";

        return $decoded_file ;
    }


}