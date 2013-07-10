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

  	
*/
class User extends CI_Model{
	
	private $data = array();
	
	private $insertId;
	
		
	public function __construct(){
		
        parent::__construct();
			
    }
	

/*
 *	CRUD Functions, dynamic table.
 **/


// Add
	public function create( $table = 'users', $values = array() ){
        
		
		if( empty( $table ) or empty( $values ) ) return false;
				
		// Set timestamp unix
		$timestamp = date( 'Y-m-d H:i:s' ) ;
		
		// Set timestamp unix
		$values['last_updated'] = $timestamp;
		$values['date'] = $timestamp;
		
		
			
		if( $this->db->insert( $table, $values ) ){
			
			$this->insertId = $this->db->insert_id();
			
			return true;
		
		}else
		
			return false;
       
    }
	
	
	public function create_banch( $table = '', $values = array() ){
        
		
		if( empty( $table ) or empty( $values ) ) return false;
				
			
		if( $this->db->insert_batch( $table, $values ) ){
									
			return true;
		
		}else
		
			return false;
       
    }
	
	
	
	

/**
 |	Update
 **/ 

    public function update( $table = 'users', $id = 0, $values = array() ){
        
		if( empty( $table ) or empty( $values ) or empty( $id ) ) return false;
					
		// Set timestamp unix
		$timestamp = strtotime( date( 'd-m-Y H:i:s' ) );
		
		$values['modified'] = $timestamp;
		
        if( $this->db->update( $table, $values, array( 'id' => $id ) ) )
			
			return true;
        
		else
        	
			return false;
        
		
    }

/**
 |	Remove 
 **/ 	
	 public function delete( $table = 'users', $id ){
        
		if( empty( $table ) or empty( $id ) ) return false;
					   
			if( $this->db->delete( $table, array('id' => $id ) ) )
			
					return true;
			
			else
			
				return false;
			
			
				
    }





// Return insert id
	public function insert_id(){   return $this->insertId;  }










/**
 |	Getting All
 **/ 
	
	public function overview( $start = 0 ) {
		
        $this->db->limit( 2, $start );

        $query = $this->db->get( $this->table );

		
		
		if ($query->num_rows() == 0) return false;
 	
		
		
		unset( $this->data );

		$this->data = array();
		
		
		
		foreach ($query->result() as $row) {

			$this->data[] = array( 
		    	'id' => $row->id,
		    	'clave' => $row->clave,
				'folio_nacional' => $row->folio_nacional,
				'folio_provicional' => $row->folio_provincial,				
				'nombre' => $row->nombre,
				'apellidos' => $row->apellidos,
				'agencia' => $row->agencia,
				'email' => $row->email,
				'tipo' => $row->tipo,
		    	'date' => date( 'd-m-Y H:i:s', $row->date ),
		    	'last_updated' => date( 'd-m-Y H:i:s', $row->last_updated )
		    );

		}

		return $this->data;
		
   }

	


// Count records for pagination
	public function record_count() {
        return $this->db->count_all( $this->table );
    }











// FInd Method
	public function find( $name =  null ) {
		
		
		if( empty( $name ) ) return false;
		
       $this->db->like( $this->table, $name);

		
		if ($query->num_rows() == 0) return false;
 	
		
		// Clean vars
		unset( $this->data );

		$this->data = array();
		
		
		
		foreach ($query->result() as $row) {

			$this->data[] = array( 
		    	'id' => $row->id,
		    	'clave' => $row->clave,
				'folio_nacional' => $row->folio_nacional,
				'folio_provicional' => $row->folio_provincial,				
				'nombre' => $row->nombre,
				'apellidos' => $row->apellidos,
				'agencia' => $row->agencia,
				'email' => $row->email,
				'tipo' => $row->tipo,
		    	'date' => date( 'd-m-Y H:i:s', $row->date ),
		    	'last_updated' => date( 'd-m-Y H:i:s', $row->last_updated )
		    );

		}

		return $this->data;
		
   }















/**
 |	Getting for id
 **/ 
	
	public function id( $id = null ){
		
		if( empty( $id ) ) return false;
				
		unset( $this->data );	$this->data = array();
		
		// Validation form not repear name
		$this->db->
					select()
				  ->
				   from( $this->table )	
				  ->
				   where( array( 'id' => $id ) );
		
		$query = $this->db->get();
				
		if( $query->num_rows == 0 ) return false;
		
		foreach ($query->result() as $row)
		
			$this->data[] = array( 
				  
				  'id' => $row->id,
				  'name' => $row->name
				  
			);
				
		return $this->data[0];
		
	}
	
	
	
	
	
	
	
	
	
// Querys for logins
	public function setLogin( $data = array() ) {
		
		
		// If data in $_POST is empty return false
		if( empty( $data ) ) return false;
		
			
        $this->db->where( array( 'username'  => $data['username'], 'password'  => md5( $data['password'] ) )  );
        $this->db->limit( 1 ); // Limit 1 record

		// Get Resutls
        $query = $this->db->get( $this->table );
		
		
		
		if ($query->num_rows() == 0) return false;
 	
		
		// Clean vars
		unset( $this->data );

		$this->data = array();
		
		
		
		// Getting data
		foreach ($query->result() as $row) {

			$this->data[] = array( 
		    	'id' => $row->id,
		    	'agency_id' => $row->agency_id,
				'office_id' => $row->office_id,			
				'name' => $row->name,
				'lastname' => $row->lastname,
				'agencia' => $row->agencia,
				'email' => $row->email,
				'working_since' => $row->working_since,
				'disabled' => $row->disabled,
		    	'date' => date( 'd-m-Y H:i:s', $row->date ),
		    	'last_updated' => date( 'd-m-Y H:i:s', $row->last_updated )
		    );

		}

		return $this->data;
		
   }	
	
	
	
	
	
	
	
	

// Get Selects
	public function getSelectsGerentes(){
		
	
		
		$query = $this->db->query(' SELECT DISTINCT(users.name), users.id  
									FROM `users_vs_user_roles` 
									JOIN users ON users.id = `user_id` 
									WHERE user_role_id=3;');
						
		
		if ($query->num_rows() == 0) return false;
 	
		
		$options = '';	
		
		// Getting data
		foreach ($query->result() as $row)
			
			$options .= '<option value="'.$row->id.'">'.$row->name.'</option>';
			
		
		return $options;
		
	}	
	
	
	
	
	
	

}
?>