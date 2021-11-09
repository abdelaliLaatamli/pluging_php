<?php 

namespace Core\Pluging\Loader;

use Core\Pluging\Loader\LoadPlugin\FileHandlers;
use Core\Pluging\Loader\LoadPlugin\LoadingHandlers;

class PluginUploader {

    private $uploadDir;
    private $pluginsDir;
    private $pluginCoreDir;
    private $bkpPluginsDir;


    private $fileHandler ;
    private $loadHandler ;

    public function __construct( $upload_dir , $plugins_dir , $plugin_core_dir , $bkp_plugins )
    {
        $this->uploadDir     = $upload_dir ;
        $this->pluginsDir    = $plugins_dir ;
        $this->pluginCoreDir = $plugin_core_dir ;
        $this->bkpPluginsDir    = $bkp_plugins ;

        $this->fileHandler  = new FileHandlers();
        $this->loadHandler  = new LoadingHandlers();
    }

    public function addPlugin( $fileToUpload ){

        // TODO: Check if any exception remove files from uplods and plugins dirs 


        // validate zip file and extraire file in temporary path , return string temporary path 
        $plugingTempPath = $this->fileHandler->pluginChecker( $fileToUpload , $this->uploadDir );
        
        // validate pluging contnet
        $this->loadHandler->validatePlugin( $plugingTempPath );

        // move to plugin dir
        $plugins_dir = $this->fileHandler->moveToPlugins( $plugingTempPath , $this->pluginsDir );
        
        // 
        $plugin_manager = $this->loadHandler->addToPluginManagerFile( $plugins_dir , $this->pluginCoreDir );


        $this->fileHandler->movePluginZipToBkp( $fileToUpload , $this->uploadDir , $this->bkpPluginsDir );


        return $plugin_manager ;
        
    }




    public function removePlugin( $plugin_name ) {


        $this->loadHandler->removePluginFromLoaderFile( $plugin_name , $this->pluginCoreDir );

        // TODO: remove pluging from loading 

        $this->fileHandler->removePlugin( $plugin_name , $this->pluginsDir );


    }






}