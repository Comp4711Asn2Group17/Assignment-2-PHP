<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author a7823
 */
class Application extends CI_Controller { 
    protected $data = array();
    
    function __construct()
    {
	parent::__construct();
        
        //grab data from server and populate every table
        $this->init();
        
        //initialize all values
	$this->data = array();
        $this->load->helper(array('common', 'url')); 
	$this->data['pagetitle'] = 'PHP Assignment Group 17';
        $this->data['logindata'] = '<a href="./login">Login</a>';
        $this->data['username'] = '';
    }
    
    //update all database
    function init()
    {
        $stock = 'http://bsx.jlparry.com/data/stocks';
        $movement = 'http://bsx.jlparry.com/data/movement';
        $transaction = 'http://bsx.jlparry.com/data/transactions';
        
        $stocks = str_getcsv($this->getContent($stock), "\n");
        $this->stocks->init($stocks);
        
        $movements = str_getcsv($this->getContent($movement), "\n");
        $this->movement->init($movements);
        
        $transactions = str_getcsv($this->getContent($transaction), "\n");
        $this->transactions->init($transactions);
    }
    
    //getting csv data
    function getContent($url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
    
    //loads page with existing template
    function render() {
        
	$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
	$this->data['data'] = &$this->data;
	$this->parser->parse('_template', $this->data);
    }
}
