<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockController
 *
 * @author a7823
 */
class Stock extends Application {

    //Default landing for the stock page. This loads the stock with newest movements.
    public function index() {
        //Grabs the information stored in the database.(stock and stock movements)
        $movements = $this->movement->newest();
        $stocks = $this->stocks->newest();
        $transactions = $this->transactions->get_stock($stocks[0]['Code']);


        //parse information to the tables layout file
        foreach ($stocks as $stock) {
            $stockarr[] = $this->parser->parse('Stocks/stock_table', (array) $stock, true);
        }

        //define a class for the table for css use
        $parms = array(
            'table_open' => '<table class="table">'
        );
        $this->table->set_template($parms);
        $this->table->set_heading('Code', 'Name', 'Category', 'Value');
        //generate column and html content
        $rows = $this->table->make_columns($stockarr, 1);
        $this->data['stocktable'] = $this->table->generate($rows);


        $this->table->set_heading('Seq','Datetime', 'Code', 'Action', 'Amount');
        foreach ($movements as $moves) {
            $movementarr[] = $this->parser->parse('Stocks/movement_table', (array) $moves, true);
        }

        $parm = array(
            'table_open' => '<table class ="table">'
        );

        $this->table->set_template($parm);

        $rows_movement = $this->table->make_columns($movementarr, 1);
        $this->data['movementtable'] = $this->table->generate($rows_movement);

        if (sizeof($transactions) > 0) {
            //getting transactions columns
            foreach ($transactions as $trans) {
                $tranarr[] = $this->parser->parse('Homepage/tran_table', (array) $trans, true);
            }

            $parms = array(
                'table_open' => '<table class="table">'
            );
            $this->table->set_template($parms);
            $this->table->set_heading('Seq','Datetime', 'Agent','Player', 'Stock', 'Type', 'Quantity');
            //generate column and html content
            $rows_tran = $this->table->make_columns($tranarr, 1);
            $this->data['transtable'] = $this->table->generate($rows_tran);
        } else $this->data['transtable'] = "No records exist.";

        //define main view for the content and the drop down menu
        $this->data['pageselect'] = Self::populate_options();
        $this->data['pagebody'] = 'Stocks/stockview';

        //set user session tab
        if ($this->session->has_userdata('username')) {
            $this->data['logindata'] = '<a href="/login/logout">Logout</a>';
            $this->data['username'] = $this->session->userdata('username');
        } else {
            $this->data['logindata'] = '<a href="/login">Login</a>';
        }
        $this->render();
    }

    //landing page when a specific stock has been passed in the url.
    //loads that particular stock's information and movement history
    function picked_stocks($code) {
        //grab informatino from database.

        $movements = $this->movement->selected($code);
        $stocks = $this->stocks->selected($code);
        $transactions = $this->transactions->get_stock($code);

        //set table layout and view
        foreach ($stocks as $stock) {
            $stockarr[] = $this->parser->parse('Stocks/stock_table', (array) $stock, true);
        }

        $parms = array(
            'table_open' => '<table class="table">'
        );
        $this->table->set_template($parms);

        //generate html elements
        $this->table->set_heading('Code', 'Name', 'Category', 'Value');
        $rows = $this->table->make_columns($stockarr, 1);
        $this->data['stocktable'] = $this->table->generate($rows);

        foreach ($movements as $moves) {
            $movementarr[] = $this->parser->parse('Stocks/movement_table', (array) $moves, true);
        }

        $parm = array(
            'table_open' => '<table class ="table">'
        );

        $this->table->set_template($parm);

        $rows_movement = $this->table->make_columns($movementarr, 1);
        $this->data['movementtable'] = $this->table->generate($rows_movement);

         if (sizeof($transactions) > 0) {
            //getting transactions columns
            foreach ($transactions as $trans) {
                $tranarr[] = $this->parser->parse('Homepage/tran_table', (array) $trans, true);
            }

            $parms = array(
                'table_open' => '<table class="table">'
            );
            $this->table->set_template($parms);
            $this->table->set_heading('Seq','Datetime', 'Player', 'Agent', 'Stock', 'Type', 'Quantity');
            //generate column and html content
            $rows_tran = $this->table->make_columns($tranarr, 1);
            $this->data['transtable'] = $this->table->generate($rows_tran);
        } else $this->data['transtable'] = "No records exist.";

        //generate drop down menu and tables
        $this->data['pageselect'] = Self::populate_options();
        $this->data['pagebody'] = 'Stocks/stockview';

        //set login session
        if ($this->session->has_userdata('username')) {
            $this->data['logindata'] = '<a href="/login/logout">Logout</a>';
            $this->data['username'] = $this->session->userdata('username');
        } else {
            $this->data['logindata'] = '<a href="/login">Login</a>';
        }
        $this->render();
    }

    //creates a drop down menu populated with stock codes
    function populate_options() {

        //make a drop down form and add onclick function to it.
        $this->load->helper('form');
        $entries = $this->stocks->codes();
        $js = 'id="stocklist" onChange="stock_onclick();"';
        $newArr = array();
        $newArr[""] = "Please Select";
        //making a new array to add a null option and better formating
        foreach ($entries as $loopArr) {
            $temp = $loopArr['Code'];
            $newArr[$temp] = $loopArr['Code'];
        }
        return form_dropdown('stock', $newArr, null, $js);
    }

}
