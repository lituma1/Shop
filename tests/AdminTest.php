<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminTest
 *
 * @author pp
 */
require_once './src/Admin.php';

class AdminTest extends PHPUnit_Extensions_Database_TestCase {

    private $pdo;

    protected function setUp() {
        parent::setUp();
        $this->test = new Admin($this->pdo);
    }

    protected function getConnection() {
        if (empty($this->pdo)) {
            $pdo = new PDO(
                    $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']
            );
            $pdo->exec("set names utf8");
            $pdo->exec("CREATE TABLE Admin "
                    . "(id INT UNSIGNED NOT NULL AUTO_INCREMENT,"
                    . " email VARCHAR(255) UNIQUE, "
                    . "hashed_password VARCHAR(255), "
                    . "name VARCHAR(255), PRIMARY KEY(id)) CHARACTER SET=utf8;");


            $this->pdo = $pdo;
        }
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($this->pdo, 'TestShop_db');
    }

    protected function getDataSet() {
        $dataMysql = $this->createMySQLXMLDataSet('users.xml');
        return $dataMysql;
    }

    protected function tearDown() {
        $this->test = null;
        parent::tearDown();
    }

    function testGetId() {
        $this->assertEquals(-1, $this->test->getId());
    }

    function testGetEmail() {
        $this->assertEquals('', $this->test->getEmail());
    }

    function testGetHashedPassword() {
        $this->assertEquals('', $this->test->getHashedPassword());
    }
    function testGetName(){
        $this->assertEquals('', $this->test->getName());
    }
    function testIsAdmin(){
        $this->assertTrue($this->test->isAdmin());
    }
    function testSetEmail(){
        $this->test->setEmail('abc@wp.pl');
        $this->assertEquals('abc@wp.pl', $this->test->getEmail());
    }
    function testSetHashedPassword(){
        $this->test->setHashedPassword('rowerek');
        $this->assertTrue(password_verify('rowerek', $this->test->getHashedPassword()));
    }
    function testCheckLoginAndPassword(){
        $this->test->setEmail('abc@onet.pl');
        $this->test->setHashedPassword('klockilego');
        $this->assertTrue($this->test->checkLoginAndPassword('abc@onet.pl', 'klockilego'));
    }
}
