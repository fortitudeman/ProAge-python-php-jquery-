<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

  Author		Ulises Rodríguez
  Site:			http://www.ulisesrodriguez.com	
  Twitter:		https://twitter.com/#!/isc_ulises
  Facebook:		http://www.facebook.com/ISC.Ulises
  Github:		https://github.com/ulisesrodriguez
  Email:		ing.ulisesrodriguez@gmail.com
  Skype:		systemonlinesoftware
  Location:		Guadalajara Jalisco Mexíco

  required library php-csv-reader;	
*/
class Reader_csv{
	
	private $reader = null;	

	private $file = null;

	private $directory;
			
    public function __construct()
    {
		error_reporting(E_ALL ^ E_NOTICE);
		
		$this->directory = APPPATH.'modules/ot/assets/tmp/';
		
		@require 'php-csv-reader/DataSource.php' ;
         				
    }
	
	
// Setting intance
	public function setInstance( $file = null ){
		
		if( empty( $file ) ) return false;
				
		if( !is_file( $this->directory . $file ) ) return false;
		
		$this->reader = new File_CSV_DataSource();
		
		$this->reader->load( $this->directory . $file );
		
		$this->file = $file;
		
		return;
		
	}
	
	
	
// 	Reader
	public function reader(){
		
		if( !is_object( $this->reader ) ) return false;	
				
		return $this->reader->connect();
	}


// Upload Files
	public function upload(){
				
		if( !isset( $_FILES['file'] ) or empty( $_FILES['file']  ) ) return false;
		
		//if( $_FILES['file']['type'] != 'application/vnd.ms-excel' or $_FILES['file']['type'] != "text/csv" ) return false;	
			
		// Setting file temporal file named			
		$name = $_FILES['file']['name'];
		
		$name = strtr($name, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

		$name = preg_replace('/([^.a-z0-9]+)/i', '_', $name);

		if( is_dir( $this->directory ) )
				
				if( !move_uploaded_file( $_FILES['file']['tmp_name'],  $this->directory  . $name ) ) return false;
		
						
		return $name;
		
	}


// Erases Files	
	public function drop(){
		
		if( empty( $this->file ) ) return false;
		
		if( is_file( $this->directory . $this->file ) )
			
			unlink( $this->directory . $this->file );
		
		$this->reader = null;
		
		$this->file = null;
					
		return true;
					
	}
}
?>