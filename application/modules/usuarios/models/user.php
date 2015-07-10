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

	public function overview( $start = 0, $filter = null ) {

		$agents = array();
		$query = $this->db->get('agents');
		foreach ($query->result() as $row)
			$agents[$row->user_id] = $row->id;

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
					
			$this->db->limit( 300, $start );
		
		}
		
		$query = $this->db->get();	
		
		if ($query->num_rows() == 0) return false;
 	
		
		
		unset( $this->data );

		$this->data = array();

		$user_infos = array();
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
			{
				$tipo .= $row_types->name.'<br>';
				$is_administrator = ($row_types->name == 'Administrador');
			}
				
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
			$user_infos[$row->id] = array(
				'uids' => $clave . $national . $provincial,
				'agent_id' => isset($agents[$row->id]) ? $agents[$row->id] :  NULL,
				'is_deletable' => !$is_administrator);
		}
		$query->free_result();
		$this->is_deletable($user_infos);
		foreach ($this->data as $key => $value)
			$this->data[$key]['is_deletable'] = $user_infos[$value['id']]['is_deletable'];
		return $this->data;
		
   }

// Determines if users are deletable
	public function is_deletable(&$user_infos)
	{
		$to_check = array(
			array(
				'table' => 'agents_activity',
				'field' => 'agent_id',
				'variable' => 'agent'),
			array(
				'table' => 'payments',
				'field' => 'agent_id',
				'variable' => 'agent'),
			array(
				'table' => 'policies_vs_users',
				'field' => 'user_id',
				'variable' => 'agent'),
			array(
				'table' => 'simulator',
				'field' => 'agent_id',
				'variable' => 'agent'),
			array(
				'table' => 'meta_new',
				'field' => 'agent_id',
				'variable' => 'agent'),
			array(
				'table' => 'simulator_new',
				'field' => 'agent_id',
				'variable' => 'agent'),
			array(
				'table' => 'work_order',
				'field' => 'user',
				'variable' => 'user'),	
		);

		if (count($user_infos) > 1)
		{
			foreach ($to_check as $description)
			{
				$query = $this->db->query(
					'SELECT DISTINCT (' . $description['field'] . ') AS identification FROM ' . $description['table']);
				$$description['table'] = array();
				foreach ($query->result() as $row)
					${$description['table']}[$row->identification] = $row->identification;
				$query->free_result();
			}
			foreach ($user_infos as $user_id => $infos)
			{
				if ($infos['is_deletable'])
				{
					foreach ($to_check as $description)
					{
						if ((($description['variable'] == 'agent') &&
							isset($infos['agent_id']) &&
							isset(${$description['table']}[$infos['agent_id']]))
							||
							(($description['variable'] == 'user') &&
							isset(${$description['table']}[$user_id])))
						{
							$user_infos[$user_id]['is_deletable'] = FALSE;
							break;
						}
					}
				}
			}
		}
		else
		{
			foreach ($user_infos as $user_id => $infos)
			{
				if ($infos['is_deletable'])
				{
					foreach ($to_check as $description)
					{
						$num_rows = 0;
						if (($description['variable'] == 'agent') &&
							$infos['agent_id'] )					
						{
							$query = $this->db->select($description['field'])
								->get_where($description['table'], 
								array($description['field'] => $infos['agent_id']), 1, 0);
							$num_rows = $query->num_rows();
							$query->free_result();
						}
						elseif ($description['variable'] == 'user')
						{
							$query = $this->db->select($description['field'])
								->get_where($description['table'], 
								array($description['field'] => $user_id), 1, 0);
							$num_rows = $query->num_rows();
							$query->free_result();							
						}
						if ($num_rows)
						{
							$user_infos[$user_id]['is_deletable'] = FALSE;
							break;
						}
					}
				}
			}
		}
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
		$this->db->order_by( 'users.company_name', 'asc' );		
		$this->db->order_by( 'users.name', 'asc' );	
		$this->db->order_by( 'users.lastnames', 'asc' );	
		
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
		$this->db->order_by('agent_uids.id', 'asc'); 
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
		$this->db->limit(1);
		$this->db->order_by('id', 'asc'); 
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

	public function getReport( $filter = array(), $meta = false )
	{
	/**
	 *	SELECT users.*, agents.id as agent_id
		FROM `agents`
	 **/
	$this->db->select( 'users.*, agents.connection_date, agents.id as agent_id' );
	$this->db->from( 'agents' );
	$this->db->join( 'users', 'users.id=agents.user_id' );

	$generacion = '';
	$is_vida = false;
	$is_gmm = false;
	$is_autos = false;
		
	if( !empty( $filter ) && is_array($filter['query'])){
		if( isset( $filter['query']['ramo']))
		{
			$is_vida = ($filter['query']['ramo'] == 1 );
			$is_gmm = ($filter['query']['ramo'] == 2 );
			$is_autos = ($filter['query']['ramo'] == 3 );
		}
		
		if ($meta)
		{
			$with_filter = FALSE;
			$this->_get_generation_filter($filter, $with_filter);
		}
		else
		{
			if( isset( $filter['query']['generacion'] ) and !empty( $filter['query']['generacion'] ) )
			{
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
/*				$this->db->select( 'payments.policy_number' );
				$this->db->join( 'payments', 'payments.agent_id=agents.id' );
				$this->db->where_in('policy_number', $policy_filter);*/
				$this->db->select( 'payments.policy_number, policies.uid' );
				$this->db->join( 'payments', 'payments.agent_id=agents.id' );
				$this->db->join( 'policies_vs_users', 'policies_vs_users.user_id=agents.id' );				
				$this->db->join( 'policies', 'policies.id=policies_vs_users.policy_id' );
				$this->db->where_in('policy_number', $policy_filter);
				$this->db->or_where_in('uid', $policy_filter);				
			}
	}
	$this->db->order_by('name', 'asc');
	$this->db->order_by('lastnames', 'asc'); 
	$query = $this->db->get();

	if ($query->num_rows() == 0) return false;		
	
	$report = array();
	if ($meta)
	{
		$report[0] = array(
			'cua' => 'CUA',
//			'name' => 'AGENTE',
			'name' => 'Agentes',
			'generacion' => 'GEN',
			'negocios' => 'NEGOCIOS',
			'primas_iniciales' => 'PRIMAS INICIALES',

			'solicitudes_meta' => 'Solicitudes Meta',
			'solicitudes_ingresadas' => 'Solicitudes Ingresadas',
			'negocios_meta' => 'Negocios Meta',
			'negocios_pagados' => 'Negocios Pagados',
			'primas_meta' => 'Primas Meta',
			'primas_pagadas' => 'Primas Pagadas',
		);
	}
	else
	{
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

	}
		
	$user_ids = array();
	$agent_ids = array();
	$rank_agent = array();
	$i = 1;

	foreach ($query->result() as $row){
		if ( !isset($user_ids[$row->id]) )
		{
			$agent_ids[] = $row->agent_id;
			$user_ids[$row->id] = $row->agent_id;

			$name = null;
			if( empty(  $row->company_name ) )
				$name =  $row->name. ' ' . $row->lastnames;
			else
				$name =  $row->company_name;

			if ($meta)
			{
				$generacion = $this->get_agent_generation($row->connection_date);
			}
			else
			{
				if( $row->connection_date != '0000-00-00' and $row->connection_date != '' )
				{
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
			}
			$report_row = array(
				'id' => $row->id,
				'name' => $name,
				'generacion' => $generacion,
				'agent_id' => $row->agent_id,
				);
			if ($meta)
			{
				$report_row = array_merge($report_row, array(
					'cua' => '',
					'negocios' => 0,
					'primas_iniciales' => 0,

					'solicitudes_meta' => 0,
					'solicitudes_ingresadas' => 0,
					'negocios_meta' => 0,
					'negocios_pagados' => 0,
					'primas_meta' => 0,
					'primas_pagadas' => 0,
				));
			}
			else
			{
				$report_row = array_merge($report_row, array(
					'connection_date' => $row->connection_date,
					'disabled' => $row->disabled,
					'negocio' => 0,
					'negociopai' => 0,
					'prima' => 0,
					'tramite' => array('work_order_ids' => array(), 'count' => 0, 'adjusted_prima' => 0),
					'aceptadas' => array('work_order_ids' => array(), 'count' => 0, 'adjusted_prima' => 0),
					'iniciales' => 0,
					'renovacion' => 0,
					'uids' => array(),
					));
				if ($is_autos)
				{
					$report_row['iniciales'] = $this->getIniciales( $row->agent_id, $filter );
					$report_row['renovacion'] = $this->getRenovacion( $row->agent_id, $filter );
				}
			}
			$report[$i] = $report_row;
			$rank_agent[$row->agent_id] = $i;
			$i++;
		}
	}
	$query->free_result();

	if (count($agent_ids))
	{
		$uids_arr = $this->getAgentsUids( $agent_ids );
		if ($is_vida && !$meta)
			$negocios_pai = $this->_getNegocioPai(TRUE, null, $filter);

		if ( !$meta && ($is_vida || $is_gmm))
		{
			$negocios = $this->getCountNegocio( $agent_ids, $filter);
			$primas = $this->getPrima( $agent_ids, $filter);
			$tramites = $this->getTramite($agent_ids, $filter);
			$aceptadas = $this->getAceptadas($agent_ids, $filter);
		}
		if ($meta)
		{
			if( isset( $filter['query']['ramo']) && ($filter['query']['ramo'] > 0) && 
				($filter['query']['ramo'] <= 3))
				$ramo = (int)$filter['query']['ramo'];
			else
				$ramo = 1;
			$start_end = $this->_get_start_end_in_month($filter, $ramo);
		}
		foreach ($rank_agent as $key => $value)
		{
			if (isset($uids_arr[$key]))
			{
				if ($meta)
				{
					if ($uids_arr[$key]['type'] == 'clave')
					{
						$report[$value]['cua'] = $uids_arr[$key]['uid'];
					}	
				}
				else
					$report[$value]['uids'] = array(0 => $uids_arr[$key]);
			}
			if ( !$meta && ($is_vida || $is_gmm))
			{
				if ($is_vida && isset($negocios_pai[$key]))
					$report[$value]['negociopai'] = $negocios_pai[$key];
				if (is_array($negocios) && isset($negocios[$key]))
					$report[$value]['negocio'] = $negocios[$key];
				if (is_array($primas) && isset($primas[$key]))
					$report[$value]['prima'] = $primas[$key];
				if (is_array($tramites) && isset($tramites[$key]))
					$report[$value]['tramite'] = $tramites[$key];
				if (is_array($aceptadas) && isset($aceptadas[$key]))
					$report[$value]['aceptadas'] = $aceptadas[$key];
			}
		}
	}
	return $report;
 }

// computes the Negocios and Primas iniciales from the simulator table row
	private function _get_simulator_data($start_end, $simulator_data)
	{
		$start_end['start'] = $start_end['start'] + 0;
		$start_end['end'] = $start_end['end'] + 0;		
		$simulator_arr = json_decode($simulator_data);
		$result = array(
			'negocios' => 0,
			'primas_iniciales' => 0);
		for ($i = $start_end['start']; $i <= $start_end['end']; $i++)
		{
			if (isset($simulator_arr->{'primas-negocios-meta-' . $i}))
				$result['negocios'] += $simulator_arr->{'primas-negocios-meta-' . $i};
			if (isset($simulator_arr->{'primas-meta-' . $i}))
				$result['primas_iniciales'] += $simulator_arr->{'primas-meta-' . $i};	
		}
		return $result;
	}

	private function _get_start_end_in_month($filter, $ramo)
	{
		$start_end = array('start' => 1, 'end' => 12);
		if ( !isset( $filter['query']['periodo'] )  || empty( $filter['query']['periodo'] ) )
			return $start_end;
		switch ($filter['query']['periodo'])
		{
			case 1:
				$month = date( 'm' );
				$start_end = array('start' => $month, 'end' => $month);
				break;
			case 2:
				$this->load->helper('tri_cuatrimester');
				if (($ramo == 2) || ($ramo == 3))
					$begin_end = get_tri_cuatrimester( $this->cuatrimestre(), 'cuatrimestre' ) ;
				else
					$begin_end = get_tri_cuatrimester( $this->trimestre(), 'trimestre' );
				if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
				{
					$parts = explode('-', $begin_end['begind']);
					$start_end['start'] = $parts[1];
					$parts = explode('-', $begin_end['end']);
					$start_end['end'] = $parts[1];
				}
				break;
			case 3:
				break;
			case 4:
				$from = $this->custom_period_from;
				$to = $this->custom_period_to;
				if ( ( $from === FALSE ) || ( $to === FALSE ) )
				{
					$from = date('Y-m-d');
					$to = $from;
				}
				$parts = explode('-', $from);
				$start_end['start'] = $parts[1];
				$parts = explode('-', $to);
				$start_end['end'] = $parts[1];
				break;
			default:
				break;
		}
		return $start_end;
	}

	
	private function _row_export_generic($value, $ramo = 'vida_gmm')
	{
		if ($ramo == 'vida_gmm')
			$data_row = array(
				'name' => $value['name'],
				'uids' => '',
				'connection_date' => '',
				'negocio' => $value['negocio'],
				'negociopai' => 0,
				'prima' => $value['prima'],
				'tramite' => 0,
				'tramite_prima' => 0,
				'pendientes' => 0,
				'pendientes_primas' => 0,
				'negocios_proyectados' => 0,
				'negocios_proyectados_primas' => 0,
				);
		else
			$data_row = array(
				'name' => $value['name'],
				'uids' => '',
				'connection_date' => '',
				'iniciales' => $value['iniciales'],
				'renovaciones' => $value['renovacion'],
				'totales' => (int)$value['iniciales']+(int)$value['renovacion']
				);
		if ( !empty( $value['uids'][0]['type'] ) && ($value['uids'][0]['type'] == 'clave')
			&& !empty( $value['uids'][0]['uid'] ))
			$data_row['uids'] =  $value['uids'][0]['uid'];
		else
			$data_row['uids'] = 'Sin clave asignada';

		if ( !empty( $value['connection_date'] ) && ($value['connection_date'] != '0000-00-00' ))
			$data_row['connection_date'] =  $value['connection_date'];
		else
			$data_row['connection_date'] = 'No Conectado';

		return $data_row;
	}

/*	report export helper methods
	TODO: use them in the ot module also (currently used in the director module only
*/
	private function _format_export_generic($data, $ramo)
	{
		if ($ramo != 3)
		{ // Vida or GMM
			$total_negocio=0;
			$total_negocio_pai=0;
			$total_primas_pagadas=0;
			$total_negocios_tramite=0;
			$total_primas_tramite=0;
			$total_negocio_pendiente=0;
			$total_primas_pendientes=0;
			$total_negocios_proyectados=0;
			$total_primas_proyectados=0;

			if( !empty( $data ) )
			{
				foreach ( $data as $key => $value )
				{
					if ($key == 0)
						$data_report[] = array(
							'name' => 'Agentes',
							'uids' => 'Clave única',
							'connection_date' => 'Fecha de conexión',
							'negocio' => 'Negocios Pagados',
							'negociopai' => 'Negocios PAI',
							'prima' => 'Primas Pagadas',
							'tramite' => 'Negocios en Tramite',
							'tramite_prima' => 'Primas en Tramite',	//	(not in $data)
							'pendientes' => 'Negocios Pendientes',
							'pendientes_primas' => 'Primas Pendientes', //  (not in $data)
							'negocios_proyectados' => 'Negocios Proyectados',
							'negocios_proyectados_primas' => 'Primas Proyectadas',
						);
					else
					{
						$data_row = $this->_row_export_generic($value, 'vida_gmm');

						if ( is_array( $value['negociopai'] ))
							$data_row['negociopai'] = count( $value['negociopai'] );
						else
							$data_row['negociopai'] = $value['negociopai'];						

						if ( isset( $value['tramite']['count'] ) )
						{
							$data_row['tramite'] = $value['tramite']['count'];
							$data_row['tramite_prima'] = $value['tramite']['adjusted_prima'];
						}
						if( isset( $value['aceptadas']['count'] ) )
						{
							$data_row['pendientes'] = $value['aceptadas']['count'];
							$data_row['pendientes_primas'] = $value['aceptadas']['adjusted_prima'];
						}
						$data_row['negocios_proyectados'] = (int)$data_row['pendientes'] + 
//							(int)$data_row['tramite'] + (int)$data_row['negociopai'] + (int)$data_row['negocio'];
							(int)$data_row['tramite'] + (int)$data_row['negocio']; // to make consistent with report on screen
						$data_row['negocios_proyectados_primas'] = (float)$data_row['prima'] + 
							(float)$data_row['pendientes_primas'] + (float)$data_row['tramite_prima'];
						$total_negocio += (int)$data_row['negocio'];
						$total_negocio_pai += (int)$data_row['negociopai'];
						$total_primas_pagadas += (float)$data_row['prima'];
						$total_negocios_tramite += (int)$data_row['tramite'];
						$total_primas_tramite += (float)$data_row['tramite_prima'];
						$total_negocio_pendiente += (int)$data_row['pendientes'];
						$total_primas_pendientes += (float)$data_row['pendientes_primas'];
						$total_negocios_proyectados += (int)$data_row['negocios_proyectados'];
						$total_primas_proyectados += (float)$data_row['negocios_proyectados_primas'];

						$data_row['prima'] = '$ '.$data_row['prima'];
						$data_row['tramite_prima'] = '$ '.$data_row['tramite_prima'];
						$data_row['pendientes_primas'] = '$ '.$data_row['pendientes_primas'];
						$data_row['negocios_proyectados_primas'] = '$ '.$data_row['negocios_proyectados_primas'];
						$data_report[] = $data_row;
					}
				}

				$data_report[] = array(
					'name' => 'Totales: ',
					'uids' => '',
					'connection_date' => '',
					'negocio' => $total_negocio,
					'negociopai' => $total_negocio_pai,
					'prima' => '$ '.$total_primas_pagadas,
					'tramite' => $total_negocios_tramite,
					'tramite_prima' => '$ '.$total_primas_tramite,
					'pendientes' => $total_negocio_pendiente,
					'pendientes_primas' => '$ '.$total_primas_pendientes,
					'negocios_proyectados' => $total_negocios_proyectados,
					'negocios_proyectados_primas' => '$ '.$total_primas_proyectados,
				);
			}
		} else
		{ // Autos
			$iniciales=0;
			$renovacion=0;
			$totalgeneral=0;
			if( !empty( $data ) )
			{
				foreach ( $data as $key => $value )
				{
					if ($key == 0)
						$data_report[] = array(
							'name' => 'Agentes',
							'uids' => 'Clave única',
							'connection_date' => 'Fecha de conexión',
							'iniciales' => 'Iniciales',
							'renovaciones' => 'Renovaciones',
							'totales' =>  'Totales'
						);
					else
					{
						$data_row = $this->_row_export_generic($value, 'autos');
						$iniciales += (int)$value['iniciales'];		
						$renovacion +=(int) $value['renovacion'];		
						$totalgeneral += $data_row['totales'];						

						$data_report[] = $data_row;
					}
				}
				$data_report[] = array(
					'name' => 'Totales: ',
					'uids' => '',
					'connection_date' => '',
					'iniciales' => $iniciales,
					'renovaciones' => $renovacion,
					'totalgeneral' => $totalgeneral
				);
			}
		}
		return $data_report;
	}

	private function _format_export_meta($data)
	{
		$data_report = array();
		if( !empty( $data ) )
		{
			$total_negocios = 0;
			$total_primas_iniciales = 0;
			$count = count($data);
			$data_report[0] = $data[0];
			for ($i = 1; $i < $count; $i++)
			{
				$data_report[$i] = array(
					'cua' => $data[$i]['cua'],
					'name' => $data[$i]['name'],
					'generacion' => $data[$i]['generacion'],
					'negocios' => '$ '. $data[$i]['negocios'],
					'primas_iniciales' => '$ '. $data[$i]['primas_iniciales']
					);
				$total_negocios += (int)$data[$i]['negocios'];
				$total_primas_iniciales += (float)$data[$i]['primas_iniciales'];				
			}

			$data_report[] = array(
				'cua' => '',
				'name' => 'TOTALES',
				'generacion' => '',
				'negocios' => '$ '. $total_negocios,
				'primas_iniciales' => '$ '. $total_primas_iniciales,
			);
		}
		return $data_report;
	}

	public function format_export_report($data = array(), $type = 'generic', $ramo = null)
	{
		if (($type == 'generic') &&
			(empty($ramo) || ($ramo < 1) || ($ramo > 3)))
			return FALSE;

		if ($type == 'generic')
			$result = $this->_format_export_generic($data, $ramo);
		else
			$result = $this->_format_export_meta($data);
		return $result;
	}
 
/*	End report export helper methods
*/
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


	if( empty( $agent ) )
		return FALSE;
	/*
	SELECT * 
	FROM `agent_uids`
	WHERE `agent_id` =
	*/
	
	$this->db->select();
	$this->db->from( 'agent_uids' );
 	if (is_array($agent))
		$this->db->where_in('agent_id', $agent);
	else
		$this->db->where(array('agent_id' => $agent));	
	$this->db->where( 'type', 'clave' );
					
	$query = $this->db->get(); 

	if ($query->num_rows() == 0) return false;		
 	
	$uids = array();

 	if (!is_array($agent))
	{
		foreach ($query->result() as $row)
			$uids[] = array(
				'type' => $row->type,
				'uid' => $row->uid
			);
	}
	else
	{
		foreach ($query->result() as $row)
			$uids[$row->agent_id] = array(
				'type' => $row->type,
				'uid' => $row->uid
			);
	}
	$query->free_result();
	return $uids;
	
 }

	public function get_negocios_primas( $agent_id = null, $filter = array() )
	{
 		return array(
			'negocios' => $this->_getNegocios( TRUE, $agent_id, $filter),
			'primas' => $this->_getPrima( TRUE, $agent_id, $filter));
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
		{
			if ($agent_id && is_array($agent_id))
				$this->db->select( 'SUM(business) AS sum_business, payments.agent_id as n_agent_id' );
			else
				$this->db->select( 'SUM(business) AS sum_business' );
		}
		else
			$this->db->select( 'payments.*, users.name as first_name, users.lastnames as last_name, users.company_name as company_name' );    
		$this->db->from( 'payments' );
		$this->db->join( 'agents', 'agents.id=payments.agent_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$where = array('valid_for_report' => '1');
		if ($agent_id && !is_array($agent_id))
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
					$next_month = date('Y-m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))) . '-01';
					$this->db->where( array(
						'payments.payment_date >= ' => $year . '-' . $month . '-01',
						'payments.payment_date < ' => $next_month,
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
			if ($agent_id && is_array($agent_id))
			{
				$this->db->where_in('agent_id', $agent_id);
				$this->db->group_by('payments.agent_id');
			}
			$result = 0;
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				if ($agent_id && !is_array($agent_id))
					$result = (int)$query->row()->sum_business;
				else
				{
					$result = array();
					foreach ($query->result() as $row)
						$result[$row->n_agent_id] = $row->sum_business;
				}
			}
			$query->free_result();
			return $result;
		} 
		else {
			if ($agent_id && is_array($agent_id))
				$this->db->where_in('agent_id', $agent_id);
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
			$query->free_result();
			return $result;
		}
  }  
  
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

	private function _getOldNegocioPai( $count_requested = TRUE, $agent_id = null, $filter = array())
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
						$next_month = date('Y-m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))) . '-01';
						$sql_date_filter .= "
WHERE `above_5000` >= '$year-$month-01'
AND `above_5000` < '$next_month'";
						$sql_plus .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` < '$next_month'";
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
				$query->free_result();
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
				$query->free_result();
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

	private function _getNegocioPai( $count_requested = TRUE, $agent_id = null, $filter = array())
	{
		$sql_date_filter = '';
		$sql_agent_filter = '';
		$sql_plus = "`valid_for_report` = '1' AND `year_prime` = '1' ";
		$sql_plus2 = ' 1 ';
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
			{
				$sql_plus .= " AND `product_group` = '" . $filter['query']['ramo'] . "'
";
				$sql_plus2 .= " AND `product_group` = '" . $filter['query']['ramo'] . "'
";
			}
			if( isset( $filter['query']['periodo'] ) and !empty( $filter['query']['periodo'] ) )
			{
				$year = date( 'Y' );				
				switch ($filter['query']['periodo'])
				{
					case 1: // month
						$month = date( 'm' );
						$next_month = date('Y-m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))) . '-01';
						$sql_date_filter .= "
WHERE `above_5000` >= '$year-$month-01'
AND `above_5000` < '$next_month'";
						$sql_plus .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` < '$next_month'";
						$sql_plus2 .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` < '$next_month'";
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
							$sql_plus2 .= "
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
						$sql_plus2 .= "
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
						$sql_plus2 .= "
AND `payments`.`payment_date` >= '$year-01-01'
AND `payments`.`payment_date` <= '$to 23:59:59'";
					break;

				}
			}
		}

		$select_plus = '';
		$join_plus = '';
		if (!$count_requested)
		{
			$select_plus = "`policies`.`name` as `asegurado`, ";
			$join_plus = ' LEFT OUTER JOIN `policies` ON `policies`.`uid`= `payments`.`policy_number` ';
		}
		$sql_str = "SELECT *
FROM
(
SELECT `payments`.*,
`policy_negocio_pai`.`negocio_pai`, `policy_negocio_pai`.`id` AS `negocio_pai_id`, " . $select_plus . "
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
WHERE
" . $sql_plus2 . $sql_agent_filter  . "
) `payments`
JOIN `agents` ON `agents`.`id`=`payments`.`agent_id`
JOIN `users` ON `users`.`id`=`agents`.`user_id`
LEFT OUTER JOIN `policy_negocio_pai` ON `policy_negocio_pai`.`policy_number`= `payments`.`policy_number`
" . $join_plus . "
WHERE `payment_acc` >= '5000'
GROUP BY `agent_id`, `policy_number`
)
AS `wrapping_t`
";
		if (!$sql_date_filter)
			$sql_date_filter = " WHERE (above_5000 <= '" . date('Y-m-d') . "') ";
		$sql_str .= " $sql_date_filter $sql_agent_filter ";

		$query = $this->db->query($sql_str);

		if ($query->num_rows() > 0)
		{
			$result = array();
			foreach ($query->result() as $row)
			{
				$this->_create_negocio_pai_rows($row);
				if (isset($row->asegurado) && ($row->asegurado == NULL))
					$row->asegurado = '';
				if ($count_requested)
				{
					if (isset($result[$row->agent_id]))
						$result[$row->agent_id] += $row->negocio_pai;
					else
						$result[$row->agent_id] = $row->negocio_pai;
				}
				else
					$result[] = $row;	
			}
			$query->free_result();

			if (!$count_requested)
			{
				$prima_details = $this->getPrimaDetails( $agent_id, $filter );
				foreach ($result as $pai_key => $pai_value)
				{
					$result[$pai_key]->amount = 0;
					foreach ($prima_details as $prima_detail)
					{
						if ($result[$pai_key]->policy_number == $prima_detail->policy_number)
							$result[$pai_key]->amount += $prima_detail->amount;
					}
				}
			}

			return $result;
		}
		else
		{
			if ($count_requested)
				return 0;
			else
				return array();
		}
	}

	private function _create_negocio_pai_rows(&$row)
	{
		if ($row->negocio_pai === NULL)
		{
			$to_insert = array(
				'ramo' => $row->product_group,
				'policy_number' => $row->policy_number,
				'negocio_pai' => 1,
				'creation_date' => date('Y-m-d H:i:s')
				);
			$this->db->insert('policy_negocio_pai', $to_insert);
			$row->negocio_pai = 1;
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
					$next_month = date('Y-m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))) . '-01';
					$this->db->where( array(
						'payments.payment_date >= ' => $year . '-' . $month . '-01',
						'payments.payment_date < ' => $next_month,
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
		{
			if ($agent_id && is_array($agent_id))
				$this->db->select( 'SUM(amount) AS primas, payments.agent_id as n_agent_id' );
			else
				$this->db->select( 'SUM(amount) AS primas' );
		}			
		else
			$this->db->select( 'payments.*, users.name as first_name, users.lastnames as last_name, users.company_name as company_name' );    
		$this->db->from( 'payments' );
		$this->db->join( 'agents', 'agents.id=payments.agent_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$where = array( 'year_prime' => 1, 'valid_for_report' => 1);
		if ($agent_id && !is_array($agent_id))
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
					$next_month = date('Y-m', mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))) . '-01';
					$this->db->where( array(
						'payment_date >= ' => $year . '-' . $month . '-01',
						'payment_date < ' => $next_month,
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
		if ($agent_id && is_array($agent_id))
			$this->db->where_in('agent_id', $agent_id);		
		if ($sum_requested && $agent_id && is_array($agent_id))
			$this->db->group_by('payments.agent_id');

		$query = $this->db->get();

		if ($sum_requested) {
			if ($query->num_rows() == 0) return 0;

			if ($agent_id && !is_array($agent_id))
			{
				foreach ($query->result() as $row)
					$prima = (float)$row->primas;	
			}
			else
			{
				$prima = array();
				foreach ($query->result() as $row)
					$prima[$row->n_agent_id] = (float)$row->primas;
			}
			$query->free_result();
			return $prima;
		} else {
//			if ($agent_id && is_array($agent_id))
//				$this->db->where_in('agent_id', $agent_id);
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
			$query->free_result();
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
		if( empty( $user_id ) && !is_array($user_id)) return 0;
		
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
		if (!is_array($user_id))
			$this->db->where( 'policies_vs_users.user_id', $user_id );
		else
			$this->db->where_in( 'policies_vs_users.user_id', $user_id );		

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
		if (!is_array($user_id))
		{
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
		}
		else
		{
			foreach ($user_id as $id_of_user)
			{
				$tramite[$id_of_user] = array(
					'work_order_ids' => array(),
					'count' => 0,
					'adjusted_prima' => 0);
			}
			foreach ($query->result() as $row)
			{
				$tramite[$row->user_id]['count']++;
				$tramite[$row->user_id]['adjusted_prima'] += $this->get_adjusted_prima($row->policy_id, $ramo, $period) * ($row->percentage / 100);
				$tramite[$row->user_id]['work_order_ids'][] = $row->work_order_id;
			}
		}
		$query->free_result();
		return $tramite;
	}	

	public function getAceptadas(  $user_id = null, $filter = array() )
	{
		if( empty( $user_id ) && !is_array($user_id)) return 0;
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
		$this->db->select('DISTINCT( policies_vs_users.policy_id ) AS policy_id, policies_vs_users.user_id, policies_vs_users.percentage, work_order.id AS work_order_id' );
		$this->db->from( 'policies' );
		$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=policies.id' );
		$this->db->join( 'work_order', 'work_order.policy_id=policies_vs_users.policy_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id' );
		$this->db->where('work_order.work_order_status_id', '7' );
		$this->db->where("( work_order_types.patent_id =47 OR work_order_types.patent_id=90 )");
		if (!is_array($user_id))
			$this->db->where( 'policies_vs_users.user_id', $user_id );
		else
			$this->db->where_in( 'policies_vs_users.user_id', $user_id );

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
		if (!is_array($user_id))
		{
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
		}
		else
		{
			foreach ($user_id as $id_of_user)
			{
				$aceptadas[$id_of_user] = array(
					'work_order_ids' => array(),
					'count' => 0,
					'adjusted_prima' => 0);
			}
			foreach ($query->result() as $row)
			{
				$aceptadas[$row->user_id]['adjusted_prima'] += $this->get_adjusted_prima($row->policy_id, $ramo, $period) * $row->percentage / 100;
				$aceptadas[$row->user_id]['work_order_ids'][] = $row->work_order_id;
				$aceptadas[$row->user_id]['count']++;
			}
		}
		$query->free_result();
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

	public function get_users_with_role($roles = array())
	{
		$result = array();
		if (empty($roles))
			return $result;
 		$query = $this->db->select('users.*')
			->from(  'users' )
			->join( 'users_vs_user_roles', 'users_vs_user_roles.user_id=users.id' )
			->where_in( 'users_vs_user_roles.user_role_id', $roles )
			->get();
		foreach ($query->result_array() as $row)
			$result[] = $row;
		return $result;
	}

	private function _get_generation_filter($filter, &$with_filter)
	{
			if( isset( $filter['query']['generacion'] ) and !empty( $filter['query']['generacion'] ) )
			{
				switch ($filter['query']['generacion'])
				{
					case 2:
						$with_filter = TRUE;
				//Consolidado: < 3 años  <option value="2">Consolidado</option>
					//Consolidado: <option value="2">Consolidado</option>	
					// Consolidado: Agents with "agents.connection_date" < October 1 of 3 years ago.  <option value="2">Consolidado</option>	
//						$begin = ( date( 'Y' )-3 ).date( '-m-d' );
//						$end = 	date( 'Y-m-d' );
//						$this->db->where( array( 'agents.connection_date <' => $begin, 'agents.connection_date !=' => '0000-00-00' ) ); 	

						$end = 	( date( 'Y' ) - 3 ) . '-10-01';
						$this->db->where(
							"(`agents`.`connection_date` < '$end')
							AND (`agents`.`connection_date` IS NOT NULL )
							AND (`agents`.`connection_date` != '0000-00-00') AND (`agents`.`connection_date` != '')",
							NULL, FALSE);
						$generacion = 'Consolidado';
					break;
					case 3:
						$with_filter = TRUE;
				//Generación 1: Fecha de conexión > 1 año < hoy <option value="3">Generación 1</option>
				//Generación 1: <option value="3">Generación 1</option>
				// Generación 1: Agents with "agents.connection_date" is between October 1 of 3 years ago and September 30 of 2 years ago. 
//						$begin = ( date( 'Y' )-1 ).date( '-m-d' );
//						$end = 	date( 'Y-m-d' );
						$begin = ( date( 'Y' ) - 3 ) . '-10-01';
						$end = 	( date( 'Y' ) - 2 ) . '-09-30';
/*						$this->db->where( array( 'agents.connection_date >=' => $begin, 'agents.connection_date <=' => $end, 'agents.connection_date = ' => "0000-00-00" ) ); 	
						$this->db->or_where( 'COALESCE(agents.connection_date, "") = "" ' ); */
						$this->db->where(
							"(((`agents`.`connection_date` >= '$begin') AND (`agents`.`connection_date` <= '$end'))
							OR (`agents`.`connection_date` IS NULL )
							OR (`agents`.`connection_date` = '0000-00-00') OR (`agents`.`connection_date` = ''))",
							NULL, FALSE);
						$generacion = 'Generación 1';
					break;
					case 4:
						$with_filter = TRUE;
				//Generación 2: fecha de conexión > 1  año y < 2 años <option value="4">Generación 2</option>
				//<option value="4">Generación 2</option>
				//Generación 2: Agents with "agents.connection_date" is between October 1 of 2 years ago and September 30 of 1 year ago. 				
//						$begin = ( date( 'Y' )-2 ).date( '-m-d' );
//						$end = 	( date( 'Y' )-1 ).date( '-m-d' );
						$begin = ( date( 'Y' ) - 2 ) . '-10-01';
						$end = 	( date( 'Y' ) - 1 ) . '-09-30';
						$this->db->where( array( 'agents.connection_date >=' => $begin, 'agents.connection_date <=' => $end ) ); 	
						$generacion = 'Generación 2';
					break;
					case 5:
						$with_filter = TRUE;
				//Generación 3: fecha de conexión > 2 años y < 3 años <option value="5">Generación 3</option>
				//Generación 3: <option value="5">Generación 3</option>
				//Generación 3: Agents with "agents.connection_date" is after October 1 of 1 year.
//						$begin = ( date( 'Y' )-3 ).date( '-m-d' );					
//						$end = 	( date( 'Y' )-2 ).date( '-m-d' );
						$begin = ( date( 'Y' ) - 1 ) .  '-10-01';
//						$this->db->where( array( 'agents.connection_date >=' => $begin, 'agents.connection_date <=' => $end ) ); 
						$this->db->where( array( 'agents.connection_date >=' => $begin )); 
						$generacion = 'Generación 3';
					break;
					default:
					break;
				}
			}

	}

	public function get_filtered_agents($filter)
	{
//		$generacion = '';
		$with_filter = FALSE;
		if( !empty( $filter ) && is_array($filter['query']))
		{
			$this->_get_generation_filter($filter, $with_filter);
			if( isset( $filter['query']['gerente'] ) and !empty( $filter['query']['gerente'] ) )
			{
				$with_filter = TRUE;
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
				{
					$this->db->where( 'users.disabled', 0 );
					$with_filter = TRUE;
				}
				elseif( $filter['query']['agent'] == 3 )
				{
					$this->db->where( 'users.disabled', 1 );
					$with_filter = TRUE;
				}
			}

			if ( isset( $filter['query']['agent_name'] ) and !empty( $filter['query']['agent_name'] ) )
			{
				$this->_get_agent_filter_where($filter['query']['agent_name']);
				if ($this->agent_name_where_in)
				{
					$with_filter = TRUE;
					$this->db->where_in('agents.id', $this->agent_name_where_in);
				}
			}
			
			if ( isset( $filter['query']['policy_num'] ) and !empty( $filter['query']['policy_num'] ) )
			{
				$with_filter = TRUE;
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

		if (!$with_filter)
			return FALSE;

		$result = array();
		$this->db->select( 'users.*, agents.connection_date, agents.id as agent_id' );
		$this->db->from( 'agents' );
		$this->db->join( 'users', 'users.id=agents.user_id' );

		$this->db->order_by('name', 'asc');
		$this->db->order_by('lastnames', 'asc'); 
		$query = $this->db->get();

		foreach ($query->result() as $row)
		{
			$result[$row->agent_id] = array(
				'user_id' => $row->id,
				'agent_id' => $row->agent_id
				);
		}
		$query->free_result();
		return ($result);
	}

	public function get_agent_generation($connection_date = '')
	{
		$generacion = '';
		if ( $connection_date != '0000-00-00' && $connection_date)
		{
			// Consolidado: "agents.connection_date" < October 1 of 3 years ago
			if ( $connection_date < (( date( 'Y' )-3 ) . '-10-01'))
				$generacion = 'Consolidado';	
			//Generación 1:  "agents.connection_date" is between October 1 of 3 years ago and September 30 of 2 years ago
			elseif (( $connection_date >= (( date( 'Y' ) - 3 ) . '-10-01')) &&
				( $connection_date < (( date( 'Y' ) - 2 ) . '-09-30')))
				$generacion = 'Generación 1';
			//Generación 2: "agents.connection_date" is between October 1 of 2 years ago and September 30 of 1 year ago
			elseif (( $connection_date >= (( date( 'Y' ) - 2 ) . '-10-01')) &&
				( $connection_date < (( date( 'Y' ) - 1 ) . '-09-30')))
				$generacion = 'Generación 2';
			//Generación 3: "agents.connection_date" is after October 1 of 1 year
			elseif ($connection_date >= (( date( 'Y' ) - 1 ) . '-10-01')) 
				$generacion = 'Generación 3';
		}
		else
		{
			$generacion = 'Generación 1';
		}
		return $generacion;
	}
}
?>