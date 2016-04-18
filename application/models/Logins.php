<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author a7823
 */
class Logins extends CI_Model 
{
    //put your code here
    function __construct()
    {
	parent::__construct();
    }
    
    //checks if the name and password match any entry in login data
    function login($name, $pass)
    {
         $query = $this->db->query('Select * From logindata '
                . 'Where name = "'.$name.'" and password = "'.$pass.'"');
         if(sizeof($query->result_array()) > 0)
         {
             return true;
         }
         else
         {
             return false;
         }
    }
    
    //return db's record unique id on specific player
    function checkid($name)
    {
        $query = $this->db->query('Select * From logindata '
                . 'Where name = "'.$name.'"');
         if(sizeof($query->result_array()) > 0)
         {
             return $query->result_array()["id"];
         }
         else
         {
             return null;
         }
    }
    
    //put a player into players table and login validation table
    function register($name, $pass)
    {
        $query = $this->db->query('Select * From logindata');
        $size = sizeof($query->result_array()) + 1;
        //each player has 1000 starting cash
        $cash = 1000;
        $this->db->query('Insert into logindata values("'.$size.'", "'.$pass.'", "'.$name.'");');
        $this->db->query('Insert into players values("'.$name.'", "'.$cash.'");');
    }
}
