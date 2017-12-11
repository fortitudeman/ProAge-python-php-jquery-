<?php
/*
defined('BASEPATH') OR exit('No direct script access allowed');

class Exec extends CI_Controller {

	public function updateCapitalizeNames()
	{
		$query = $this->db->get('products');
		$products = $query->result_array();
		foreach ($products as $product){
			$obj = array(
				"name" => ucwords(strtolower($product["name"])),
			);
			$this->db->where('id', $product["id"]);
			$this->db->update('products', $obj);
		}

		$query = $this->db->get('work_order_status');
		$status = $query->result_array();
		foreach ($status as $stat){
			$obj = array(
				"name" => ucwords(strtolower($stat["name"])),
			);
			$this->db->where('id', $stat["id"]);
			$this->db->update('work_order_status', $obj);
		}
		$obj = array(
			"name" => "Póliza NTU",
		);
		$this->db->where('id', 10);
			$this->db->update('work_order_status', $obj);
		echo "Finalizo!!";
	}

}

/* End of file exec.php */
/* Location: ./application/controllers/exec.php */