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
require_once 'User.php';
require_once 'Message.php';
class Customer extends User {

    protected $pdo;
    private $surname;
    private $address;
    private $history;

    function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id = -1;
        $this->email = '';
        $this->hashed_password = '';
        $this->name = '';
        $this->surname = '';
        $this->address = '';
        $this->history = [];
    }

    function getSurname() {
        return $this->surname;
    }

    function getAddress() {
        return $this->address;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function getHistory() {
        return $this->history;
    }

    function isAdmin() {
        return false;
    }

    static function loadAllCustomers($pdo) {
        $customers = [];
        $sql = "SELECT * FROM Customers";
        $query = $pdo->prepare($sql);
        $query->execute();
        $array = $query->fetchAll();
        foreach ($array as $customer) {

            $loadedCustomer = new Customer($pdo);
            $loadedCustomer->id = $customer['id'];
            $loadedCustomer->setEmail($customer['email']);
            $loadedCustomer->setName($customer['name']);
            $loadedCustomer->setSurname($customer['surname']);
            $loadedCustomer->setHashedPassword($customer['hashed_password']);
            $loadedCustomer->setAddress($customer['address']);
            $customers[] = $loadedCustomer;
        }

        return $customers;
    }

    static function loadCustomerById($pdo, $id) {
        $sql = "SELECT * FROM Customers WHERE id=$id";
        $query = $pdo->prepare($sql);
        $query->execute();
        $customer = $query->fetch(PDO::FETCH_ASSOC);
        $loadedCustomer = new Customer($pdo);
        $loadedCustomer->id = $customer['id'];
        $loadedCustomer->setEmail($customer['email']);
        $loadedCustomer->setName($customer['name']);
        $loadedCustomer->setSurname($customer['surname']);
        $loadedCustomer->setHashedPassword($customer['hashed_password']);
        $loadedCustomer->setAddress($customer['address']);

        return $loadedCustomer;
    }

    function saveToDb($pdo) {
        $id = $this->getId();
        $email = $this->getEmail();
        $name = $this->getName();
        $hashed_password = $this->getHashedPassword();
        $surname = $this->getSurname();
        $address = $this->getAddress();
        if ($id == -1) {
            $sql = "INSERT INTO Customers (email, hashed_password, name, surname, address)"
                    . "VALUES ('$email', '$hashed_password', '$name', '$surname', '$address')";
            $query = $pdo->prepare($sql);
            $query->execute();
        } else {
            $sql = "UPDATE Customers SET email='$email', hashed_password='$hashed_password', "
                    . "name='$name', surname='$surname', address='$address' WHERE id=$id";
            $query = $pdo->prepare($sql);
            $query->execute();
        }
        
    }
    static function deleteCustomer($pdo, $id) {
        $sql = "DELETE FROM Customers WHERE id=$id";
        $query = $pdo->prepare($sql);
        $query->execute();
    }
    static function createCustomer($pdo, $email, $password, $name, $surname, $address) {
        $newHashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO Customers (email, hashed_password, name, surname, address)"
                . " VALUES ('$email', '$newHashedPassword', '$name', '$surname', '$address')";
        $query = $pdo->prepare($sql);
        try {
            $pdo->beginTransaction();
            $query->execute(array("$email", "$newHashedPassword", "$name", "$surname", "$address"));
            $id = $pdo->lastInsertId();
            $pdo->commit();
        } catch (PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        $customer =  new Customer($pdo);
        $customer->id = $id;
        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setHashedPassword($password);
        $customer->setAddress($address);
        $customer->setSurname($surname);
        
        return $customer;
    }
    function getMyMessages($pdo){
        $messages = Message::loadMessagesByReceiverId($pdo, $this->id);
        return $messages;
    }

}
