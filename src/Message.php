<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author pp
 */
class Message {

    //put your code here
    protected $pdo;
    private $id;
    private $receiver_id;
    private $text;

    function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id = -1;
        $this->receiver_id = -1;
        $this->text = '';
    }

    function getId() {
        return $this->id;
    }

    function getReceiverId() {
        return $this->receiver_id;
    }

    function getText() {
        return $this->text;
    }

    function setReceiverId($receiver_id) {
        $this->receiver_id = $receiver_id;
    }

    function setText($text) {
        $this->text = $text;
    }

    static function loadAllMessages($pdo) {
        $messages = [];
        $sql = "SELECT * FROM Message";
        $query = $pdo->prepare($sql);
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $loadedMessage = new Message($pdo);
            $loadedMessage->id = $row['id'];
            $loadedMessage->setText($row['text_message']);
            $loadedMessage->setReceiverId($row['receiver_id']);
            $messages[] = $loadedMessage;
        }
        return $messages;
    }

    static function loadMessagesByReceiverId($pdo, $rId) {
        $messages = [];
        $sql = "SELECT * FROM Message WHERE receiver_id=$rId";
        $query = $pdo->prepare($sql);
        $query->execute();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)){
            $loadedMessage = new Message($pdo);
            $loadedMessage->id = $row['id'];
            $loadedMessage->setText($row['text_message']);
            $loadedMessage->setReceiverId($row['receiver_id']);
            $messages[] = $loadedMessage;
        }
        return $messages;
    }
    static function createMessage(){
        
    }

}
