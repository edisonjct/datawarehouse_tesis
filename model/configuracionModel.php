<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of configuracionModel
 *
 * @author EChulde
 */
require_once 'modelo.php';
require_once '../controler/auditoriaControler.php';

class configuracionModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function tabla_config_all($numtabla) {
        $query = "SELECT * FROM dw_configuraciones WHERE estado = 1 AND numtabla = '$numtabla' ORDER BY orden ASC;";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function tabla_config_by_id($numtabla, $codtabla) {
        $query = "SELECT * FROM dw_configuraciones WHERE estado = 1 AND numtabla = '$numtabla' AND codtabla = '$codtabla' LIMIT 1;";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }
    
    public function bodegas() {
        $query = "SELECT * FROM dw_bodegas WHERE estado = 1";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

}
