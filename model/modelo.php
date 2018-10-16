<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'config.php';

class Modelo {

    protected $db;

    public function __construct() {
        //$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db = new mysqli('localhost', 'root', '', 'mrbooks_datawarehouse');
        if ($this->db->connect_errno) {
            echo "Fallo al conectar a MySQL: " . $this->db->connect_error;
            return;
        }       
        $this->db->set_charset('utf8');
    }

}
