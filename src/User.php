<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author pp
 */
abstract class User {
    protected $id;
    protected $email;
    protected $hashed_password;
    
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashed_password() {
        return $this->hashed_password;
    }

    
    abstract protected function checkLogin($email, $password);

    abstract protected function setEmail($email);

    abstract protected function setHashedPassword($password);

    abstract protected function isAdmin();
    
    final function login($username, $password) {
        if ($this->checkLogin($username, $password)) {
            return true;
        } else {
            return false;
        }
    }

}
