<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Customer
 *
 * @author pp
 */
class Customer extends User {
    private $name;
    private $surname;
    private $address;
    private $history;
    
    function __construct(){
        $this->id = -1;
        $this->email = '';
        $this->hashed_password = '';
        $this->name = '';
        $this->surname = '';
        $this->address = '';
        $this->history = [];
    }
    function getName() {
        return $this->name;
    }
    

    function getSurname() {
        return $this->surname;
    }

    function getAddress() {
        return $this->address;
    }

    function getHistory() {
        return $this->history;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashed_password() {
        return $this->hashed_password;
    }

    function checkLogin($email, $password) {
        if($this->$email == $email && password_verify($password, $this->getPassword())){
            return true;
        } else {
            return false;
        }
    }

    function isAdmin() {
        return false;
    }

    function setEmail($email) {
        $this->$email;
    }

    function setHashedPassword($password) {
        $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
    }

//put your code here
}
