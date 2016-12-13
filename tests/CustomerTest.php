<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerTest
 *
 * @author pp
 */
require_once './src/Customer.php';
require_once './src/Message.php';
class CustomerTest extends PHPUnit_Extensions_Database_TestCase {

    private $pdo;

    protected function setUp() {
        parent::setUp();
        $this->test = new Customer($this->pdo);
    }

    protected function getConnection() {
        if (empty($this->pdo)) {
            $pdo = new PDO(
                    $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']
            );
            $pdo->exec("set names utf8");
            $pdo->exec("CREATE TABLE Customers "
                    . "(id INT UNSIGNED NOT NULL AUTO_INCREMENT,"
                    . " email VARCHAR(255) UNIQUE, "
                    . "hashed_password VARCHAR(255), "
                    . "name VARCHAR(255), surname VARCHAR(255), "
                    . "address VARCHAR(255), PRIMARY KEY(id)) "
                    . "CHARACTER SET=utf8;");


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

    function testGetName() {
        $this->assertEquals('', $this->test->getName());
    }

    function testGetSurname() {
        $this->assertEquals('', $this->test->getSurname());
    }

    function testGetAddress() {
        $this->assertEquals('', $this->test->getAddress());
    }

    function testGetHistory() {
        $this->assertEmpty($this->test->getHistory());
    }

    function testIsAdmin() {
        $this->assertFalse($this->test->isAdmin());
    }

    function testSetEmail() {
        $this->test->setEmail('abc@wp.pl');
        $this->assertEquals('abc@wp.pl', $this->test->getEmail());
    }

    function testSetName() {
        $this->test->setName('Jan');
        $this->assertEquals('Jan', $this->test->getName());
    }

    function testSetSurname() {
        $this->test->setSurname('Tur');
        $this->assertEquals('Tur', $this->test->getSurname());
    }

    function testSetAddress() {
        $this->test->setAddress('ul. Nowa 3/5');
        $this->assertEquals('ul. Nowa 3/5', $this->test->getAddress());
    }

    function testSetHashedPassword() {
        $this->test->setHashedPassword('rowerek');
        $this->assertTrue(password_verify('rowerek', $this->test->getHashedPassword()));
    }

    function testCheckLoginAndPassword() {
        $this->test->setEmail('abc@onet.pl');
        $this->test->setHashedPassword('klockilego');
        $this->assertTrue($this->test->checkLoginAndPassword('abc@onet.pl', 'klockilego'));
    }

    function testLoadAllCustomers() {
        $customers = Customer::loadAllCustomers($this->pdo);
        $this->assertCount(3, $customers);
        $this->assertEquals('Jan', $customers[0]->getName());
    }

    function testLoadCustomerById() {
        $customer = Customer::loadCustomerById($this->pdo, 2);
        $this->assertEquals('Karol', $customer->getName());
    }

    function testSaveToDb() {
        $this->test->setName('Wacław');
        $this->test->setSurname('Nowakowski');
        $this->test->setAddress('Warszawa Słoneczna 11');
        $this->test->setHashedPassword('dgh235h9&*=%');
        $this->test->setEmail('wac@wp.pl');
        $this->test->saveToDb($this->pdo);
        $this->assertCount(4, Customer::loadAllCustomers($this->pdo));
    }

    function testModyfyAndSaveToDb() {
        $customer = Customer::loadCustomerById($this->pdo, 1);
        $customer->setAddress('Wrocław ul. Szeroka 11');
        $customer->setEmail('tyz@gmail.com');
        $customer->saveToDb($this->pdo);
        $this->assertCount(3, Customer::loadAllCustomers($this->pdo));
    }

    function testDeleteCustomer() {
        Customer::deleteCustomer($this->pdo, 2);
        $this->assertCount(2, Customer::loadAllCustomers($this->pdo));
    }
    function testCreateCustomer() {
        $customer = Customer::createCustomer($this->pdo, 'malpa@wp.pl', 'sanki', 'Adam', 'Kot', 'Poznań ul. Szeroka 13');
        $this->assertCount(4, Customer::loadAllCustomers($this->pdo));
        $this->assertEquals(4, $customer->getId());
        $this->assertTrue(password_verify('sanki', $customer->getHashedPassword()));
        
    }
    function testGetMyMessages(){
        $customer = Customer::loadCustomerById($this->pdo, 2);
        $messages = Message::loadMessagesByReceiverId($this->pdo, $customer->getId());
        $this->assertCount(2, $messages);
        
    }

}
