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
require_once 'InsertOperationWithoutChecks.php';
class AdminTest extends PHPUnit_Extensions_Database_TestCase {

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
    function testLoadAdminById(){
        $admin = Admin::loadAdminById($this->pdo, 1);
        $this->assertEquals('Tola', $admin->getName());
    }
    function testLoadAllAdmins(){
        $admins = Admin::loadAllAdmins($this->pdo);
        $this->assertCount(3, $admins);
        $this->assertEquals('Tola', $admins[0]->getName());
    }
    function testSaveToDb(){
        $this->test->setName('Jola');
        $this->test->setHashedPassword('oleole');
        $this->test->setEmail('jola@wp.pl');
        $this->test->SaveToDb($this->pdo);
        $this->assertCount(4, Admin::loadAllAdmins($this->pdo));
    }
    function testModyfyAndSaveToDb(){
        $admin = Admin::loadAdminById($this->pdo, 1);
        $admin->setEmail('tolazmieniona@onet.pl');
        $admin->SaveToDb($this->pdo);
        $this->assertCount(3, Admin::loadAllAdmins($this->pdo));
        $admin2 = Admin::loadAdminById($this->pdo, 1);
        
        $this->assertEquals('tolazmieniona@onet.pl', $admin2->getEmail());
    }
    function testdeleteAdmin(){
        Admin::deleteAdmin($this->pdo, 2);
        $this->assertCount(2, Admin::loadAllAdmins($this->pdo));
    }
    
    function testCreateAdmin(){
        
        $admin = Admin::createAdmin($this->pdo, 'bolek@wp.pl', 'lolek', 'Bolek');
        $this->assertCount(4, Admin::loadAllAdmins($this->pdo));
        $this->assertEquals(4, $admin->getId());
        $this->assertTrue(password_verify('lolek', $admin->getHashedPassword()));
    }
    
}
