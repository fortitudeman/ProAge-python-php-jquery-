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
class Activity extends CI_Model{
	
	private $data = array();
	
	private $insertId;
	
		
	public function __construct(){
		
        parent::__construct();
			
    }
	

/*
 *	CRUD Functions, dynamic table.
 **/


// Add
	public function create( $table = 'agents_activity', $values = array() ){
        
		
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

    public function update( $table = 'agents_activity', $id = 0, $values = array() ){
        
		if( empty( $table ) or empty( $values ) or empty( $id ) ) return false;
					
				
        if( $this->db->update( $table, $values, array( 'id' => $id ) ) )
			
			return true;
        
		else
        	
			return false;
        
		
    }

/**
 |	Remove 
 **/ 	
	 public function delete( $table = 'agents_activity', $field = 'id', $value = null ){
        
		if( empty( $table ) or empty( $field )  or empty( $value ) ) return false;
					   
			if( $this->db->delete( $table, array( $field => $value ) ) )
			
					return true;
			
			else
			
				return false;
			
			
				
    }





// Return insert id
	public function insert_id(){   return $this->insertId;  }


	public function exist( $table = 'agents_activity', $values = array() ){
        
		
		if( empty( $table ) or empty( $values ) ) return false;
		
		$this->db->select();
		$this->db->from( 'agents_activity' );
		$this->db->where( 'agent_id', $values['agent_id'] );
		$this->db->where( 'begin', $values['begin'] );
		$this->db->where( 'end', $values['end'] );
        $this->db->limit( 1 );
				
		$query = $this->db->get();	
		
		if($query->num_rows() == 0) 
			
			return true;
		
		else
			
			return false;	
		
			
    }

/**
 |	Getting for overview
 **/ 
	
	public function overview( $start = 0, $agent_id = null, $filter = null ) {
		
		if( empty( $agent_id ) ) return false;
		/*
		 SELECT *
		 FROM `agents_activity` 
		 ORDER BY id DESC		
		*/
		$this->db->select();
		$this->db->from( 'agents_activity' );
		$this->db->where( 'agent_id', $agent_id );
		$this->db->order_by( 'id', 'desc' );
        $this->db->limit( 50, $start );
		
		$query = $this->db->get();	
		
		if ($query->num_rows() == 0) return false;
 	
		$data = array();
													
		foreach ($query->result() as $row) {
			
			$data[] = array(
				 'begin' => $row->begin,
				 'end' => $row->end,
				 'cita' => $row->cita,
				 'prospectus' => $row->prospectus,
				 'interview' => $row->interview,
				 'comments' => $row->comments,
				 'last_updated' => $row->last_updated,
				 'date' => $row->date       			
			);
			
		}
		
		return $data;
		
   }

	


// Count records for pagination
	public function record_count( $agent_id = null, $filter = null ) {
		
		if( empty( $agent_id ) ) return false;
	    		
		return $this->db->from( 'agents_activity' )->where( 'agent_id',$agent_id )->count_all_results();
    }
}
?>