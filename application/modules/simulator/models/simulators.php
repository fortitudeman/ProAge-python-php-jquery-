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
class Simulators extends CI_Model{
	
	private $data = array();
	
	private $insertId;
	
		
	public function __construct(){
		
        parent::__construct();
			
    }
	

/*
 *	CRUD Functions, dynamic table.
 **/


// Add
	public function create( $table = '', $values = array() ){
        
		
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

    public function update( $table = '', $id = 0, $values = array() ){
        
		if( empty( $table ) or empty( $values ) or empty( $id ) ) return false;
					
				
        if( $this->db->update( $table, $values, array( 'id' => $id ) ) )
			
			return true;
        
		else
        	
			return false;
        
		
    }

/**
 |	Remove 
 **/ 	
	 public function delete( $table = '', $field = 'id', $value = null ){
        
		if( empty( $table ) or empty( $field )  or empty( $value ) ) return false;
					   
			if( $this->db->delete( $table, array( $field => $value ) ) )
			
					return true;
			
			else
			
				return false;
			
			
				
    }





// Return insert id
	public function insert_id(){   return $this->insertId;  }
	
	
	


// Getting by Agent
	public function getByAgent( $agent = null ){
		
		if( empty( $agent ) ) return false;
		
		//SELECT * FROM simulator WHERE agent_id = '' ORDER BY id DESC LIMIT 1;
		$this->db->select();
		$this->db->from( 'simulator' );
		$this->db->where( 'agent_id', $agent );
		$this->db->order_by( 'id', 'desc' );
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$data = array();
		
		// Getting data
		foreach ($query->result() as $row)
			
			$data[]  = array(
			
				'id' => $row->id,
				'data' => json_decode( $row->data )
				
			);
			
				
		return $data;
		
	}	
	
	
	
	
// Getting config
	public function getConfig(){
				
		//SELECT * FROM simulator_default_estacionalidad ORDER BY id DESC;
		$this->db->select();
		$this->db->from( 'simulator_default_estacionalidad' );
		$this->db->order_by( 'id', 'asc' );
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$data = array();
		
		// Getting data
		foreach ($query->result() as $row)
			
			$data[]  = array(
			
				'id' => $row->id,
				'month' => $row->month,
				'vida' => $row->vida,
				'gmm' => $row->gmm,
				'autos' => $row->autos
				
				
			);
			
				
		return $data;
		
	}		
	
	
	/*Solicitudes logradas*/
	public function getSolicitudLograda( $agent = null, $product_group_id = null, $month = null, $year = null ){
		
		if( empty( $agent ) or empty( $product_group_id ) or empty( $month ) or empty( $year ) ) return 0;		
		/*
		SELECT COUNT(id) AS count 
		FROM `agents_activity` 
		WHERE  YEAR(end) = 2013 
		AND MONTH(end) = 09 
		AND `agent_id` =1
		*/
				
		$this->db->select( 'COUNT(id) AS count ' );
		$this->db->from( 'agents_activity' );
		$this->db->where( 'YEAR(end) = '. $year );
		$this->db->where( 'MONTH(end) = '. $month );
		$this->db->where( 'agent_id', $agent );
				
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$data = array();
		
		$count = 0;
		
		// Getting data
		foreach ($query->result() as $row)
			
			$count = $row->count;
									
				
		return $count;
		
	}		
	
	
	
	/* Negocios logrados */
	public function getNegociosLograda( $user = null, $product_group_id = null, $month = null, $year = null ){
		
		if( empty( $user ) or empty( $product_group_id ) or empty( $month ) or empty( $year ) ) return 0;		
		/*
		SELECT  COUNT(id) AS count  
		FROM `work_order` 
		WHERE  YEAR(creation_date) = 2013 
		AND MONTH(creation_date) = 09 
		AND `user` =1
		AND work_order_status_id=7
		AND product_group_id=1;
		*/
				
		$this->db->select( 'COUNT(id) AS count ' );
		$this->db->from( 'work_order' );
		$this->db->where( 'YEAR(creation_date) = '. $year );
		$this->db->where( 'MONTH(creation_date) = '. $month );
		$this->db->where( 'user', $user );
		$this->db->where( 'work_order_status_id', 7 );
		$this->db->where( 'product_group_id', $product_group_id );
		
				
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$data = array();
		
		$count = 0;
		
		// Getting data
		foreach ($query->result() as $row)
			
			$count = $row->count;
									
				
		return $count;
		
	}	
	
	
	
	
	/*Primas logradas*/
	public function getPrimasLograda( $user = null, $product_group_id = null, $month = null, $year = null ){
		
		if( empty( $user ) or empty( $product_group_id ) or empty( $month ) or empty( $year ) ) return 0;		
		/*
		SELECT DISTINCT(policy_id) 
		FROM `work_order` 
		WHERE  YEAR(creation_date) = 2013 
		AND MONTH(creation_date) = 09 
		AND `user` =1
		AND work_order_status_id=7
		AND product_group_id=1;
		*/
				
		$this->db->select( 'policy_id' );
		$this->db->from( 'work_order' );
		$this->db->where( 'YEAR(creation_date) = '. $year );
		$this->db->where( 'MONTH(creation_date) = '. $month );
		$this->db->where( 'user', $user );
		$this->db->where( 'work_order_status_id', 7 );
		$this->db->where( 'product_group_id', $product_group_id );
		
				
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return 0;
		
		$data = array();
		
		$prima = 0;
		
		// Getting data
		foreach ($query->result() as $row){
		
			
			/*
			SELECT prima
			FROM `policies` 
			WHERE `id` =policy_id
			*/
			$this->db->select( 'prima' );
			$this->db->from( 'policies' );
			$this->db->where( 'id', $row->policy_id );
			
			$queryprima = $this->db->get();
			
			if ($queryprima->num_rows() == 0) return 0;
			
			foreach ($queryprima->result() as $rowprima)
				
				$prima = (float)$rowprima->prima;
			
			
		
		
		}
				
		return $prima;		
	}	
	
	
	
	
}
?>