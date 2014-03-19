<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation{
    
    public function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------
    /**
     * Validates against indices of an array
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   boolean
     */
    function src_is_array_index($str, $allowed)
    {
        $result = $this->_src_check_array_index($str, $allowed);
        if (!$result)
            $this->set_message('src_is_array_index', 'El campo %s no tiene tener un valor v�lido.');
        return $result;
    }

    // --------------------------------------------------------------------
    /**
     * Validates against values of an array
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   boolean
     */
    function src_is_array_value($str, $allowed)
    {
        $result = $this->_src_check_array_index($str, $allowed, FALSE);
        if (!$result)
            $this->set_message('src_is_array_value', 'El campo %s no tiene tener un valor v�lido.');
        return $result;
    }

    // --------------------------------------------------------------------
    /**
     * Validates against an array (index or value)
     *
     * @access   private
     * @param    string
     * @param    array
     * @param    boolean
     * @return   boolean
     */
    function _src_check_array_index($str, $allowed, $on_index = TRUE)
    {
        $result = TRUE;
        $CI = & get_instance();
        if (($allowed_array = $CI->config->item($allowed)) === FALSE)
            $result = FALSE;
        elseif (!is_array($allowed_array))
            $result = FALSE;
        else {
            if ($on_index)
                $result = isset($allowed_array[$str]);
            else
                $result = in_array($str, $allowed_array);
        }
        return $result;
    }

    // --------------------------------------------------------------------
    /**
     * Validates is not array index
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   boolean
     */
    public function src_is_not_array_index($str, $not_allowed) {
        $result = TRUE;
        $CI = & get_instance();
        if (($not_allowed_array = $CI->config->item($not_allowed)) === FALSE)
            $result = FALSE;
        elseif (!is_array($not_allowed_array))
            $result = FALSE;
        else
            $result = !isset($allowed_array[$str]);
        if (!$result)
            $this->set_message('src_is_not_array_index', 'El campo %s no tiene tener un valor v�lido');
        return $result;
    }
    // --------------------------------------------------------------------
    /**
     * Validates is decimal or integer
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   boolean
     */
	public function decimal_or_integer($str)
	{
        $result = $this->decimal($str) || $this->integer($str);
        if (!$result)
            $this->set_message('decimal_or_integer', 'El campo %s debe contener un n�mero decimal o entero.');
        return $result;
	}
}
