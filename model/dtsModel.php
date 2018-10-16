<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dtsModel
 *
 * @author EChulde
 */
require_once 'modelo.php';

class dtsModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function sel_databla_config_all($numero) {
        $query = "SELECT * FROM dw_arrays WHERE numtabla = '$numero' AND estado = '1' order by orden;";
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
        $vaciar_tabla = $this->db->query($query);
        return $vaciar_tabla;
    }

    public function eliminar_datos_tabla($tabla, $campo, $fecha_inicia) {
        $query = "DELETE FROM $tabla WHERE ($campo >= '$fecha_inicia');";
        $vaciar_tabla = $this->db->query($query);
        return $vaciar_tabla;
    }

    public function insert_autores($array) {
        $query = "INSERT INTO dw_autores (codigo, nombres) VALUES $array;";
        $result = $this->db->query($query);
        return $result;
    }

    public function insert_editoriales($array) {
        $query = "INSERT INTO dw_editoriales VALUES $array;";
        $result = $this->db->query($query);
        return $result;
    }

    public function insert_maepro($array) {
        $query = "INSERT INTO dw_productos VALUES $array;";
        $result = $this->db->query($query);
        return $result;
    }

    public function insert_maefac($array) {
        $query = "INSERT INTO dw_facturas VALUES $array;";
        $insert_maefac = $this->db->query($query);
        return $insert_maefac;
    }

    public function insert_notas_credito($array) {
        $query = "INSERT INTO dw_nota_credito VALUES $array;";
        $insert_notas = $this->db->query($query);
        return $insert_notas;
    }

    public function insert_detalle_facturas($array) {
        $query = "INSERT INTO dw_facturas_detalle VALUES $array;";
        $insert_maefac = $this->db->query($query);
        return $insert_maefac;
    }

    public function insert_detalle_notas_credito($array) {
        $query = "INSERT INTO dw_nota_credito_detalle VALUES $array;";
        $insert_maefac = $this->db->query($query);
        return $insert_maefac;
    }

    public function insert_clientes($array) {
        $query = "INSERT INTO dw_clientes VALUES $array;";
        $insert_cliente = $this->db->query($query);
        return $insert_cliente;
    }

    public function insert_provedores($array) {
        $query = "INSERT INTO dw_provedores VALUES $array;";
        $insert_provedor = $this->db->query($query);
        return $insert_provedor;
    }

    public function insert_tabla($tabla, $array) {
        $query = "INSERT INTO $tabla VALUES $array;";
        $insert_tabla = $this->db->query($query);
        return $insert_tabla;
    }

    public function count_tabla_all($tabla, $fecha, $valor) {
        $query = "SELECT count(*) as max FROM $tabla WHERE $fecha >= '$valor';";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function count_tabla($tabla) {
        $query = "SELECT count(*) as max FROM $tabla;";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function select_data_mart_clientes($num, $fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT
        c.codcte01 AS codigo,
        c.nomcte01 AS nombre,
        c.dircte01 AS direccion,
        c.telcte01 AS telefono,
        c.cascte01 AS cedularuc,
        c.desctocte01 AS descuento,
        c.sdoact01 AS saldo,
        c.statuscte01 AS estado,
        c.emailcte01 AS correo,
        cc.nombre AS tipo_cliente,
        l.nombre AS localidad,
        cc.nombre AS categoria,
        g.nombre AS genero,
        u.nombre as usuario,
        c.fecing01 AS fecha_ingreso,
        Day(c.fecing01) AS dia,
        DAYNAME(c.fecing01) as nomdia,
        MONTHNAME(c.fecing01) as mes,
        YEAR(c.fecing01) as anio
        FROM
        dw_clientes AS c        
        LEFT JOIN dw_localidades AS l ON c.loccte01 = l.ID_LOCALIDAD
        LEFT JOIN dw_categoria_clientes AS cc ON c.catcte01 = cc.ID
        LEFT JOIN dw_genero AS g ON c.sexo01 = g.ID
        INNER JOIN dw_usuarios_pac AS u ON c.UID = u.ID
        WHERE c.fecing01 >= '$fecha_inicia 00:00:00'
        LIMIT $num,$num2";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function select_data_mart_provedores($num, $fecha_inicia) {
        $num2 = 1000;
        $query = "SELECT
        p.codcte01 AS ID,
        p.coddest01 as cod_destino,
        p.nomcte01 AS nombre,
        p.dircte01 AS direccion,
        p.telcte01 AS telefono,
        p.cascte01 AS cedularuc,
        p.desctocte01 AS descuento,
        p.sdoact01 AS saldo,
        p.statuscte01 AS estado,
        p.emailcte01 AS correo,
        l.nombre AS localidad,
        t.nombre AS tipo_provedor,
        cp.nombre AS condicion_pago,
        d.nombre AS destino,
        u.nombre as usuario,
        p.fecing01 as fecha_ingreso,
        day(p.fecing01) as dia,
        DAYNAME(p.fecing01) as nomdia,
        MONTHNAME(p.fecing01) as mes,
        YEAR(p.fecing01) as anio
        FROM
        dw_provedores AS p
        LEFT JOIN dw_localidades_provedor AS l ON p.loccte01 = l.ID_LOCALIDAD
        LEFT JOIN dw_tipo_provedores AS t ON p.tipcte01 = t.ID
        LEFT JOIN dw_condicion_pago AS cp ON p.condpag01 = cp.ID
        LEFT JOIN dw_destinos AS d ON p.coddest01 = d.ID
        LEFT JOIN dw_usuarios_pac AS u ON p.UID = u.ID
        WHERE p.fecing01 >= '$fecha_inicia 00:00:00'
        LIMIT $num,$num2";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function select_data_mart_productos($num) {
        $num2 = 1000;
        $query = "SELECT
        p.ID as codigo,
        p.codigo as barras,
        p.titulo as titulo,
        p.costo as costo,
        p.pvp as pvp,
        p.iva as iva,
        p.descuento as descuento,
        p.tipo as tipo_producto,
        p.ubicacion as ubicacion,
        c.nombre as categoria,
        a.nombres as autor,
        e.razon as editorial,
        i.nombre as idioma,
        dp.destino as provedor,
        dp.localidad as pais,
        dp.tipo_provedor as tipo_provedor,
        p.cdi,
        p.wb,
        p.jrd,
        p.sl,
        p.cnd,
        p.scl,
        p.vl,
        p.ev,
        p.qc,
        p.snl,
        p.snm,
        p.cm,
        p.pcf,
        p.man,
        p.estado as estado
        FROM
        dw_productos AS p
        LEFT JOIN data_mart_provedores AS dp ON p.provedor = dp.cod_destino
        LEFT JOIN dw_categoria_productos AS c ON p.categoria = c.ID
        LEFT JOIN dw_autores AS a ON p.autor = a.codigo
        LEFT JOIN dw_editoriales as e ON p.editorial = e.codigo
        LEFT JOIN dw_idiomas as i ON p.idioma = i.ID
        LIMIT $num,$num2;";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function select_data_mart_ventas($fecha_inicia) {
        $query = "INSERT INTO data_mart_ventas
        SELECT
        d.TIPOTRA03 AS tipo,
        d.NOCOMP03 AS documento,
        Sum(d.CANTID03) AS cantidad,
        Sum(d.PU03) AS costo,
        Sum(d.PRECVTA03) AS vtabta,
        Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03) AS vtanet,
        Sum(d.DESCVTA03+d.desctotvta03+d.desctotfp03) AS desct,
        Sum(d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)+(ROUND((((d.PRECVTA03-d.DESCVTA03-d.desctotvta03-d.desctotfp03)*d.iva03)/100),2)) AS pvp,
        d.iva03 AS iva,
        d.FECMOV03 AS fecha_ingreso,
        DAY(f.fecfact31) AS dia,
        DAYNAME(f.fecfact31) AS dianom,
        MONTHNAME(f.fecfact31) AS mes,
        YEAR(f.fecfact31) AS anio,
        HOUR(f.fecfact31) AS hora,
        MINUTE(f.fecfact31) AS minuto,
        f.cvanulado31 AS estado,
        v.nombre AS vendedor,
        u.nombre as cajero,
        d.nombre_bodega as bodega,
        f.nocte31 AS cedularuc,
        f.nomcte31 AS cliente,
        c.direccion AS direccion,
        c.telefono AS telefono,
        c.correo AS correo,
        c.tipo_cliente AS tipo_cliente,
        c.localidad AS ciudad,
        c.categoria AS cat_cliente,
        c.genero AS genero,
        p.barras AS barras,
        p.codigo AS codigo,
        p.titulo AS titulo,
        p.categoria AS cat_producto,
        p.autor AS autor,
        p.editorial AS editorial,
        p.idioma AS idioma,
        p.provedor AS provedor,
        p.pais AS pais,
        p.tipo_provedor AS tipo_provedor,
        p.cdi
        FROM
        dw_facturas_detalle AS d
        INNER JOIN dw_facturas AS f ON d.NOCOMP03 = f.nofact31
        INNER JOIN data_mart_clientes AS c ON f.nocte31 = c.codigo
        INNER JOIN data_mart_productos AS p ON d.CODPROD03 = p.codigo
        INNER JOIN dw_vendedores AS v ON f.novend31 = v.ID
        INNER JOIN dw_usuarios_pac AS u ON f.UID = u.ID
        WHERE d.FECMOV03 >= '$fecha_inicia'
        GROUP BY d.TIPOTRA03,d.NOCOMP03,d.CODPROD03";
        $insert_tabla = $this->db->query($query);
        return $insert_tabla;
    }

    public function select_datos_anios($anio) {
        $query = "INSERT INTO dw_totales_anio
        SELECT
        d.bodega,
        d.anio,
        sum(d.pvp),
        (SELECT sum(pvp) FROM data_mart_ventas WHERE anio = '$anio'),
        (sum(d.pvp) * 100) / (SELECT sum(pvp) FROM data_mart_ventas WHERE anio = '$anio')
        FROM
        data_mart_ventas AS d
        INNER JOIN dw_bodegas AS b ON d.bodega = b.nombre
        WHERE d.anio = '$anio' AND b.estado = 1
        GROUP BY d.anio,d.bodega;";
        $insert_tabla = $this->db->query($query);
        return $insert_tabla;
    }

}
