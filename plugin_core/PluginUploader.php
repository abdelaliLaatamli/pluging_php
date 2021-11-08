<?php 

namespace Core\Pluging\Loader;

use Core\Pluging\Loader\LoadPlugin\FileHandlers;
use Core\Pluging\Loader\LoadPlugin\LoadingHandlers;
use Exception;
use ZipArchive;

class PluginUploader {

    private $file ;
    private $upload_dir;
    private $plugins_dir;
    private $pluginCoreDir;


    private $fileHandler ;
    private $loadHandler ;

    public function __construct( $file , $upload_dir , $plugins_dir , $pluginCoreDir )
    {
        $this->file          = $file ;
        $this->upload_dir    = $upload_dir ;
        $this->plugins_dir   = $plugins_dir ;
        $this->pluginCoreDir = $pluginCoreDir ;

        $this->fileHandler  = new FileHandlers();
        $this->loadHandler  = new LoadingHandlers();
    }

    public function moveUpload(){


        $extPath = $this->fileHandler->fileChecker( $this->file , $this->upload_dir );
        
        $this->validatePlugin( $extPath );
        $plugins_dir = $this->moveToPlugins($extPath);
        
        $file_info = $this->getInfoFile( $plugins_dir );

        $this->addToPluginManagerFile( $file_info );

        // print_r( $file_info );

        return $plugins_dir ;
    }


    private function validatePlugin( $extPath ):void {

        if( !file_exists( $extPath."/info.json" ) ){
            throw new Exception( "File not found info.json inside plugin");
        }

        $infoFile   = file_get_contents( $extPath."/info.json" );

        $decoded_file = json_decode( $infoFile , true);

        // return true;
        // TODO: Validation config pluging file

        // if( isset $decoded_file )

    }

    private function getInfoFile( $extPath ) {
        $infoFile               = file_get_contents( $extPath."/info.json" );
        $decoded_file           = json_decode( $infoFile , true);
        $decoded_file["status"] = "enable";
        return $decoded_file ;
    }


    private function moveToPlugins($extPath) {

        $extPath__ = explode("/",$extPath) ;
        $plugins_dir = $this->plugins_dir . $extPath__[count($extPath__)-1]; 
        $this->Move_Folder_To( $extPath, $plugins_dir);
        return $plugins_dir;

    }

    private function Move_Folder_To($source, $target){
        if( !is_dir($target) ) mkdir( dirname($target), 0777 ,true );
        rename( $source,  $target);
    }

    private function addToPluginManagerFile( $infoPlugin ){

        $pluginManager = file_get_contents(  $this->pluginCoreDir."/loader.json" );
        $decoded       = json_decode( $pluginManager , true );

        $decoded["plugins"][] = $infoPlugin ;

        file_put_contents( 
            $this->pluginCoreDir."/loader.json" ,
            json_encode(  $decoded , true)
        ); 
    }


}