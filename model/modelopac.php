<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelopac
 *
 * @author EChulde
 */
require_once 'configPac.php';

class ModeloPac {

    protected $db_pac;

    public function __construct() {
        $this->db_pac = new mysqli('100.100.20.100', 'root', '', 'mrbooks');

        if ($this->db_pac->connect_errno) {
            echo "Fallo al conectar a MySQL: " . $this->db_pac->connect_error;
            return;
        }
        $this->db_pac->set_charset('utf8');
    }

}
