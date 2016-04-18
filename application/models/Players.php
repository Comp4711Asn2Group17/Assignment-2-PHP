<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Contacts table.
 */
class Players extends CI_Model {
    // Constructor
    function __construct()
    {
	parent::__construct();
	//$this->setTable('contacts', 'ID');
    }
    
    // return all players
    function all()
    {

        $this->db->order_by("Player", "asc");
        $query = $this->db->get('players');
        return $query->result_array();
        
    }
    
    //return the player with name in alphabetical order
    function newest()
    {
        $this->db->order_by("Player", "asc");
        $this->db->limit(1);
        $query = $this->db->query('Select * From players');
        return $query->result_array();
    }
    
    //return all players with equity attached
    function all_with_equity()
    {
        $players = $this->players->all();
        
        $playerarr = array();
        
        foreach($players as $player)
        {
            $item = array('Player' => $player['Player'],
                          'Cash'   => $player['Cash'], 
                          'Equity' => (
                                        ($this->players->get_equity($player['Player'])
                                        + 
                                        $player['Cash']
                                        )
                                      )
                         );
            
            
            array_push($playerarr, $item);
        }
        
        
        return $playerarr;
    } 
    
    //return a specific player based on name
    public function get($which)
    {

        $sql = 'SELECT * FROM players WHERE Player = "'.$which.'";'; 
           
        $query = $this->db->query($sql, array($which));
        $row = $query->row_array();

        return $row;
        //return null;
    }
    
    //get a specific players equity
    public function get_equity($player)
    {
        $equity = 0;
        $sql  = "SELECT t.Stock, t.Quantity, t.Trans "
                        ."FROM transactions t "
                        ."WHERE t.Player = '"  
                        .$player
                        ."'";
        
        $query_rows = $this->db->query($sql)->result_array();

        foreach($query_rows as $row)
        {
            $stock_value = ($this->transactions->get_stock_value($row['Stock']))
                           *
                           $row['Quantity'];
            
            if($row['Stock'] == "buy")
            {
                $equity += $stock_value;
            }
            else
            {
                $equity -= $stock_value;
            }
        }
        
        return $equity;
    }
}

