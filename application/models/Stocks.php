<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Stocks table.
 */
class Stocks extends CI_Model {
    // Constructor
    function __construct()
    {
	parent::__construct();
        
    }
    //grabs data from server and populates database
    function init($values)
    {
        $query = $this->db->query("DELETE FROM stocks");
        for($i = 1; $i < sizeof($values); $i++)
        {
            $stock = str_getcsv($values[$i], ",");
            $query = $this->db->query('Insert into stocks values("'.$stock[0].'","'.$stock[1].'",'
                    . '"'.$stock[2].'","'.$stock[3].'")');
        }
    }
    
    // return all images desc order by post date
    function all()
    {
        $this->db->order_by("Code", "asc");
        $query = $this->db->get('stocks');
        return $query->result_array();
    }
    
    //grbas the most recently moved stock
    function newest() 
    {
        $this->db->order_by("Datetime", "asc");
        $this->db->limit(1);
        $codes = $this->db->get('movement');
        $code = $codes->result_array()[0]['Code'];
        $query = $this->db->query('Select * From stocks '
                . 'Where Code = "'.$code.'"');
        return $query->result_array();
    }
    
    //return a specific stock by its code
    function selected($code)
    {
        $query = $this->db->query('Select * from stocks Where Code = "'.$code.'"');
        return $query->result_array();
    }
    
    //return all codes of all stocks
    function codes() {
        $query = $this->db->query("Select Code from stocks");
        return $query->result_array();
    }
}