<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Register
 *
 * @author a7823
 */
class Register extends Application {
    //put your code here
    public function index()
    {
        $this->data['pagebody'] = 'Login/register';
        $this->render(); 
    }
}
