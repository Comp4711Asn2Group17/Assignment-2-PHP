<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends Application{
    
    function index() 
    {
        $this->data['pagebody'] = 'Login/login';
        $this->render();              
    }
    
    function logout()
    {
        //unset user session
        $this->session->unset_userdata('username');
        redirect('./');
    }
     
}?>
