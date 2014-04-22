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
// Read a row
    public function getForUpdateOrDelete( $table = 'agents_activity', $id = 0, $agent_id = 0 ){

		if	( empty( $table ) or empty( $agent_id ) or empty( $id ) )
			return false;

		$where = array( 'id' => (int) $id );
		if ($agent_id)
			$where['agent_id'] = (int) $agent_id;
		$this->db->where( $where );
	
		$query = $this->db->get($table);
		if ($query->num_rows() == 0)
			return false;

		return $query->row();
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
				 'activity_id' => $row->id,			
				 'begin' => $row->begin,
				 'end' => $row->end,
				 'cita' => $row->cita,
				 'prospectus' => $row->prospectus,
				 'vida_requests' => $row->vida_requests,
				 'vida_businesses' => $row->vida_businesses,
				 'gmm_requests' => $row->gmm_requests,
				 'gmm_businesses' => $row->gmm_businesses,
				 'autos_businesses' => $row->autos_businesses,
				 'interview' => $row->interview,
				 'comments' => $row->comments,
				 'last_updated' => $row->last_updated,
				 'date' => $row->date       			
			);
			
		}
		
		return $data;
		
   }

	public function getByAgentId( $agent_id = null ){
		
		if( empty( $agent_id ) ) return false;
		/*
		 SELECT SUM( cita ) AS cita, SUM( prospectus ) AS prospectus, SUM( interview ) AS interview
		 FROM `agents_activity` 
		 WHERE agent_id=27
		 ORDER BY id DESC		
		*/ 
		$this->db->select( 'SUM( cita ) AS cita, SUM( prospectus ) AS prospectus, SUM( interview ) AS interview' );
		$this->db->from( 'agents_activity' );
		$this->db->where( 'agent_id', $agent_id );
		$this->db->order_by( 'id', 'desc' );
		
		$query = $this->db->get();	
		
		if ($query->num_rows() == 0) return false;
 	
		$data = array();
													
		foreach ($query->result() as $row) {
			
			$data[] = array(
				 'cita' => $row->cita,
				 'prospectus' => $row->prospectus,
				 'interview' => $row->interview,
			);
			
		}
		
		return $data;
		
	}


// Count records for pagination
	public function record_count( $agent_id = null, $filter = null ) {
		
		if( empty( $agent_id ) ) return false;
	    		
		return $this->db->from( 'agents_activity' )->where( 'agent_id',$agent_id )->count_all_results();
    }


//View Activities report
	public function report( $table = 'agents_activity', $values = array() ){
        
		$data = array();
		
		if( empty( $table ) or empty( $values ) ) return false;
		if ($values['periodo'] == 2)	// if Week is selected
		{
			$this->db->select();
		}
		else // Month, Year or Custom
//		if (TRUE)
		{
			$fields_selected = '`agents_activity`.`agent_id` ,
`agents_activity`.`begin`,
`agents_activity`.`end`,
"" AS `comments`,
`agents_activity`.`last_updated`,
`agents_activity`.`date`,
SUM( `agents_activity`.`cita` ) AS `cita` , 
SUM( `agents_activity`.`prospectus` )  AS `prospectus`, 
SUM( `agents_activity`.`interview` )  AS `interview`, 
SUM( `agents_activity`.`vida_requests` )  AS `vida_requests`, 
SUM( `agents_activity`.`vida_businesses` )  AS `vida_businesses`, 
SUM( `agents_activity`.`gmm_requests` )  AS `gmm_requests`, 
SUM( `agents_activity`.`gmm_businesses` )  AS `gmm_businesses`,
SUM( `agents_activity`.`autos_businesses` )  AS `autos_businesses`,
`users`.`name` ,
`users`.`lastnames`';
			$this->db->select($fields_selected, FALSE);
			$this->db->group_by('agent_id');
		}
		$this->db->from( 'agents_activity' );
		$this->db->join( 'agents', 'agents_activity.agent_id=agents.id');
		$this->db->join( 'users', 'agents.user_id=users.id');
//		$this->db->where( 'begin', $values['begin'] );
//		$this->db->where( 'end', $values['end'] );
		$this->db->where( array(
			'begin >= ' => $values['begin'],
			'end <= ' => $values['end']) );
		$this->db->order_by( 'interview', 'desc' );
		$query = $this->db->get();		

		if ($query->num_rows() == 0) return false;
 	
		$data = array(
			'totals' => array(
				'cita' => 0, 'prospectus' => 0, 'interview' => 0,
				'vida_requests' => 0, 'vida_businesses' => 0, 'gmm_requests' => 0,
				'gmm_businesses' => 0, 'autos_businesses' => 0),
			'rows' => array()
		);
													
		foreach ($query->result() as $row) {
			foreach ($data['totals'] as $key => $value)
				$data['totals'][$key] += $row->$key;
			$data['rows'][] = array(
				 'name' => $row->name,
				 'lastnames' => $row->lastnames,
				 'begin' => $row->begin,
				 'end' => $row->end,
				 'cita' => $row->cita,
				 'prospectus' => $row->prospectus,
				 'vida_requests' => $row->vida_requests,
				 'vida_businesses' => $row->vida_businesses,
				 'gmm_requests' => $row->gmm_requests,
				 'gmm_businesses' => $row->gmm_businesses,
				 'autos_businesses' => $row->autos_businesses,
				 'interview' => $row->interview,
				 'comments' => $row->comments,
				 'last_updated' => $row->last_updated,
				 'date' => $row->date       			
			);
			
		}

		return $data;
			
    }
}
?>