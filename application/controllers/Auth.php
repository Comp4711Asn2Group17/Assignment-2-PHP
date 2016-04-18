<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author a7823
 */
class Auth extends Application
{
    //the login handling page
    public function index()
    {
        //if form information not null
        if($_POST["username"] != null && $_POST["password"] != null)
        {
            //if admin, redirect to admin only page
            if(strcmp($_POST["username"],"admin") == 0
                        && strcmp($_POST["password"],"letmein") == 0)    
            {
                $this->session->set_userdata('username', $_POST["username"]);
                redirect('/admin');
                //else if everything matchs, log the user in
            } else if($this->logins->login($_POST["username"],$_POST["password"]))
            {
                $this->session->set_userdata('username', $_POST["username"]);
                redirect('/');
            }
            else //error message on failed login attempt
            {
                echo "password and username doesn't match.";
            }
        } 
        else if($_POST["username"] == null)
        {
            echo "username is null";
        }
        else
        {
            echo "password is null";
        }
    }
    
    //registers a player into the database
    public function register()
    {
         if($_POST["username"] != null && $_POST["password"] != null)
        {
             //store user in db
            $this->logins->register($_POST["username"], $_POST["password"]);
            //move image to data folder
            $destFile = "/data/".$_POST["username"].'.jpg';
            move_uploaded_file($_FILES['images']['tmp_name'], $destFile );
            //redirect to login
            redirect('/login');
        } 
        else if($_POST["username"] == null)
        {
            echo "username is null";
        }
        else
        {
            echo "password is null";
        }
    }
}
