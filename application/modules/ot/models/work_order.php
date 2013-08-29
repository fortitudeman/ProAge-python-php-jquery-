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
	
	public function overview( $start = 0, $user = null ) {
		
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
		$this->db->where( 'work_order.work_order_status_id', 9 );
		$this->db->or_where( 'work_order.work_order_status_id', 5  );
		$this->db->or_where( 'work_order.work_order_status_id', 6  );
		
		
		if( !empty( $user ) )
			$this->db->where( 'work_order.user', $user );
		
		$this->db->limit( 50, $start );
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

	


// Count records for pagination
	public function record_count( $user = null ) {
       
	    if( empty( $user ) )
	    	 return $this->db->from( 'work_order' )->where( array( 'work_order_status_id !=' => 2 ) )->count_all_results();
    	else
		  return $this->db->from( 'work_order' )->where( array( 'work_order_status_id !=' => 2, 'work_order.user' => $user ) )->count_all_results();
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
	public function find( $advansed = array(), $user = null ) {
		
		$status=0;
		
		
						
		if( $advansed['work_order_status_id'] == 'activadas' )
			$status =6;
		if( $advansed['work_order_status_id'] == 'canceladas' )
			$status =2;
		if( $advansed['work_order_status_id'] == 'tramite' )
			$status =5;	
		if( $advansed['work_order_status_id'] == 'terminada' )
			$status =7;	
		if( $advansed['work_order_status_id'] == 'todas' )
			$status =0;		
		
		
		$filter_user = $advansed['user'];

		unset( $advansed['user'] );
		unset( $advansed['work_order_status_id'] );
		/*
			
			SELECT product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*
			FROM `work_order`
			JOIN product_group ON product_group.id=work_order.product_group_id
			JOIN work_order_types ON work_order_types.id=work_order.work_order_type_id 
			JOIN work_order_status ON work_order_status.id=work_order.work_order_status_id;
			WHERE work_order.work_order_status_id=1;
		*/
		
		$this->db->select( 'product_group.name as group_name, work_order_types.name as type_name, work_order_status.name as status_name, work_order.*' );
		$this->db->from( 'work_order' );
		$this->db->join( 'product_group', 'product_group.id=work_order.product_group_id' );
		$this->db->join( 'work_order_types', 'work_order_types.id=work_order.work_order_type_id ' );
		$this->db->join( 'work_order_status', 'work_order_status.id=work_order.work_order_status_id' );

		
		if( $status == 6 )
			$this->db->where( 'work_order.work_order_status_id', 6 );
		
		if( $status == 2 )
			$this->db->where( 'work_order.work_order_status_id', 2 );
		
		
		if( $status == 5 ){
			$this->db->where( 'work_order.work_order_status_id', 5 );	
			$this->db->or_where( 'work_order.work_order_status_id', 9 );
		}
		
		
		if( $status == 7 ){
			$this->db->where( 'work_order.work_order_status_id', 7 );	
			$this->db->or_where( 'work_order.work_order_status_id', 6 );
		}
		
				
		
		if( $filter_user == 'mios' and !empty( $user ) ){
			$this->db->where( array( 'work_order.user' => $user ) );
		}
		
				
		
		// Added Avansed
		if( !empty( $advansed ) ){
				
				foreach( $advansed['advanced'] as $value ){
					
					
					if( isset( $value[0] ) and $value[0] == 'id' ){
																		
						if( !empty( $value[1] ) ){
						
							$id = $value[1];
																													
							$this->db->where( array( 'work_order.uid' => $id ) );	
						
						}
					}
					
					
					if( isset( $value[0] ) and $value[0] == 'creation_date' ){
							
							if( !empty( $value[1] ) and !empty( $value[2] ) )
								
								$this->db->where( array( 'work_order.creation_date >=' => $value[1], 'work_order.creation_date <=' => $value[2]  ) );	
					
					
					}
					
					if( isset( $value[0] ) and $value[0] == 'ramo' ){
							
							if( !empty( $value[1] ) )
							
								$this->db->where( array( 'work_order.product_group_id' => $value[1] ) );			
					}
					
					
					// Agents
					if( isset( $value[0] ) and $value[0] == 'agent' ){
						
						/**
						 JOIN policies_vs_users ON policies_vs_users.policy_id=work_order.policy_id
						 WHERE policies_vs_users.user_id=1
						*/
						
						if( !empty( $value[1] ) ){

							$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=work_order.policy_id' );
							$this->db->where( 'policies_vs_users.user_id', $value[1] );
						
						}
					}
					
					
					// Gerentes
					if( isset( $value[0] ) and $value[0] == 'gerente' ){
						
						/**
						 JOIN policies_vs_users ON policies_vs_users.policy_id=work_order.policy_id
						 WHERE policies_vs_users.user_id=1
						*/
						if( !empty( $value[1] ) ){
							$this->db->join( 'policies_vs_users', 'policies_vs_users.policy_id=work_order.policy_id' );
							$this->db->where( 'policies_vs_users.gerente', $value[1] );
						}
					}
					
					
					
					
					
					
					
					
				}
				
				
				
		
		}
		
		
		
		
		
		
		
		
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
	
	
	
   public function getWorkOrderById( $id = null ){
   		
		if( empty( $id ) ) return false;
		
		if ($query->num_rows() == 0) return false;
		
		$this->db->where( 'id', $id );
		$this->db->limit(1);
		
		
		$query = $this->db->get( 'work_order' );
		
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
				'type_name' => $row->type_name,				
		    	'status_name' =>  $row->status_name,
				'creation_date' =>  $row->creation_date,
				'duration' =>  $row->duration,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
						
		return $ot;
   
   }
	
	
	
	

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
		$this->db->select( ' policies_vs_users.percentage, users.name, users.lastnames, users.company_name, users.email ' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id ' );
		$this->db->where( 'policies_vs_users.policy_id', $policy );
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$agents = array();
		
		foreach ($query->result() as $row) {

			$agents[] = array( 
		    	'percentage' => $row->percentage,
				'name' => $row->name,
				'lastnames' => $row->lastnames,
				'company_name' => $row->company_name,
				'email' => $row->email
		    );

		}
		
		return $agents;
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
	
	public function getPeriod( $product = null ){
		
		$this->db->select( 'period' );
		
		if( !empty( $product ) )
			$this->db->where( array( 'id' => $product ) );
		
		$this->db->limit(1);
		
		
		$query = $this->db->get( 'products' );
		
		$options = '<option value="">Seleccione</option>';	
		
		if ($query->num_rows() == 0) return $options;
		
		$period = array();
		
		foreach ($query->result() as $row)
			
			$period[] = $row->period;
		
		
		if( empty( $period[0] ) )return $options;
		
		
		$explode = explode( '-', $period[0] );	
				
						
		
		if( is_array( $explode ) and isset( $explode[1] ) ){
			
			for( $i = (int)$explode[0]; $i <= (int) $explode[1]; $i++ )
				$options .= '<option value="'.$i.'">'.$i.'</option>';	
		
		}else{
			
			$explode = explode( ',', $period[0] );	
				
				foreach( $explode as $value )
					$options .= '<option value="'.$value.'">'.$value.'</option>';	
		}	
		
		
		
		
		
			
		//print_r( $period );
		//exit;	
			
		
		return $options;
		
		
		
		
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
 *	Products
 **/
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
	
	public function getPaymentMethodsOptions(){
				
		$query = $this->db->get( 'payment_intervals' );	
		
		$options = '<option value="">Seleccione</option>';
					
		if ($query->num_rows() == 0) return $options;
						
		foreach ($query->result() as $row) {

			$options  .= '<option value="'.$row->id.'">'.$row->name.'</option>'; 

		}
		
		return $options;
		
	}



/**
 *	Payments Methods Conducto
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

}
?>