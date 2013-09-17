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
					
				
        if( $this->db->update( $table, $values, array( 'id' => $id ) ) )
			
			return true;
        
		else
        	
			return false;
        
		
    }

/**
 |	Remove 
 **/ 	
	 public function delete( $table = 'users', $field = 'id', $value = null ){
        
		if( empty( $table ) or empty( $field )  or empty( $value ) ) return false;
					   
			if( $this->db->delete( $table, array( $field => $value ) ) )
			
					return true;
			
			else
			
				return false;
			
			
				
    }





// Return insert id
	public function insert_id(){   return $this->insertId;  }










/**
 |	Getting for overview
 **/ 
	
	public function overview( $start = 0, $filter = null ) {
		
		/*
		 SELECT id, name, lastnames, email 
		 FROM `users` 
		 JOIN users_vs_user_roles ON users_vs_user_roles.user_id=users.id 
		 WHERE users_vs_user_roles.user_role_id=1;
		
		*/
		$this->db->select( 'id, name, lastnames, email, company_name,  manager_id, date, last_updated' );
		$this->db->from( 'users' );
        
		
		if( !empty( $filter ) ){
			
			$this->db->join( 'users_vs_user_roles', 'users_vs_user_roles.user_id=users.id '  );
			$this->db->where( 'users_vs_user_roles.user_role_id', $filter );
			
		}else{
					
			$this->db->limit( 150, $start );
		
		}
		
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
				'company_name' => $row->company_name,		
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
	public function record_count( $filter = null ) {
       
	   	if( empty( $filter ) )
	   	 return $this->db->count_all( 'users' );
		else
		   return $this->db->from( 'users_vs_user_roles' )->where( array( 'user_role_id' => $filter ) )->count_all_results();
    }




// Count records for rol
	public function record_count_roles( $role = null ) {
        
		
		if( empty( $role ) ) return 0;
		
		// SELECT COUNT(*) from users_vs_user_roles WHERE user_role_id=1;
		
		
		return $this->db->select()-> from( 'users_vs_user_roles' )->where( array( 'user_role_id' => $role ) )->count_all_results();
    
	}







// FInd Method
	public function find( $find =  null ) {
		
		
		if( empty( $find ) ) return false;
		
		
		$this->db->select();
		$this->db->from(  'users' );
		
		if( isset( $find['rol'] ) and !empty( $find['rol'] ) ){
			
			/*
				JOIN users ON users.id=users_vs_user_roles.user_id
				WHERE users_vs_user_roles.user_role_id=1;
			*/
			
			$this->db->join( 'users_vs_user_roles', 'users_vs_user_roles.user_id=users.id' );		
			$this->db->where( array( 'users_vs_user_roles.user_role_id' => $find['rol'] ) );	
		
		}else{
						
			
		}
		
		
		if( isset( $find['find'] ) and !empty( $find['find'] ) )
			$this->db->like( 'users.name', $find['find'] );
		
		
		
		// Advanced search
		if( isset( $find['advanced'] ) and !empty( $find['advanced'] ) ){
			
			foreach( $find['advanced'] as $value ){
			
				if( in_array( 'clave', $value ) or in_array( 'national', $value ) or in_array( 'provincial', $value  ) or in_array( 'license_expired_date', $value  ) ){
					
					$this->db->join( 'agents', 'agents.user_id=users.id' );	
					
				}
				
				if( in_array( 'clave', $value ) or in_array( 'national', $value ) or in_array( 'provincial', $value  ) ){
					
					$this->db->join( 'agent_uids', 'agent_uids.agent_id=agents.id' );	
					
				}
				break;
			
			}
			
			
			
			foreach( $find['advanced'] as $value )
				
				
					
					
				
				if( $value[0] == 'clave' ){
					
					$this->db->like( array( 'agent_uids.type' => $value[0], 'agent_uids.uid' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'national' ){
					
					$this->db->like( array( 'agent_uids.type' => $value[0], 'agent_uids.uid' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'provincial' ){
					
					$this->db->like( array( 'agent_uids.type' => $value[0], 'agent_uids.uid' => $value[1] ) );	
					
				}
				
				
				if( $value[0] == 'birthdate' ){
					
					$this->db->where( array( 'users.birthdate' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'manager_id' ){
					
					$this->db->where( array( 'users.manager_id' => $value[1] ) );	
					
				}
				
				
				if( $value[0] == 'name' ){
					
					$this->db->like( array( 'users.name' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'lastname' ){
					
					$this->db->like( array( 'users.lastnames' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'email' ){
					
					$this->db->where( array( 'users.email' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'license_expired_date' ){
					
					$this->db->where( array( 'agents.license_expired_date' => $value[1] ) );	
					
				}
					
					
					
					//clavenationalprovincial
				
				//print_r( $value[0] );
			/*print_r( $fprint_r( $find['advanced'] );ind['advanced'] );
			
			JOIN `agents` ON agents.user_id=users.id
			JOIN `agent_uids` ON `agent_uids`.`agent_id`=agents.id
			WHERE type='' AND uid='';
			*/
			
			//exit;
			
		}
		
		
		
		
			
		
		$query = $this->db->get();
		
			
						
		if ($query->num_rows() == 0) return false;
 
		
		// Clean vars
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
				'company_name' => $row->company_name,			
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


	public function getIdRol( $name = null ){
		
		if( empty( $name ) ) return false; 
		
		
		$this->db->select( 'user_roles.id' );
		$this->db->from( 'user_roles' );
		$this->db->where( 'name', ucwords(trim($name))  );
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		foreach ($query->result() as $row)
				return $row->id;	
		
		
		
	}



// Export Method
	public function export( $start = 0 ) {
		
		
		// SELECT id, name, lastnames, email FROM `users`;
		$this->db->select();
		$this->db->from( 'users' );
        $this->db->limit( 150, $start );
		
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
					$tipo .= $row_types->name.', ';	
				
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
					$clave .= $row_claves->uid.', ';	
				
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
					$national .= $row_national->uid.', ';	
				
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
					$provincial .= $row_provincial->uid.', ';	
				
			unset( $provincials ); // Clean memory
			
			
			
			// Representatives
			/*
				SELECT * 
				FROM `representatives`
				WHERE `user_id`=3
			*/
			$representatives='';			
			$this->db->select();
			$this->db->from( 'representatives' );
			$this->db->where( array( 'user_id' => $row->id )  );
			
			$representative = $this->db->get();
			
			if ($representative->num_rows() == 0) $representatives = '';
			
			foreach ($representative->result() as $row_representative)
					$provincial .= $row_representative->name.','.$row_representative->lastnames.','.$row_representative->office_phone.','.$row_representative->office_phone.','.$row_representative->office_ext.','.$row_representative->mobile;	
				
			unset( $representative ); // Clean memory
			
			
			$this->data[] = array( 
		    	'office_id' => $row->office_id,
				'manager_id' => $manager,
				'company_name' => $row->company_name,
				'username' => $row->username,
				'name' => $row->name,
				'lastnames' => $row->lastnames,
				'birthdate' => $row->birthdate,				
				'email' => $row->email,		
				'disabled' => $row->disabled,
				'tipo' => $tipo,
				'clave' => $clave,
				'national' => $national,
				'provincial' => $provincial,
				'representatives' => $representatives
		    );
		
		

		}

		return $this->data;
		
   }





// FInd Method export
	public function export_find( $find =  array() ) {
		
		
		if( empty( $find ) ) return false;
		
		
		$this->db->select();
		$this->db->from(  'users' );
		
		if( isset( $find['rol'] ) and !empty( $find['rol'] ) ){
			
			/*
				JOIN users ON users.id=users_vs_user_roles.user_id
				WHERE users_vs_user_roles.user_role_id=1;
			*/
			
			$this->db->join( 'users_vs_user_roles', 'users_vs_user_roles.user_id=users.id' );		
			$this->db->where( array( 'users_vs_user_roles.user_role_id' => $find['rol'] ) );	
		
		}else{
						
			
		}
		
		
		if( isset( $find['find'] ) and !empty( $find['find'] ) )
			$this->db->like( 'users.name', $find['find'] );
		
		
		
		// Advanced search
		if( isset( $find['advanced'] ) and !empty( $find['advanced'] ) ){
			
			foreach( $find['advanced'] as $value ){
			
				if( in_array( 'clave', $value ) or in_array( 'national', $value ) or in_array( 'provincial', $value  ) or in_array( 'license_expired_date', $value  ) ){
					
					$this->db->join( 'agents', 'agents.user_id=users.id' );	
					
				}
				
				if( in_array( 'clave', $value ) or in_array( 'national', $value ) or in_array( 'provincial', $value  ) ){
					
					$this->db->join( 'agent_uids', 'agent_uids.agent_id=agents.id' );	
					
				}
				break;
			
			}
			
			
			
			foreach( $find['advanced'] as $value )
				
				
					
					
				
				if( $value[0] == 'clave' ){
					
					$this->db->like( array( 'agent_uids.type' => $value[0], 'agent_uids.uid' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'national' ){
					
					$this->db->like( array( 'agent_uids.type' => $value[0], 'agent_uids.uid' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'provincial' ){
					
					$this->db->like( array( 'agent_uids.type' => $value[0], 'agent_uids.uid' => $value[1] ) );	
					
				}
				
				
				if( $value[0] == 'birthdate' ){
					
					$this->db->where( array( 'users.birthdate' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'manager_id' ){
					
					$this->db->where( array( 'users.manager_id' => $value[1] ) );	
					
				}
				
				
				if( $value[0] == 'name' ){
					
					$this->db->like( array( 'users.name' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'lastname' ){
					
					$this->db->like( array( 'users.lastnames' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'email' ){
					
					$this->db->where( array( 'users.email' => $value[1] ) );	
					
				}
				
				if( $value[0] == 'license_expired_date' ){
					
					$this->db->where( array( 'agents.license_expired_date' => $value[1] ) );	
					
				}
					
					
					
					//clavenationalprovincial
				
				//print_r( $value[0] );
			/*print_r( $fprint_r( $find['advanced'] );ind['advanced'] );
			
			JOIN `agents` ON agents.user_id=users.id
			JOIN `agent_uids` ON `agent_uids`.`agent_id`=agents.id
			WHERE type='' AND uid='';
			*/
			
			//exit;
			
		}
		
		$query = $this->db->get();
		
			
						
		if ($query->num_rows() == 0) return false;
 
		
		// Clean vars
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
					$tipo .= $row_types->name.', ';	
				
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
					$clave .= $row_claves->uid.', ';	
				
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
					$national .= $row_national->uid.', ';	
				
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
					$provincial .= $row_provincial->uid.', ';	
				
			unset( $provincials ); // Clean memory
			
			
			// Representatives
			/*
				SELECT * 
				FROM `representatives`
				WHERE `user_id`=3
			*/
			$representatives='';			
			$this->db->select();
			$this->db->from( 'representatives' );
			$this->db->where( array( 'user_id' => $row->id )  );
			
			$representative = $this->db->get();
			
			if ($representative->num_rows() == 0) $representatives = '';
			
			foreach ($representative->result() as $row_representative)
					$provincial .= $row_representative->name.','.$row_representative->lastnames.','.$row_representative->office_phone.','.$row_representative->office_phone.','.$row_representative->office_ext.','.$row_representative->mobile;	
				
			unset( $representative ); // Clean memory
			
			$disabled = 'Desactivado';
			
			if( $row->disabled == 1 ) $disabled = 'Activado';
			
			$this->data[] = array( 
		    	'office_id' => $row->office_id,
				'manager_id' => $manager,
				'company_name' => $row->company_name,
				'username' => $row->username,
				'name' => $row->name,
				'lastnames' => $row->lastnames,
				'birthdate' => $row->birthdate,				
				'email' => $row->email,		
				'disabled' => $disabled,
				'tipo' => $tipo,
				'clave' => $clave,
				'national' => $national,
				'provincial' => $provincial,
				'representatives' => $representatives
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
	
	
// Get user by id to update
	public function getByIdToUpdate( $id = null ){
		
		if( empty( $id ) ) return false;
				
		unset( $this->data );	$this->data = array();
		
		// Validation form not repear name
		$this->db->
					select()
				  ->
				   from( 'users' )	
				  ->
				   where( array( 'id' => $id ) );
		
		$query = $this->db->get();
				
		if( $query->num_rows == 0 ) return false;
		
		foreach ($query->result() as $row)
		
			$this->data[] = array( 
				  
				  'id' => $row->id,
				  'username' => $row->username,
				  'password' => $row->password,
				  'email' => $row->email,
				  'picture' => $row->picture
				  
				  
			);
				
		return $this->data[0];
		
	}	
	
	
	
	
	
	// getForUpdateOrDelete
	public function getForUpdateOrDelete( $id = null ){
		
		if( empty( $id ) ) return false;
		
		
		
		$this->db->where( array( 'id' => $id ) );
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
				'disabled' => $row->disabled,
				'picture' => $row->picture
		    );

		}
		
		unset( $query );
		
		
		// Getting users_vs_user_roles
		if( !empty( $this->data ) ){
			
			$users_vs_user_roles = array();
			
			$this->db->where( array( 'user_id' => $id ) );
		
			$query = $this->db->get( 'users_vs_user_roles' );
			
			if ($query->num_rows() > 0){
		
				foreach ($query->result() as $row) {
		
					$users_vs_user_roles[] = array( 
						'user_id' => $row->user_id,
						'user_role_id' => $row->user_role_id
					);
		
				}
				
				$this->data['users_vs_user_roles'] = $users_vs_user_roles;		
			}
			
			
			
		}
		
		
		
		unset( $query );
		
		
		
		
		
		
		
		
		
		
		// Get agents info
		$this->db->where( array( 'user_id' => $id ) );
		
		$query = $this->db->get( 'agents' );
		
		$agents = array();
		
		
		if ($query->num_rows() > 0){
		
			foreach ($query->result() as $row) {
	
				$agents[] = array( 
					'id' => $row->id,
					'user_id' => $row->user_id,
					'connection_date' => $row->connection_date,			
					'license_expired_date' => $row->license_expired_date
				);
	
			}
			
			$this->data['agents'] = $agents;		
		}
		
		
		
		
		
		// Getting data for agents
		if( isset( $this->data['agents'] ) ){
			
			$agent_uids=array();
			
			$this->db->where( array( 'agent_id' => $this->data['agents'][0]['id'] ) );
		
			$query = $this->db->get( 'agent_uids' );
			
			if ($query->num_rows() > 0){
			
				
				foreach ($query->result() as $row) {
		
					$agent_uids[] = array( 
						'id' => $row->id,
						'agent_id' => $row->agent_id,
						'type' => $row->type,			
						'uid' => $row->uid
					);
		
				}
			
			}
			
			$this->data['agent_uids'] = $agent_uids;	
		
		
		}
		
		
		
		// Getting Representatives
		if( !empty( $this->data ) ){
			
			$representatives=array();
			
			$this->db->where( array( 'user_id' => $this->data[0]['id'] ) );
		
			$query = $this->db->get( 'representatives' );
			
			if ($query->num_rows() > 0){
				
				foreach ($query->result() as $row) {
		
					$representatives[] = array( 
						'id' => $row->id,
						'user_id' => $row->user_id,
						'name' => $row->name,			
						'lastnames' => $row->lastnames,
						'office_phone' => $row->office_phone,
						'office_ext' => $row->office_ext,
						'mobile' => $row->mobile
					);
		
				}
				
			}
			
			$this->data['representatives'] = $representatives;	
			
		}
		
		return $this->data;
		
		
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
				'disabled' => $row->disabled,
				'picture' => $row->picture
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
	

// Get selects Agents 	
	public function getAgents(){
		
		/*
			SELECT agents.id, users.name FROM agents
			JOIN users ON users.id=agents.user_id;
		*/
		$this->db->select( 'agents.id, users.name, users.lastnames, users.company_name' );
		$this->db->from( 'agents' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		//$this->db->order_by( 'users.company_name', 'asc' );
		
		$query = $this->db->get();
		
		$options = '<option value="">Seleccione</option>';
		
		if ($query->num_rows() == 0) return $options;
		
		$agents = array();
		
		// Getting data
		foreach ($query->result() as $row){
			
			
			if( !empty( $row->company_name ) )
				$agents[] = array( 'name' => $row->company_name, 'id' => $row->id );
			
			else
				$agents[] = array( 'name' => $row->name.' '.$row->lastnames, 'id' => $row->id );	
			
			
		}
				
		 asort($agents);
				 	
		 foreach( $agents as $value )
		
				$options .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		
		return $options;
		
	}


// Get Agents by id 	
	public function getAgentsById( $id = null ){
		
		if( empty( $id ) ) return false;
		
		/*
			SELECT users.name, users.company_name 
			FROM agents
			JOIN users ON users.id=agents.user_id
			WHERE agents.id=5;
		*/
		$this->db->select( 'users.name, users.company_name, users.lastnames ' );
		$this->db->from( 'agents' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( 'agents.id =', $id );
		
		$query = $this->db->get();
		
		
		
		if ($query->num_rows() == 0) return false;
		
		// Getting data
		foreach ($query->result() as $row){
			
			
			if( !empty( $row->company_name ) )
				return $row->company_name;
			
			else
				return $row->name.' '.$row->lastnames;	
			
			
		}
		
		return true;
		
	}	

// Getting user_id	
	public function getUserIdByAgentId( $id = null ){
		
		if( empty( $id ) ) return false;
		
		
		/*
			SELECT user_id
			FROM agents
			WHERE agents.id=5;
		*/
		$this->db->select( 'user_id' );
		$this->db->from( 'agents' );
		$this->db->where( 'agents.id =', $id );
		
		$query = $this->db->get();
		
		
		
		if ($query->num_rows() == 0) return false;
		
		$user = null;
		
		// Getting data
		foreach ($query->result() as $row)
			
			$user = $row->user_id;
			
		
		return $user;
		
	}	
	
	
	
/**
 *	Import Payments
 **/	
	public function getAgentByFolio( $uid = null, $type = null, $optiongroup = null ){
		
		if( empty( $uid ) ) return false;
		
		/*
			SELECT users.company_name, users.name, users.lastnames
			FROM agent_uids 
			JOIN `agents` ON `agents`.id=agent_uids.agent_id
			JOIN `users` ON `users`.id=agents.user_id
			WHERE agent_uids.`uid`='1421424';
		*/
		$this->db->select( ' users.company_name, users.name, users.lastnames' );
		$this->db->from( 'agent_uids' );
		$this->db->join( 'agents', 'agents.id=agent_uids.agent_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( array( 'agent_uids.uid' => $uid, 'agent_uids.type' => $type ) );
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0){
			 
			 $options = '<select name="agent_id['.$optiongroup.']" class="required options-'.$optiongroup.'">';
				 
			 $options .= $this->getAgents();
			 
			 $options .= '</select>';
			 
			 $options .= '<a id="link-'.$optiongroup.'"  href="javascript:void(0)" class="create-user"><i class="icon-plus"></i></a>';
			 
			 return $options;
		}
				
		foreach ($query->result() as $row){
						
			if( !empty( $row->company_name ) )
				return $row->company_name;
			
			else
				return $row->name.' '.$row->lastnames;
			
			
		}
				
				
		return false;
		
	}
	
	
	
	public function getIdAgentByFolio( $uid = null ){
		
		if( empty( $uid ) ) return false;
		
		/*
			SELECT id 
			FROM agent_uids
			WHERE agent_uids.uid='';
		*/
		$this->db->select( ' id' );
		$this->db->from( 'agent_uids' );
		$this->db->where( 'agent_uids.uid', $uid );
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return null;
				
		foreach ($query->result() as $row)
						
			return $row->id;
			
			
		
				
				
		return false;
		
	}
	
	
	
	
	
	
	
	
	
	
// Validations
	public function is_unique( $field = null, $value = null ){
		
		if( empty( $field ) or empty( $value ) ) return false;
		
		
		$this->db->where( array( $field  => $value )  );
        $this->db->limit( 1 ); // Limit 1 record

		// Get Resutls
        $query = $this->db->get( 'users' );
		
		
		if ($query->num_rows() == 0) 
			
			return true;
		
		else
			
			return false;
		
			
	}	













/**
 *	Report of agents
 **/

	
	
	public function getReport( $filter = array() ){
 	
	
	/**
	 *	SELECT users.*, agents.id as agent_id
		FROM `agents`
		JOIN `users` ON users.id=agents.user_id
		WHERE  work_order.product_group_id=1
	 **/
	
	$this->db->select( 'users.*, agents.connection_date, agents.id as agent_id' );
	$this->db->from( 'agents' );
	$this->db->join( 'users', 'users.id=agents.user_id' );
	
	/*
	if( !empty( $filter ) ){
		/*
		$this->db->join( 'work_order', 'work_order.user=users.id' );
				
		if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
						
			$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
		}
		*
		
		/*
		<option value="1">Mes</option>
		<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
		<option value="3">Año</option>
		*								
		
		$mes = date( 'Y' ).'-'.(date( 'm' )-1).'-'.date( 'd' );
		//echo date('Y-m-d', mktime(0,0,0,date('n')-1,1,date('Y')));;
		
		$trimestre = date( 'Y' ).'-'.(date( 'm' )-3).'-'.date( 'd' );		
		
		$cuatrimetre = date( 'Y' ).'-'.(date( 'm' )-4).'-'.date( 'd' );
		
		$anio = (date( 'Y' )-1).'-'.date( 'm' ).'-'.date( 'd' );
		
		
		if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
			
			if( $filter['query']['periodo'] == 1 )
			
				$this->db->where( 'work_order.creation_date >= ', strtotime( $mes ) ); 
			
			if( $filter['query']['periodo'] == 2 )
			
				
				if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 )
					
					$this->db->where( 'work_order.creation_date >= ', strtotime( $cuatrimetre ) ); 
				
				else
					
					$this->db->where( 'work_order.creation_date >= ', strtotime( $trimestre ) ); 
					
				
				
				
			if( $filter['query']['periodo'] == 3 )
			
				$this->db->where( 'work_order.creation_date >= ', strtotime( $anio ) ); 		
			
		}
		
		
		if( isset( $filter['query']['generacion'] ) and !empty( $filter['query']['generacion'] ) ){
			/*
			foreach( $filter['query']['generacion'] as $generacion ){
				
				$this->db->where();
				
			}
			*
		}
		
		
		
		
		if( isset( $filter['query']['gerente'] ) and !empty( $filter['query']['gerente'] ) ){
			
			$this->db->where( 'users.manager_id', $filter['query']['gerente'] ); 	
			
		}
		
		
		if( isset( $filter['query']['agent'] ) and !empty( $filter['query']['agent'] ) ){
			
			/*
			<option value="">Seleccione</option>
			<option value="1">Todos</option>
			<option value="2">Vigentes</option>
			<option value="3">Cancelados</option>
			*						  
			
			if( $filter['query']['agent'] == 1 ){
				
				$this->db->where( 'users.disabled', 1 ); 	
				$this->db->or_where( 'users.disabled', 2 ); 	
				
			}	
			
			
			if( $filter['query']['agent'] == 2 )
				
				$this->db->where( 'users.disabled', 1 ); 
			
			if( $filter['query']['agent'] == 3 )
				
				$this->db->where( 'users.disabled', 0 ); 	
				
				
					
		}
		
			
	}*/
	
	
	$query = $this->db->get(); 
  	
	if ($query->num_rows() == 0) return false;		
	
	$report = array();
	
	foreach ($query->result() as $row){
		
		$name = null;
		
		if( empty(  $row->company_name ) )
			
			$name =  $row->name. ' ' . $row->lastnames;
		
		else
			
			$name =  $row->company_name;
		
		
		
		$report[] = array(
			
			'id' => $row->id,
			'name' => $name,
			'uids' => $this->getAgentsUids( $row->agent_id ),
			'connection_date' => $row->connection_date,
		    'disabled' => $row->disabled,
			'negocio' => $this->getCountNegocio( $row->id, $filter ),
			'negociopai' => $this->getCountNegocioPai( $row->id, $filter ),
			'prima' => $this->getPrima( $row->id, $filter ),
			'tramite' => $this->getTramite( $row->id, $filter ),
			'aceptadas' => $this->getAceptadas( $row->id, $filter )
			
		);
		
	}	
	
	return $report;
	
	
 }
 
 
 public function getAgentsUids( $agent = null ){
 	
	if( empty( $agent ) );
	/*
	SELECT * 
	FROM `agent_uids`
	WHERE `agent_id` =
	*/
	
	$this->db->select();
	$this->db->from( 'agent_uids' );
	$this->db->where( 'agent_id', $agent );
	$this->db->where( 'type', 'clave' );
	
	$query = $this->db->get(); 
  	
	if ($query->num_rows() == 0) return false;		
 	
	$uids = array();
	
	foreach ($query->result() as $row)
	
		$uids[] = array(
			'type' => $row->type,
			'uid' => $row->uid
		);
		
	return $uids;
	
 }
 
  public function getCountNegocio( $user_id = null ){
 		
		if( empty( $user_id ) ) return 0;
		/*
		SELECT count(*) 
		FROM `policies_vs_users`
		JOIN  payments ON payments.policy_id=policies_vs_users.policy_id
		WHERE policies_vs_users.user_id=8
		AND amount>0
		*/
		
		$this->db->select( 'count(*) as count' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'payments', 'payments.policy_id=policies_vs_users.policy_id' );
		$this->db->where( array( 'policies_vs_users.user_id' => $user_id, 'amount >' =>  0 ) );
  		
		$query = $this->db->get(); 
  	
		if ($query->num_rows() == 0) return 0;		
		
		foreach ($query->result() as $row)
			
			return $row->count;
		
		return 0;
	
  }
  
  public function getCountNegocioPai( $user_id = null ){
 		
		
		
		if( empty( $user_id ) ) return 0;
		/*
		SELECT DISTINCT( policies_vs_users.policy_id )
		FROM `policies_vs_users`
		JOIN  payments ON payments.policy_id=policies_vs_users.policy_id
		WHERE policies_vs_users.user_id=8
		AND amount>10.000
		*/
		
		$this->db->distinct( 'policies_vs_users.policy_id' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'payments', 'payments.policy_id=policies_vs_users.policy_id' );
		$this->db->where( array( 'policies_vs_users.user_id' => $user_id, 'amount >' =>  10.000 ) );
  		
		$query = $this->db->get(); 
  		
		if ($query->num_rows() == 0) return 0;		
		
		$pai = array();
		
		foreach ($query->result() as $row){
			
			
			/*
				SELECT SUM(amount) as sum
				FROM payments
				WHERE policy_id=28
			*/
			
			$this->db->select_sum( 'amount' );
			$this->db->from( 'payments' );
			$this->db->where( array( 'policy_id' => $row->policy_id ) );
			
			$querypai = $this->db->get(); 
			
			if ($querypai->num_rows() == 0) break;
			
			
			foreach ($querypai->result() as $rowpai)
				
				if( (float)$rowpai->amount >= 5.000 )
					
					$pai[]=$rowpai->amount;
				
		}
			
		
			
			
			
		return $pai;
		
	
  }
  
  
  public function getPrima( $user_id = null ){
 		
		if( empty( $user_id ) ) return 0;
		/*
		SELECT SUM( prima )
		FROM policies
		JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
		WHERE policies_vs_users.user_id=7
		*/
		
		$this->db->select_sum( 'prima' );
		$this->db->from( 'policies' );
		$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=policies.id' );
		$this->db->where( array( 'policies_vs_users.user_id' => $user_id ) );
  		
		$query = $this->db->get(); 
  	
		if ($query->num_rows() == 0) return 0;		
		
		$prima = 0;
		
		foreach ($query->result() as $row)
			
			$prima = $row->prima;
		
		if( empty( $prima ) ) $prima = 0;
		
		return $prima;
	
  }
  
  
  public function getTramite( $user_id = null ){
 		
		if( empty( $user_id ) ) return 0;
		/*
		SELECT policy_id
		FROM `work_order`
		WHERE work_order_status_id!=7
		AND user=9
		AND ( `work_order_type_id`=47 OR `work_order_type_id`=90 )
		*/
		
		
		$this->db->select( 'policy_id' );
		$this->db->from( 'work_order' );
		$this->db->where( array( 'work_order_status_id !=' => 7, 'work_order_type_id' => 47  ) );
		$this->db->or_where( 'work_order_type_id', 90 );
		$this->db->where( 'user', $user_id );
		
		$query = $this->db->get(); 
  	
		if ($query->num_rows() == 0) return 0;		
		
		$tramite = array();
				
		$tramite['count'] = $query->num_rows();
		
		$tramite['prima'] = 0;
		
		foreach ($query->result() as $row){
									
			
			/*
			SELECT SUM( prima )
			FROM policies
			WHERE id=9
			*/
			
			
			$this->db->select_sum( 'prima' );
			$this->db->from( 'policies' );
			$this->db->where( array( 'id' => $row->policy_id ) );
					
			$queryprima = $this->db->get(); 
			
			$prima = 0;
			
			if ($queryprima->num_rows() == 0){
				
				$prima = 0;												
				
			}else{
				
				foreach ($queryprima->result() as $rowprima){
					
					if( !empty( $rowprima->prima ) ) $tramite['prima'] = (float)$tramite['prima'] + (float)$rowprima->prima;
					
				}
				
				
				
			}
			
		}
		
		
		
		return $tramite;
	
  }	
  
  public function getAceptadas(  $user_id = null ){
  	
	
		if( empty( $user_id ) ) return 0;
		/*
		SELECT policy_id
		FROM `work_order`
		WHERE work_order_status_id=7
		AND user=7
		*/
		
		
		$this->db->select( 'policy_id' );
		$this->db->from( 'work_order' );
		$this->db->where( array( 'work_order_status_id' => 7 ) );
		$this->db->where( 'user', $user_id );
  		
		
		$query = $this->db->get(); 
  		
		
		if ($query->num_rows() == 0) return 0;		
		
		$aceptadas = array();
		
		$aceptadas['prima'] = 0;
		
		$aceptadas['count']=0;
		
		foreach ($query->result() as $row){
			
			/*
			SELECT *
			FROM payments
			WHERE `policy_id`=1
			*/
			
			
			$this->db->select();
			$this->db->from( 'payments' );
			$this->db->where( array( 'policy_id' => $row->policy_id ) );
					
			$querypayments = $this->db->get(); 
			
			
			if ($querypayments->num_rows() == 0){
				
				/*
				SELECT SUM( prima )
				FROM policies
				WHERE id=1*/
				$this->db->select_sum( 'prima' );
				$this->db->from( 'policies' );
				$this->db->where( array( 'id' => $row->policy_id ) );
				
				$querypolicies = $this->db->get(); 
				
				
				if ($querypolicies->num_rows() > 0){
					
					foreach ($querypolicies->result() as $rowprima){
					
					$aceptadas['count'] = (int)$aceptadas['count']+1;
					
					if( !empty( $rowprima->prima ) ) $aceptadas['prima'] = (float)$aceptadas['prima'] + (float)$rowprima->prima;
					
				}
					
				}
				
				
			}	
			
			
		}
		
		
		
		
		
		
		return $aceptadas;		
		
  }
	

}
?>