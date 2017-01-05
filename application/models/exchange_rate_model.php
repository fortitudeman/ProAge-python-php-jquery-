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
class Exchange_rate_model extends CI_Model
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
  Get current exchange rate from www.banxico.org.mx
 **/
	public function get_from_banxico()
	{
		$yesterday = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
		$query = $this->db->get_where('exchange_rates',
			"date >= '$yesterday'");

		if ($query->num_rows() > 0)
		{
			return NULL;
		}
		$result = FALSE;

		$getContents = @file_get_contents(
			'http://www.banxico.org.mx/rsscb/rss?BMXC_canal=fix&BMXC_idioma=es');
		if ($getContents === FALSE)
		{
			$this->handle_error('No respuesta del sitio www.banxico.org.mx. Informe al administrador.');
			return $result;
		}
		$getContents = str_replace(["rdf:", "dc:", "cb:" ], ["", "", ""],
			$getContents);  // to be able to parse the xml
		$xml = (array) simplexml_load_string($getContents, null, LIBXML_NOCDATA);
		if (!$xml)
		{
			$this->handle_error('Leyendo la rspuesta del sitio www.banxico.org.mx: no se pudo analizar el xml. Informe al administrador.');
			return $result;
		}
		$json = json_encode($xml);
		$json_decoded = json_decode($json, true);

		if (empty($json_decoded['item']['date']) ||
			empty($json_decoded['item']['statistics']['exchangeRate']['value'])
			)
		{
			$this->handle_error('No se pudo leer campos en la respuesta del sitio www.banxico.org.mx. Informe al administrador.');
			return $result;
		}
		$response_date = substr($json_decoded['item']['date'], 0, 10);
		if (($response_date != $yesterday) && ($response_date != date('Y-m-d')))
		{
			$this->handle_error('No se pudo leer el campo &lt;date/&gt; en la respuesta del sitio www.banxico.org.mx. Informe al administrador.');	
			return $result;
		}

		$response_value = $json_decoded['item']['statistics']['exchangeRate']['value'];
		if (!preg_match('/^([0-9]*[.])?[0-9]+$/', $response_value) &&
			(strtoupper($response_value) != 'N/E'))
		{
			$this->handle_error('No se pudo leer el campo &lt;value/&gt; en la respuesta del sitio www.banxico.org.mx. Informe al administrador.');	
			return $result;
		}

		$now = date('Y-m-d H:i:s');
		$data = array('date' => $response_date, 
			'rate' => $response_value,
			'created_at' => $now,
			'updated_at' => $now
		);
		$result = $this->db->insert('exchange_rates', $data);
		if (!$result)
		{
			$this->handle_error('No se pudo actualizar el tipo de cambio en la base de datos. Informe al administrador.');	
		}
		return $result;
	}

	private function handle_error($message)
	{
		echo $message;
	}
}
/* End of file exchange_rate_model.php */
/* Location: ./application/models/exchange_rate_model.php */