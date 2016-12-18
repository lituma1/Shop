<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageTest
 *
 * @author pp
 */
require_once 'InsertOperationWithoutChecks.php';

require_once './src/Message.php';

class MessageTest extends PHPUnit_Extensions_Database_TestCase {

    private $pdo;

    protected function getSetUpOperation() {
        // Override
        return new PHPUnit_Extensions_Database_Operation_Composite([
            PHPUnit_Extensions_Database_Operation_Factory::TRUNCATE(),
            new InsertOperationWithoutChecks(),
        ]);
    }
    protected function setUp() {
        parent::setUp();
        $this->testMessage = new Message($this->pdo);
    }

    protected function getConnection() {
        if (empty($this->pdo)) {
            $pdo = new PDO(
                    $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']
            );
            $pdo->exec("set names utf8");
            $pdo->exec("CREATE TABLE Message ("
                    . "id INT UNSIGNED NOT NULL AUTO_INCREMENT, "
                    . "receiver_id INT UNSIGNED NOT NULL, "
                    . "text_message TEXT, PRIMARY KEY (id), "
                    . "FOREIGN KEY(receiver_id) REFERENCES Customers(id) "
                    . "ON DELETE CASCADE) CHARACTER SET=utf8;");
            $this->pdo = $pdo;
        }
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($this->pdo, 'TestShop_db');
    }

    protected function getDataSet() {
        $dataMysql = $this->createMySQLXMLDataSet('users.xml');
        return $dataMysql;
    }
    protected function tearDown() {
        $this->testMessage = null;
        parent::tearDown();
    }
    function testGetId(){
        $this->assertEquals(-1, $this->testMessage->getId());
    }
    function testGetText(){
        $this->assertEquals('', $this->testMessage->getText());
    }
    function testGetReceiverId(){
        $this->assertEquals(-1, $this->testMessage->getReceiverId());
    }
    function testSetText(){
        $this->testMessage->setText('Wysłano paczkę');
        $this->assertEquals('Wysłano paczkę', $this->testMessage->getText());
    }
    function testSetReceiverId(){
        $this->testMessage->setReceiverId(3);
        $this->assertEquals(3, $this->testMessage->getReceiverId());
    }
    function testLoadAllMessages(){
        $messages = Message::loadAllMessages($this->pdo);
        $this->assertCount(3, $messages);
        $this->assertEquals(2, $messages[0]->getReceiverId());
        $this->assertEquals('Prosimy o dokonanie płatności za zamówienie Pozdrawiamy'
                , $messages[2]->getText());
    }
    function testLoadMessagesByReceiverId(){
        $messages = Message::loadMessagesByReceiverId($this->pdo, 2);
        $this->assertCount(2, $messages);
        $this->assertEquals('Paczka została dziś wysłana Pozdrawiamy', $messages[0]->getText());
    }
    function testCreateMessage(){
        
        Message::createMessage($this->pdo, 3, 'Prosimy o dokonanie płatności');
        $this->assertCount(4, Message::loadAllMessages($this->pdo));
        
    }
}
