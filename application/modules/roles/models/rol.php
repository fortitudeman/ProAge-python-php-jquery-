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
class Rol extends CI_Model{
	
	private $data = array();
	
	private $table = 'user_roles';
	
	
	
	public function __construct(){
		
        parent::__construct();
			
    }
	


// Add role method	
	public function create( $values = array() ){
        
		
		if( empty( $values ) ) return false;
			
		
		// Validation form not repear name
		$this->db->
					select()
				  ->
				   from( $this->table )	
				  ->
				   where( array( 'name' => $values['name'] ) );
		
		$query = $this->db->get();
		
		if( $query->num_rows > 0 ) return false;
		
				
		
		// Set timestamp unix
		$timestamp = strtotime( date( 'd-m-Y H:i:s' ) );
		
		// Set timestamp unix
		$values['last_updated'] = $timestamp;
		$values['date'] = $timestamp;
		
			
		if( $this->db->insert( $this->table, $values ) )
			
			return true;
		else
		
			return false;
       
    }
	
	
	
	

/**
 |	Update
 **/ 

    public function update( $id = 0, $values = array() ){
        
		if( empty( $values ) or empty( $id ) ) return false;
			
		unset( $this->data ); $this->data = array();
		
				
		// Validation form not repear name
		$this->db->
					select()
				  ->
				   from( $this->table )	
				  ->
				   where( array( 'name' => $values['name'] ) )
				  ->
				   limit( 1 ) ;
		
		$query = $this->db->get();
		
		if( $query->num_rows > 0 ){
				
			foreach ($query->result() as $row)
				
				if( $id !=  $row->id ) return false;
				
		}
			
		// Set timestamp unix
		$timestamp = strtotime( date( 'd-m-Y H:i:s' ) );
		
		$values['last_updated'] = $timestamp;
					
		
		
        if( $this->db->update( $this->table , $values, array( 'id' => $id ) ) )
			
			return true;
        
		else
        	
			return false;
        
		
    }

/**
 |	Remove 
 **/ 	
	 public function delete( $id ){
        
		if( empty( $id ) ) return false;
					   
			if( $this->db->delete( $this->table, array('id' => $id ) ) )
			
					return true;
			
			else
			
				return false;
			
			
				
    }

















/**
 |	Getting All
 **/ 
	
	public function all( $start = 0 ) {
		
        $this->db->limit( 20, $start );

        $query = $this->db->get( $this->table );

		
		
		if ($query->num_rows() == 0) return false;
 	
		
		
		unset( $this->data );

		$this->data = array();
		
		
		
		foreach ($query->result() as $row) {

			$this->data[] = array( 
		    	'id' => $row->id,
		    	'name' => $row->name,
				'label' => $row->label,
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







/** 
 *	This secttions setting roles and access for an user
 **/

// Getting user_roles
	public function user_role( $user = null ){
		
		if( empty( $user ) ) return false; 
			
			
			$this->db->where( array( 'user_id' => $user ) );
	
			$query = $this->db->get( 'users_vs_user_roles' );
	
						
			if ($query->num_rows() == 0) return false;
		
			
			
			unset( $this->data );
	
			$this->data = array();
			
			
			
			foreach ($query->result() as $row) {
	
				$this->data[] = array( 
					'user_role_id' => $row->user_role_id
				);
	
			}

		return $this->data;
		
		
	}


// Getting access for the rol
	public function user_roles_vs_access( $roles = array() ){
		
		if( empty( $roles ) ) return false; 
			
		$rol = array();
		
		
		
		// Added user_role_id
		foreach( $roles as $value )
			array_push($rol,$value['user_role_id']);//$rol[$value];
							
		
		// Runin Example  query
		/*
			
			SELECT * FROM `user_roles_vs_access` WHERE user_role_id=5 OR user_role_id=4;
			
			
			SELECT `user_roles_vs_access` .*, modules.name, actions.name 
			FROM `user_roles_vs_access` 
			JOIN modules ON `user_roles_vs_access`.module_id=modules.id
			JOIN actions ON `user_roles_vs_access`.action_id=actions.id
			WHERE `user_roles_vs_access` .user_role_id IN (5, 4)
		*/
		
		$this->db->select( 'user_roles_vs_access.*, modules.name as module_name, actions.name as action_name' );	
		$this->db->from( 'user_roles_vs_access' );
		$this->db->join( 'modules', 'user_roles_vs_access.module_id=modules.id' );
		$this->db->join( 'actions', 'user_roles_vs_access.action_id=actions.id' );						
		$this->db->where_in('user_role_id', $rol);
		
		$query = $this->db->get();

					
					
					
					
		if ($query->num_rows() == 0) return false;
	
		
		
		unset( $this->data, $roles, $rol ); // Free memory

		$this->data = array();
		
		
		
		foreach ($query->result() as $row)

			$this->data[] = array( 
				'module_name' => $row->module_name,
				'action_name' => $row->action_name,
				'module_id' => $row->module_id,
				'action_id' => $row->action_id
			);

		

		
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
				  'name' => $row->name,
				  'label' => $row->label
				  
			);
				
		return $this->data[0];
		
	}
	
	
	
	
	
// Getting rol id by name
	public function name( $name = null ){
		
		if( empty( $name ) ) return false;
				
		unset( $this->data );	$this->data = array();
		
		// Validation form not repear name
		$this->db->
					select( 'id' )
				  ->
				   from( $this->table )	
				  ->
				   where( array( 'name' => $name ) )
				  ->
				  	limit(1); 
				  
		$query = $this->db->get();
				
		if( $query->num_rows == 0 ) return false;
		
		foreach ($query->result() as $row)
		
			$this->data[] = array( 
				  
				  'id' => $row->id
				  
			);
				
		return $this->data[0]['id'];
		
	}	
	
	
	
	
	
	
//  Getting Checkbox	
	public function checkbox() {
	
	
	    $query = $this->db->get( $this->table );
				
		if ($query->num_rows() == 0) return '';
 	
		$checkbox = '';
		
		
		foreach ($query->result() as $row)

			$checkbox .= '<input type="checkbox" class="required roles" name="group[]" value="'.$row->id.'"> '.  $row->name.'<br>';
		

		return $checkbox;
		
   }
   

// Getting Selects    
	public function options() {
	
	
	    $query = $this->db->get( $this->table );
				
		if ($query->num_rows() == 0) return '';
 				
		$options = '';
		
		
		foreach ($query->result() as $row)

			$options .= '<option value="'.$row->id.'"> '.  $row->name .'</option>';
		

		return $options;
		
   }

}
?>