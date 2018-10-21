<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of datagraficosModel
 *
 * @author EChulde
 */
require_once 'modelo.php';
require_once '../controler/auditoriaControler.php';

class datagraficosModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function sel_ventas_tienda($anio) {
        $query = "SELECT bodega,anio,sum(valor),porcentaje_anual FROM data_mart_ventas_anual_mensual WHERE anio = '$anio' GROUP BY anio,bodega  ORDER BY bodega;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function sel_ventas_tienda_mes($anio, $bodega) {
        $query = "SELECT *
        FROM
        data_mart_ventas_anual_mensual
        WHERE anio = '$anio' AND bodega = '$bodega' 
        GROUP BY anio,bodega,numeromes
        ORDER BY numeromes;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function sel_ventas_paises($anio) {
        $query = "SELECT pais,ROUND(sum(pvp)) as valor FROM data_mart_ventas WHERE pais != '' AND anio = '$anio' GROUP BY anio,pais HAVING ROUND(sum(pvp)) >= 100 ORDER BY anio,pais;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function sel_nombres_paises() {
        $query = "SELECT pais FROM data_mart_ventas WHERE pais != '' GROUP BY pais ORDER BY pais;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function vaciar_tabla($tabla) {
        $query = "TRUNCATE TABLE $tabla;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function venta_semanal($anio, $semana) {
        $query = "SELECT sum(valor) as semana FROM data_mart_ventas_semanal WHERE semana = '$semana' AND anio = '$anio' GROUP BY anio,semana;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function venta_mensual($anio, $mes) {
        $query = "SELECT sum(valor) as mes FROM data_mart_ventas_mensual WHERE numeromes = '$mes' AND anio = '$anio' GROUP BY anio,numeromes;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function venta_anual($anio) {
        $query = "SELECT sum(valor) as anio FROM data_mart_ventas_anual_mensual WHERE anio = '$anio' GROUP BY anio;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function sel_ventas_categoria($anio) {
        $query = "SELECT cat_producto,ROUND(sum(pvp)) as valor FROM data_mart_ventas WHERE cat_producto != '' AND anio = '$anio' GROUP BY anio,cat_producto ORDER BY valor DESC LIMIT 10";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function sel_ventas_vendedores($anio) {
        $query = "SELECT vendedor,ROUND(sum(pvp)) as valor FROM data_mart_ventas WHERE vendedor != '' AND anio = '$anio' GROUP BY anio,vendedor ORDER BY valor DESC LIMIT 10;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function sel_ventas_clientes($anio) {
        $query = "SELECT cliente,ROUND(sum(pvp)) as valor FROM data_mart_ventas WHERE cliente != '' AND anio = '$anio' GROUP BY anio,cliente ORDER BY valor DESC LIMIT 10;";
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
