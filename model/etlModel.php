<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioModel
 *
 * @author EChulde
 */
require_once 'modelo.php';
require_once '../controler/auditoriaControler.php';

class etlModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function vaciar_tabla($tabla) {
        $query = "TRUNCATE TABLE $tabla;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function max_registros($tabla) {
        $query = "SELECT count(*) as max FROM $tabla;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function select_data_mart_productos($num) {
        $num2 = 1000;
        $query = "SELECT p.ID as codigo,p.codigo as barras,p.titulo as titulo,p.costo as costo,p.pvp as pvp,p.iva as iva,p.descuento as descuento,p.tipo as tipo_producto,p.ubicacion as ubicacion,c.nombre as categoria,
        a.nombres as autor,e.razon as editorial,i.nombre as idioma,dp.destino as provedor,dp.localidad as pais,dp.tipo_provedor as tipo_provedor,
        p.cdi,p.wb,p.jrd,p.sl,p.cnd,p.scl,p.vl,p.ev,p.qc,p.snl,p.snm,p.cm,p.pcf,p.man,p.estado as estado,p.fecha_venta
        FROM dw_productos AS p
        LEFT JOIN data_mart_provedores AS dp ON p.provedor = dp.cod_destino
        LEFT JOIN dw_categoria_productos AS c ON p.categoria = c.ID
        LEFT JOIN dw_autores AS a ON p.autor = a.codigo
        LEFT JOIN dw_editoriales as e ON p.editorial = e.codigo
        LEFT JOIN dw_idiomas as i ON p.idioma = i.ID
        LIMIT $num,$num2;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function insert_tabla($tabla, $array) {
        $query = "INSERT INTO $tabla VALUES $array;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
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
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function select_data_mart_provedores($num) {
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
        LIMIT $num,$num2";
        ocon($query);
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
        ocon($query);
        $insert_tabla = $this->db->query($query);
        return $insert_tabla;
    }

    public function eliminar_datos_tabla($tabla, $campo, $fecha_inicia) {
        $query = "DELETE FROM $tabla WHERE ($campo = '$fecha_inicia');";
        ocon($query);
        $vaciar_tabla = $this->db->query($query);
        return $vaciar_tabla;
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
        ocon($query);
        $insert_tabla = $this->db->query($query);
        return $insert_tabla;
    }

    public function total_ventas_anules($anio) {
        $query = "SELECT sum(pvp) as max FROM data_mart_ventas WHERE anio = '$anio' GROUP BY anio;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function update_valor_anio($anio, $valor) {
        $query = "UPDATE data_mart_ventas_anual_mensual SET valoranio='$valor' WHERE (anio='$anio');";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function total_ventas_anules_bodega($anio, $bodega) {
        $query = "SELECT sum(pvp) as max FROM data_mart_ventas WHERE anio = '$anio' AND bodega = '$bodega' GROUP BY anio,bodega;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function update_valor_bodega($anio, $bodega, $total) {
        $query = "UPDATE data_mart_ventas_anual_mensual SET valorbodega='$total' WHERE (bodega='$bodega') AND (anio='$anio');";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function ventas_anulaes() {
        $query = "INSERT INTO data_mart_ventas_anual_mensual(bodega,anio,mes,valor,numeromes)
        SELECT
        d.bodega,
        d.anio,
        CASE (d.mes) WHEN 'January' THEN '01 Enero'
        WHEN 'February' THEN '02 Febrero'
        WHEN 'March' THEN '03 Marzo'
        WHEN 'April' THEN '04 Abril'
        WHEN 'May' THEN '05 Mayo'
        WHEN 'June' THEN '06 Junio'
        WHEN 'July' THEN '07 Julio'
        WHEN 'August' THEN '08 Agosto'
        WHEN 'September' THEN '09 Septiembre'
        WHEN 'October' THEN '10 Octubre'
        WHEN 'November' THEN '11 Noviembre'
        WHEN 'December' THEN '12 Diciembre' END mes,
        sum(d.pvp),
        CASE (d.mes) WHEN 'January' THEN 1
        WHEN 'February' THEN 2
        WHEN 'March' THEN 3
        WHEN 'April' THEN 4
        WHEN 'May' THEN 5
        WHEN 'June' THEN 6
        WHEN 'July' THEN 7
        WHEN 'August' THEN 8
        WHEN 'September' THEN 9
        WHEN 'October' THEN 10
        WHEN 'November' THEN 11
        WHEN 'December' THEN 12 END valor_mes
        FROM
        data_mart_ventas AS d
        INNER JOIN dw_bodegas AS b ON d.bodega = b.nombre
        WHERE b.estado = 1
        GROUP BY d.anio,d.bodega,mes;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function sel_ventas_anuales() {
        $query = "SELECT * FROM data_mart_ventas_anual_mensual;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        $result->free();
        return $array;
    }

    public function update_porcentajes($anio, $bodega, $mes, $porcentaje_anual, $porcentaje_menual) {
        $query = "UPDATE data_mart_ventas_anual_mensual SET porcentaje_anual='$porcentaje_anual', porcentaje_menual='$porcentaje_menual' WHERE (bodega='$bodega') AND (anio='$anio') AND (mes='$mes') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function data_mart_venta_semanal() {
        $query = "INSERT INTO data_mart_ventas_semanal (bodega, anio, semana, valor)
        SELECT
	bodega,
	anio,
	WEEK (fecha_ingreso),
	sum(pvp)
        FROM
	data_mart_ventas
        GROUP BY bodega,anio,WEEK (fecha_ingreso)
        ORDER BY WEEK (fecha_ingreso);";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function data_mart_ventas_mensual() {
        $query = "INSERT INTO data_mart_ventas_mensual (bodega, anio, mes, numeromes, valor)
        SELECT
	bodega,
	anio,
        CASE mes WHEN 'January' THEN '01 Enero'
        WHEN 'February' THEN '02 Febrero'
        WHEN 'March' THEN '03 Marzo'
        WHEN 'April' THEN '04 Abril'
        WHEN 'May' THEN '05 Mayo'
        WHEN 'June' THEN '06 Junio'
        WHEN 'July' THEN '07 Julio'
        WHEN 'August' THEN '08 Agosto'
        WHEN 'September' THEN '09 Septiembre'
        WHEN 'October' THEN '10 Octubre'
        WHEN 'November' THEN '11 Noviembre'
        WHEN 'December' THEN '12 Diciembre' END mes,
	MONTH(fecha_ingreso),
	sum(pvp)
        FROM
	data_mart_ventas
        GROUP BY bodega,anio,MONTH(fecha_ingreso)
        ORDER BY WEEK (fecha_ingreso);";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

}
