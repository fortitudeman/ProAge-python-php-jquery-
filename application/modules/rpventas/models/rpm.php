<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rpm extends CI_Model{
	private $table = 'payments py';

	public function __construct(){
		parent::__construct();
	}

	public function getAllData($year, $ramo){
		$this->db->select('year(py.payment_date) year,month(py.payment_date) month', FALSE);
		$this->db->select_sum("py.amount");
		$this->db->where('year(py.payment_date)', $year);
		$this->db->where('py.year_prime', 1);
		$this->db->where('product_group', $ramo);
		$this->db->group_by('year, month');
		$this->db->order_by('month', 'asc');
		$q = $this->db->get($this->table);
		$result = $q->result_array();
		//Fill the blank months
		$payments = array(0,0,0,0,0,0,0,0,0,0,0,0);
		foreach ($result as $row)
			$payments[$row["month"] - 1] = $row["amount"];
		return $payments;
	}

	public function getFirstPaymentYear(){
		$this->db->select('min(year(py.payment_date)) year');
		$q = $this->db->get($this->table);
		$row = $q->row_array();
		return isset($row["year"]) ? $row["year"] : date("Y");
	}

	public function getDataByProduct($year, $ramo){
		//Get all products of ramo
		$this->db->select('po.uid, pr.id, pr.name');
		$this->db->join('products pr', 'po.product_id = pr.id', "left");
		$this->db->order_by('pr.id', 'asc');
		$q = $this->db->get('policies po');
		$policies = $q->result_array();
		
		//Create array of products
		$products = array();
		foreach ($policies as $policy) {
			$products[$policy["id"]]["name"] = $policy["name"];
			$products[$policy["id"]]["id"] = $policy["id"];
			if(!empty($policy["uid"]))
				$products[$policy["id"]]["policies"][] = $policy["uid"];
		}
		$products[""]["name"] = "No clasificado";
		
		foreach ($products as $i => $product) {
			//Get sum of amounts grouped by month
			if(isset($product["policies"])){
				$this->db->select('year(py.payment_date) year,month(py.payment_date) month', FALSE);
				$this->db->select_sum("py.amount");
				$this->db->where('product_group', $ramo);
				$this->db->where('year(py.payment_date)', $year);
				$this->db->where('py.year_prime', 1);
				$this->db->where_in('policy_number', $product["policies"]);
				$this->db->group_by('year, month');
				$this->db->order_by('month', 'asc');
				$q = $this->db->get($this->table);
				$result = $q->result_array();
			}
			else
				$result = array();
			//Fill the blank months
			$payments = array(0,0,0,0,0,0,0,0,0,0,0,0);
			
			foreach ($result as $row)
				$payments[$row["month"] - 1] = $row["amount"];
			$products[$i]["payments"] = $payments;
		}

		foreach ($products as $i => $product) {
			$delete = TRUE;
			foreach ($product["payments"] as $payment){
				if($payment != 0)
					$delete = FALSE;
			}
			if($delete)
				unset($products[$i]);
		}
		return $products;
	}
}
?>