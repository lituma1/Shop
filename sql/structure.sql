/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  pp
 * Created: 2016-12-13
 */

CREATE TABLE Message (id INT UNSIGNED NOT NULL AUTO_INCREMENT, receiver_id INT UNSIGNED NOT NULL, text_message TEXT, PRIMARY KEY (id), FOREIGN KEY(receiver_id) REFERENCES Customers(id) ON DELETE CASCADE) CHARACTER SET=utf8;
INSERT INTO Message (receiver_id, text_message) VALUES (2, 'Prosimy o dokonanie płatności za zamówienie Pozdrawiamy');
CREATE TABLE Image (id INT UNSIGNED NOT NULL AUTO_INCREMENT, source VARCHAR(255) UNIQUE, PRIMARY KEY(id));