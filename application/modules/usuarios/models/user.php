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
	
	
	public function getSelectsGerentes2(){
		
	
		
		$query = $this->db->query(' SELECT DISTINCT(users.name), users.id  
									FROM `users_vs_user_roles` 
									JOIN users ON users.id = `user_id` 
									WHERE user_role_id=3;');
						
		
		if ($query->num_rows() == 0) return false;
 	
		
		$data = array();	
		
		// Getting data
		foreach ($query->result() as $row)
			
			$data[] = array( 'id' =>  $row->id, 'name' => $row->name );
			
		
		return $data;
		
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
	
	public function getAgentIdByUser( $user = null ){
		
		if( empty( $user ) ) return false;
		
		
		/*
			SELECT id
			FROM agents
			WHERE agents.user_id=5;
		*/
		$this->db->select( 'id' );
		$this->db->from( 'agents' );
		$this->db->where( 'agents.user_id =', $user );
		
		$query = $this->db->get();
		
		
		
		if ($query->num_rows() == 0) return false;
		
		$agent = null;
		
		// Getting data
		foreach ($query->result() as $row)
			
			$agent = $row->id;
			
		
		return $agent;
		
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
		//14011 en vez de P0014011.
		
		$uidorigin = $uid;
						
		$this->db->select( ' users.company_name, users.name, users.lastnames' );
		$this->db->from( 'agent_uids' );
		$this->db->join( 'agents', 'agents.id=agent_uids.agent_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( array( 'agent_uids.type' => $type ) );
		
		
		if( !empty( $type ) and $type == 'national' ){
			
			$uid = str_replace( "N000000", '', $uid );
			$uid = str_replace( "N00000", '', $uid );
			$uid = str_replace( "N0000", '', $uid );
			$uid = str_replace( "N000", '', $uid );
			$uid = str_replace( "N00", '', $uid );
			$uid = str_replace( "N0", '', $uid );			
			$uid = ltrim( $uid, '0');
			
			//$this->db->where( 'agent_uids.type', 'national' );
			
			$this->db->where( '(agent_uids.uid=\''.$uidorigin.'\' OR agent_uids.uid=\''.$uid.'\')' );
			
			
		}
		if( !empty( $type ) and $type == 'provincial' ) {
			
			$uid = str_replace( "P000000", '', $uid );
			$uid = str_replace( "P00000", '', $uid );
			$uid = str_replace( "P0000", '', $uid );
			$uid = str_replace( "P000", '', $uid );
			$uid = str_replace( "P00", '', $uid );
			$uid = str_replace( "P0", '', $uid );
			$uid = ltrim( $uid, '0');
			
			//$this->db->where( 'agent_uids.type', 'provincial' );
			
			$this->db->where( '(agent_uids.uid=\''.$uidorigin.'\' OR agent_uids.uid=\''.$uid.'\')' );
		}
		
		$this->db->limit(1);
				
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
	 **/
	
	$this->db->select( 'users.*, agents.connection_date, agents.id as agent_id' );
	$this->db->from( 'agents' );
	$this->db->join( 'users', 'users.id=agents.user_id' );
	
	$generacion = '';
	
	if( !empty( $filter ) ){
			
			if( isset( $filter['query']['generacion'] ) and !empty( $filter['query']['generacion'] ) ){
				/*
				<option value="">Todas las Generaciónes</option>
				<option value="2">Consolidado</option>
				<option value="3">Generación 1</option>
				<option value="4">Generación 2</option>
				<option value="5">Generación 3</option>
				
				
				*/
				
				//Consolidado: < 3 años  <option value="2">Consolidado</option>														
				if( $filter['query']['generacion'] == 2 ){
					
					$begin = ( date( 'Y' )-3 ).date( '-m-d' );
					
					$end = 	date( 'Y-m-d' );
						
					$this->db->where( array( 'agents.connection_date <' => $begin, 'agents.connection_date !=' => '0000-00-00' ) ); 	
					
					$generacion = 'Consolidado';
					
				} 
				
				
				//Generación 1: Fecha de conexión > 1 año < hoy <option value="3">Generación 1</option>
				if( $filter['query']['generacion'] == 3 ){
					
					$begin = ( date( 'Y' )-1 ).date( '-m-d' );
					
					$end = 	date( 'Y-m-d' );
					
					$this->db->where( array( 'agents.connection_date >=' => $begin, 'agents.connection_date <=' => $end, 'agents.connection_date = ' => "0000-00-00" ) ); 	
										
					$this->db->or_where( 'COALESCE(agents.connection_date, "") = "" ' ); 	
					
					$generacion = 'Generación 1';
					
				} 
				
				//Generación 2: fecha de conexión > 1  año y < 2 años <option value="4">Generación 2</option>				
				if( $filter['query']['generacion'] == 4 ){
					
					$begin = ( date( 'Y' )-2 ).date( '-m-d' );
					
					$end = 	( date( 'Y' )-1 ).date( '-m-d' );
						
					$this->db->where( array( 'agents.connection_date >=' => $begin, 'agents.connection_date <=' => $end ) ); 	
					
					$generacion = 'Generación 2';
				} 
				
				//Generación 3: fecha de conexión > 2 años y < 3 años <option value="5">Generación 3</option>
				if( $filter['query']['generacion'] == 5 )
                                {
                                    $begin = ( date( 'Y' )-3 ).date( '-m-d' );					
                                    $end = 	( date( 'Y' )-2 ).date( '-m-d' );						
                                    $this->db->where( array( 'agents.connection_date >=' => $begin, 'agents.connection_date <=' => $end ) ); 					
                                    $generacion = 'Generación 3';
				} 
				
			}
		
		
			if( isset( $filter['query']['gerente'] ) and !empty( $filter['query']['gerente'] ) )
                        {				
                            $this->db->where( 'users.manager_id', $filter['query']['gerente'] ); 				
			}
		
		
			if( isset( $filter['query']['agent'] ) and !empty( $filter['query']['agent'] ) and $filter['query']['agent'] != 1 )
                        {
				/*
				<option value="">Seleccione</option>
				<option value="1">Todos</option>
				<option value="2">Vigentes</option>
				<option value="3">Cancelados</option>
				*/					  
						
				if( $filter['query']['agent'] == 2 )
					
					$this->db->where( 'users.disabled', 0 ); 
				
				if( $filter['query']['agent'] == 3 )
					
					$this->db->where( 'users.disabled', 1 ); 	
			}
				
		}
	$query = $this->db->get(); 
  	
	if ($query->num_rows() == 0) return false;		
	
	$report = array();
		
	$report[0] = array(
		
		'name' => 'Agentes',
		'negocio' => 'Negocios Pagados',
		'negociopai' => 'Negocios Pal',
		'prima' => 'Primas Pagadas',
		'tramite' => 'Negocios en Tramite',
		'tramite_prima' => 'Primas en Tramite',
		'pendientes' => 'Negocios Pendientes',
		'pendientes_primas' => 'Primas Pendientes',
		'negocios_proyectados' => 'Negocios Proyectados',
		'negocios_proyectados_primas' => 'Primas Proyectadas',
		'iniciales' => 'Iniciales',
		'renovaciones' => 'Renovaciones'
		
	);
	
	
	
	foreach ($query->result() as $row){
		
		$name = null;
		
		if( empty(  $row->company_name ) )
			
			$name =  $row->name. ' ' . $row->lastnames;
		
		else
			
			$name =  $row->company_name;
		
		
		if( $row->connection_date != '0000-00-00' and $row->connection_date != '' ){
			
			$resultado =  date( 'Y', strtotime( $row->connection_date ) );
			
			//Consolidado: < 3 años < hoy
			if( $resultado < ( date( 'Y' )-3 ))
				$generacion = 'Consolidado';	
						
			//Generación 1: Fecha de conexión > 1 año < hoy
			if( $resultado > ( date( 'Y' )-1 )  )
				$generacion = 'Generación 1';
						
			//Generación 2: fecha de conexión > 1  año y < 2 años
			if( $resultado >= ( date( 'Y' )-2 ) and $resultado <= ( date( 'Y' )-1 ) )
				$generacion = 'Generación 2';
			
			//Generación 3: fecha de conexión > 2 años y < 3 años <option value="5">Generación 3</option>
			if( $resultado >= ( date( 'Y' )-3 ) and $resultado <= ( date( 'Y' )-2 ) ) 
				$generacion = 'Generación 3';
																			
			
		}else{
			$generacion = 'Generación 1';
		}
												
		$report[] = array(
			
			'id' => $row->id,
			'name' => $name,
			'uids' => $this->getAgentsUids( $row->agent_id ),
			'connection_date' => $row->connection_date,
                        'disabled' => $row->disabled,
			'negocio' => $this->getCountNegocio( $row->agent_id, $filter ),
			'negociopai' => $this->getCountNegocioPai( $row->agent_id, $filter ),
			'prima' => $this->getPrima( $row->agent_id, $filter ),
			
                        'tramite'=>$this->getTramite($row->agent_id,$filter),
			
                        'aceptadas' => $this->getAceptadas($row->agent_id,$filter),
                    
			'iniciales' => $this->getIniciales( $row->agent_id, $filter ),
			'renovacion' => $this->getRenovacion( $row->agent_id, $filter ),
			'generacion' => $generacion			
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
 
  public function getCountNegocio( $agent_id = null, $filter = array() ){
 		
						
		if( empty( $agent_id ) ) return 0;
		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id
		FROM `policies_vs_users`
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=6
		*/
		
		$this->db->select( 'DISTINCT( policies_vs_users.policy_id ) as policy_id' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( array( 'policies_vs_users.user_id' => $agent_id ) );
  		
		
						
		if( !empty( $filter ) ){
			
			
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
						
				$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			
			$mes = date( 'Y' ).'-'.(date( 'm' )).'-01';
			
			
			$trimestre = $this->trimestre();
			
			$cuatrimetre = $this->cuatrimestre();
									
			$anio = date( 'Y' ).'-01-01';
						
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
			
			
			if( $filter['query']['periodo'] == 1 )
			
				$this->db->where( 'work_order.creation_date >= ', $mes); 
			
			
			
			if( $filter['query']['periodo'] == 2 )
			
				
				if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
					
					if( $cuatrimetre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-04-'.date('d');	
					}
					
					if( $cuatrimetre == 2 ){			
						$begind = date( 'Y' ).'-04-01';	
						$end = date( 'Y' ).'-08-'.date('d');	
					}
					
					if( $cuatrimetre == 3 ){			
						$begind = date( 'Y' ).'-08-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
					$this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
				
				}else{
					
					
					if( $trimestre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-03-'.date('d');	
					}
					
					if( $trimestre == 2 ){			
						$begind = date( 'Y' ).'-03-01';	
						$end = date( 'Y' ).'-06-'.date('d');	
					}
					
					if( $trimestre == 3 ){			
						$begind = date( 'Y' ).'-06-01';	
						$end = date( 'Y' ).'-09-'.date('d');	
					}
					
					if( $trimestre == 4 ){			
						$begind = date( 'Y' ).'-09-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
						
					$this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
				}
				
				
				
				
				
				
			if( $filter['query']['periodo'] == 3 )
			
				$this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
			
			}
							
		}
		
		
		$query = $this->db->get(); 
  		
		if ($query->num_rows() == 0) return 0;		
		
		
		$negocio = array();
		
		$negocio['count'] = 0;
		
		foreach ($query->result() as $row){
			
			/*
			SELECT *
			FROM payments
			WHERE policy_id=30;
			*/
					
			$this->db->select();
			$this->db->from( 'payments' );
			$this->db->where( 'policy_id', $row->policy_id );
			
						
			$querypayemnt = $this->db->get(); 
			
			if ($querypayemnt->num_rows() > 0)		
						
				$negocio['count'] =(int)$negocio['count']+1;
													
			
		}
		
		
		
		return $negocio['count'];
		
  }
  
  public function getCountNegocioPai( $agent_id = null, $filter = array() ){
 		
		
		
		if( empty( $agent_id ) ) return 0;
		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id
		FROM `policies_vs_users`
		JOIN  policies ON policies.id=policies_vs_users.policy_id
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=1
    	AND policies.prima>10000
		*/
		
		$this->db->select( 'DISTINCT( policies_vs_users.policy_id ) as policy_id' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'policies', 'policies.id=policies_vs_users.policy_id' );
		$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( array( 'policies_vs_users.user_id' => $agent_id, 'policies.prima >' => 10000 ) );
  		
		
		if( !empty( $filter ) ){
			
			
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
						
				$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			
			$mes = date( 'Y' ).'-'.(date( 'm' )).'-01';
			
			
			$trimestre = $this->trimestre();
			
			$cuatrimetre = $this->cuatrimestre();
									
			$anio = date( 'Y' ).'-01-01';
						
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
			
			
			if( $filter['query']['periodo'] == 1 )
			
				$this->db->where( 'work_order.creation_date >= ', $mes); 
			
			
			
			if( $filter['query']['periodo'] == 2 )
			
				
				if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
					
					if( $cuatrimetre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-04-'.date('d');	
					}
					
					if( $cuatrimetre == 2 ){			
						$begind = date( 'Y' ).'-04-01';	
						$end = date( 'Y' ).'-08-'.date('d');	
					}
					
					if( $cuatrimetre == 3 ){			
						$begind = date( 'Y' ).'-08-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
					$this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
				
				}else{
					
					
					if( $trimestre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-03-'.date('d');	
					}
					
					if( $trimestre == 2 ){			
						$begind = date( 'Y' ).'-03-01';	
						$end = date( 'Y' ).'-06-'.date('d');	
					}
					
					if( $trimestre == 3 ){			
						$begind = date( 'Y' ).'-06-01';	
						$end = date( 'Y' ).'-09-'.date('d');	
					}
					
					if( $trimestre == 4 ){			
						$begind = date( 'Y' ).'-09-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
						
					$this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
				}
				
				
				
				
				
				
			if( $filter['query']['periodo'] == 3 )
			
				$this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
			
			}
							
		}
		
		
		$query = $this->db->get(); 
  		
		if ($query->num_rows() == 0) return 0;		
		
		$pai = array();
		
		foreach ($query->result() as $row){
			
			/*
				SELECT SUM(amount) as amount
				FROM payments
				WHERE policy_id=28
			*/
			
			$this->db->select_sum( 'amount' );
			$this->db->from( 'payments' );
			$this->db->where( array( 'policy_id' => $row->policy_id ) );
						
			$querypai = $this->db->get(); 
			
			if ($querypai->num_rows() == 0) break;			
			
			foreach ($querypai->result() as $rowpai)
			
				if( (float)$rowpai->amount >= 5000 )
					
					$pai[]=$rowpai->amount;
			
					
			
				
		}
			
		return $pai;
  }
  
  
  public function getPrima( $agent_id = null, $filter = array() ){
 		
		if( empty( $agent_id ) ) return 0;
		
		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id, policies.prima
		FROM `policies_vs_users`
		JOIN  policies ON policies.id=policies_vs_users.policy_id
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=6
		*/		
		$this->db->select( 'DISTINCT( policies_vs_users.policy_id ) as policy_id, policies.prima' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'policies', 'policies.id=policies_vs_users.policy_id' );
		$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( 'policies_vs_users.user_id', $agent_id  );
		
		
		if( !empty( $filter ) ){
			
			
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
						
				$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			
			$mes = date( 'Y' ).'-'.(date( 'm' )).'-01';
			
			
			$trimestre = $this->trimestre();
			
			$cuatrimetre = $this->cuatrimestre();
									
			$anio = date( 'Y' ).'-01-01';
						
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
			
			
			if( $filter['query']['periodo'] == 1 )
			
				$this->db->where( 'work_order.creation_date >= ', $mes); 
			
			
			
			if( $filter['query']['periodo'] == 2 )
			
				
				if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
					
					if( $cuatrimetre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-04-'.date('d');	
					}
					
					if( $cuatrimetre == 2 ){			
						$begind = date( 'Y' ).'-04-01';	
						$end = date( 'Y' ).'-08-'.date('d');	
					}
					
					if( $cuatrimetre == 3 ){			
						$begind = date( 'Y' ).'-08-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
					$this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
				
				}else{
					
					
					if( $trimestre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-03-'.date('d');	
					}
					
					if( $trimestre == 2 ){			
						$begind = date( 'Y' ).'-03-01';	
						$end = date( 'Y' ).'-06-'.date('d');	
					}
					
					if( $trimestre == 3 ){			
						$begind = date( 'Y' ).'-06-01';	
						$end = date( 'Y' ).'-09-'.date('d');	
					}
					
					if( $trimestre == 4 ){			
						$begind = date( 'Y' ).'-09-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
						
					$this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
				}
				
				
				
				
				
				
			if( $filter['query']['periodo'] == 3 )
			
				$this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
			
			}				
		}
		
		
		
		$query = $this->db->get(); 
  	
		if ($query->num_rows() == 0) return 0;		
		
		$prima = 0;
		
		foreach ($query->result() as $row){
			
			/*
			SELECT policy_id
			FROM payments
			WHERE policy_id=30;
			*/
					
			$this->db->select();
			$this->db->from( 'payments' );
			$this->db->where( 'policy_id', $row->policy_id );			
						
			$querypayemnt = $this->db->get(); 
			
			if ($querypayemnt->num_rows() > 0)
                        {
                            $prima = (float)$prima + $row->prima;
			}		
		}		
		return $prima;
  }
  
  
  
  
        public function getTramite($user_id = null, $filter = array())
        {
		if( empty( $user_id ) ) return 0;
		
                /*
		SELECT DISTINCT( policies_vs_users.policy_id ) AS policy_id
		FROM work_order_types
		JOIN work_order ON work_order.work_order_type_id=work_order_types.id
		JOIN policies ON policies.id=work_order.policy_id
		JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
		JOIN agents ON agents.id=policies_vs_users.user_id
		JOIN users ON users.id=agents.user_id
		WHERE ( work_order.work_order_status_id=5 OR  work_order.work_order_status_id=9 )
		AND ( work_order_types.patent_id =47 OR work_order_types.patent_id=90 )
		AND policies_vs_users.user_id=7		
		*/
		/*
		$this->db->query(
			
		   'SELECT DISTINCT( policies_vs_users.policy_id ) AS policy_id
			FROM work_order_types
			JOIN work_order ON work_order.work_order_type_id=work_order_types.id
			JOIN policies ON policies.id=work_order.policy_id
			JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
			JOIN agents ON agents.id=policies_vs_users.user_id
			JOIN users ON users.id=agents.user_id
			WHERE ( work_order.work_order_status_id=5 OR  work_order.work_order_status_id=9 )
			AND ( work_order_types.patent_id =47 OR work_order_types.patent_id=90 )
			AND policies_vs_users.user_id='.$user_id
		);
		
		*/
         
                
		$this->db->select('DISTINCT( policies_vs_users.policy_id ) AS policy_id,work_order.id AS work_order_id');
		$this->db->from('work_order_types' );
		$this->db->join('work_order','work_order.work_order_type_id=work_order_types.id');
		$this->db->join('policies','policies.id=work_order.policy_id' );		
		$this->db->join('policies_vs_users', 'policies_vs_users.policy_id=policies.id');
		$this->db->join( 'agents','agents.id=policies_vs_users.user_id');
		$this->db->join( 'users','users.id=agents.user_id');
                
		$this->db->where("( work_order.work_order_status_id=5 OR  work_order.work_order_status_id=9)");
                
		$this->db->where("( work_order_types.patent_id =47 OR work_order_types.patent_id=90 )");
                
		$this->db->where( 'policies_vs_users.user_id', $user_id );
		
                
		if( !empty( $filter ) )
                    {
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) )
                        {			
                            $this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			
			$mes = date( 'Y' ).'-'.(date( 'm' )).'-01';		
			$trimestre = $this->trimestre();			
			$cuatrimetre = $this->cuatrimestre();									
			$anio = date( 'Y' ).'-01-01';						
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo']))
                        {
                            if( $filter['query']['periodo'] == 1 )			
				$this->db->where( 'work_order.creation_date >= ', $mes); 
                            
                            if( $filter['query']['periodo'] == 2 )
			
				
				if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
					
					if( $cuatrimetre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-04-'.date('d');	
					}
					
					if( $cuatrimetre == 2 ){			
						$begind = date( 'Y' ).'-04-01';	
						$end = date( 'Y' ).'-08-'.date('d');	
					}
					
					if( $cuatrimetre == 3 ){			
						$begind = date( 'Y' ).'-08-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
					$this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
				
				}else{
					
					
					if( $trimestre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-03-'.date('d');	
					}
					
					if( $trimestre == 2 ){			
						$begind = date( 'Y' ).'-03-01';	
						$end = date( 'Y' ).'-06-'.date('d');	
					}
					
					if( $trimestre == 3 ){			
						$begind = date( 'Y' ).'-06-01';	
						$end = date( 'Y' ).'-09-'.date('d');	
					}
					
					if( $trimestre == 4 ){			
						$begind = date( 'Y' ).'-09-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
						
					$this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
				}
			if( $filter['query']['periodo'] == 3 )			
				$this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
			}
				
		}
		
		
		$query = $this->db->get();
                
		if ($query->num_rows() == 0) return 0;		
		
                
		$tramite = array();			
                $work_order_ids = array();            
		$tramite['count'] = $query->num_rows();		
		$tramite['prima'] = 0;
                
                
                foreach ($query->result() as $row)
                {	
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
			
			if ($queryprima->num_rows() == 0)
                        {
                            $prima = 0;											
			}
                        else
                        {	
                            foreach ($queryprima->result() as $rowprima)
                            {
                                    if(!empty( $rowprima->prima)) 
                                        $tramite['prima'] = (float)$tramite['prima'] + (float)$rowprima->prima;					
                            }
			}
                        $work_order_ids[] = $row->work_order_id;
                       
		}	
                
                $tramite['work_order_ids'] = $work_order_ids; 
                return $tramite;
        }	
  
  
  
  
  
  public function getAceptadas(  $user_id = null, $filter = array() )
            {
		if( empty( $user_id ) ) return 0;
		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) AS policy_id
		FROM policies
		JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN agents ON agents.id=policies_vs_users.user_id
		JOIN users ON users.id=agents.user_id	
		WHERE work_order.work_order_status_id=7   
		AND policies_vs_users.user_id=7
		*/
		
		
		$this->db->select('DISTINCT( policies_vs_users.policy_id ) AS policy_id,work_order.id AS work_order_id' );
		$this->db->from( 'policies' );
		$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=policies.id' );
		$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where( array( 'work_order.work_order_status_id' => 7 ) );
		$this->db->where( 'policies_vs_users.user_id', $user_id );
  		
		if(!empty($filter))
                {
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) )
                        {
						
				$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			
			$mes = date( 'Y' ).'-'.(date( 'm' )).'-01';
			
			
			$trimestre = $this->trimestre();
			
			$cuatrimetre = $this->cuatrimestre();
									
			$anio = date( 'Y' ).'-01-01';
						
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
			
			
			if( $filter['query']['periodo'] == 1 )
			
				$this->db->where( 'work_order.creation_date >= ', $mes); 
			
			
			
			if( $filter['query']['periodo'] == 2 )
			
				
				if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
					
					if( $cuatrimetre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-04-'.date('d');	
					}
					
					if( $cuatrimetre == 2 ){			
						$begind = date( 'Y' ).'-04-01';	
						$end = date( 'Y' ).'-08-'.date('d');	
					}
					
					if( $cuatrimetre == 3 ){			
						$begind = date( 'Y' ).'-08-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
					$this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
				
				}else{
					
					
					if( $trimestre == 1 ){			
						$begind = date( 'Y' ).'-01-01';	
						$end = date( 'Y' ).'-03-'.date('d');	
					}
					
					if( $trimestre == 2 ){			
						$begind = date( 'Y' ).'-03-01';	
						$end = date( 'Y' ).'-06-'.date('d');	
					}
					
					if( $trimestre == 3 ){			
						$begind = date( 'Y' ).'-06-01';	
						$end = date( 'Y' ).'-09-'.date('d');	
					}
					
					if( $trimestre == 4 ){			
						$begind = date( 'Y' ).'-09-01';	
						$end = date( 'Y' ).'-12-'.date('d');	
					}
					
						
					$this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
				}
				
				
				
				
				
				
			if( $filter['query']['periodo'] == 3 )
			
				$this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
			
			}				
		}
		
		$query = $this->db->get(); 
  		
		
		if ($query->num_rows() == 0) return 0;			
		$aceptadas = array();	
                $work_order_ids = array();
		$aceptadas['prima'] = 0;		
		$aceptadas['count']=0;		
		foreach ($query->result() as $row)
                {
                    /*
                    SELECT *
                    FROM payments
                    WHERE `policy_id`=1
                    */			

                    $this->db->select();
                    $this->db->from( 'payments' );
                    $this->db->where( array( 'policy_id' => $row->policy_id ) );

                    $querypayments = $this->db->get(); 


                    if ($querypayments->num_rows() == 0)
                    {	
                        /*
                        SELECT SUM( prima )
                        FROM policies
                        WHERE id=1*/
                        $this->db->select_sum( 'prima' );
                        $this->db->from( 'policies' );
                        $this->db->where( array( 'id' => $row->policy_id ) );
                        $querypolicies = $this->db->get(); 
                        if ($querypolicies->num_rows() > 0)
                        {
                            foreach ($querypolicies->result() as $rowprima)
                            {
                                $aceptadas['count'] = (int)$aceptadas['count']+1;					
                                if( !empty( $rowprima->prima ) ) $aceptadas['prima'] = (float)$aceptadas['prima'] + (float)$rowprima->prima;					
                            }
                        }
                    }
                    $work_order_ids[] = $row->work_order_id;       
		}
                $aceptadas['work_order_ids'] = $work_order_ids; 
		return $aceptadas;		
            }
  
            
            
  
  public function getIniciales( $user_id = null, $filter = array() ){
	
	if( empty( $user_id ) ) return 0; 
	/*
	SELECT COUNT( DISTINCT( policies_vs_users.policy_id ) ) AS policy_id
	FROM policies
	JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
	JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
	JOIN agents ON agents.id=policies_vs_users.user_id
	JOIN users ON users.id=agents.user_id	
	WHERE policies_vs_users.user_id=7
	*/
	
	$this->db->select( 'COUNT( DISTINCT( policies_vs_users.policy_id ) ) AS policy_id' );
	$this->db->from( 'policies' );
	$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=policies.id' );
	$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
	$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
	$this->db->join( 'users', 'users.id=agents.user_id' );
	$this->db->where( 'policies_vs_users.user_id', $user_id );
	
	if( !empty( $filter ) ){
			
			
		if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
					
			$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
		}
		
		/*
		<option value="1">Mes</option>
		<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
		<option value="3">Año</option>
		*/	
		
		$mes = date( 'Y' ).'-'.(date( 'm' )).'-01';
		
		
		$trimestre = $this->trimestre();
		
		$cuatrimetre = $this->cuatrimestre();
								
		$anio = date( 'Y' ).'-01-01';
					
		if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
		
		
		if( $filter['query']['periodo'] == 1 )
		
			$this->db->where( 'work_order.creation_date >= ', $mes); 
		
		
		
		if( $filter['query']['periodo'] == 2 )
		
			
			if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
				
				if( $cuatrimetre == 1 ){			
					$begind = date( 'Y' ).'-01-01';	
					$end = date( 'Y' ).'-04-'.date('d');	
				}
				
				if( $cuatrimetre == 2 ){			
					$begind = date( 'Y' ).'-04-01';	
					$end = date( 'Y' ).'-08-'.date('d');	
				}
				
				if( $cuatrimetre == 3 ){			
					$begind = date( 'Y' ).'-08-01';	
					$end = date( 'Y' ).'-12-'.date('d');	
				}
				
				$this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
			
			}else{
				
				
				if( $trimestre == 1 ){			
					$begind = date( 'Y' ).'-01-01';	
					$end = date( 'Y' ).'-03-'.date('d');	
				}
				
				if( $trimestre == 2 ){			
					$begind = date( 'Y' ).'-03-01';	
					$end = date( 'Y' ).'-06-'.date('d');	
				}
				
				if( $trimestre == 3 ){			
					$begind = date( 'Y' ).'-06-01';	
					$end = date( 'Y' ).'-09-'.date('d');	
				}
				
				if( $trimestre == 4 ){			
					$begind = date( 'Y' ).'-09-01';	
					$end = date( 'Y' ).'-12-'.date('d');	
				}
				
					
				$this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
			}
			
			
			
			
			
			
		if( $filter['query']['periodo'] == 3 )
		
			$this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
		
		}				
	}
	
	
	$query = $this->db->get(); 
  	
	if ($query->num_rows() == 0) return 0;	
	
	$count = 0;
	
	foreach ($query->result() as $row){
		
		/*
		SELECT count(*) as count
		FROM payments
		WHERE `policy_id`=1
		*/
		
		
		$this->db->select( 'SUM(amount) as count' );
		$this->db->from( 'payments' );
		$this->db->where( array( 'policy_id' => $row->policy_id, 'year_prime' => 1 ) );
				
		$querypayments = $this->db->get(); 
		
		
		if ($querypayments->num_rows() == 0){
			
			foreach ( $querypolicies->result() as $rowpayment )	
				
				$count += (int) $rowpayment->count;
						
			
		}	
		
	}
		
	return $count;		
	 
  }
  
   
  public function getRenovacion( $user_id = null, $filter = array() ){
	
	if( empty( $user_id ) ) return 0;  
	/*
	SELECT COUNT( DISTINCT( policies_vs_users.policy_id ) ) AS policy_id
	FROM policies
	JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
	JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
	JOIN agents ON agents.id=policies_vs_users.user_id
	JOIN users ON users.id=agents.user_id	
	WHERE policies_vs_users.user_id=7
	*/
	
	$this->db->select( 'COUNT( DISTINCT( policies_vs_users.policy_id ) ) AS policy_id' );
	$this->db->from( 'policies' );
	$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=policies.id' );
	$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
	$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
	$this->db->join( 'users', 'users.id=agents.user_id' );
	$this->db->where( 'policies_vs_users.user_id', $user_id );
	
	if( !empty( $filter ) ){
			
			
	  if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
				  
		  $this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] ); 
	  }
	  
	  /*
	  <option value="1">Mes</option>
	  <option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
	  <option value="3">Año</option>
	  */	
	  
	  $mes = date( 'Y' ).'-'.(date( 'm' )).'-01';
	  
	  
	  $trimestre = $this->trimestre();
	  
	  $cuatrimetre = $this->cuatrimestre();
							  
	  $anio = date( 'Y' ).'-01-01';
				  
	  if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) ){
	  
	  
	  if( $filter['query']['periodo'] == 1 )
	  
		  $this->db->where( 'work_order.creation_date >= ', $mes); 
	  
	  
	  
	  if( $filter['query']['periodo'] == 2 )
	  
		  
		  if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 ){
			  
			  if( $cuatrimetre == 1 ){			
				  $begind = date( 'Y' ).'-01-01';	
				  $end = date( 'Y' ).'-04-'.date('d');	
			  }
			  
			  if( $cuatrimetre == 2 ){			
				  $begind = date( 'Y' ).'-04-01';	
				  $end = date( 'Y' ).'-08-'.date('d');	
			  }
			  
			  if( $cuatrimetre == 3 ){			
				  $begind = date( 'Y' ).'-08-01';	
				  $end = date( 'Y' ).'-12-'.date('d');	
			  }
			  
			  $this->db->where( array( 'work_order.creation_date >= ' =>  $begind , 'work_order.creation_date <=' =>  $end  ) ); 
		  
		  }else{
			  
			  
			  if( $trimestre == 1 ){			
				  $begind = date( 'Y' ).'-01-01';	
				  $end = date( 'Y' ).'-03-'.date('d');	
			  }
			  
			  if( $trimestre == 2 ){			
				  $begind = date( 'Y' ).'-03-01';	
				  $end = date( 'Y' ).'-06-'.date('d');	
			  }
			  
			  if( $trimestre == 3 ){			
				  $begind = date( 'Y' ).'-06-01';	
				  $end = date( 'Y' ).'-09-'.date('d');	
			  }
			  
			  if( $trimestre == 4 ){			
				  $begind = date( 'Y' ).'-09-01';	
				  $end = date( 'Y' ).'-12-'.date('d');	
			  }
			  
				  
			  $this->db->where( array( 'work_order.creation_date >= ' => $begind, 'work_order.creation_date <=' =>  $end ) ); 
		  }
		  
		  
		  
		  
		  
		  
	  if( $filter['query']['periodo'] == 3 )
	  
		  $this->db->where( array( 'work_order.creation_date >= ' => $anio,  'work_order.creation_date <=' => date( 'Y-m-d' ) ) ); 
	  
	  }				
  }
	
	$query = $this->db->get(); 
  	
	if ($query->num_rows() == 0) return 0;	
	
	$count = 0;
	
	foreach ($query->result() as $row){
		
		/*
		SELECT count(*) as count
		FROM payments
		WHERE `policy_id`=1
		*/
				
		$this->db->select( 'SUM(amount) as count' );
		$this->db->from( 'payments' );
		$this->db->where( array( 'policy_id' => $row->policy_id, 'year_prime >' => 1 ) );
				
		$querypayments = $this->db->get(); 
		
		
		if ($querypayments->num_rows() == 0){
			
			foreach ( $querypolicies->result() as $rowpayment )	
				
				$count += (int) $rowpayment->count;
						
			
		}	
		
	}
		
	return $count;	
  }
  
  public function trimestre($mes=null){	  
	$mes = is_null($mes) ? date('m') : $mes;
	$trim=floor(($mes-1) / 3)+1;
	return $trim;
  }
  
  public function cuatrimestre($mes=null){	  
	$mes = is_null($mes) ? date('m') : $mes;
	$trim=floor(($mes-1) / 4)+1;
	return $trim;
  }
	

}
?>