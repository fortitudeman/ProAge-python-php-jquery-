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
		$payments = $this->fillMonths($result, "month", "amount");
		return $payments;
	}

	public function getPolicies(){
		$this->db->select('po.id,po.prima,po.uid');
		$q = $this->db->get('policies po');
		$result = $q->result_array();
		$return = array();
		foreach ($result as $row) 
			$return[$row["uid"]] = $row; 
		return $return;
	}

	public function getPrimas($year, $ramo){
		$this->db->select_sum("prima");
		$this->db->where('year(wo.creation_date)', $year);
		$this->db->where('wo.product_group_id', $ramo);
		$this->db->where_in('wo.work_order_status_id', array(4, 7));
		$this->db->join('policies po', 'po.id = wo.policy_id');
		$q = $this->db->get("work_order wo");
		$result = $q->row_array();
		return $result['prima'];
	}

	public function getPrimasList($year, $ramo){
		$this->db->select('year(wo.creation_date) year,month(wo.creation_date) month');
		$this->db->join('policies po', 'po.id = wo.policy_id');
		$this->db->select_sum("prima");
		$this->db->where('year(wo.creation_date)', $year);
		$this->db->where('wo.product_group_id', $ramo);
		$this->db->where_in('wo.work_order_status_id', array(4, 7));
		$this->db->order_by('month', 'asc');
		$this->db->group_by('month');
		$q = $this->db->get("work_order wo");
		$result = $q->result_array();
		$primas = $negocios = $this->fillMonths($result, "month", "prima");
		return $primas;
	}

	public function getNegociosList($year, $ramo){
		$this->db->select('month(wo.creation_date) month, count(*) negocios', FALSE);
		$this->db->join('work_order_types wot', 'wot.id = wo.work_order_type_id');
		$this->db->where('year(wo.creation_date)', $year);
		$this->db->where('wo.product_group_id', $ramo);
		$this->db->where('wo.work_order_status_id', 4);
		$this->db->where_in('wot.patent_id', array(47, 90));
		$this->db->order_by('month', 'asc');
		$this->db->group_by('month');
		$q = $this->db->get("work_order wo");
		$result = $q->result_array();

		//Fill the blank months
		$negocios = $this->fillMonths($result, "month", "negocios");
		return $negocios;
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
		
		//Create array of with all policies grouped by product (Enhaces the direct query speed)
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
			$payments = $this->fillMonths($result, "month", "amount");
			$products[$i]["payments"] = $payments;
		}

		//Delete the products without payments
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

	public function getNegocios($year, $ramo){
		$this->db->join('work_order_types wot', 'wot.id = wo.work_order_type_id');
		$this->db->where('year(wo.creation_date)', $year);
		$this->db->where('wo.product_group_id', $ramo);
		$this->db->where('wo.work_order_status_id', 4);
		$this->db->where_in('wot.patent_id', array(47, 90));
		return $this->db->count_all_results("work_order wo");
	}


	public function getNumAgents($year, $ramo){
		$this->db->select('sum(py.amount) as val', FALSE);
		$this->db->where('py.product_group', $ramo);
		$this->db->where('py.year_prime', 1);
		$this->db->where('year(py.payment_date)', $year);
		$this->db->where('py.valid_for_report', 1);
		$this->db->group_by('py.agent_id');
		$this->db->having('val >= ', 385000); 
		$q = $this->db->get($this->table);
		$result = $q->result_array();
		return count($result);
	}

	public function getNumBusiness($year, $ramo){
		$this->db->select('sum(negocio_pai) as val', FALSE);
		$this->db->where('ramo', $ramo);
		$this->db->where('year(date_pai)', $year);
		$q = $this->db->get('policy_negocio_pai');
		$result = $q->row_array();
		$val = $result['val'];
		$num = 0;
		if($val!=''){ $num = $val; }
		return $num;
	}

	public function fillMonths($data, $month_field, $value_field){
		$filled_months = $this->getZerosArray(12);
		foreach ($data as $row){
			$filled_months[$row[$month_field] - 1] = $row[$value_field];
		}
		return $filled_months;
	}

	public function getZerosArray($length){
		$zeros = array();
		for ($i=0; $i < $length; $i++) { 
			$zeros[$i] = 0;
		}
		return $zeros;
	}
}
?>