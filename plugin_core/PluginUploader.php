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


        $extPath = $this->fileChecker();
        $this->validatePlugin( $extPath );
        $extPath__ = explode("/",$extPath) ;
        $plugins_dir = $this->plugins_dir . $extPath__[count($extPath__)-1]; 
        // shell_exec("mv $extPath path_to_destination");


        echo "bbb" . $extPath ."\n\n $plugins_dir"; 
          
      
    }


    private function validatePlugin( $extPath ):void {

        if( !file_exists( $extPath."/info.json" ) ){
            throw new \Exception( "File not found info.json inside plugin");
        }

        $infoFile   = file_get_contents( $extPath."/info.json" );

        $decoded_file = json_decode( $infoFile , true);

        // return true;
        // TODO: Validation config pluging file

        // if( isset $decoded_file )

    }

    private function getInfoFile( $extPath ) {
        $infoFile   = file_get_contents( $extPath."/info.json" );

        $decoded_file = json_decode( $infoFile , true);
        return $decoded_file ;
    }



    private function fileChecker(){

        $basename = basename($this->file["name"]);
        $target_file = $this->upload_dir  . $basename;

        if ( !move_uploaded_file( $this->file["tmp_name"] , $target_file ) ) {
            throw new \Exception( "Sorry, there was an error uploading your file." );
        }
        
        // echo $target_file ;
        $zip=new ZipArchive;

        $zipFile=$zip->open( $target_file );
            
        if ($zipFile === TRUE){
            throw new \Exception( "Echec de l'extraction du fichier ");
        }
            
        $zip->extractTo( $this->upload_dir  );
        $zip->close();

        $extPath = $this->upload_dir . explode(".",  $basename)[0] ;

        if( file_exists( $extPath  ) ){
            throw new \Exception( "File not found ");
        }
        return $extPath;

    }

    private function moveToPlugins() {

    }


}