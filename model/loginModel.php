<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginModel
 *
 * @author EChulde
 */
require_once 'modelo.php';
require_once '../controler/auditoriaControler.php';

class loginModel extends Modelo {

    public function __construct() {
        parent::__construct();
    }

    public function valida_usuario($usuario, $clave) {
        $query = "SELECT * FROM dw_usuario where usuario = '$usuario' AND clave = '$clave' AND estado = 1 LIMIT 1";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function bitacora($fecha, $usuario, $ip, $navegador, $OS) {
        ocon($query = "INSERT INTO dw_bitacora (fecha, usuario, ip ,navegador , sistema) VALUES ('$fecha', '$usuario', '$ip', '$navegador','$OS');");
        $bitacora = $this->db->query($query);
        return $bitacora;
    }

    public function getbyid($ID_USUARIO) {
        ocon($query = "SELECT * FROM dw_usuario where ID_USUARIO = '$ID_USUARIO' AND estado = 1 LIMIT 1");
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

}
