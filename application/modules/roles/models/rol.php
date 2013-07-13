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