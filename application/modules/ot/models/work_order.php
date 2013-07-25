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
		
				
   }

	


// Count records for pagination
	public function record_count() {
        return $this->db->count_all( '' );
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
		
		
		if( empty( $subtype ) ) return false;
				
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
			
			//$options .= '<option value="'.$row->id.'">'.$row->name.'</option>';	
			
		
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