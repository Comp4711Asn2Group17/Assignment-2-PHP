<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Play
 *
 * @author a7823
 */
class Play extends Application {

    //put your code here

    //playing page
    public function index() {
        $status = simplexml_load_file('http://bsx.jlparry.com/status');
        //if game not in session goto error page
        if ($status->state != 2 && $status->state != 3) {
            if ($this->session->has_userdata('token')) {
                $this->session->unset_userdata('token');
            }
            $this->data['pagebody'] = 'errors/gamestate';
            $this->render();
        } else {
            //else if agent is registered and player is logged in, goto play page
            if ($this->session->has_userdata('token') && $this->session->has_userdata('username')) {
                $record = $this->players->newest();
                //if player isnt null, display player information
                if (sizeof($record) > 0) {
                    $this->data['name'] = $record[0]['Player'];
                    $this->data['cash'] = $record[0]['Cash'];
                    $this->data['equity'] = $this->players->get_equity($record[0]['Player']);
                    $this->data['image'] = '/data/' . $record[0]['Player'] . '.jpg';
                    $this->data['select_players'] = self::populate_options();

                    $stocks = $this->stocks->all();

                    //parse stock information to the tables layout file
                    foreach ($stocks as $stock) {
                        $stockarr[] = $this->parser->parse('buy', (array) $stock, true);
                    }

                    $parms = array(
                        'table_open' => '<table class="table">'
                    );
                    $this->table->set_template($parms);
                    $this->table->set_heading('Code', 'Name', 'Category', 'Value', 'Quantity', 'Buy');
                    //generate column and html content
                    $rows = $this->table->make_columns($stockarr, 1);
                    $this->data['stocks'] = $this->table->generate($rows);
                    $this->data['pagebody'] = 'play';
            $this->render();
                } else
                    redirect('/errors/records');
                //if user not logged in, direct to login
            } else if (!$this->session->has_userdata('username')) {
                redirect('/login');
                //if agent not set, register
            } else if(!$this->session->has_userdata('token')) {
                $url = 'http://bsx.jlparry.com/register';
                $data = array('team' => 'G17', 'name' => "bobsmith ", 'password' => 'tuesday');
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                $this->session->set_userdata('token', $result);
                redirect('/login');
            }
        }
    }

    //player dropdown menu
    public function populate_options() {
        $players = $this->players->all();
        foreach ($players as $player_record)
            $options[$player_record['Player']] = $player_record['Player'];

        $extra = 'id="playerlist" class="form-control" onchange="player_redirect()"';

        $select = form_dropdown('select_players', $options, $this->data['name'], $extra);
        return $select;
    }
    
    public function buy($code) {
        var_dump($this->session->userdata('token'));
        if($this->players->get($this->session->userdata('username'))['Cash'] >= 
                $this->stocks->selected($code)[0]['Value'] * 10)
        {
            $url = 'http://bsx.jlparry.com/buy';
                $data = array('team' => 'G17', 'token' => $this->session->userdata('token'), 
                    'player' => $this->session->userdata('username'),
                    'stock' => $code, 'quantity' => 10);
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                var_dump($result);
        } else echo "not enough cash";
    }
    
    public function sell($code)
    {
        
    }

}
