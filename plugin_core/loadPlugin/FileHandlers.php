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

    

}