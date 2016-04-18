<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Application {

    public function index() {
        //load all 3 tables information from model
        $players = $this->players->all_with_equity();
        $stocks = $this->stocks->all();
        $transactions = $this->transactions->all();
        //load game status
        $status = simplexml_load_file('http://bsx.jlparry.com/status');

        //getting stock columns
        for ($i = 0; $i < 5; $i++) {
            $stockarr[] = $this->parser->parse('Homepage/stock_table', (array) $stocks[$i], true);
        }

        if (sizeof($players) > 0) {
            //getting player columns
            foreach ($players as $player) {
                $playerarr[] = $this->parser->parse('Homepage/player_table', (array) $player, true);
            }
            //generate player
            $parms = array('table_open' => '<table class="table">'
            );
            $this->table->set_template($parms);
            $this->table->set_heading('Player', 'Cash', 'Equity');

            $rows = $this->table->make_columns($playerarr, 1);
            $this->data['playertable'] = $this->table->generate($rows);
        } else
            $this->data['playertable'] = 'no players exist';

        //generate stock
        $parm = array(
            'table_open' => '<table class ="table">'
        );

        $this->table->set_template($parm);

        $this->table->set_heading('Code', 'Name', 'Category', 'Value');
        $rows_stock = $this->table->make_columns($stockarr, 1);
        $this->data['stocktable'] = $this->table->generate($rows_stock);

        //generate transaction
        if (sizeof($transactions) > 0) {
            //getting transactions columns
            foreach ($transactions as $trans) {
                $tranarr[] = $this->parser->parse('Homepage/tran_table', (array) $trans, true);
            }

            $parms = array('table_open' => '<table class="table">');
            $this->table->set_template($parms);
            $this->table->set_heading('Seq', 'Datetime', 'Agent', 'Player', 'Stock', 'Trans', 'Quantity');
            $rows_tran = $this->table->make_columns($tranarr, 1);
            $this->data['transactiontable'] = $this->table->generate($rows_tran);
        } else
            $this->data['transactiontable'] = 'No data available';

        //display game status
        $this->data['gamenum'] = 'Game round number: ' . $status->round;
        $this->data['gamestatus'] = 'Game status: ' . $status->desc;
        //load view
        $this->data['pagebody'] = 'Homepage/homeview';

        //display login session
        if ($this->session->has_userdata('username')) {
            $this->data['logindata'] = '<a href="/login/logout">Logout</a>';
            $this->data['username'] = $this->session->userdata('username');
        } else {
            $this->data['logindata'] = '<a href="/login">Login</a>';
        }
        $this->render();
    }

}
