<?php 

namespace Core\Pluging\Loader;

use Exception;
use ZipArchive;

class PluginUploader {

    private $file ;
    private $upload_dir;
    private $plugins_dir;

    public function __construct( $file , $upload_dir , $plugins_dir )
    {
        $this->file        = $file ;
        $this->upload_dir  = $upload_dir ;
        $this->plugins_dir = $plugins_dir ;
    }

    public function moveUpload(  ){

        $basename = basename($this->file["name"]);
        $target_file = $this->upload_dir  . $basename;

        if ( move_uploaded_file( $this->file["tmp_name"] , $target_file ) ) {

            $zip=new ZipArchive;

            $zipFile=$zip->open( $target_file );
            
            if ($zipFile === TRUE)
            {
                $zip->extractTo( $this->upload_dir  );
                $zip->close();

                $extPath = $this->upload_dir . explode(".",  $basename)[0] ;
                if( file_exists( $extPath  ) ){

                    

                    echo "bbb" . $extPath; 
                }else{
         
                    throw new \Exception( "File not found ");
                }

            } else {
                throw new \Exception( "Echec de l'extraction du fichier ");
            }


          } else {
            throw new \Exception( "Sorry, there was an error uploading your file." );
          }
    }


    private function validatePlugin( $extPath ){

    }


}