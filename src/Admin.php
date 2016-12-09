<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author pp
 */
class Admin extends User{
    
    private $name;
    
    function __construct(){
        $this->id = -1;
        $this->email = '';
        $this->hashed_password = '';
        $this->name = '';
        
    }
    function checkLogin($email, $password) {
        if($this->$email == $email && password_verify($password, $this->getPassword())){
            return true;
        } else {
            return false;
        }
    }

    function isAdmin() {
        return true;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setHashedPassword($password) {
        $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
    }

//put your code here
}
