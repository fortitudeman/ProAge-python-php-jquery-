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
 |	Getting for overview
 **/ 
	
	public function overview( $start = 0 ) {
		
		
		// SELECT id, name, lastnames, email FROM `users`;
		$this->db->select( 'id, name, lastnames, email, manager_id, date, last_updated' );
		$this->db->from( 'users' );
        $this->db->limit( 30, $start );
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
 	
		
		
		unset( $this->data );

		$this->data = array();
		
		
		
		foreach ($query->result() as $row) {
			
			
			// Getting Manager name
			if( !empty( $row->manager_id ) ){
				
				$manager='';
												
				$this->db->select( 'name' );
				$this->db->from( 'users' );
				$this->db->where( 'id', $row->manager_id  );
				$this->db->limit( 1 );
				
				$managers = $this->db->get();
				
				if ($managers->num_rows() == 0) $manager = '';
				
				foreach ($managers->result() as $row_manager)
						$manager = $row_manager->name;
				
				unset( $managers ); // Free memory
				
			}else{
				$manager='';
			}
			
			
			// Getting Types
			/*
			SELECT user_roles.name 
			FROM `users_vs_user_roles`
			JOIN  `user_roles` ON user_roles.id=`users_vs_user_roles`.user_role_id
			WHERE users_vs_user_roles.user_id=1;
			*/
			
			
			$tipo='';
			$this->db->select( 'user_roles.name' );
			$this->db->from( 'users_vs_user_roles' );
			$this->db->join( 'user_roles', ' user_roles.id=users_vs_user_roles.user_role_id ' );
			$this->db->where( 'users_vs_user_roles.user_id', $row->id  );
			
			$types = $this->db->get();
			
			if ($types->num_rows() == 0) $tipo = '';
			
			foreach ($types->result() as $row_types)
					$tipo .= $row_types->name.'<br>';	
				
			unset( $types ); // Clean memory
			
			
			
			
			
			// Getting Clave
			/*
				SELECT agent_uids.uid 
				FROM agents
				JOIN agent_uids ON agent_uids.agent_id=agents.id
				WHERE agent_uids.type='clave' AND agents.user_id=2;
			*/
			$clave='';			
			$this->db->select( 'agent_uids.uid' );
			$this->db->from( 'agents' );
			$this->db->join( 'agent_uids', 'agent_uids.agent_id=agents.id' );
			$this->db->where( array( 'agent_uids.type' => 'clave', 'agents.user_id' => $row->id )  );
			
			$claves = $this->db->get();
			
			if ($claves->num_rows() == 0) $clave = '';
			
			foreach ($claves->result() as $row_claves)
					$clave .= $row_claves->uid.'<br>';	
				
			unset( $claves ); // Clean memory
			
			
			
			// Getting Clave
			/*
				SELECT agent_uids.uid 
				FROM agents
				JOIN agent_uids ON agent_uids.agent_id=agents.id
				WHERE agent_uids.type='national' AND agents.user_id=2;
			*/
			$national='';			
			$this->db->select( 'agent_uids.uid' );
			$this->db->from( 'agents' );
			$this->db->join( 'agent_uids', 'agent_uids.agent_id=agents.id' );
			$this->db->where( array( 'agent_uids.type' => 'national', 'agents.user_id' => $row->id )  );
			
			$nationals = $this->db->get();
			
			if ($nationals->num_rows() == 0) $national = '';
			
			foreach ($nationals->result() as $row_national)
					$national .= $row_national->uid.'<br>';	
				
			unset( $nationals ); // Clean memory
			
			
			
			
			// Getting Clave
			/*
				SELECT agent_uids.uid 
				FROM agents
				JOIN agent_uids ON agent_uids.agent_id=agents.id
				WHERE agent_uids.type='provincial' AND agents.user_id=2;
			*/
			$provincial='';			
			$this->db->select( 'agent_uids.uid' );
			$this->db->from( 'agents' );
			$this->db->join( 'agent_uids', 'agent_uids.agent_id=agents.id' );
			$this->db->where( array( 'agent_uids.type' => 'provincial', 'agents.user_id' => $row->id )  );
			
			$provincials = $this->db->get();
			
			if ($provincials->num_rows() == 0) $provincial = '';
			
			foreach ($provincials->result() as $row_provincial)
					$provincial .= $row_provincial->uid.'<br>';	
				
			unset( $provincials ); // Clean memory
			
			
			$this->data[] = array( 
		    	'id' => $row->id,
		    	'name' => $row->name,
				'lastnames' => $row->lastnames,
				'email' => $row->email,				
				'manager_id' => $manager,
				'tipo' => $tipo,
				'clave' => $clave,
				'national' => $national,
				'provincial' => $provincial,
		    	'date' => $row->date ,
		    	'last_updated' => $row->last_updated
		    );
		
		

		}

		return $this->data;
		
   }

	


// Count records for pagination
	public function record_count() {
        return $this->db->count_all( 'users' );
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
        $query = $this->db->get( 'users' );
		
		
		
		if ($query->num_rows() == 0) return false;
 	
		
		// Clean vars
		unset( $this->data );

		$this->data = array();
		
		
		
		// Getting data
		foreach ($query->result() as $row) {

			$this->data[] = array( 
		    	'id' => $row->id,
		    	'office_id' => $row->office_id,
				'company_name' => $row->company_name,			
				'username' => $row->username,
				'name' => $row->name,
				'lastnames' => $row->lastnames,
				'birthdate' => $row->birthdate,
				'email' => $row->email,
				'disabled' => $row->disabled
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