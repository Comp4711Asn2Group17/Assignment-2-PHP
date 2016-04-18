<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player extends Application {

    //player index page
	public function index()
	{  
            //set template and grab first player record
            $this->data['pagebody'] = 'player/portfolio';
            $record = $this->players->newest();
            
            //if there are records then load table, else error message
            if(sizeof($record) > 0)
            {
                //player information panel
            $this->data = array_merge($this->data, $record);
            $this->data['name'] = $record[0]['Player'];
            $this->data['cash'] = $record[0]['Cash'];
            $this->data['image'] = '/data/'.$record[0]['Player'].'.jpg';
            
            $transactions_parms['transactions'] = self::transaction_get_all_by_player("Donald");
            
            //get all transcation history
            if(sizeof($transactions_parms) > 0)
                $this->data['transactions'] = $this->parser->parse('transactions',$transactions_parms, true);
            else
                $this->data['transactions'] = 'No records exist';
            //get player dropdown
            $this->data['select_players'] = self::populate_options();
            
            //login session
            if($this->session->has_userdata('username'))
            {
                $this->data['logindata'] = '<a href="/login/logout">Logout</a>';
                $this->data['username'] = $this->session->userdata('username');
            }
            else
            {
                $this->data['logindata'] = '<a href="/login">Login</a>';
            }   
            } else $this->data['pagebody'] = '/errors/records';
            $this->render();
	}
        
        //this creates the player dropdown menu
        public function populate_options()
        {
            $players = $this->players->all();
            foreach ($players as $player_record)
                $options[$player_record['Player']] =  $player_record['Player'];

            $extra = 'id="playerlist" class="form-control" onchange="player_redirect()"'; 
            
            $select = form_dropdown('select_players', $options, $this->data['name'], $extra);
            return $select;
        }
        
        //same as index but instead renders information of a particular player
        public function portfolio($player)
        {
            $this->data['pagebody'] = 'player/portfolio';
           
            $record = $this->players->get($player);
            
            //if there are records then load table, else error message
            if(sizeof($record) > 0)
            {
            $this->data = array_merge($this->data, $record);
            $this->data['name'] = $record['Player'];
            $this->data['cash'] = $record['Cash'];
            $this->data['image'] = '/./data/'.$record['Player'].'.png';

            //transaction table
            $transactions_parms['transactions'] = self::transaction_get_all_by_player($player);
            
            $this->data['transactions'] = $this->parser->parse('transactions',$transactions_parms, true);

            //dropdown menu
            $this->data['select_players'] = self::populate_options();
            
            //session tabs
            if($this->session->has_userdata('username'))
            {
                $this->data['logindata'] = '<a href="/login/logout">Logout</a>';
                $this->data['username'] = $this->session->userdata('username');
            }
            else
            {
                $this->data['logindata'] = '<a href="/login">Login</a>';
            }
            } else $this->data['pgaebody'] = '/errors/records';
            $this->render();
        }
        
        //renders the transactino table
        public function transaction_get_all_by_player($player)
        {
           
            $transactions = $this->transactions->get_all_by_player($player);

            if($transactions !== null) {
                foreach ($transactions as $transaction)
                    $transaction_rows[] = (array) $transaction;
                
                return $transaction_rows;
            }
            return null;
        }    
}

