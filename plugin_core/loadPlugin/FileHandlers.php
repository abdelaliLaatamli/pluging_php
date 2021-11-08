<?php 

namespace Core\Pluging\Loader\LoadPlugin;

use Exception;
use ZipArchive;

class FileHandlers {



    public  function fileChecker( $uploadFile , $uploadDir )
    {

        $uploadedZipFile = $this->moveUploadedFileToUploads( $uploadFile , $uploadDir );

        return $this->extractZipFile(  $uploadedZipFile , $uploadDir );

    }


    private function moveUploadedFileToUploads( $uploadFile , $uploadDir ): string {

        $basename = basename( $uploadFile["name"] );
        $uploadedZipFile = $uploadDir  . $basename;

        // TODO: check if file is zip file

        if( $uploadFile["type"] !== "application/x-zip-compressed" ){
           throw new Exception("Type Must be Zip  $uploadedZipFile");
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
    

}