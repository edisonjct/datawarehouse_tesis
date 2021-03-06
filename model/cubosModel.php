<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cubosModel
 *
 * @author EChulde
 */
require_once 'modelo.php';
require_once '../controler/auditoriaControler.php';

class cubosModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function cubo_ventas_detallado($desde, $hasta) {
        $query = "SELECT
        CASE WHEN tipo = '80' THEN 'FACTURA' END as tipo,
        documento,
        fecha_ingreso,
        cantidad,
        costo,
        vtabta,
        vtanet,
        desct,
        pvp,
        iva,
        dia,
        dianom,
        mes,
        anio,
        hora,
        minuto,
        cedularuc,
        cliente,
        direccion,
        telefono,
        correo,
        tipo_cliente,
        cat_cliente,
        ciudad,
        genero,
        vendedor,
        cajero,
        bodega,
        codigo,
        barras,
        titulo,
        autor,
        editorial,
        cat_producto,
        idioma,
        provedor,
        pais,
        tipo_provedor,
        cdi        
        FROM
        data_mart_ventas
        WHERE fecha_ingreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59'
        AND estado != '9';";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function cubo_ventas_totalisado($desde, $hasta) {
        $query = "SELECT
        CASE WHEN tipo = '80' THEN 'FACTURA' END as tipo,				
        fecha_ingreso,
	(COUNT(documento)) as numdoc,
        sum(cantidad) as cantidad,
        sum(costo) as costo,
        sum(vtabta) as vtabta,
        sum(vtanet) as vtanet,
        sum(desct) as desct,
        sum(pvp) as pvp,
        dia,
        mes,
        anio,
        cat_cliente,
        ciudad,
        bodega,       
        autor,
        editorial,
        cat_producto,
        idioma,
        provedor,
        pais,
        tipo_provedor,
        cdi        
        FROM
        data_mart_ventas
        WHERE fecha_ingreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND estado != '9'
        GROUP BY bodega,anio,mes,pais,tipo_provedor,cat_cliente;";
        $result = $this->db->query($query);
        ocon($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function cubo_clientes($desde, $hasta) {
        $query = "SELECT
        *    
        FROM
        data_mart_clientes
        WHERE fecha_ingreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59';";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function max_tabla($tabla) {
        $query = "SELECT count(*) as max FROM $tabla;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function datos_totales_anios($anio) {
        $query = "SELECT *
        FROM
        dw_totales_anio
        INNER JOIN dw_bodegas  ON dw_totales_anio.bodega = dw_bodegas.nombre
        WHERE anio = '$anio' AND estado = '1'
        ORDER BY orden ASC;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function datos_grafico_ventas($desde, $hasta) {
        $query = "SELECT
        bodega as bodega,
        (COUNT(documento)) AS facturas,
        sum(cantidad) AS cantidad,
        sum(pvp) AS pvp
        FROM
        data_mart_ventas
        WHERE fecha_ingreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND estado != '9'
        GROUP BY bodega ORDER BY bodega;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function sel_grafico_vendedores($desde, $hasta) {
        $query = "SELECT
        vendedor as vendedor,
        (COUNT(documento)) AS facturas,
        sum(cantidad) AS cantidad,
        sum(pvp) AS pvp
        FROM
        data_mart_ventas
        WHERE fecha_ingreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND estado != '9'
        GROUP BY vendedor ORDER BY sum(pvp) DESC LIMIT 10;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function cubo_ventas_vendedores($desde, $hasta) {
        $query = "SELECT
        CASE WHEN tipo = '80' THEN 'FACTURA' END as tipo,				
        fecha_ingreso,
	(COUNT(documento)) as numdoc,
        sum(cantidad) as cantidad,
        sum(costo) as costo,
        sum(vtabta) as vtabta,
        sum(vtanet) as vtanet,
        sum(desct) as desct,
        sum(pvp) as pvp,
	hora,
        dia,
        mes,
        anio,        
        bodega,       
        autor,
        editorial,
        cat_producto,
        idioma,
        provedor,
        pais,
        tipo_provedor,        
        vendedor       
        FROM
        data_mart_ventas
        WHERE fecha_ingreso BETWEEN '$desde 00:00:00' AND '$hasta 23:59:59' AND estado != '9'
        GROUP BY bodega,anio,mes,dia,hora,vendedor;";
        $result = $this->db->query($query);
        ocon($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }
    
    public function sel_grafico_productos($desde, $hasta) {
        $query = "";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

}
