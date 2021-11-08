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


        // // validate zip file and extraire file in temporary path , return string temporary path 
        $plugingTempPath = $this->fileHandler->pluginChecker( $this->file , $this->upload_dir );
        
        // // validate pluging contnet
        $this->loadHandler->validatePlugin( $plugingTempPath );

        // // move to plugin dir
        $plugins_dir = $this->fileHandler->moveToPlugins( $plugingTempPath , $this->plugins_dir );
        

        return $this->loadHandler->addToPluginManagerFile( $plugins_dir , $this->pluginCoreDir );
        

        return $plugins_dir ;
    }






}