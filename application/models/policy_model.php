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
  Update adjusted prima in `policy_adjusted_primas` for one given OT
 **/
    public function update_adjusted_primas($ot_id = FALSE, $policy_id = FALSE, $new_prima = FALSE)
	{
		return TRUE;
		if (!$ot_id || !$policy_id || ($new_prima === FALSE))
			return FALSE;
		$result = TRUE;

		$this->db->order_by('due_date', 'asc');
		$query = $this->db->get_where('policy_adjusted_primas', 
			array('policy_id' => $policy_id), 1, 0);
		if ($query->num_rows() == 0)
			return $result;
		$old_policy_adjusted_prima = $query->row();
		$start_date = $old_policy_adjusted_prima->due_date . ' 00:01:00';

		$this->db->select('`work_order`.`work_order_status_id`, `work_order`.`product_group_id`, `work_order_types`.`patent_id`, `policies`.`id`, `policies`.`prima`, `policies`.`payment_interval_id`, `policies`.`date`, `extra_payment`.`extra_percentage`', FALSE);
		$this->db->from(array('work_order', 'work_order_types', 'policies', 'products', 'extra_payment'));
		$this->db->where("
`work_order`.`id` = '$ot_id'
AND
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

		$query = $this->db->get();
		$new_rows = array();
		foreach ($query->result_array() as $row)
		{
			$row['date'] = $start_date;
			$this->_prepare_adjusted_primas($row, $new_rows);
		}
log_message('error', print_r($row, true));
log_message('error', print_r($new_rows, true));
		if ($new_rows)
		{
			if ($this->db->delete('policy_adjusted_primas', 
				array('policy_id' => $new_rows[0]['policy_id'])))
			{
log_message('error', $this->db->last_query());
				$result = $this->db->insert_batch('policy_adjusted_primas', $new_rows);
log_message('error', $this->db->last_query());
			}
			else
			{
log_message('error', $this->db->last_query());
				$result = FALSE;
			}
		}
		return $result;
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

/**
  Deletes rows of table policy_adjusted_prima for a given policy and given dates
 **/
    public function delete_adjusted_primas($policy_dates = array())
	{
		$deleted = 0;
		$to_delete = count($policy_dates);
		foreach ($policy_dates as $policy_date)	
		{
			$policy_date_arr = explode('_', $policy_date);
			if (isset($policy_date_arr[0]) && isset($policy_date_arr[1]))
			{
				$where = array('policy_id' => $policy_date_arr[0], 'due_date' => $policy_date_arr[1]);
				$this->db->delete('policy_adjusted_primas', $where);
				if ($this->db->affected_rows())
					$deleted++;
			}
		}
		return ($deleted >= $to_delete);
	}

/**
  Script to compute (initialize) `policies`.`prima_entered`
  (special attention to rows with currency_id USD)
 **/
    public function init_policy_prima_entered()
	{
		$result = array('mxn' => 0, 'usd' => 0);
// 1. process policies entered in MXN if any: just copy `prima` into `prima_entered'
		$this->db->select( 'prima_entered' );
		$query = $this->db->get_where('policies',
			'prima is NOT NULL AND prima_entered is NULL AND currency_id = 1', 1);

		if ($query->num_rows() > 0)
		{
			$query->free_result();
			$this->db->flush_cache();
			$to_update = array();
			$this->db->select( 'id, prima' );
			$query = $this->db->get_where('policies',
				'prima is NOT NULL AND prima_entered is NULL AND currency_id = 1');
			foreach ($query->result() as $row)
			{
				$to_update[] = array(
					'id' => $row->id,
					'prima_entered' => $row->prima
				);
			}
			$query->free_result();
			$this->db->flush_cache();
//			$this->db->update_batch('policies', $to_update, 'id'); // CI bug
			$result['mxn'] = $this->update_batch('policies', $to_update, 'id');
		}

// 2. process polcies entered in USD: just copy `prima` into `prima_entered'
		$this->db->flush_cache();
		$this->db->select( 'prima_entered' );
		$query = $this->db->get_where('policies',
			'prima is NOT NULL AND prima_entered is NULL AND currency_id = 2', 1);

		if ($query->num_rows() > 0)
		{
			$query->free_result();
			$this->db->flush_cache();
			$to_update = array();
			$this->db->select( 
				'policies.id as policy_id, policies.prima, policies.last_updated, exchange_rates.id as xrate_id, exchange_rates.date, exchange_rates.rate' );
			$this->db->join( 'exchange_rates',
				'exchange_rates.date=DATE(policies.last_updated)', 'right' );
			$query = $this->db->get_where('policies',
				'policies.prima is NOT NULL AND policies.prima_entered is NULL AND policies.currency_id = 2');
			$ne_rates = array();
			foreach ($query->result() as $row)
			{
				if ($row->rate == 'N/E')
				{
					$ne_rates[] = $row;
				}
				else
				{
					$to_update[] = array(
						'id' => $row->policy_id,
						'prima_entered' => $row->prima / $row->rate,
					);
				}
			}
			foreach ($ne_rates as $ne_rate)
			{
				$this->db->flush_cache();
				$this->db->select( 'rate' );
				$this->db->order_by('date', 'DESC');
				$rate_query = $this->db->get_where('exchange_rates',
					"date < '" . $ne_rate->date . "' and rate != 'N/E'", 1);
				if ($query->num_rows() > 0)
				{
					$rate_row = $rate_query->row();
					$to_update[] = array(
						'id' => $ne_rate->policy_id,
						'prima_entered' => $ne_rate->prima / $rate_row->rate,
					);
				}
				else
				{
					echo "Falta el tipo cambio para convertir la prima de una poliza. Informe al administrador.";
					exit;
				}
				$rate_query->free_result();
			}

			$query->free_result();
			$this->db->flush_cache();
//			$this->db->update_batch('policies', $to_update, 'id'); // CI bug
			$result['usd'] = $this->update_batch('policies', $to_update, 'id');
		}
		return $result;
	}

/**
  Update batch - workaround for the CI method not working
 **/
    public function update_batch($table, $to_update, $id)
	{
		$this->db->flush_cache();
		$where_array = array();
		$update_string = "UPDATE `$table` SET `prima_entered` = CASE";
		foreach ($to_update as $policy_row)
		{
			$update_string .= sprintf("\nWHEN `$id` = '%s' THEN '%s'",
				$policy_row[$id], $policy_row['prima_entered']);
			$where_array[] = "'" . $policy_row[$id] .  "'";
		}
		if ($where_array)
		{
			$update_string .= "\nELSE `prima_entered` END
WHERE `id` IN (" . implode(',', $where_array) . ")";
			$this->db->query($update_string);
			return $this->db->affected_rows();
		}
		return 0;
    }

}
/* End of file policy_model.php */
/* Location: ./application/models/policy_model.php */