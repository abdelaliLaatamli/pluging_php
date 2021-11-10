<?php 

namespace Core\Pluging\Loader\LoadPlugin;

use Exception;
use ZipArchive;

class FileHandlers {



    public  function pluginChecker( $uploadFile , $uploadDir )
    {

        $uploadedZipFile = $this->moveUploadedFileToUploads( $uploadFile , $uploadDir );

        return $this->extractZipFile( $uploadedZipFile , $uploadDir );

    }


    private function moveUploadedFileToUploads( $uploadFile , $uploadDir ): string {

        $basename = basename( $uploadFile["name"] );
        $uploadedZipFile = $uploadDir  . $basename;

        if( $uploadFile["type"] !== "application/x-zip-compressed" ){
           throw new Exception("Type Must be Zip  $uploadedZipFile");
        }
    
        if( file_exists( $uploadedZipFile ) ){
            throw new Exception("This pluging is already exist");
        }

        if ( !move_uploaded_file( $uploadFile["tmp_name"] , $uploadedZipFile ) ) {
            throw new Exception( "Sorry, there was an error uploading your file." );
        }

        return $uploadedZipFile ;
    }


    private function extractZipFile( $uploadedZip , $uploadDir ): string {

        $zip=new ZipArchive;

        $zipFile=$zip->open( $uploadedZip );


        if ($zipFile !== true){
            throw new Exception( "Echec de l'extraction du fichier {$zipFile} , $uploadedZip");
        }
            
        $zip->extractTo( $uploadDir  );
        $zip->close();

        $extPath = $uploadDir . explode(".", basename( $uploadedZip ) )[0] ;

        if( !file_exists( $extPath  ) ){
            throw new Exception( "File not found  $extPath ");
        }
        return $extPath;

    }


    public function movePluginZipToBkp( $fileToUpload , $uploadDir , $pkpPluginsDir ){

        $basename = basename( $fileToUpload["name"] );
          
        /* Store the path of source file */
        $filePath = $uploadDir . $basename;
        
        /* Store the path of destination file */
        $destinationFilePath = $pkpPluginsDir.time()."_".$basename;
        
        /* Move File from images to copyImages folder */
        if( !rename($filePath, $destinationFilePath) ) {  
            throw new Exception( "Can't Move plugin file $filePath" );
        }  
     
    }

    public function moveToPlugins( string $plugingTempPath , string $pluginsDir ) {

        $plugins_dir = $pluginsDir . basename( $plugingTempPath ); 

        if( file_exists( $plugins_dir ) ){
            throw new Exception( "This Pluging is already exist $plugins_dir " );
        }

        $this->Move_Folder_To( $plugingTempPath , $plugins_dir);

        return $plugins_dir;

    }

    private function Move_Folder_To($source, $target){
        if( !is_dir($target) ) {
            mkdir( dirname($target), 0777 ,true );
        }
        rename( $source,  $target);
    }
    


    public function removePlugin( $plugin_name , $pluginsDir ){


        $plugins_dir = $pluginsDir .$plugin_name ; 

        if( !file_exists( $plugins_dir ) ){
            throw new Exception( "This Pluging Not found $plugins_dir " );
        }

        $this->RemovePluginFromPluginsDir( $plugin_name , $pluginsDir );

    }


    private function RemovePluginFromPluginsDir(  $plugin_name , $pluginsDir ){

        $plugins_dir = $pluginsDir .$plugin_name ; 

        array_map('unlink', glob("$plugins_dir/*.*"));

        rmdir($plugins_dir);

        if( file_exists( $plugins_dir ) ){
            throw new Exception( "Can't Delete plugin $plugin_name " );
        }
    }

}