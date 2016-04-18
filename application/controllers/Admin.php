<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author a7823
 */
class Admin extends Application {

    //Checks game state information
    public function index() {
        $status = simplexml_load_file('http://bsx.jlparry.com/status');
        $this->data['gamenum'] = 'Game round number: ' . $status->round;
        $this->data['gamestatus'] = 'Game status: ' . $status->desc;
        $this->data['countdown'] = 'Count down: ' . $status->countdown;

        if ($this->session->has_userdata('username')) {
            $this->data['logindata'] = '<a href="/login/logout">Logout</a>';
            $this->data['username'] = $this->session->userdata('username');
        } else {
            $this->data['logindata'] = '<a href="/login">Login</a>';
        }
        $this->data['pagebody'] = 'admin';
        $this->render();
    }

    //reload all data into database then redirect to homepage
    public function reload() {
        $this->init();
        redirect('./');
    }

}
