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
		
		$values['last_updated'] = $timestamp;
		
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
	
	public function overview( $start = 0 ) {
		
		
		// SELECT id, name, lastnames, email FROM `users`;
		$this->db->select( 'id, name, lastnames, email, manager_id, date, last_updated' );
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
	
	
	
// Validations
	public function is_unique( $field = null, $value = null ){
		
		if( empty( $field ) or empty( $value ) ) return false;
		
		
		$this->db->where( array( 'name'  => $value )  );
        $this->db->limit( 1 ); // Limit 1 record

		// Get Resutls
        $query = $this->db->get( 'users' );
		
		
		if ($query->num_rows() == 0) 
			
			return true;
		
		else
			
			return false;
		
			
	}	
	
	

}
?>