<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author pp
 */
class Item {

    //put your code here
    private $pdo;
    private $id;
    private $name;
    private $description;
    private $price;
    private $quantity;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id = -1;
        $this->name = '';
        $this->description = '';
        $this->price = 0;
        $this->quantity = 0;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }


    
}
