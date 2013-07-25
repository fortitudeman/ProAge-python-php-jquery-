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
					
		// Set timestamp unix
		$timestamp = strtotime( date( 'd-m-Y H:i:s' ) );
		
		$values['modified'] = $timestamp;
		
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
	
	public function overview( $start = 0 ) {
		
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
		$this->db->limit( 50, $start );
		$query = $this->db->get();
		
		
		if ($query->num_rows() == 0) return false;
		
		$ot = array();
		
		foreach ($query->result() as $row) {

			$ot[] = array( 
		    	'id' => $row->id,
				'policy' => $this->getPolicyBuId( $row->policy_id ),
				'agents' => $this->getAgentsByPolicy( $row->policy_id ),
		    	'product_group_id' => $row->product_group_id,
				'group_name' => $row->group_name,
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

	


// Count records for pagination
	public function record_count() {
        return $this->db->count_all( '' );
    }


	// Get Policy by Id
	public function getPolicyBuId( $id = null ){
		
		if( empty( $id ) ) return false;
		/*
			
			SELECT * 
			FROM policies
			WHERE id=1

			
		*/
				
		$this->db->where( 'id', $id );
		$this->db->limit(1);
		$query = $this->db->get('policies');
		
		
		if ($query->num_rows() == 0) return false;
		
		$policy = array();
		
		foreach ($query->result() as $row) {

			$policy[] = array( 
		    	'id' => $row->id,
		    	'product_id' => $row->product_id,
				'currency_id' => $row->currency_id,
				'payment_interval_id' => $row->payment_interval_id,
		    	'payment_method_id' =>  $row->payment_method_id,
				'name' =>  $row->name,
				'lastname_father' =>  $row->lastname_father,
				'lastname_mother' =>  $row->lastname_mother,
				'year_premium' =>  $row->year_premium,
				'expired_date' =>  $row->expired_date,
				'last_updated' =>  $row->last_updated,
				'date' =>  $row->date
		    );

		}
		
		return $policy;
		
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
		$this->db->select( ' policies_vs_users.percentage, users.name, users.lastnames ' );
		$this->db->from( 'policies_vs_users' );
		$this->db->join( 'agents', 'agents.id=policies_vs_users.user_id' );
		$this->db->join( 'users', 'users.id=agents.user_id ' );
		$this->db->where( 'policies_vs_users.policy_id', $policy );
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 0) return false;
		
		$agents = array();
		
		foreach ($query->result() as $row) {

			$agents[] = array( 
		    	'percentage' => $row->percentage,
				'name' => $row->name,
				'lastnames' => $row->lastnames
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

			$options  .= '<option value="'.$row->id.'">'.$row->group_name.' - '.$row->name.'</option>'; 
		    
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

}
?>