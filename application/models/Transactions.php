<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Contacts table.
 */
class Transactions extends CI_Model 
{

    // Constructor
    function __construct() 
    {
        parent::__construct();

    }

    //grab the data from server and populate the database
    function init($values)
    {
        $query = $this->db->query("DELETE FROM transactions");
        for($i = 1; $i < sizeof($values); $i++)
        {
            $tran = str_getcsv($values[$i], ",");
            $query = $this->db->query('Insert into transactions values("'.$tran[0].'","'.$tran[1].'",'
                    . '"'.$tran[2].'","'.$tran[3].'","'.$tran[4].'","'.$tran[5].'","'.$tran[6].'")');
        }
    }
    
    // return all transactions
    function all() 
    {
        $this->db->order_by("DateTime", "asc");
        $query = $this->db->get('transactions');
        return $query->result_array();
    }

    //get all transaction belonging to one player
    public function get_all_by_player($which) 
    {

        $sql = "SELECT * FROM transactions WHERE Player = ?";

        $query = $this->db->query($sql, array($which));
        if ($query->num_rows() > 0)
            return $query->result_array();

        return null;
    }

    //get the value of a specific stock
    public function get_stock_value($stock) 
    {
        $stock_value = null;

        $sql = "SELECT  s.Value "
                . "FROM stocks s "
                . "WHERE s.Code = '"
                . $stock
                . "'";

        $query = $this->db->query($sql)->result_array();

        if (!empty($query)) {
            $stock_value = $query[0]['Value'];
        }

        return $stock_value;
    }
    
    //get transactions belonging to a stock
    public function get_stock($stock)
    {
        $stock_value = null;

        $sql = "SELECT  * "
                . "FROM transactions t "
                . "WHERE t.Stock = '"
                . $stock
                . "'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}
