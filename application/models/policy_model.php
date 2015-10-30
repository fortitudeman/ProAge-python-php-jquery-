<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

  Author
  Site:
  Twitter:
  Facebook:
  Github:
  Email:
  Skype:
  Location:		Mexíco

  	
*/
class Policy_model extends CI_Model
{
	private $table = '';

	public function __construct()
	{
        parent::__construct();
    }

/**
  Set table
 **/
    public function set_table( $table )
	{
		$this->table = $table;
    }	

/**
  Initialize the table `policy_adjusted_primas`
 **/
    public function populate_adjusted_primas()
	{
		$result = 0;
		if ($this->db->table_exists('policy_adjusted_primas'))
		{
			$query = $this->db->get_where('policies',
				'prima is NOT NULL', 1, 0);
			if ($query->num_rows() == 0)
				return;
			$query = $this->db->get('policy_adjusted_primas', 1, 0);
			if ($query->num_rows() > 0)
				return;

			$this->db->select('`work_order`.`work_order_status_id`, `work_order`.`product_group_id`, `work_order_types`.`patent_id`, `policies`.`id`, `policies`.`prima`, `policies`.`payment_interval_id`, `policies`.`date`, `extra_payment`.`extra_percentage`', FALSE);
			$this->db->from(array('work_order', 'work_order_types', 'policies', 'products', 'extra_payment'));
			$this->db->where("
`work_order_types`.`id`=`work_order`.`work_order_type_id`
AND
`work_order`.`policy_id` = `policies`.`id`
AND
 `products`.`id`=`policies`.`product_id`
AND
`extra_payment`.`x_product_platform` = `products`.`platform_id`
AND
`extra_payment`.`x_currency` = `policies`.`currency_id`
AND
`extra_payment`.`x_payment_interval` = `policies`.`payment_interval_id`
AND
`work_order`.`work_order_status_id` IN ( 7, 4)
AND
(
((`work_order`.`product_group_id` = 1) AND (`work_order_types`.`patent_id` = 47))
OR
((`work_order`.`product_group_id` = 2) AND (`work_order_types`.`patent_id` = 90))
)
", NULL, FALSE);

//`policies`.`prima` IS NOT NULL
//AND
			$query = $this->db->get();
			$new_rows = array();
			foreach ($query->result_array() as $row)
			{
				$this->_prepare_adjusted_primas($row, $new_rows);
			}
			if ($new_rows)
				$this->db->insert_batch('policy_adjusted_primas', $new_rows);
			$result = $this->db->count_all('policy_adjusted_primas');
		}
		return $result;
    }

/**
  Insert rows in `policy_adjusted_primas` for one given OT
 **/
    public function add_adjusted_primas($ot_id = null)
	{
		if (!$ot_id)
			return FALSE;
		$this->db->select('`work_order`.`work_order_status_id`, `policies`.`id`, `policies`.`prima`, `policies`.`payment_interval_id`, `policies`.`date`, `extra_payment`.`extra_percentage`', FALSE);
		$this->db->from(array('work_order', 'policies', 'products', 'extra_payment'));
		$this->db->where("
`work_order`.`policy_id` = `policies`.`id`
AND
 `products`.`id`=`policies`.`product_id`
AND
`extra_payment`.`x_product_platform` = `products`.`platform_id`
AND
`extra_payment`.`x_currency` = `policies`.`currency_id`
AND
`extra_payment`.`x_payment_interval` = `policies`.`payment_interval_id`
AND
`work_order`.`id` = '$ot_id'
", NULL, FALSE);

//`policies`.`prima` IS NOT NULL
//AND
		$query = $this->db->get();
		$new_rows = array();
		foreach ($query->result_array() as $row)
		{
			$this->_prepare_adjusted_primas($row, $new_rows);
		}
		if ($new_rows)
			return $this->db->insert_batch('policy_adjusted_primas', $new_rows);
		else
			return false;
	}

/**
  Insert rows in `policy_adjusted_primas` for one given OT
 **/
    private function _prepare_adjusted_primas($row, &$new_rows)
	{
		list($year, $month, $day_time) = explode('-', $row['date']);
		list($day, $time) = explode(' ', $day_time);
		$row['prima'] = $row['prima'] * (1 + $row['extra_percentage']);
		switch ($row['payment_interval_id'])
		{
			case 1: // mensual payment
				for ($i = 0; $i < 12; $i++) {
					$new_rows[] = array(
						'policy_id' => $row['id'],
						'adjusted_prima' => $row['prima'] / 12,
						'due_date' => date('Y-m-d', mktime(0, 0, 0, $month + $i, $day, $year))
						);
				}
				break;
			case 2: // trimestrial payment
				for ($i = 0; $i < 4; $i++) {
					$new_rows[] = array(
						'policy_id' => $row['id'],
						'adjusted_prima' => $row['prima'] / 4,
						'due_date' => date('Y-m-d', mktime(0, 0, 0, $month + ($i * 3), $day, $year))
						);
				}
				break;
			case 3: // semestrial payment
				for ($i = 0; $i < 2; $i++) {
					$new_rows[] = array(
						'policy_id' => $row['id'],
						'adjusted_prima' => $row['prima'] / 2,
						'due_date' => date('Y-m-d', mktime(0, 0, 0, $month + ($i * 6), $day, $year))
						);
				}
				break;
			case 4: // annual payment
				$new_rows[] = array(
					'policy_id' => $row['id'],
					'adjusted_prima' => $row['prima'],
					'due_date' => date('Y-m-d', mktime(0, 0, 0, $month, $day, $year))
					);
				break;
		}
	}

/**
  Get rows in `policy_adjusted_primas` for given OTs
 **/
    public function get_ot_adjusted_primas($ots = null)
	{
		$result = array();
		if (!$ots)
			return $result;
		$this->db->select( 'policy_adjusted_primas.*, work_order.id as ot_id' );
		$this->db->from( 'policy_adjusted_primas' );
		$this->db->join( 'work_order', 'work_order.policy_id=policy_adjusted_primas.policy_id' );
		$this->db->where_in('work_order.id', $ots);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				if (!isset($result[$row->ot_id]))
					$result[$row->ot_id] = array(
						'adjusted_prima' => $row->adjusted_prima,
						'due_date' => array($row->due_date)
					);
				else
					$result[$row->ot_id]['due_date'][] = $row->due_date;
			}
		}
		$query->free_result();
		return $result;
	}

}
/* End of file settings_model.php */
/* Location: ./application/models/settings_model.php */