<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rpm extends CI_Model{
	private $table = 'payments py';

	public function __construct(){
		parent::__construct();
	}

	public function getAllData($year, $ramo){
		$this->db->select('year(py.payment_date) year, ,month(py.payment_date) month', FALSE);
		$this->db->select_sum("py.amount");
		$this->db->where('year(py.payment_date)', $year);
		$this->db->where('product_group', $ramo);
		$this->db->group_by('year, month');
		$this->db->order_by('month', 'asc');
		$q = $this->db->get($this->table);
		return $q->result_array();
	}

	public function getFirstPaymentYear(){
		$this->db->select('min(year(py.payment_date)) year');
		$q = $this->db->get($this->table);
		$row = $q->row_array();
		return isset($row["year"]) ? $row["year"] : date("Y");
	}
}
?>