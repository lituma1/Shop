<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsertOperationWithoutFkChecks
 *
 * @author pp
 */
class InsertOperationWithoutFkChecks extends PHPUnit_Extensions_Database_Operation_Insert{
    public function execute(
    PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet
    ) {
        $connection->getConnection()->exec("SET foreign_key_checks = 0");
        parent::execute($connection, $dataSet);
        $connection->getConnection()->exec("SET foreign_key_checks = 1");
    }
}
