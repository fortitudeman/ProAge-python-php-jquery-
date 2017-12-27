<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rpm extends CI_Model{
	//private $data = array();
	private $table1 = 'payments';
	// private $table2 = 'products';
	// private $table3 = 'polices';
	// private $table3 = 'work_order';

	public function __construct(){
		parent::__construct();
	}

	// public function all( $start = 0 ) {
	// 	$this->db->limit( 20, $start );
	// 	$query = $this->db->get( $this->table1 );
	// 	if ($query->num_rows() == 0) return false;
	// 	unset( $this->data );
	// 	$this->data = array();
	// 	foreach ($query->result() as $row) {
	// 		$this->data[] = array( 'pay_tbl_id' => $row->pay_tbl_id );
	// 	}
	// 	echo '<pre>'; print_r($this->data); echo '</pre>'; die();
	// 	return $this->data;
	// }

	public function getAllData($year1, $year2, $ramos){
		//echo $year1.'  '.$year2;
		$yearb = array();
		$yeara = array();
		for($i=1;$i<13;$i++){
			$month=$i;
			//echo "SELECT SUM(py.amount) FROM payments AS py WHERE valid_for_report=1 AND YEAR(py.payment_date)=$year1 AND MONTH(py.payment_date)=$month".'<br>';
			$query = $this->db->query("SELECT SUM(py.amount) as sumr FROM payments AS py WHERE product_group=$ramos AND valid_for_report=1 AND YEAR(py.payment_date)=$year1 AND MONTH(py.payment_date)=$month");
			$resulta = $query->result_array();
			$res = $resulta[0]['sumr'];
			array_push($yearb, $res);
		}
		for($i=1;$i<13;$i++){
			$month=$i;
			//echo "SELECT SUM(py.amount) FROM payments AS py WHERE valid_for_report=1 AND YEAR(py.payment_date)=$year1 AND MONTH(py.payment_date)=$month".'<br>';
			$query = $this->db->query("SELECT SUM(py.amount) as sumr FROM payments AS py WHERE product_group=$ramos AND valid_for_report=1 AND YEAR(py.payment_date)=$year2 AND MONTH(py.payment_date)=$month");
			$resulta = $query->result_array();
			$res = $resulta[0]['sumr'];
			array_push($yeara, $res);
		}
		$result = array();
		array_push($result, $yearb);
		array_push($result, $yeara);
		return $result;
	}
}
?>