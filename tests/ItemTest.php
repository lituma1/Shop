<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemTest
 *
 * @author pp
 */
require_once './src/Item.php';
require_once 'InsertOperationWithoutChecks.php';
class ItemTest extends PHPUnit_Extensions_Database_TestCase {

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
        $this->testItem = new Item($this->pdo);
    }

    protected function getConnection() {
        if (empty($this->pdo)) {
            $pdo = new PDO(
                    $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']
            );
            $pdo->exec("set names utf8");
            $pdo->exec("CREATE TABLE Item ("
                    . "id INT UNSIGNED NOT NULL AUTO_INCREMENT, "
                    . "name VARCHAR(255), "
                    . "description TEXT,"
                    . "price DECIMAL(7, 2), quantity INT UNSIGNED) "
                    . "CHARACTER SET=utf8;");
            $pdo->exec("CREATE TABLE Image (id INT UNSIGNED NOT NULL AUTO_INCREMENT,"
                    . " source VARCHAR(255) UNIQUE,"
                    . " PRIMARY KEY(id), FOREIGN KEY(item_id) REFERENCES Item(id) "
                    . "ON DELETE CASCADE) CHARACTER SET=utf8;)");

            $this->pdo = $pdo;
        }
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($this->pdo, 'TestShop_db');
    }

    protected function getDataSet() {
        $dataMysql = $this->createMySQLXMLDataSet('users.xml');
        return $dataMysql;
    }

    protected function tearDown() {
        $this->testItem = null;
        parent::tearDown();
    }

    public function testGetId() {
        $this->assertEquals(-1, $this->testItem->getId());
    }

}
