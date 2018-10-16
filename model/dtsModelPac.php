<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dtsModelPac
 *
 * @author EChulde
 */
require_once 'modelopac.php';

class dtsModelPac extends ModeloPac {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function autores($num) {
        $num2 = 1000;
        $query = "SELECT * FROM autores LIMIT $num,$num2";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function editorial() {
        $query = "SELECT * FROM editoriales";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function maepro($num) {
        $num2 = 1000;
        $query = "SELECT 
        m.codprod01 AS ID,
        m.codbar01 AS codigo,
        m.desprod01 AS titulo,
        m.cantact01 AS cantidad,
        m.precuni01 AS costo,
        m.fecvta01 AS fecha_venta,
        m.precvta01 AS pvp,
        m.porciva01 AS iva,
        m.descto101 AS descuento,
        m.proved101 AS provedor,
        m.catprod01 AS categoria,
        m.tipprod01 AS tipo,
        m.statuspro01 AS estado,
        m.infor01 AS autor,
        m.infor02 AS editorial,
        m.infor03 AS idioma,
        m.infor08 AS ubicacion,
        s.cdi as cdi,
        s.wb as wb,
        s.jrd as jrd,
        s.sl as sl,
        s.cnd as cnd,
        s.scl as scl,
        s.vl as vl,
        s.ev as ev,
        s.qc as qc,
        s.snl as snl,
        s.snm as snm,
        s.cm as cm,
        s.pcf as pcf,
        s.man as man
        FROM maepro AS m
        LEFT JOIN ws_productos_stock as s ON m.codprod01 = s.cod
        LIMIT $num,$num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function maefac($base, $num, $fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT nofact31,nocte31,nomcte31,localid31,vtabta31,descto31,fecfact31,formapago31,cvanulado31,ruc31,tel31,desctofp31,UID,novend31 FROM $base.maefac WHERE fecfact31 >= '$fecha_inicia' LIMIT $num,$num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function detalle_facturas($base, $num, $fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT TIPOTRA03,NOCOMP03,CODPROD03,FECMOV03,CANTID03,PU03,CODDEST03,PRECVTA03,DESCVTA03,nomdest03,UID,cvanulado03,iva03,desctotvta03,desctotfp03 FROM $base.movpro WHERE TIPOTRA03 = '80' AND FECMOV03 >= '$fecha_inicia' LIMIT $num,$num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function detalle_notas_credito($base, $num, $fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT NOCOMP03,CODPROD03,FECMOV03,CANTACT03,PU03,CODDEST03,PRECVTA03,DESCVTA03,nomdest03,UID,cvanulado03,iva03 FROM $base.movpro WHERE TIPOTRA03 = '22' AND FECMOV03 >= '$fecha_inicia' LIMIT $num,$num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function count_tabla_all($base, $tabla, $fecha, $valor) {
        $query = "SELECT count(*) as max FROM $base.$tabla WHERE $fecha >= '$valor';";
        $result = $this->db_pac->query($query);
        return $result->fetch_object();
    }

    public function count_tabla_by_id($base, $tabla, $fecha, $campo, $valor, $valor2) {
        $query = "SELECT count(*) as max FROM $base.$tabla WHERE $campo = '$valor' AND $fecha >= '$valor2';";
        $result = $this->db_pac->query($query);
        return $result->fetch_object();
    }

    public function count_tabla($tabla) {
        $query = "SELECT count(*) as max FROM $tabla";
        $result = $this->db_pac->query($query);
        return $result->fetch_object();
    }

    public function clientes($num,$fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT codcte01,nomcte01,tipcte01,loccte01,dircte01,telcte01,cascte01,fecing01,desctocte01,sdoact01,statuscte01,emailcte01,UID,catcte01,razcte01,sexo01 FROM maecte WHERE fecing01 >= '$fecha_inicia' LIMIT $num, $num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function provedor($num) {
        $num2 = 100;
        $query = "SELECT codcte01,nomcte01,tipcte01,loccte01,dircte01,telcte01,cascte01,fecing01,condpag01,desctocte01,sdoact01,statuscte01,emailcte01,UID,catcte01,coddest01 FROM maepag LIMIT $num, $num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function notas_credito($num, $fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT numdoc43,codcte43,totdoc43,fecdoc43,cvanulado43,UID FROM movcte WHERE tipodoc43 = '53' AND fecdoc43 >= '$fecha_inicia' LIMIT $num,$num2;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function tabla_maetab($tabla, $numtab) {
        $query = "SELECT * FROM $tabla where codtab != '' AND numtab = '$numtab';";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }
    
    public function tabla_categorias($tabla, $numtab) {
        $query = "SELECT * FROM $tabla where tipocate = '$numtab';";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }
    
    public function usuarios_pac() {
        $query = "SELECT UID,username,userpwd,nombreusuario FROM mrbooks_infosac.usuario;";
        $result = $this->db_pac->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

}
