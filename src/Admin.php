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
require_once 'User.php';
class Admin extends User{
    protected $pdo;
    
    
    function __construct($pdo){
        $this->pdo = $pdo;
        $this->id = -1;
        $this->email = '';
        $this->hashed_password = '';
        $this->name = '';
        
    }

    function isAdmin() {
        return true;
    }

    
}
