<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class group extends CI_Model {

	private $data = array();
	private $table = 'user_groups';
	
	public function __construct(){
        parent::__construct();	
    }

    /**
 	 |	Create
	 **/ 
	public function create($values = array()){
		if( empty( $values ) ) return false;
		if( $this->db->insert( $this->table, $values ) )
			
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
	public function all($limit = 30, $start = 0, $filter = "" ) {
		$this->db->select("g.*");
		$this->db->select("concat(u.name, ' ', u.lastnames) owner_name", FALSE);
		$this->db->select("(select count(*) from user_groups_vs_agents where user_group_id=g.id) agents", FALSE);
        if($filter != "")
        	$this->db->like('description', "%$filter%");
        $this->db->limit($limit, $start );
        $this->db->join('users u', 'g.group_owner = u.id');
        $query = $this->db->get($this->table." g");
		
		if ($query->num_rows() == 0) return false;
		
		unset( $this->data );
		$this->data = $query->result_array();
		
		return $this->data;	
   	}

	// Count records for pagination
	public function record_count($filter = "") {
		if($filter != "")
        	$this->db->like('description', "%$filter%");
        return $this->db->count_all( $this->table );
    }

	/**
	 |	Getting for id
 	 **/ 
	
	public function id( $id = null ){
		
		if( empty( $id ) ) return false;
				
		unset( $this->data );	
		$this->data = array();
		
		// Validation form not repear name
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
				
		if( $query->num_rows == 0 ) return false;
		
		$this->data = $query->row_array();
		$this->db->flush_cache();

		$this->db->select('uga.*, u.username');
		$this->db->select("CONCAT(u.name, ' ', u.lastnames)", FALSE);
		$this->db->where('user_group_id', $id);
		$this->db->join('agents a', 'a.id = uga.agent_id');
		$this->db->join('users u', 'u.id = a.user_id');
		$query = $this->db->get("user_groups_vs_agents uga");

		$this->data["agents"] = $query->result_array();
		return $this->data;
	}

}

/* End of file groups.php */
/* Location: ./application/modules/groups/models/groups.php */