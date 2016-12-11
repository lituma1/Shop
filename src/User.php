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
    
    protected $pdo;
    protected $id;
    protected $email;
    protected $hashed_password;
    protected $name;

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashedPassword() {
        return $this->hashed_password;
    }
    function getName(){
        return $this->name;
    }
    function setName($name){
        $this->name = $name;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }

    function setHashedPassword($password) {
        $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->hashed_password = $newHashedPassword;
    }
    
    function checkLoginAndPassword($email, $password) {
        if ($this->email == $email && password_verify($password, $this->getHashedPassword())) {
            return true;
        } else {
            return false;
        }
    }

    abstract protected function isAdmin();
}
