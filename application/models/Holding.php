<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Holding
 *
 * @author a7823
 */
class Holding extends CI_Model{
    //put your code here
    function __construct()
    {
	parent::__construct();
    }
    
    //adding an entry to the holding table
    function buy($player,$stock,$cert)
    {
        
    }
    
    //removing an entry from the holding table
    function sell($player,$stock,$cert)
    {
        
    }
    
    //minus 10 quantity from specific record in holding table
    function sellPart($cert)
    {
        $quantity = $this->db->query('select Quantity from holding '
                . 'where certificate = "'.$cert.'"');
        $newQuantity = $quantity - 10;
        $query = $this->db->query('update holding set Quantity = '.$newQuantity.' '
                . 'where certificate = "'.$cert.'"');
    }
    
    //add 10 quantity from specific record in holding table
    function buyPart($cert)
    {
        $quantity = $this->db->query('select Quantity from holding '
                . 'where certificate = "'.$cert.'"');
        $newQuantity = $quantity + 10;
        $query = $this->db->query('update holding set Quantity = '.$newQuantity.' '
                . 'where certificate = "'.$cert.'"');
    }
    
    //return quantity available for a specific entry
    function amountHad($cert)
    {
        $query = $this->db->query('select Quantity from holding where certificate = "'.$cert.'"');
    }
    
    //return all holding table entries
    function all()
    {
        $query = $this->db->query('select * from holding');
        return $query->result_array();
    }
}
