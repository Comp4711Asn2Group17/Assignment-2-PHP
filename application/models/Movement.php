<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Movement
 *
 * @author a7823
 */
class Movement extends CI_Model {
    // Constructor
    function __construct()
    {
	parent::__construct();

    }
    //grabs the data from the server and populate the database
    function init($values)
    {
        $query = $this->db->query("DELETE FROM movement");
        for($i = 1; $i < sizeof($values); $i++)
        {
            $move = str_getcsv($values[$i], ",");
            $query = $this->db->query('Insert into movement values("'.$move[0].'","'.$move[1].'",'
                    . '"'.$move[2].'","'.$move[3].'","'.$move[4].'")');
        }
    }
    
    // return all images desc order by post date
    function all()
    {
        $this->db->order_by("Datetime", "asc");
        $query = $this->db->get('movement');
        return $query->result_array();
    }
    
    //return the newest movement record
    function newest() 
    {
        $this->db->order_by("Datetime", "asc");
        $this->db->limit(1);
        $codes = $this->db->get('movement');
        $code = $codes->result_array()[0]['Code'];
        $query = $this->db->query('Select * From movement '
                . 'Where Code = "'.$code.'"');
        return $query->result_array();
    }
    
    //return the movement of a selected stock
    function selected($code) {
        $query = $this->db->query('Select * from movement Where Code = "'.$code.'"');
        return $query->result_array();
    }
}