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
	private $agent_name_where_in = null;
		
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
		
		$to_select = 'users.*';
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
				if( in_array( 'clave', $value ) or 
					in_array( 'national', $value ) or
					in_array( 'provincial', $value  ) or
					in_array( 'license_expired_date', $value  ) ){
					$to_select .= ', agents.id as agent_id';
					$this->db->join( 'agents', 'agents.user_id=users.id' );	
				}
				
				if( in_array( 'clave', $value ) or
					in_array( 'national', $value ) or
					in_array( 'provincial', $value  ) ){
					$to_select .= ', agent_uids.id as agent_uid_id';
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
		$this->db->select($to_select);
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
	public function getAgents( $as_string = TRUE ){
		
		/*
			SELECT agents.id, users.name FROM agents
			JOIN users ON users.id=agents.user_id;
		*/
		$this->db->select( 'agents.id, users.name, users.lastnames, users.company_name' );
		$this->db->from( 'agents' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		//$this->db->order_by( 'users.company_name', 'asc' );
		
		$query = $this->db->get();

		if ($as_string)
			$options = '<option value="">Seleccione</option>';
		else
			$options = array();

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
		if ( $as_string ) {
			foreach( $agents as $value )
				$options .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		} else {
			foreach( $agents as $value )
				$options[$value['id']]= $value['name'];
		}
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
	
	
	
	public function getIdAgentByFolio( $uid = null, $type = null ){
		
		if( empty( $uid ) ) return false;
		
		/*
			SELECT id 
			FROM agent_uids
			WHERE agent_uids.uid='';
		*/

		$uidorigin = $uid;

		$this->db->select( ' agent_id' );
		$this->db->from( 'agent_uids' );
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

		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return null;
				
		foreach ($query->result() as $row)
						
			return $row->agent_id;
			
			
		
				
				
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
 	
	$negocios_pai = $this->_getNegocioPai(TRUE, null, $filter);
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

			if ( isset( $filter['query']['agent_name'] ) and !empty( $filter['query']['agent_name'] ) )
			{
				$this->_get_agent_filter_where($filter['query']['agent_name']);
				if ($this->agent_name_where_in)
					$this->db->where_in('agents.id', $this->agent_name_where_in);
			}
			
			if ( isset( $filter['query']['policy_num'] ) and !empty( $filter['query']['policy_num'] ) )
			{
				$policy_filter = explode("\n", $filter['query']['policy_num']);
				foreach ($policy_filter as $key => $value)
				{
					$policy_filter[$key] = trim($policy_filter[$key]);
					if (!strlen($value))
						unset($policy_filter[$key]);
				}
				$policy_filter = array_unique($policy_filter);
				$this->db->select( 'payments.policy_number' );
				$this->db->join( 'payments', 'payments.agent_id=agents.id' );
				$this->db->where_in('policy_number', $policy_filter);
			}
		}
	$this->db->order_by('name', 'asc');
	$this->db->order_by('lastnames', 'asc'); 
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
	
	
	$user_ids = array();
	foreach ($query->result() as $row){
		if ( !isset($user_ids[$row->id]) )
		{
			$user_ids[$row->id] = $row->id;

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

			$report_row = array(
				'id' => $row->id,
				'name' => $name,
				'uids' => $this->getAgentsUids( $row->agent_id ),
				'connection_date' => $row->connection_date,
				'disabled' => $row->disabled,
				'negocio' => $this->getCountNegocio( $row->agent_id, $filter ),
				'negociopai' => 0,
				'prima' => $this->getPrima( $row->agent_id, $filter ),
				'tramite'=>$this->getTramite($row->agent_id,$filter),
				'aceptadas' => $this->getAceptadas($row->agent_id,$filter),
				'iniciales' => $this->getIniciales( $row->agent_id, $filter ),
				'renovacion' => $this->getRenovacion( $row->agent_id, $filter ),
				'generacion' => $generacion,
				'agent_id' => $row->agent_id
				);
			if (isset($negocios_pai[$row->agent_id]))
				$report_row['negociopai'] = $negocios_pai[$row->agent_id];
			$report[] = $report_row;
		}
	}
	return $report;
 }
 
 public function getReportAgent( $userid = null, $filter = array() ){
 	
	/**
	 *	SELECT users.*, agents.id as agent_id
		FROM `agents`
	 **/
	
	if( empty( $userid ) ) return false;
	
	$this->db->select( 'users.*, agents.connection_date, agents.id as agent_id' );
	$this->db->from( 'agents' );
	$this->db->join( 'users', 'users.id=agents.user_id' );
	$this->db->where( 'users.id', $userid );
		
	$generacion = '';
		
	$query = $this->db->get(); 
  	
	if ($query->num_rows() == 0) return false;		
	
	$report = array();
	
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
			'picture' => $row->picture,
			'uids' => $this->getAgentsUids( $row->agent_id ),
			'connection_date' => $row->connection_date,
            'disabled' => $row->disabled,
			'negocio' => $this->getCountNegocio( $row->agent_id, $filter ),
			'negociopai' => $this->_getNegocioPai(TRUE, $row->agent_id, $filter),
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
 		
		return $this->_getNegocios( TRUE, $agent_id, $filter);
	}

	public function getNegocioDetails( $agent_id = null, $filter = array() ){
 		
		return $this->_getNegocios( FALSE, $agent_id, $filter);
	}

	// Common method for getting count of negocios (first param = TRUE) and details of negocios (first param = FALSE) 
	private function _getNegocios( $count_requested = TRUE, $agent_id = null, $filter = array()) {

		if ( empty( $agent_id ) && $count_requested)
			return 0;
		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id
		FROM `policies_vs_users`
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=6
		*/
		if ($count_requested)		
			$this->db->select( 'SUM(business) AS sum_business' );
		else
			$this->db->select( 'payments.*, users.name as first_name, users.lastnames as last_name, users.company_name as company_name' );    
		$this->db->from( 'payments' );
		$this->db->join( 'agents', 'agents.id=payments.agent_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$where = array('valid_for_report' => '1');
		if ($agent_id)
			$where['agent_id'] = $agent_id;
		$this->db->where($where);
		$this->db->where( "((business = '1') OR (business = '-1'))" );

		if( !empty( $filter ) ){
			
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
						
				$this->db->where( 'product_group', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) )
			{
				if( $filter['query']['periodo'] == 1 )
				{
					$year = date( 'Y' );
					$month = date( 'm' );
					$next_month = date('m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
					$this->db->where( array(
						'payments.payment_date >= ' => $year . '-' . $month . '-01',
						'payments.payment_date < ' => $year . '-' . $next_month . '-01',
						)); 
				}
				if( $filter['query']['periodo'] == 2 )
				{
					$this->load->helper('tri_cuatrimester');
					if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 )
						$begin_end = get_tri_cuatrimester( $this->cuatrimestre(), 'cuatrimestre' ) ;
					else
						$begin_end = get_tri_cuatrimester( $this->trimestre(), 'trimestre' );

					if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
						$this->db->where( array(
							'payments.payment_date >= ' => $begin_end['begind'],
							'payments.payment_date <=' =>  $begin_end['end']) );
				}
				if( $filter['query']['periodo'] == 3 )
				{
					$year = date( 'Y' );
					$this->db->where( array(
						'payments.payment_date >= ' => $year . '-01-01',
						'payments.payment_date <= ' => $year . '-12-31 23:59:59'
						)); 
				}
				if( $filter['query']['periodo'] == 4 )
				{
					$from = $this->custom_period_from;
					$to = $this->custom_period_to;
					if ( ( $from === FALSE ) || ( $to === FALSE ) )
					{
						$from = date('Y-m-d');
						$to = $from;
					}
					$this->db->where( array(
						'payments.payment_date >= ' => $from . ' 00:00:00',
						'payments.payment_date <=' => $to . ' 23:59:59') );
				}
			}
			if ( !$agent_id && isset( $filter['query']['agent_name'] ) and !empty( $filter['query']['agent_name'] ) )
			{
				$this->_get_agent_filter_where($filter['query']['agent_name']);
				if ($this->agent_name_where_in)
					$this->db->where_in('agent_id', $this->agent_name_where_in);
			}
		}

		if ($count_requested)
		{
			if (isset($filter['query']) && isset($filter['query']['min_amount']))
				$this->db->where(array('ABS(amount)  >= ' => '5000'));
			$result = 0;
			$query = $this->db->get();
			if ($query->num_rows() > 0)
				$result = (int)$query->row()->sum_business;
			return $result;
		} 
		else {
			$query = $this->db->get();
			$result = array();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$row->asegurado = '';
					if ($row->policy_number) {
						$query_policy = $this->db->get_where('policies', array('uid' => $row->policy_number), 1, 0);
						if ($query_policy->num_rows() > 0)
							$row->asegurado = $query_policy->row()->name;
						$query_policy->free_result();
					}
					$result[] = $row;
				}
			}
			return $result;
		}
  }  
  // getCountNegocio Old
  /*
  public function getCountNegocio( $agent_id = null, $filter = array() ){
 		
						
		if( empty( $agent_id ) ) return 0;
		*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id
		FROM `policies_vs_users`
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=6
		*
		
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
			
			*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*
			
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
			
			*
			SELECT *
			FROM payments
			WHERE policy_id=30;
			*
					
			$this->db->select();
			$this->db->from( 'payments' );
			$this->db->where( 'policy_id', $row->policy_id );
			
						
			$querypayemnt = $this->db->get(); 
			
			if ($querypayemnt->num_rows() > 0)		
						
				$negocio['count'] =(int)$negocio['count']+1;
													
			
		}
		
		
		
		return $negocio['count'];
		
  }*/
  
	public function getCountNegocioPai( $agent_id = null, $filter = array() )
	{
		if	( empty( $agent_id ) )
			return 0;
		$filter['query']['min_amount'] = TRUE;
		$result = 0;
		$array_scalar = $this->_getNegocios( TRUE, $agent_id, $filter);
		if (!is_numeric($array_scalar))
			log_message('error', 'application/modules/usuarios/models/user.php - getCountNegocioPai() - not int - ' . print_r($array_scalar, TRUE));
		elseif ($array_scalar > 0)
			$result = array_fill(0, $array_scalar, 0);
		return $result; 
	}

/*	public function getCountNegocioPai( $agent_id = null, $filter = array() )
	{
		return $this->_getNegocioPai(TRUE, $agent_id, $filter);
	}
*/

	public function getNegocioPai( $agent_id = null, $filter = array() )
	{
		return $this->_getNegocioPai(FALSE, $agent_id, $filter);
	}

//	private function _getNegocioPai( $count_requested = TRUE, $agent_id = null, $filter = array())
	private function _getOldNegocioPai( $count_requested = TRUE, $agent_id = null, $filter = array())
	{
		$sql_begin = 'SELECT `payments`.*, `users`.`name` AS first_name, `users`.`lastnames` AS last_name, `users`.`company_name` AS company_name
FROM `payments` 
JOIN `agents` ON `agents`.`id` = `payments`.`agent_id`
JOIN `users` ON `users`.`id` = `agents`.`user_id`
WHERE `policy_number`
IN ( ';

		$sql_end = ") AND `valid_for_report` = '1' AND `year_prime` = '1' 
";
		$sub_sql = "
SELECT `t_year`.`policy_number` 
FROM (
SELECT `payments`.*, SUM( `payments`.`amount` ) AS `sum_payment`, SUM( ABS(`payments`.`business` )) AS `abs_business`
FROM (
`payments`
)
WHERE `valid_for_report` = '1' AND `year_prime` = '1' 
";

		if ($agent_id)
		{
			$sub_sql .= "
AND `agent_id` = '$agent_id'";
			$sql_end .= "
AND `agent_id` = '$agent_id'";
		}

		if( !empty( $filter ) )
		{
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) )
			{
				$sub_sql .= " AND `product_group` = '" . $filter['query']['ramo'] . "'
";
				$sql_end .= " AND `product_group` = '" . $filter['query']['ramo'] . "'
";
			}
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) )
			{
				$year = date( 'Y' );				
				switch ($filter['query']['periodo'])
				{
					case 1: // month
						$month = date( 'm' );
						$next_month = date('m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
						$sql_end .= "
AND `payments`.`payment_date` >= '$year-$month-01'
AND `payments`.`payment_date` < '$year-$next_month-01'";
						$sub_sql .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` < '$year-$next_month-01'";
					break;
					case 2: // trimester/cuatrimestre
						$this->load->helper('tri_cuatrimester');
						if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 )
							$begin_end = get_tri_cuatrimester( $this->cuatrimestre(), 'cuatrimestre' ) ;
						else
							$begin_end = get_tri_cuatrimester( $this->trimestre(), 'trimestre' );

						if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
						{
							$sql_end .= "
AND `payments`.`payment_date` >= '" . $begin_end['begind'] . "'
AND `payments`.`payment_date` <= '" . $begin_end['end'] . "'";
							$sub_sql .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '" . $begin_end['end'] . "'";
						}
					break;
					case 3: // year
						$sql_end .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '$year-12-31 23:59:59'";
						$sub_sql .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '$year-12-31 23:59:59'";
					break;
					case 4: // custom period
						$from = $this->custom_period_from;
						$to = $this->custom_period_to;
						if ( ( $from === FALSE ) || ( $to === FALSE ) )
						{
							$from = date('Y-m-d');
							$to = $from;
						}
						$sql_end .= "
AND `payments`.`payment_date` >= '$from 00:00:00'
AND `payments`.`payment_date` <= '$to 23:59:59'";
						$sub_sql .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '$to 23:59:59'";
					break;

				}
			}
			if ( !$agent_id && isset( $filter['query']['agent_name'] ) and !empty( $filter['query']['agent_name'] ) )
			{
				$this->_get_agent_filter_where($filter['query']['agent_name']);
				if ($this->agent_name_where_in)
				{
					$agent_filter = array();
					foreach ($this->agent_name_where_in as $agent_key => $agent_value)
						$agent_filter[$agent_key] = "'$agent_value'";
					$agent_filter_str = implode(',', $agent_filter);
					$sub_sql .= "
AND `agent_id` IN (" . $agent_filter_str . ") ";
					$sql_end .= "
AND `agent_id` IN (" . $agent_filter_str . ") ";
				}
			}
		}

		$sub_sql .= "
GROUP BY `payments`.`policy_number`
) AS t_year
WHERE (`sum_payment` > '5000') AND (`abs_business` > 0)
";
		$sql_end .= ' ORDER BY `payments`.`payment_date` ASC';
		$sql = $sql_begin . $sub_sql . $sql_end;

		$query = $this->db->query($sql);

		$temp_result = array();
		$temp_rows = array();
		$temp_counts = array();
		$temp_not_empty = FALSE;
		if ($query->num_rows() > 0)
		{
			$temp_not_empty = TRUE;
			foreach ($query->result() as $row)
			{
				$set = FALSE;
				if (!isset($temp_result[$row->agent_id]))
				{
					$temp_result[$row->agent_id] = array();
					$temp_counts[$row->agent_id] = 1;
					$set = TRUE;
				}
				elseif (!isset($temp_result[$row->agent_id][$row->policy_number]))
				{
					$temp_counts[$row->agent_id]++;
					$set = TRUE;
				}
				if ($set)
				{
					$row->asegurado = '';
					if ($row->policy_number) {
						$query_policy = $this->db->get_where('policies', array('uid' => $row->policy_number), 1, 0);
						if ($query_policy->num_rows() > 0)
							$row->asegurado = $query_policy->row()->name;
						$query_policy->free_result();
					}
					$temp_result[$row->agent_id][$row->policy_number] = $row->policy_number;
					$temp_rows[] = $row;
				}
			}
		}

		if ($count_requested)
		{
			if ($temp_not_empty)
			{
				if ($agent_id)
					return $temp_counts[$agent_id];
				else
					return $temp_counts;
			}
			else
				return 0;
		} else
			return $temp_rows;
	}

//	private function _getNewNegocioPai( $count_requested = TRUE, $agent_id = null, $filter = array())
	private function _getNegocioPai( $count_requested = TRUE, $agent_id = null, $filter = array())
	{
		$sql_date_filter = '';
		$sql_agent_filter = '';
		$sql_plus = "`valid_for_report` = '1' AND `year_prime` = '1' ";
		if ($agent_id)
			$sql_agent_filter .= " AND `agent_id` = '$agent_id'";

		if( !empty( $filter ) )
		{
			if ( !$agent_id && isset( $filter['query']['agent_name'] ) and !empty( $filter['query']['agent_name'] ) )
			{
				$this->_get_agent_filter_where($filter['query']['agent_name']);
				if ($this->agent_name_where_in)
				{
					$agent_filter = array();
					foreach ($this->agent_name_where_in as $agent_key => $agent_value)
						$agent_filter[$agent_key] = "'$agent_value'";
					$sql_agent_filter .= "
AND `agent_id` IN (" . implode(',', $agent_filter) . ") ";
				}
			}
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) )
				$sql_plus .= " AND `product_group` = '" . $filter['query']['ramo'] . "'
";
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) )
			{
				$year = date( 'Y' );				
				switch ($filter['query']['periodo'])
				{
					case 1: // month
						$month = date( 'm' );
						$next_month = date('m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
						$sql_date_filter .= "
WHERE `above_5000` >= '$year-$month-01'
AND `above_5000` < '$year-$next_month-01'";
						$sql_plus .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` < '$year-$next_month-01'";
					break;
					case 2: // trimester/cuatrimestre
						$this->load->helper('tri_cuatrimester');
						if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 )
							$begin_end = get_tri_cuatrimester( $this->cuatrimestre(), 'cuatrimestre' ) ;
						else
							$begin_end = get_tri_cuatrimester( $this->trimestre(), 'trimestre' );

						if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
						{
							$sql_date_filter .= "
WHERE `above_5000` >= '" . $begin_end['begind'] . "'
AND `above_5000` <= '" . $begin_end['end'] . "'";
							$sql_plus .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '" . $begin_end['end'] . "'";
						}
					break;
					case 3: // year
						$sql_date_filter .= "
WHERE `above_5000` >= '$year-01-01'
AND `above_5000` <= '$year-12-31 23:59:59'";
						$sql_plus .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '$year-12-31 23:59:59'";
					break;
					case 4: // custom period
						$from = $this->custom_period_from;
						$to = $this->custom_period_to;
						if ( ( $from === FALSE ) || ( $to === FALSE ) )
						{
							$from = date('Y-m-d');
							$to = $from;
						}
						$sql_date_filter .= "
WHERE `above_5000` >=  '$from 00:00:00'
AND `above_5000` <= '$to 23:59:59'";
						$sql_plus .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '$to 23:59:59'";
					break;

				}
			}
		}

		if ($count_requested)
			$sql_str = "SELECT COUNT(*) AS `payment_count`,
 `agent_id`, `first_name`, `last_name`, `company_name`";
		else
			$sql_str = "SELECT *";		

		$sql_str .= "
FROM
(
SELECT `payments`.*,
`users`.`name` AS `first_name`, `users`.`lastnames` AS `last_name`, `users`.`company_name` AS `company_name`,
min( `payment_date` ) AS above_5000
FROM (
SELECT * , (
SELECT sum( `amount` )
FROM `payments` `t2`
WHERE `t2`.`agent_id` = `payments`.`agent_id`
AND (
`t2`.`policy_number` = `payments`.`policy_number`
)
AND `t2`.`payment_date` <= `payments`.`payment_date`
AND 
" . $sql_plus . $sql_agent_filter . " 
AND CONCAT(`agent_id`, '|', `policy_number`)
IN ( 
SELECT CONCAT(`t_year`.`agent_id`, '|', `t_year`.`policy_number`)
FROM (
SELECT `payments`.*, SUM( ABS(`payments`.`business` )) AS `abs_business`
FROM (
`payments`
)
WHERE
" . $sql_plus . $sql_agent_filter  . "
GROUP BY `payments`.`policy_number`, `payments`.`agent_id`
) AS `t_year`
WHERE (`abs_business` > '0')
)
) AS `payment_acc`
FROM `payments`
) `payments`
JOIN `agents` ON `agents`.`id`=`payments`.`agent_id`
JOIN `users` ON `users`.`id`=`agents`.`user_id`
WHERE `payment_acc` >= '5000'
GROUP BY `agent_id`, `policy_number`
)
AS `wrapping_t`
";
//		if ($sql_date_filter && $sql_agent_filter)
		if (!$sql_date_filter)
			$sql_date_filter = " WHERE (above_5000 <= '" . date('Y-m-d') . "') ";
		$sql_str .= " $sql_date_filter $sql_agent_filter ";

		if ($count_requested)
			$sql_str .= "
GROUP BY `agent_id`";

		$query = $this->db->query($sql_str);

		if ($query->num_rows() > 0)
		{
			if ($count_requested)
			{
				$result = array();
				foreach ($query->result() as $row)
					$result[$row->agent_id] = $row->payment_count;
				if ($agent_id)
					return $result[$agent_id];
				else
					return $result;
			}
			else
			{
				$result = array();
				foreach ($query->result() as $row)
				{
					$row->asegurado = '';
					if ($row->policy_number) {
						$query_policy = $this->db->get_where('policies', array('uid' => $row->policy_number), 1, 0);
						if ($query_policy->num_rows() > 0)
							$row->asegurado = $query_policy->row()->name;
						$query_policy->free_result();
					}
					$result[] = $row;				
				}
				return $result;
			}
		}
		else
		{
			if ($count_requested)
				return 0;
			else
				return array();
		}
	}

  public function getCountNegocioPai_other_old( $agent_id = null, $filter = array() ){
 		
		
		
		if( empty( $agent_id ) ) return 0;
		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id
		FROM `policies_vs_users`
		JOIN  policies ON policies.id=policies_vs_users.policy_id
		JOIN  payments ON payments.policy_number=policies.uid
		--JOIN  agents ON agents.id=policies_vs_users.user_id
		--JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=1
    	AND policies.prima>10000
		*/
		
		$this->db->select( 'DISTINCT( policy_number ) as policy_number' );
		$this->db->from( 'payments' );		
		//$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		//$this->db->join( 'users', 'users.id=agents.user_id' );
//		$this->db->where( array( 'agent_id' => $agent_id, 'business' => 1 ) );
		$this->db->where( array( 'agent_id' => $agent_id, 'valid_for_report' => '1'));
		$this->db->where( "((business = '1') OR (business = '-1'))" );

		if( !empty( $filter ) ){
			
			
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){
						
				$this->db->where( 'product_group', $filter['query']['ramo'] ); 
			}
			
			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) )
			{
				if( $filter['query']['periodo'] == 1 )
				{
					$year = date( 'Y' );
					$month = date( 'm' );
					$next_month = date('m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
					$this->db->where( array(
						'payments.payment_date >= ' => $year . '-' . $month . '-01',
						'payments.payment_date < ' => $year . '-' . $next_month . '-01',
						)); 
				}
				if( $filter['query']['periodo'] == 2 )
				{
					$this->load->helper('tri_cuatrimester');
					if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 )
						$begin_end = get_tri_cuatrimester( $this->cuatrimestre(), 'cuatrimestre' ) ;
					else
						$begin_end = get_tri_cuatrimester( $this->trimestre(), 'trimestre' );

					if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
						$this->db->where( array(
							'payments.payment_date >= ' => $begin_end['begind'],
							'payments.payment_date <=' =>  $begin_end['end']) );
				}
				if( $filter['query']['periodo'] == 3 )
				{
					$year = date( 'Y' );
					$this->db->where( array(
						'payments.payment_date >= ' => $year . '-01-01',
						'payments.payment_date <= ' => $year . '-12-31 23:59:59'
						)); 
				}
				if( $filter['query']['periodo'] == 4 )
				{
					$from = $this->custom_period_from;
					$to = $this->custom_period_to;
					if ( ( $from === FALSE ) || ( $to === FALSE ) )
					{
						$from = date('Y-m-d');
						$to = $from;
					}
					$this->db->where( array(
						'payments.payment_date >= ' => $from . ' 00:00:00',
						'payments.payment_date <=' => $to . ' 23:59:59') );
				}
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
			$this->db->where( array( 'policy_number' => $row->policy_number ) );
						
			$querypai = $this->db->get(); 
			
			if ($querypai->num_rows() == 0) break;			
			
			foreach ($querypai->result() as $rowpai)
			
				if( (float)$rowpai->amount >= 5000 )
					
					$pai[]=$rowpai->amount;
			
					
			
				
		}
			
		return $pai;
  }
  
  
  
  /*  getCountNegocioPai
   public function getCountNegocioPai( $agent_id = null, $filter = array() ){
 		
		
		
		if( empty( $agent_id ) ) return 0;
		*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id
		FROM `policies_vs_users`
		JOIN  policies ON policies.id=policies_vs_users.policy_id
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=1
    	AND policies.prima>10000
		*
		
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
			
			*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*
			
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
			
			*
				SELECT SUM(amount) as amount
				FROM payments
				WHERE policy_id=28
			*
			
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
  }*/

	public function getPrima( $agent_id = null, $filter = array() ){

		return $this->_getPrima( TRUE, $agent_id, $filter);
	}

	public function getPrimaDetails( $agent_id = null, $filter = array() ){

		return $this->_getPrima( FALSE, $agent_id, $filter);
	}

// Common method for getting sum of prima (first param = TRUE) and details of prima (first param = FALSE) 
	private function _getPrima( $sum_requested = TRUE, $agent_id = null, $filter = array()) {

		if ( empty( $agent_id ) && $sum_requested)
			return 0;

		/*
		SELECT DISTINCT( policies_vs_users.policy_id ) as policy_id, policies.prima
		FROM `policies_vs_users`
		JOIN  policies ON policies.id=policies_vs_users.policy_id
		JOIN  work_order ON work_order.policy_id=policies_vs_users.policy_id
		JOIN  agents ON agents.id=policies_vs_users.user_id
		JOIN  users ON users.id=agents.user_id
		WHERE policies_vs_users.user_id=6
		*/
		if ($sum_requested)
			$this->db->select( 'SUM( amount ) as primas' );
		else
			$this->db->select( 'payments.*, users.name as first_name, users.lastnames as last_name, users.company_name as company_name' );    
		$this->db->from( 'payments' );
		$this->db->join( 'agents', 'agents.id=payments.agent_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$where = array( 'year_prime' => 1, 'valid_for_report' => 1);
		if ($agent_id)
			$where['agent_id'] = $agent_id;
		$this->db->where($where);

		if( !empty( $filter ) ){

			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) ){

				$this->db->where( 'product_group', $filter['query']['ramo'] ); 
			}

			/*
			<option value="1">Mes</option>
			<option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
			<option value="3">Año</option>
			*/	
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) )
			{
				if( $filter['query']['periodo'] == 1 )
				{
					$year = date( 'Y' );
					$month = date( 'm' );
					$next_month = date('m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
					$this->db->where( array(
						'payment_date >= ' => $year . '-' . $month . '-01',
						'payment_date < ' => $year . '-' . $next_month . '-01',
						)); 
				}
				if( $filter['query']['periodo'] == 2 )
				{
					$this->load->helper('tri_cuatrimester');
					if( isset( $filter['query']['ramo'] ) and $filter['query']['ramo'] == 2 or $filter['query']['ramo'] == 3 )
						$begin_end = get_tri_cuatrimester( $this->cuatrimestre(), 'cuatrimestre' ) ;
					else
						$begin_end = get_tri_cuatrimester( $this->trimestre(), 'trimestre' );

					if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
						$this->db->where( array(
							'payment_date >= ' => $begin_end['begind'],
							'payment_date <=' =>  $begin_end['end']) );
				}
				if( $filter['query']['periodo'] == 3 )
				{
					$year = date( 'Y' );
					$this->db->where( array(
						'payment_date >= ' => $year . '-01-01',
						'payment_date <= ' => $year . '-12-31 23:59:59'
						)); 
				}
				if( $filter['query']['periodo'] == 4 )
				{
					$from = $this->custom_period_from;
					$to = $this->custom_period_to;
					if ( ( $from === FALSE ) || ( $to === FALSE ) )
					{
						$from = date('Y-m-d');
						$to = $from;
					}
					$this->db->where( array(
						'payment_date >= ' => $from . ' 00:00:00',
						'payment_date <=' => $to . ' 23:59:59') );
				}
			}

			if ( !$agent_id && isset( $filter['query']['agent_name'] ) and !empty( $filter['query']['agent_name'] ) )
			{
				$this->_get_agent_filter_where($filter['query']['agent_name']);
				if ($this->agent_name_where_in)
					$this->db->where_in('agent_id', $this->agent_name_where_in);
			}
		}

		$query = $this->db->get();
		if ($sum_requested) {
			if ($query->num_rows() == 0) return 0;		
			foreach ($query->result() as $row){
				$prima = (float)$row->primas;	
			}
			return $prima;
		} else {
			$result = array();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$row->asegurado = '';
					if ($row->policy_number) {
						$query_policy = $this->db->get_where('policies', array('uid' => $row->policy_number), 1, 0);
						if ($query_policy->num_rows() > 0)
							$row->asegurado = $query_policy->row()->name;
						$query_policy->free_result();
					}
					$result[] = $row;
				}
			}
			return $result;
		}
	}
/*
 Get the prima for a given policy while taking into account
* the extra payment that depends on payment interval and currency
* the period selected in the filter (note: the period is not taken into account any more):
    1: 1 month prima
	2: 3 month prima if ramo is Vida (1)
	   4 month prima if ramo is not Vida
	3: 12 months prima
*/
	public function get_adjusted_prima($policy_id, $ramo = 1, $period = 2)
	{
		$result = null;

// Get the infos regarding the policy (anual prima, payment interval and the extra payment that depends on currency		
		$this->db->select('`policies`.`prima`, `policies`.`payment_interval_id`, `extra_payment`.`extra_percentage`', FALSE);
		$this->db->from(array('policies', 'products', 'extra_payment'));
		$this->db->where("`policies`.`id` = '$policy_id'
AND
 `products`.`id`=`policies`.`product_id`
AND
`extra_payment`.`x_product_platform` = `products`.`platform_id`
AND
`extra_payment`.`x_currency` = `policies`.`currency_id`
AND
`extra_payment`.`x_payment_interval` = `policies`.`payment_interval_id`", NULL, FALSE);
		$query_adjusted_prima = $this->db->get();
		if ($query_adjusted_prima->num_rows() > 0)
		{
			$row = $query_adjusted_prima->row();
			$adjusted_year_prima = $row->prima * (1 + $row->extra_percentage);
			switch ($row->payment_interval_id)
			{
				case 1: // mensual payment
					$result = $adjusted_year_prima / 12;
					break;
				case 2: // trimestrial payment
					$result = $adjusted_year_prima / 4;
					break;
				case 3: // semestrial payment
					$result = $adjusted_year_prima / 2;
					break;
				case 4: // annual payment
					$result = $adjusted_year_prima;
					break;
				default:
					break;
			}
		}
		return $result;
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

		$this->db->select('DISTINCT( policies_vs_users.policy_id ) AS policy_id, policies_vs_users.user_id, policies_vs_users.percentage,work_order.id AS work_order_id');
		$this->db->from('work_order_types' );
		$this->db->join('work_order','work_order.work_order_type_id=work_order_types.id');
		$this->db->join('policies','policies.id=work_order.policy_id' );		
		$this->db->join('policies_vs_users', 'policies_vs_users.policy_id=policies.id');
		$this->db->join( 'agents','agents.id=policies_vs_users.user_id');
		$this->db->join( 'users','users.id=agents.user_id');

		$this->db->where("( work_order.work_order_status_id=5 OR  work_order.work_order_status_id=9)");
		$this->db->where("( work_order_types.patent_id =47 OR work_order_types.patent_id=90 )");
		$this->db->where( 'policies_vs_users.user_id', $user_id );

		$ramo = 1;
		$period = 2;
		if( !empty( $filter ) )
		{
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) )
			{			
				$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] );
				$ramo = $filter['query']['ramo'];
			}

		}
		$query = $this->db->get();

		if ($query->num_rows() == 0) return 0;		

		$tramite = array();			
		$work_order_ids = array();            
		$tramite['count'] = $query->num_rows();		
		$tramite['prima'] = 0;
		$tramite['adjusted_prima'] = 0;
		
		foreach ($query->result() as $row)
		{
			$tramite['adjusted_prima'] += $this->get_adjusted_prima($row->policy_id, $ramo, $period) * ($row->percentage / 100);
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
						$tramite['prima'] = (float)$tramite['prima'] + ((float)$rowprima->prima * $row->percentage / 100);					
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

		$this->db->select('DISTINCT( policies_vs_users.policy_id ) AS policy_id, policies_vs_users.percentage, work_order.id AS work_order_id' );
		$this->db->from( 'policies' );
		$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=policies.id' );
		$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where('work_order.work_order_status_id', '7' );
		$this->db->where("( work_order_types.patent_id =47 OR work_order_types.patent_id=90 )");
		$this->db->where( 'policies_vs_users.user_id', $user_id );

		$ramo = 1;
		$period = 2;
		if(!empty($filter))
		{
			if( isset( $filter['query']['ramo'] ) and !empty( $filter['query']['ramo'] ) )
			{
				$this->db->where( 'work_order.product_group_id', $filter['query']['ramo'] );
				$ramo = $filter['query']['ramo'];
			}
		}

		$query = $this->db->get(); 

		if ($query->num_rows() == 0) return 0;			

		$aceptadas = array();	
		$work_order_ids = array();
		$aceptadas['prima'] = 0;
		$aceptadas['adjusted_prima'] = 0;		
		$aceptadas['count']=0;		
		foreach ($query->result() as $row)
        {
			$aceptadas['adjusted_prima'] += $this->get_adjusted_prima($row->policy_id, $ramo, $period) * $row->percentage / 100;
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
					if( !empty( $rowprima->prima ) )
						$aceptadas['prima'] = (float)$aceptadas['prima'] + ((float)$rowprima->prima  * $row->percentage / 100);					
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
		$this->db->where( array( 'year_prime' => 1, 'valid_for_report' => 1 ) );
				
		$querypayments = $this->db->get(); 
		
		
		if ($querypayments->num_rows() == 0){
			
			foreach ( $querypolicies->result() as $rowpayment )	
				
				$count += $rowpayment->count;
						
			
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
		$this->db->where( array( 'year_prime >' => 1, 'valid_for_report' => 1 ) );
				
		$querypayments = $this->db->get(); 
		
		
		if ($querypayments->num_rows() == 0){
			
			foreach ( $querypolicies->result() as $rowpayment )	
				
				$count += $rowpayment->count;
						
			
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

	private function _get_agent_filter_where($agent_name)
	{
		if ($this->agent_name_where_in !== null)
			return;
		$this->agent_name_where_in = array();
		$agent_name_array = explode("\n", $agent_name);
		$to_replace = array(']', "\n", "\r");
		foreach ($agent_name_array as $value)
		{
			$pieces = explode( ' [ID: ', $value);
			if (isset($pieces[1]))
			{
				$pieces[1] = str_replace($to_replace, '', $pieces[1]);
				if (!isset($this->agent_name_where_in[$pieces[1]]))
					$this->agent_name_where_in[] = $pieces[1];
			}
		}
	}

	public function get_agent_by_user($user_id)
	{
		if( empty( $user_id ) ) return false;

		
		$this->db->select( 'users.*, agents.connection_date, agents.id as agent_id' );
		$this->db->from( 'users' );
		$this->db->join( 'agents', 'agents.user_id=users.id' );		
		$this->db->where( 'users.id =', $user_id );
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 0)
			return FALSE;

		foreach ($query->result() as $row)
		{
			if ( !empty( $row->company_name ) )
				$row->agent_name = $row->company_name;
			else
				$row->agent_name = $row->name . ' ' . $row->lastnames;
			$row->generacion = '';

			if( $row->connection_date != '0000-00-00' and $row->connection_date != '' )
			{
				$resultado =  date( 'Y', strtotime( $row->connection_date ) );

				//Consolidado: < 3 años < hoy
				if( $resultado < ( date( 'Y' )-3 ))
					$row->generacion = 'Consolidado';  

				//Generación 1: Fecha de conexión > 1 año < hoy
				if( $resultado > ( date( 'Y' )-1 )  )
					$row->generacion = 'Generación 1';
            
				//Generación 2: fecha de conexión > 1  año y < 2 años
				if( $resultado >= ( date( 'Y' )-2 ) and $resultado <= ( date( 'Y' )-1 ) )
					$row->generacion = 'Generación 2';
      
				//Generación 3: fecha de conexión > 2 años y < 3 años <option value="5">Generación 3</option>
				if( $resultado >= ( date( 'Y' )-3 ) and $resultado <= ( date( 'Y' )-2 ) ) 
					$row->generacion = 'Generación 3';
			}
			else
				$row->generacion = 'Generación 1';

			$row->uids = $this->getAgentsUids( $row->agent_id );
			return $row;
		}
		return FALSE;
	}
}
?>