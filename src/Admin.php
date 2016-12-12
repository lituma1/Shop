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

class Admin extends User {

    protected $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id = -1;
        $this->email = '';
        $this->hashed_password = '';
        $this->name = '';
    }

    function isAdmin() {
        return true;
    }

    static function loadAdminById($pdo, $id) {
        $sql = "SELECT * FROM Admin WHERE id=$id";
        $query = $pdo->prepare($sql);
        $query->execute();
        $admin = $query->fetch(PDO::FETCH_ASSOC);
        $loadedAdmin = new Admin($pdo);
        $loadedAdmin->setEmail($admin['email']);
        $loadedAdmin->id = $id;
        $loadedAdmin->setHashedPassword($admin['hashed_password']);
        $loadedAdmin->setName($admin['name']);
        return $loadedAdmin;
    }

    static function loadAllAdmins($pdo) {
        $admins = [];
        $sql = "SELECT * FROM Admin";
        $query = $pdo->prepare($sql);
        $query->execute();
        $array = $query->fetchAll();
        foreach ($array as $admin) {
            $loadedAdmin = new Admin($pdo);
            $loadedAdmin->setEmail($admin['email']);
            $loadedAdmin->id = $admin['id'];
            $loadedAdmin->setHashedPassword($admin['hashed_password']);
            $loadedAdmin->setName($admin['name']);
            $admins[] = $loadedAdmin;
        }
        return $admins;
    }

}
