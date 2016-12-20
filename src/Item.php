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

    static function loadAllItems($pdo){
        $items = [];
        $sql = "SELECT * FROM Item";
        $query = $pdo->prepare($sql);
        $query->execute();
         while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $loadedItem = new Item($pdo);
            $loadedItem->id = $row['id'];
            $loadedItem->setName($row['name']);
            $loadedItem->setDescription($row['description']);
            $loadedItem->setPrice($row['price']);
            $loadedItem->setQuantity($row['quantity']);
            $items[] = $loadedItem;
        }
        return $items;
        
    }
    static function loadItemById($pdo, $id){
        $sql = "SELECT * FROM Item WHERE id=$id";
        $query = $pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $loadedItem = new Item($pdo);
        $loadedItem->id = $row['id'];
        $loadedItem->setName($row['name']);
        $loadedItem->setPrice($row['price']);
        $loadedItem->setDescription($row['description']);
        $loadedItem->setQuantity($row['quantity']);
        return $loadedItem;
    }
    static function createItem($pdo, $name, $description, $price, $quantity){
        
        $sql = "INSERT INTO Item (name, description, price, quantity) VALUES "
                . "('$name', '$description', $price, $quantity)";
        $query = $pdo->prepare($sql);
        $query->execute();
        $id = $pdo->lastInsertId();
        $item = new Item($pdo);
        $item->id = $id;
        $item->setName($name);
        $item->setPrice($price);
        $item->setQuantity($quantity);
        $item->setDescription($description);
        return $item;
        
        
    }
    function saveToDb($pdo) {
        $id = $this->getId();
        $name = $this->getName();
        $description = $this->getDescription();
        $price = $this->getPrice();
        $quantity = $this->getQuantity();
       
        if ($id == -1) {
            $sql = "INSERT INTO Item (name, description, price, quantity)"
                    . "VALUES ('$name', '$description', $price, $quantity)";
            $query = $pdo->prepare($sql);
            $query->execute();
        } else {
            $sql = "UPDATE Item SET name='$name', description='$description', "
                    . "price=$price, quantity=$quantity WHERE id=$id";
            $query = $pdo->prepare($sql);
            $query->execute();
        }
        
    }
}
