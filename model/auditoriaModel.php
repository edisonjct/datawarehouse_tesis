<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auditoriaModelo
 *
 * @author EChulde
 */
require_once 'modelo.php';

class auditoriaModelo extends Modelo {

    //put your code here
    public function __constructor() {
        parent:: __construct();
    }

    public function insertarauditoria($fecha, $factura, $sql) {
        $query = 'INSERT INTO insertarauditorias (fecha, factura, sqlauditoria, estado) VALUES ("' . $fecha . '","' . $factura . '","' . $sql . '", "1");';
        $result = $this->db->query($query);
        return $result;
    }

    public function vaciar_tmp($tabla) {
        $query = "TRUNCATE `$tabla`";
        $result = $this->db->query($query);
        return $result;
    }

    public function insertarauditoria_tmp($fecha, $sql, $cantidad, $tipo) {
        $query = 'INSERT INTO insertarauditorias_tmp (fecha, sqlauditoria, cantidad, tipo) VALUES ("' . $fecha . '", "' . $sql . '", "' . $cantidad . '", "' . $tipo . '");';
        $result = $this->db->query($query);
        return $result;
    }

    public function facturas_sin_movpro($fecha, $estado) {
        $query = "SELECT * from facturas_sin_movpro WHERE fecha = '$fecha' AND estado = $estado;";
        $result = $this->db->query($query);
        return $result;
    }

    public function estado_facturas_sin_movpro($factura, $estado) {
        $query = "UPDATE facturas_sin_movpro SET estado='$estado' WHERE (factura='$factura') LIMIT 1;";
        $result = $this->db->query($query);
        return $result;
    }

    public function select_facturas_sin_movpro($factura, $estado, $fecha) {
        $query = "SELECT * FROM facturas_sin_movpro WHERE factura = '$factura' AND estado = '$estado' AND fecha = '$fecha' LIMIT 1;";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function valida_fechas($fecha) {
        $query = "SELECT * FROM insertarauditorias WHERE fecha = '$fecha';";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function valida_factura($factura) {
        $query = "SELECT * FROM insertarauditorias WHERE factura = '$factura';";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

}
