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

    function SaveToDb($pdo) {
        if ($this->id == -1) {
            $name = $this->getName();
            $email = $this->getEmail();
            $hashed_password = $this->getHashedPassword();
            $sql = "INSERT INTO Admin (email, hashed_password, name) VALUES ('$email', '$hashed_password', '$name')";
            $query = $pdo->prepare($sql);
            $query->execute();
        } else {
            $id = $this->getId();
            $name = $this->getName();
            $email = $this->getEmail();
            $hashed_password = $this->getHashedPassword();
            $sql = "UPDATE Admin SET name= '$name', email= '$email', hashed_password= '$hashed_password' WHERE id=$id";
            $query = $pdo->prepare($sql);
            $query->execute();
            
        }
    }
    static function deleteAdmin($pdo, $id){
        $sql = "DELETE FROM Admin WHERE id=$id";
        $query = $pdo->prepare($sql);
        $query->execute();
    }
    static function createAdmin($pdo, $email, $password, $name){
        $admin = new Admin($pdo);
        $admin->setEmail($email);
        $admin->setHashedPassword($password);
        $hashedPassword = $admin->getHashedPassword();
        $admin->setName($name);
        $sql = "INSERT INTO Admin (email, hashed_password, name) VALUES ('$email', '$hashedPassword', '$name')";
        $query = $pdo->prepare($sql);
        $query->execute();
        //Ta wersja prostsza niż w Customer też działa
        $id = $pdo->lastInsertId();
        $admin->id = $id;
        return $admin;
    }

}
