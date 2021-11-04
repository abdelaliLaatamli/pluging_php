<?php 

namespace Core\Pluging\Loader;

use Composer\Autoload\ClassLoader;
use Exception;

class Loader {

    private $rootPath ;

    public static $loadedPluging = [];

    public function __construct( $rootPath = __DIR__ )
    { 
        $this->rootPath = $rootPath ;
    }


    public function pluginsLoader(): void {

        $pluginsFile = $this->filePluginManager();

        if( !isset($pluginsFile["plugins"]) ){
            throw new Exception("Loader File must respect plugins form");
        }

        $this->loadPlugins( $pluginsFile["plugins"] ) ;
        

    }


    private function loadPlugins( $listPlugins ){

        foreach( $listPlugins as $pluging ){

            $plugingPath = $this->rootPath."/plugins/".$pluging['name'];
            
            if (!file_exists( $plugingPath )) {
                Throw new Exception("Pluging {$pluging['name']} Implementation Not Exist");  
            } 

            $this->loadPlugin( $plugingPath  , $pluging["namespace"] );

            static::$loadedPluging[$pluging["name"]] = $pluging;

        }

    }

    private function loadPlugin( $namespace , $plugingPath ){
        
        $loader = new ClassLoader();
         
        // register classes with namespaces
        $loader->add( $namespace ,  $plugingPath );

        // activate the autoloader
        $loader->register();
     
       // to enable searching the include path (eg. for PEAR packages)
        $loader->setUseIncludePath(true);
    }


    private function filePluginManager(){


        $pluginManagerFilePath = __DIR__."/loader.json";

        if ( !file_exists($pluginManagerFilePath) ) {
            Throw new Exception("Loader File Not Exist");
        } 

        $fileContent = file_get_contents($pluginManagerFilePath);

        $encodedContentOfFile = json_decode( $fileContent , true ); 

        return $encodedContentOfFile;
    }

    

}