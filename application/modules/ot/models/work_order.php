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
class Work_order extends CI_Model{
	
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
		
			
		if( $this->db->insert( $table, $values ) ){
			
			$this->insertId = $this->db->insert_id();
			
			return true;
		
		}else
		
			return false;
       
    }
	
	public function replace( $table = '', $values = array() ){
        
		
		if( empty( $table ) or empty( $values ) ) return false;
		
			
		if( $this->db->replace( $table, $values ) ){
			
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
	 public function delete( $table = '', $id ){
        
		if( empty( $table ) or empty( $id ) ) return false;
					   
			if( $this->db->delete( $table, array('id' => $id ) ) )
			
					return true;
			
			else
			
				return false;
			
			
				
    }





// Return insert id
	public function insert_id(){   return $this->insertId;  }










/**
 |	Getting for overview
 **/ 
	
/*	public function overview( $user = null, $start = 0, $limit = null ) {
		
		/*
			
			SELECT product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*
			FROM `work_order`
			JOIN product_group ON product_group.id=work_order.product_group_id
			JOIN work_order_types ON work_order_types.id=work_order.work_order_type_id 
			JOIN work_order_status ON work_order_status.id=work_order.work_order_status_id;
			
		*/
/*		
		$this->db->select( 'product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*' );
		$this->db->from( 'work_order' );
		$this->db->join( 'product_group', 'product_group.id=work_order.product_group_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id ' );
		$this->db->join( 'work_order_status', 'work_order_status.id=work_order.work_order_status_id' );
		$this->db->where( 'work_order.work_order_status_id', 9 );
		$this->db->or_where( 'work_order.work_order_status_id', 5  );
		$this->db->or_where( 'work_order.work_order_status_id', 6  );
		$this->db->or_where( 'work_order.work_order_status_id', 7  );
		
		
		if( !empty( $user ) )
			$this->db->where( 'work_order.user', $user );
		
		if ( $start && !empty( $limit ) )
			$this->db->limit( $limit, $start );
		$query = $this->db->get();
		
		
		if ($query->num_rows() == 0) return false;

		$ot = array();
		
		foreach ($query->result() as $row) {
			
			$type_tramite = $this->getParentsWorkTipes( $row->work_order_type_id );

			$ot[] = array( 
		    	'id' => $row->id,
				'uid' => $row->uid,
				'policy' => $this->getPolicyBuId( $row->policy_id ),
				'agents' => $this->getAgentsByPolicy( $row->policy_id ),
		    	'product_group_id' => $row->product_group_id,
				'group_name' => $row->group_name,
				'parent_type_name' => $this->getTypeTramiteId( $type_tramite ),
				'type_name' => $row->type_name,
		    	'work_order_status_id' => $row->work_order_status_id,
				'status_name' =>  $row->status_name,
				'creation_date' =>  $row->creation_date,
				'duration' =>  $row->duration,				
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
			
		return $ot;
		
		
   }
*/
	


// Count records for pagination
	public function record_count( $user = null ) {

		$this->db->where_in('work_order_status_id', array('9', '5', '6', '7'));
		if( !empty( $user ) )
			$this->db->where('work_order.user', $user);
		return $this->db->from( 'work_order' )->count_all_results();
	}

	
	
	
// Notifications
	public function getNotification( $id = null ){
						
		/*
			
			SELECT product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*
			FROM `work_order`
			JOIN product_group ON product_group.id=work_order.product_group_id
			JOIN work_order_types ON work_order_types.id=work_order.work_order_type_id 
			JOIN work_order_status ON work_order_status.id=work_order.work_order_status_id;
			
		*/
		
		$this->db->select( 'product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*' );
		$this->db->from( 'work_order' );
		$this->db->join( 'product_group', 'product_group.id=work_order.product_group_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id ' );
		$this->db->join( 'work_order_status', 'work_order_status.id=work_order.work_order_status_id' );
		
		if( !empty(  $id ) )				
			$this->db->where( 'work_order.id', $id );
		
		$this->db->order_by( 'work_order.id', 'desc' );
		
		
						
		$this->db->limit( 1 );
		
		$query = $this->db->get();
		
		
		if ($query->num_rows() == 0) return false;
		
		$ot = array();
		
		foreach ($query->result() as $row) {
			
			$type_tramite = $this->getParentsWorkTipes( $row->work_order_type_id );

			$ot[] = array( 
		    	'id' => $row->id,
				'uid' => $row->uid,
				'work_order_status_id' => $row->work_order_status_id,
				'work_order_responsible_id' => $row->work_order_responsible_id,
				'work_order_reason_id' => $row->work_order_reason_id,
				'policy' => $this->getPolicyBuId( $row->policy_id ),
				'agents' => $this->getAgentsByPolicy( $row->policy_id ),
		    	'product_group_id' => $row->product_group_id,
				'group_name' => $row->group_name,
				'parent_type_name' => $this->getTypeTramiteId( $type_tramite ),
				'type_name' => $row->type_name,
		    	'status_name' =>  $row->status_name,
				'creation_date' =>  $row->creation_date,
				'duration' =>  $row->duration,			
				'comments' => $row->comments,	
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
				
		return $ot;
		
	}	
	
	
	public function getResponsiblesById( $id = null ){
		
		if( empty( $id ) ) return false;
		
		$this->db->where( 'id', $id );
		
		$query = $this->db->get( 'work_order_responsibles' );
		
		if ($query->num_rows() == 0) return false;
		
		
		$responsibles = array();
		
		foreach ($query->result() as $row) {
			
			$responsibles[] = array( 
		    	'id' => $row->id,
				'name' => $row->name,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
				
		return $responsibles;
	}
	
	public function getReasonById( $id = null ){
		
		if( empty( $id ) ) return false;
		
		$this->db->where( 'id', $id );
		
		$query = $this->db->get( 'work_order_reason' );
		
		if ($query->num_rows() == 0) return false;
		
		
		$reason = array();
		
		foreach ($query->result() as $row) {
			
			$reason[] = array( 
		    	'id' => $row->id,
				'name' => $row->name,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
				
		return $reason;
	}
	
	
	
	
	
	
	
	
/**
 *	Getting for update
 **/
	public function getById( $ot = null ){
		
		if( empty( $ot ) )return false;
		
		
		$this->db->where( 'id', $ot );
		$this->db->limit( 1 );
		
		$query  = $this->db->get( 'work_order' );
		
		
		if ($query->num_rows() == 0) return false;
		
		$ot = array();
		
		foreach ($query->result() as $row) {

			$ot[] = array( 
		    	'id' => $row->id,
				'product_group_id' => $row->product_group_id,
				'policy_id' => $row->policy_id ,
				'subtype' => $row->work_order_type_id,
				'type' => $this->getParentsWorkTipes( $row->work_order_type_id ),
		    	'uid' => $row->uid,
				'creation_date' => date( 'Y-m-d', strtotime($row->creation_date) ),
				'comments' => $row->comments
		    );

		}
				
		return $ot;
		
		
	}
	
	
	public function getParentsWorkTipes( $type = null ){
		
		if( empty( $type ) )return false;
		
		//SELECT patent_id FROM `work_order_types` WHERE id=61;
		$this->db->select( 'patent_id' );
		$this->db->where( 'id', $type );
		$this->db->limit( 1 );
		
		$query  = $this->db->get( 'work_order_types' );
		
		
		if ($query->num_rows() == 0) return false;
		
		$type = array();
		
		foreach ($query->result() as $row) {

			$type[] = array( 
		    	'type' => $row->patent_id
		    );

		}
						
		return $type[0]['type'];
		
	}
	
	
	
	
// Getting for filters	
	public function find( $access_all = false ) {

		$agentes_gerentes = array();
		// Gerentes (prepare the agents who have selected gerente)
		if  ( ( ( $gerente = $this->input->post('gerente') ) !== FALSE ) &&
			strlen($gerente) ){
			$this->db->select( 'agents.id' );
			$this->db->from( 'agents' );
			$this->db->join('users', 'users.id = agents.user_id');			
			$this->db->join( 'users_vs_user_roles', 'users_vs_user_roles.user_id=users.id '  );
			$this->db->where( 'manager_id', (int) $gerente );
			$this->db->where( 'users_vs_user_roles.user_role_id', 1 );
			$query = $this->db->get();
			foreach ($query->result() as $row)
				$agentes_gerentes[] = $row->id;
		}

		// Prepare work order type for filter on patent id (this should be validated against ramo filter field)
		$patent_work_order_types = array();
		if  ( ( ( $patent_type = $this->input->post('patent_type') ) !== FALSE ) &&
			strlen($patent_type) ){
			$this->db->select( 'work_order_types.id' );
			$this->db->from( 'work_order_types' );
			$this->db->where( 'patent_id', (int)$patent_type );
			$query = $this->db->get();
			foreach ($query->result() as $row)
				$patent_work_order_types[] = $row->id;
		}

		$this->db->select( 'product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*' );
		$this->db->from( 'work_order' );
		$this->db->join( 'product_group', 'product_group.id=work_order.product_group_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id ' );
		$this->db->join( 'work_order_status', 'work_order_status.id=work_order.work_order_status_id' );

		switch ($this->input->post('work_order_status_id'))
		{
			case 'activadas':
				$this->db->where( 'work_order.work_order_status_id', 6 );
				break;
			case 'canceladas':
				$this->db->where( 'work_order.work_order_status_id', 2 );
				break;
			case 'tramite':
				$this->db->where_in('work_order.work_order_status_id', array('5', '9'));
				break;
			case 'terminada':
				$this->db->where_in('work_order.work_order_status_id', array('7', '6'));
				break;
			case 'NTU':
				$this->db->where( 'work_order.work_order_status_id', 10 );
				break;
			default:
				break;
		}

		if ( !$access_all || ( $this->input->post('user') == 'mios' ) )
			$this->db->where( array( 'work_order.user' => $this->sessions['id'] ) );

		// OT id
		if ( ( ( $id = $this->input->post('id') ) !== FALSE ) &&
			strlen($id) )
			$this->db->where( array( 'work_order.uid' => trim( $id )) );

		// Ramo
		if ( ( ( $ramo = $this->input->post('ramo') ) !== FALSE ) &&
			( ( $ramo == 1 ) || (  $ramo == 2 ) || ( $ramo == 3 ) ) )
			$this->db->where( array( 'work_order.product_group_id' => $ramo ) );

		// Complete handling filter on patent id (tipo  de tramite)
		if ( count($patent_work_order_types) ) {
			$this->db->where_in('work_order.work_order_type_id', $patent_work_order_types);
		}

		// Periodo
		if ( ( ( $periodo = $this->input->post('periodo') ) !== FALSE ) && 
			( ( $periodo == 1 ) || (  $periodo == 2 ) || ( $periodo == 3 ) || ( $periodo == 4) ) )
		{
			if( $periodo == 1 ) // Month
				$this->db->where( 'work_order.creation_date >= ', date( 'Y' ) . '-' . (date( 'm' )) . '-01'); 
			if( $periodo == 2 ) // Trimester or cuatrimester depending ramo
			{
				$this->load->helper('tri_cuatrimester');
				if( ($ramo == 2 ) || ( $ramo == 3 ) )
					$begin_end = get_tri_cuatrimester( cuatrimestre(), 'cuatrimestre' ) ;
				else
					$begin_end = get_tri_cuatrimester( trimestre(), 'trimestre' );

				if (isset($begin_end) && isset($begin_end['begind']) && isset($begin_end['end']))
					$this->db->where( array(
						'work_order.creation_date >= ' => $begin_end['begind'],
						'work_order.creation_date <=' =>  $begin_end['end']) );
			}
			if(  $periodo == 3 ) // Year
				$this->db->where( array(
					'work_order.creation_date >= ' => date( 'Y' ) .'-01-01', 
					'work_order.creation_date <=' => date( 'Y-m-d' ) . ' 23:59:59') );

			if( $periodo == 4 ) // Custom
			{
				$from = $this->custom_period_from;
				$to = $this->custom_period_to;
				if ( ( $from === FALSE ) || ( $to === FALSE ) )
				{
					$from = date('Y-m-d');
					$to = $from;
				}
				$this->db->where( array(
					'work_order.creation_date >= ' => $from . ' 00:00:00',
					'work_order.creation_date <=' => $to . ' 23:59:59') );
			}
		}	

		// Agent
		if  ( ( ( $agent = $this->input->post('agent') ) !== FALSE ) &&
			strlen($agent) ){
			/**
			 JOIN policies_vs_users ON policies_vs_users.policy_id=work_order.policy_id
			 WHERE policies_vs_users.user_id=1
			*/		
			$this->db->join( 'policies_vs_users AS policies_users_A', 'policies_users_A.policy_id=work_order.policy_id' );
			$this->db->where( 'policies_users_A.user_id', (int) $agent );

		}
		// Complete Gerente filtering
		if ( count($agentes_gerentes) ) {
			$this->db->join( 'policies_vs_users AS policies_users_B', 'policies_users_B.policy_id=work_order.policy_id' );
			$this->db->where_in( 'policies_users_B.user_id', $agentes_gerentes );		
		}

		$query = $this->db->get();
		if ($query->num_rows() == 0) return false;

		$ot = array();
		foreach ($query->result() as $row)
		{
			$type_tramite = $this->getParentsWorkTipes( $row->work_order_type_id );
			$ot[] = array( 
		    	'id' => $row->id,
				'uid' => $row->uid,
				'policy' => $this->getPolicyBuId( $row->policy_id ),
				'agents' => $this->getAgentsByPolicy( $row->policy_id ),
		    	'product_group_id' => $row->product_group_id,
				'group_name' => $row->group_name,
				'parent_type_name' => $this->getTypeTramiteId( $type_tramite ),
				'type_name' => $row->type_name,
				'work_order_status_id' => $row->work_order_status_id,				
		    	'status_name' =>  $row->status_name,
				'creation_date' =>  $row->creation_date,
				'duration' =>  $row->duration,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date,
				'is_editable' => $this->is_editable( $row->product_group_id, $type_tramite, $row->work_order_status_id )
		    );
		}
		return $ot;
   }
	
	
	
   public function getWorkOrderById( $id = null ){
   		
		if( empty( $id ) ) return false;
				
		
		
		$this->db->select( 'product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*' );
		$this->db->from( 'work_order' );
		$this->db->join( 'product_group', 'product_group.id=work_order.product_group_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id ' );
		$this->db->join( 'work_order_status', 'work_order_status.id=work_order.work_order_status_id' );
		$this->db->where( 'work_order.id', $id );
		$this->db->limit(1);
		
		
		$query = $this->db->get();
	
		if ($query->num_rows() == 0) return false;
		
		$ot = array();
		
		foreach ($query->result() as $row) {
			
			$type_tramite = $this->getParentsWorkTipes( $row->work_order_type_id );
			
			$ot[] = array( 
		    	'id' => $row->id,
				'uid' => $row->uid,
				'policy_id' => $row->policy_id,
				'policy' => $this->getPolicyBuId( $row->policy_id ),
				'agents' => $this->getAgentsByPolicy( $row->policy_id ),
		    	'product_group_id' => $row->product_group_id,
				'group_name' => $row->group_name,
				'parent_type_name' => $this->getTypeTramiteId( $type_tramite ),
				'type_id' => $row->work_order_type_id,
				'type_name' => $row->type_name,
				'status_id' => $row->work_order_status_id,
		    	'status_name' =>  $row->status_name,
				'creation_date' =>  $row->creation_date,
				'comments' => $row->comments,
				'duration' =>  $row->duration,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
						
		return $ot;
   
   }
   
   public function getWorkOrderByPolicy( $policy = null ){
   		
		if( empty( $policy ) ) return false;
		
				
		$this->db->where( 'policy_id', $policy );
		$this->db->limit(1);
		
		
		$query = $this->db->get( 'work_order' );
		
		$ot = array();
		
		if ($query->num_rows() == 0) return false;
		
		
		foreach ($query->result() as $row) {
			
			$type_tramite = $this->getParentsWorkTipes( $row->work_order_type_id );
			
			$ot[] = array( 
		    	'id' => $row->id,
				'uid' => $row->uid,
				'policy_id' => $row->policy_id,
				'policy' => $this->getPolicyBuId( $row->policy_id ),
				'agents' => $this->getAgentsByPolicy( $row->policy_id ),
		    	'product_group_id' => $row->product_group_id,
				'parent_type_name' => $this->getTypeTramiteId( $type_tramite ),
				'creation_date' =>  $row->creation_date,
				'duration' =>  $row->duration,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
			
		return $ot;
   
   }	
	

/**
 *	Functions Policies
 **/		

	// Get Policy by Id
	public function getPolicyBuId( $id = null ){
		
		if( empty( $id ) ) return false;
		/*
			
			SELECT * 
			FROM policies
			WHERE id=1

			
		*/
		$this->db->select( 'policies.*, payment_methods.name as payment_method_name, payment_intervals.name as payment_intervals_name' );		
		$this->db->join( 'payment_methods', 'payment_methods.id=policies.payment_method_id' );	
		$this->db->join( 'payment_intervals', 'payment_intervals.id=policies.payment_interval_id' );	
		$this->db->where( 'policies.id', $id );
		$this->db->limit(1);
		$query = $this->db->get('policies');
		
		
		if ($query->num_rows() == 0) {
		
				
			$this->db->select();		
			$this->db->where( 'policies.id', $id );
			$this->db->limit(1);
			$query = $this->db->get('policies');
			
			
			
			if ($query->num_rows() == 0) return false;
		
		
		}
		
		$policy = array();
		
		foreach ($query->result() as $row) {
			
			$payment_intervals_name='';
			$payment_method_name='';
			if( isset( $row->payment_intervals_name ) )
				$payment_intervals_name=$row->payment_intervals_name;
			if( isset( $row->payment_method_name ) )
				$payment_method_name=$row->payment_method_name;	
			
			$policy[] = array( 
		    	'id' => $row->id,
		    	'product_id' => $row->product_id,
				'currency_id' => $row->currency_id,
				'payment_interval_id' => $row->payment_interval_id,
				'payment_intervals_name' => $payment_intervals_name,
		    	'payment_method_id' =>  $row->payment_method_id,
				'payment_method_name' => $payment_method_name,
				'prima' => $row->prima,
				'name' =>  $row->name,
				'uid' =>  $row->uid,
				'lastname_father' =>  $row->lastname_father,
				'lastname_mother' =>  $row->lastname_mother,
				'year_premium' =>  $row->year_premium,
				'period' => $row->period,
				'expired_date' =>  $row->expired_date,
				'products' => $this->getProductsByPolicy( $row->product_id ),
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $policy;
		
	}
	
	public function getProductsByPolicy( $policy = null ){
		
		if( empty( $policy ) ) return false;
		
		$this->db->where( 'id', $policy );
		$this->db->limit(1);
		$query = $this->db->get('products');
		
		if ($query->num_rows() == 0) return false;
		
		$products = array();
		
		foreach ($query->result() as $row) {

			$products[] = array( 
		    	'id' => $row->id,
		    	'platform_id' => $row->platform_id,
				'product_group_id' => $row->product_group_id,
				'name' => $row->name,
		    	'period' =>  $row->period,
				'active' =>  $row->active,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $products;
		
	}
	
	
	public function getAgentsByPolicy( $policy = null ){
		
		if( empty( $policy ) ) return false;
		/*
		SELECT policies_vs_users.percentage, users.name, users.lastnames 
		FROM policies_vs_users
		JOIN agents ON agents.id=policies_vs_users.user_id
		JOIN users ON users.id=agents.user_id
		WHERE policy_id=1
		*/
		$this->db->select( ' policies_vs_users.percentage, policies_vs_users.user_id AS agent_id, users.name, users.lastnames, users.company_name, users.email ' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id ' );
		$this->db->where( 'policies_vs_users.policy_id', $policy );
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$agents = array();
		
		foreach ($query->result() as $row) {

			$agents[] = array(
				'agent_id' => $row->agent_id,
		    	'percentage' => $row->percentage,
				'name' => $row->name,
				'lastnames' => $row->lastnames,
				'company_name' => $row->company_name,
				'email' => $row->email
		    );

		}
		
		return $agents;
	}


// Getting policy by uid
	public function getPolicyByUid( $uid = null ){
		
		if( empty( $uid ) ) return false;
		/*
			
			SELECT id
			FROM policies
			WHERE uid='';

			
		*/
				
		$this->db->select( 'id, prima' );		
		$this->db->where( 'policies.uid', $uid );
		$this->db->limit(1);
		$query = $this->db->get('policies');
		
		
		if ($query->num_rows() == 0) return false;
		
		
		$policy = array();
		
		foreach ($query->result() as $row) {
			
			$policy[] = array( 
		    	'id' => $row->id,
				'prima' => $row->prima
		    );

		}
		
		return $policy;
		
	}

	public function getByPolicyUid( $policy_uid = null ){
		
		if( empty( $policy_uid ) ) return false;
		/*
		SELECT work_order.id, work_order.uid,  policies.name
		FROM work_order
   		JOIN policies ON policies.id=work_order.policy_id
		WHERE policies.uid*/
		$this->db->select( 'work_order.id, work_order.uid,  policies.name' );
		$this->db->from( 'work_order' );
		$this->db->join( 'policies', 'policies.id=work_order.policy_id' );		
		$this->db->where( 'policies.uid', $policy_uid );
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		
		foreach ($query->result() as $row)
		
			return $row->uid.' - '.$row->name;
		
		
	}


/**
 *	Ajax Requests, getting data
 **/





// Getting typetramite for ramo
	public function getTypeTramite( $ramo = null ){
		
		
		if( empty( $ramo ) ) return false;
		
		
		// SELECT * FROM `work_order_types` WHERE patent_id=1 and duration=0;
		
		$options = '<option value="">Seleccione</option>';	
		
		$this->db->where( array( 'patent_id' => $ramo, 'duration' => 0 ) );
		
		$query = $this->db->get( 'work_order_types' );
		
		
		if ($query->num_rows() == 0) return $options;
		
				
		foreach ($query->result() as $row)
			
			$options .= '<option value="'.$row->id.'">'.$row->name.'</option>';	
			
		
		return $options;
		
	}
	
	
	public function getTypeTramiteId( $id = null ){
		
		
		if( empty( $id ) ) return false;
		
		
		// SELECT * FROM `work_order_types` WHERE patent_id=1 and duration=0;
						
		$this->db->where( array( 'id' => $id ) );
		$this->db->limit(1);
		
		$query = $this->db->get( 'work_order_types' );
		
		
		if ($query->num_rows() == 0) return $options;
		
		$type = array();
				
		foreach ($query->result() as $row)
			
			$type[] = array( 'id' => $row->id,  'name' => $row->name );
			
		
		return $type[0];
		
	}

// Getting getSubType for type
	public function getSubType( $type = null ){
		
		
		if( empty( $type ) ) return false;
		
		
		// SELECT * FROM `work_order_types` WHERE patent_id=1 and duration!=0;
		
		$options = '<option value="">Seleccione</option>';	
		
		$this->db->where( array( 'patent_id' => $type, 'duration !=' => 0 ) );
		
		$query = $this->db->get( 'work_order_types' );
		
		
		if ($query->num_rows() == 0) return $options;
		
				
		foreach ($query->result() as $row)
			
			$options .= '<option value="'.$row->id.'">'.$row->name.'</option>';	
			
		
		return $options;
		
	}
	
	public function getPeriod( $product = null, $as_string = TRUE ){
		
		$this->db->select( 'period' );

		if( !empty( $product ) )
			$this->db->where( array( 'id' => $product ) );
		
		$this->db->limit(1);

		$query = $this->db->get( 'products' );
		
		$options = '<option value="">Seleccione</option>';	
		$result_array = array();

		if ($query->num_rows() == 0) {
			if ($as_string)
				return $options;
			return $result_array;
		}

		$period = array();
		foreach ($query->result() as $row)
			$period[] = $row->period;

		if ( empty( $period[0] ) ) {
			if ($as_string)
				return $options;
			return $result_array;
		}

		$explode = explode( '-', $period[0] );	
		if( is_array( $explode ) and isset( $explode[1] ) ){
			for( $i = (int)$explode[0]; $i <= (int) $explode[1]; $i++ ) {
				$options .= '<option value="'.$i.'">'.$i.'</option>';
				$result_array[$i] = $i;
			}
		}else{
			$explode = explode( ',', $period[0] );	
			foreach( $explode as $value ) {
				$options .= '<option value="'.$value.'">'.$value.'</option>';
				$result_array[$value] = $value;
			}
		}	
		//print_r( $period );
		//exit;
		if ($as_string)
			return $options;
		return $result_array;
	}

/**
 *	Get Policies
 **/
	public function getPolicies( $product = null ){
		
		
		if( empty( $product ) ) return false;
				
		/*
			SELECT policies.id, products.name as product_name 
			FROM policies
			JOIN products ON products.id=policies.product_id
		*/
		
		$options = '<option value="">Seleccione</option>';	
		
		
							
		$this->db->where( array( 'product_id' => $product ) );
		
		$query = $this->db->get( 'policies' );
		
		//print_r( $query );
		
		if ($query->num_rows() == 0) return $options;
		
		
		foreach ($query->result() as $row)
			
			$options .= '<option value="'.$row->id.'">'.$row->name.'</option>';	
			
		
		return $options;
		
	}




/**
 *	Functions Products
 **/
	public function getProductsGroupsOptions(){
				
		$query = $this->db->get( 'product_group' );	
			
		$options = '<option value="">Seleccione</option>';
		
		
		if ($query->num_rows() == 0) return $options;
		
				
		foreach ($query->result() as $row) {

			$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 
		    
		}
		
		return $options;
		
	}
	
	public function getProducts( $product_group = null ){
		
			
		//SELECT * FROM `products` WHERE product_group_id=1;
		if( !empty( $product_group ) )
			
			$this->db->where( array( 'product_group_id' => $product_group ) );
			
		
		$query = $this->db->get( 'products' );	
			
		
		
		if ($query->num_rows() == 0) return false;
		
		$products = array();
		
		foreach ($query->result() as $row) {

			$products[] = array( 
		    	'id' => $row->id,
		    	'platform_id' => $row->platform_id,
				'product_group_id' => $row->product_group_id,
		    	'name' =>  $row->name,
				'period' =>  $row->period,
				'active' =>  $row->active,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $products;
		
	}
	
	
	public function getProductsOptions( $product_group = null ){
		
			
		//SELECT * FROM `products` WHERE product_group_id=1;
		$this->db->select( 'products.*, product_group.name as group_name' );
		$this->db->join( 'product_group', 'product_group.id = products.product_group_id' );
		
		if( !empty( $product_group ) )
			
			$this->db->where( array( 'products.product_group_id' => $product_group ) );
			
		
		$query = $this->db->get( 'products' );	
			
		$options = '<option value="">Seleccione</option>';
		
		
		if ($query->num_rows() == 0) return $options;
		
				
		foreach ($query->result() as $row) {

			$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 
		    
		}
		
		return $options;
		
	}



/**
 *	Currency
 **/
	public function getCurrency(){
				
		$query = $this->db->get( 'currencies' );	
					
		if ($query->num_rows() == 0) return false;
		
		$currency = array();
		
		foreach ($query->result() as $row) {

			$currency[] = array( 
		    	'id' => $row->id,
		    	'name' => $row->name,
				'label' => $row->label,
		    	'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $currency;
		
	}
	
	public function getCurrencyOptions(){
				
		$query = $this->db->get( 'currencies' );	
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0) return $options;
						
		foreach ($query->result() as $row) {

			$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 

		}
		
		return $options;
		
	}


/**
 *	Payments Methods
 **/
	public function getPaymentMethods(){
				
		$query = $this->db->get( 'payment_intervals' );	
					
		if ($query->num_rows() == 0) return false;
		
		$payment = array();
		
		foreach ($query->result() as $row) {

			$payment[] = array( 
		    	'id' => $row->id,
		    	'name' => $row->name,
				'label' => $row->label,
		    	'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $payment;
		
	}
/**
 *	Payments Intervals as array
 **/
	public function getPaymentIntervals() {
		return $this->getPaymentMethods();
	}

/**
 *	Payments Intervals as string
 **/
	public function getPaymentIntervalOptions(){
				
		$query = $this->db->get( 'payment_intervals' );	
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0) return $options;
						
		foreach ($query->result() as $row) {

			$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 

		}
		
		return $options;
		
	}

/**
 *	Payments Methods Conducto (payment method) as array 
 **/
	public function getPaymentMethodsConducto(){
				
		$query = $this->db->get( 'payment_methods' );	
					
		if ($query->num_rows() == 0) return false;
		
		$payment = array();
		
		foreach ($query->result() as $row) {

			$payment[] = array( 
		    	'id' => $row->id,
		    	'name' => $row->name,
				'label' => $row->label,
		    	'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $payment;
		
	}
/**
 *	Payments Methods Conducto (payment method) as string 
 **/	
	public function getPaymentMethodsConductoOptions(){
				
		$query = $this->db->get( 'payment_methods' );	
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0) return $options;
						
		foreach ($query->result() as $row) {

			$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 

		}
		
		return $options;
		
	}




/**
 *	Activate / Desactivate
 **/	
 	public function getOtActivateDesactivate( $ot = null ){
		
		if( empty( $ot ) ) return false;
		
		
		$this->db->where( 'id', $ot );		
		$query = $this->db->get( 'work_order' );	
					
				
		$ot = array();
		
		foreach ($query->result() as $row) {

			$ot[] = array( 
		    	'id' => $row->id,
		    	'product_group_id' => $row->product_group_id,
				'work_order_status_id' => $row->work_order_status_id,
				'work_order_reason_id' => $row->work_order_reason_id,
		    	'work_order_responsible_id' =>  $row->work_order_responsible_id,
				'comments' =>  $row->comments
		    );

		}
		
		return $ot;
		
	}
	
	
	public function setPolicy( $ot = null, $policy = null ){
		
		if( empty( $ot ) or empty( $policy ) ) return false;
		
		$this->db->select( 'policy_id' );
		$this->db->where( 'id', $ot );		
		$this->db->limit(1);
		$query = $this->db->get( 'work_order' );	
		
		
		if ($query->num_rows() == 0) return false;
		
		
		$policies = array();
		
		foreach ($query->result() as $row) {

			$policies[] = array( 
		    	'policy_id' => $row->policy_id
		    );

		}
		
		$updatepolicy = array( 'uid' =>  $policy );
		
		
		
		if( $this->db->update( 'policies', $updatepolicy, array( 'id' => $policies[0]['policy_id'] ) ) )
			
			return true;
        
		else
        	
			return false;
		
		
		
		
		
		
	}
	
 
	public function getStatus( $work_order_status = null ){
				
		$query = $this->db->get( 'work_order_status' );	
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0) return $options;
						
		foreach ($query->result() as $row) {
			
			if( !empty( $work_order_status ) and $work_order_status == $row->id )
			
				$options  .= '<option selected="selected" value="'.$row->id.'">'.$row->name.'</option>'; 
			
			else
				
				$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 	

		}
		
		return $options;
		
	}

	public function getReason( $group = null, $work_order_status = null, $work_order_reason = null ){
				
		
		// And Where
		if( !empty( $group ) )
			$this->db->where( 'product_group_id', $group );
		
		
		if( !empty( $work_order_status ) )
			$this->db->where( 'work_order_status_id', $work_order_status );	
		
		
		$query = $this->db->get( 'work_order_reason' );	
		
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0){ return $options; }
						
		foreach ($query->result() as $row) {

			if( !empty( $work_order_reason ) and $work_order_reason == $row->id )
			
				$options  .= '<option selected="selected" value="'.$row->id.'">'.$row->name.'</option>'; 
			
			else
				
				$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 	

		}
		
				
		return $options;
		
	}

	public function getResponsibles( $work_order_responsibles = null ){
				
		$query = $this->db->get( 'work_order_responsibles' );	
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0) return $options;
						
		foreach ($query->result() as $row) {

			if( !empty( $work_order_responsibles ) and $work_order_responsibles == $row->id )
			
				$options  .= '<option selected="selected" value="'.$row->id.'">'.$row->name.'</option>'; 
			
			else
				
				$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 	

		}
		
		return $options;
		
	}
	


/**
 *	Import payments
 **/	
  public function importPaymentsTmp( $data = array() ){
  		
		if( empty( $data ) ) return false;
		
		$query = $this->db->get( 'payments_tmp' );	
  		
		if ($query->num_rows() == 0){  $this->db->insert( 'payments_tmp', array( 'data' => json_encode( $data ) ) ); return;  }
  		
		$id = null;
		
		foreach ($query->result() as $row)			
		
			$id	= $row->id;
		
  		
	   $this->db->delete( 'payments_tmp', array('id' => $id ) );	
	   
	   $this->db->insert( 'payments_tmp', array( 'data' => json_encode( $data ) ) );
	   
	   return true;	
  
  }
  
   public function removeImportPaymentsTmp(){
  				
		$query = $this->db->get( 'payments_tmp' );	
  		
		if ($query->num_rows() == 0){  return true; }
  		
		$id = null;
		
		foreach ($query->result() as $row)			
		
			$id	= $row->id;
		
  		
	   $this->db->delete( 'payments_tmp', array('id' => $id ) );	
	   
	   return true;	
  
  }
  
  public function getImportPaymentsTmp(){
  				
		$query = $this->db->get( 'payments_tmp' );	
  		
		if ($query->num_rows() == 0){  return true; }
  		
		$data = array();
		
		foreach ($query->result() as $row)			
		
			$data[]= array( 'id' => $row->id, 'data' => $row->data );  ;
		
  	
	   return $data;	
  
  }
  
  public function checkPayment( $uid = null, $prima = null, $payment_date = null, $user_id = null ){
	 
	if( empty( $uid ) ) return false;
	if( empty( $prima ) ) return false;
	if( empty( $payment_date ) ) return false;
	if( empty( $user_id ) ) return false;
	
	/*
	    SELECT * 
		FROM policies
		JOIN policies_vs_users ON policies_vs_users.policy_id=policies.id
		JOIN payments ON payments.policy_id=policies.id
		WHERE policies.uid='' 
		AND policies.prima >=''
		AND payments.payment_date=''
		AND policies_vs_users.user_id='';
	*/
	
	$this->db->select();
	$this->db->from( 'payments' );
	$this->db->where( array( 'policy_number' => $uid, 'amount >=' => $prima, 'payment_date' => $payment_date, 'agent_id' => $user_id ) );
	
	
	$query = $this->db->get();	
		
	if ($query->num_rows() == 0)  return true;
		
	return false;
	
  }
  
	  public function getWathdo( $i = 0 ){
	
		/*
		SELECT work_order.id, work_order.uid,  policies.name
		FROM work_order
   		JOIN policies ON policies.id=work_order.policy_id
   	    JOIN work_order_types ON work_order_types.id=work_order.work_order_type_id
		WHERE work_order.work_order_status_id=7
		AND ( work_order_types.patent_id=90
		OR work_order_types.patent_id=47 )   
		*//*
		$query = $this->db->query(
			
		   'SELECT work_order.id, work_order.uid,  policies.name
			FROM work_order
			JOIN policies ON policies.id=work_order.policy_id
			JOIN work_order_types ON work_order_types.id=work_order.work_order_type_id
			WHERE work_order.work_order_status_id=7
			AND ( work_order_types.patent_id=90
			OR work_order_types.patent_id=47 )'
			
		);*/
		
		$this->db->select( 'work_order.id, work_order.uid,  policies.name' );
		$this->db->from( 'work_order' );
		$this->db->join( 'policies', 'policies.id=work_order.policy_id' );
		$this->db->join( 'work_order_types', ' work_order_types.id=work_order.work_order_type_id' );
		$this->db->where( 'work_order.work_order_status_id', 7 );	
		$this->db->where( '( work_order_types.patent_id=90 OR work_order_types.patent_id=47 )' );
		$this->db->order_by( 'policies.name', 'asc' );
		
		$query = $this->db->get(); 
  	
		$options = '<select name="assing['.$i.']" class="required"><option value="">Seleccione OT relacionada</option>';
				
		if ($query->num_rows() == 0){  
			
			
			$options .= '<option value="noasignar" selected>No asignar a OT</option></select>';
			
				
			return $options; 
		
		}
		
		$options .= '<option value="noasignar" selected>No asignar a OT</option>';
		
		foreach ($query->result() as $row)			
			
			$options .= '<option value="'.$row->id.'">'.$row->uid.' - '.$row->name.'</option>';
		
		
		$options .= '</select>';
		
		return $options;
  }
  
  
  public function getWathdoPayment( $policy = null ){
		
		if( empty( $policy ) ) return false;
		/*
		SELECT * 
		FROM `payments`
		WHERE `policy_id`='1'
		*/
		$this->db->select();
		$this->db->from( 'payments' );
		$this->db->where( 'policy_id', $policy );	
		
		$query = $this->db->get(); 
  	
		if ($query->num_rows() == 0) return true;		
		
		return false;
  }
  
  public function getOtPolicyAssing( $ot = null ){
 	
		if( empty( $ot ) ) return 'No se encontro la ot';
		/*
		SELECT work_order.id, work_order.uid,  policies.name
		FROM work_order
		JOIN policies ON policies.id=work_order.policy_id
		WHERE work_order.work_order_status_id=7
		*/
	
	
	
		$this->db->select( ' work_order.id, work_order.uid,  policies.name');
		$this->db->from( 'work_order' );
		$this->db->join( 'policies', 'policies.id=work_order.policy_id' );
		$this->db->where( array( 'work_order.id ' =>  $ot  ) );	
		
		$query = $this->db->get(); 
  	
		if ($query->num_rows() == 0) return 'No se encontro la ot';		
		
		
		foreach ($query->result() as $row)	
			
			return $row->uid.' - '.$row->name;
		
		
		return true;
 
  }
  
  
  
  function pop_up_data($work_order_id)
    {
        $this->db->select('*,work_order.id AS work_order_id,agent_user.email AS agent_user_email,policies.uid AS policies_uid,policies.name AS policies_name,products.name AS products_name,policies.period AS policies_period,work_order_status.name AS work_order_status_name,payment_methods.name AS payment_methods_name,currencies.name AS currencies_name,work_order.uid AS work_order_uid,payment_intervals.name AS payment_intervals_name, work_order_types.patent_id AS patent_id');
        //$this->db->select('*');
        $this->db->from('work_order');
        $this->db->where('work_order.id',$work_order_id); 
        $this->db->join('users','work_order.user = users.id','left');
        $this->db->join('work_order_status','work_order.work_order_status_id = work_order_status.id','left');
        $this->db->join('policies','work_order.policy_id = policies.id','left');
        
        $this->db->join('policies_vs_users','policies.id = policies_vs_users.policy_id','left');
        $this->db->join('agents','policies_vs_users.user_id = agents.id','left');
        $this->db->join('users agent_user','agents.user_id = agent_user.id','left');
        
        $this->db->join('products','policies.product_id = products.id','left');         
        $this->db->join('payment_intervals','policies.payment_interval_id = payment_intervals.id','left'); 
        $this->db->join('payment_methods','policies.payment_method_id = payment_methods.id','left');
        $this->db->join('currencies','policies.currency_id = currencies.id','left');
        $this->db->join('work_order_types','work_order.work_order_type_id = work_order_types.id','left');        
        //$query = $this->db->get_where('work_order',array('work_order.id'=>$work_order_id));
        $query = $this->db->get();
        $result['general'] = $query->result();
		foreach ($result['general'] as $key => $value) {
			$result['general'][$key]->is_ntuable = $this->is_ntuable(
				$value->product_group_id,
				$value->patent_id,
				$value->work_order_status_id);
		}
        
        $this->db->select('email,name');
        $this->db->from('users_vs_user_roles');
        $this->db->where('users_vs_user_roles.user_role_id',4); 
        $this->db->join('users','users_vs_user_roles.user_id = users.id');        
        $query_later = $this->db->get();
        $result['director'] = $query_later->result();
        return $result;
    }

// Determine if an OT is editable

	public function is_editable( $product_group_id, $tramite, $ot_status ) {

		return ($ot_status != 4) &&						// OT is editable if not already paid
			(												// AND:
			(($product_group_id == 1) && ($tramite == 47)) 	// "Vida" and "NUEVO NEGOCIO" or ...
				||
			(($product_group_id == 2) && ($tramite == 90))  // "GMM" and "NUEVO NEGOCIO"
			);
	}
// Determine if an OT is "NTU-able"

	public function is_ntuable( $product_group_id, $tramite, $ot_status ) {

		return ($ot_status == 7) &&						// OT is editable if status "aceptado"
			(												// AND:
			(($product_group_id == 1) && ($tramite == 47)) 	// "Vida" and "NUEVO NEGOCIO" or ...
				||
			(($product_group_id == 2) && ($tramite == 90))  // "GMM" and "NUEVO NEGOCIO"
			);
	}
	
// Search values 
	public function generic_search( $table = null, $searched = null, $like = null,
		$limit = null, $offset = 0 )
	{
		if (( $table == null ) || ( $searched == null ))
			return FALSE;
        $this->db->select($searched, FALSE)->from($table);

		//limit
		if ($limit)
			$this->db->limit($limit, $offset);

		// like
		if ($like)
			$this->db->like($like[0], $like[1], $like[2]);

		$q = $this->db->get();

		return ($q->num_rows() > 0) ? $q->result() : FALSE;		
	}
	
	
// Generic row retrieval

	public function generic_get( $table = null, $where = null, $limit = null, $offset = 0 ) {
		if ( $table == null )
			return FALSE;
        $this->db->select('*')->from($table);

		$where = is_array($where) ? $where : array();
		foreach ($where as $key => $value)
			$this->db->where($key, $value);

		//limit
		if ($limit)
			$this->db->limit($limit, $offset);

		$q = $this->db->get();

		return ($q->num_rows() > 0) ? $q->result() : FALSE;		
	}

// Another generic update method
	public function generic_update( $table = null, $values = null, $where = null, $limit = null, $offset = 0 ) {
		if (( $table === null ) ||  !is_array($values) || !count($values)) 
			return FALSE;

		$where = is_array($where) ? $where : array();
		foreach ($where as $key => $value)
			$this->db->where($key, $value);
		//limit
		if ($limit)
			$this->db->limit($limit, $offset);

		$result = $this->db->update($table, $values) && ($this->db->affected_rows() > 0);
		return $result;
	}

// Another generic delete method
	public function generic_delete( $table = null, $where = null, $limit = null, $offset = 0 ) {
		if ( $table === null )
			return FALSE;

		$where = is_array($where) ? $where : array();
		foreach ($where as $key => $value)
			$this->db->where($key, $value);
		//limit
		if ($limit)
			$this->db->limit($limit, $offset);

		$result = $this->db->delete($table) && ($this->db->affected_rows() > 0);
		return $result;
	}

}
?>