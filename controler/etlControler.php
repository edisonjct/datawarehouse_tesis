<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioControler
 *
 * @author EChulde
 */
session_start();

date_default_timezone_set("America/Guayaquil");


error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('mysql.connect_timeout', 1200);
ini_set('default_socket_timeout', 1200);
ini_set('default_socket_timeout', 1200);
ini_set('max_execution_time', 10800);
ini_set('memory_limit', '15600M');

require_once '../model/etlModel.php';
require_once '../model/configuracionModel.php';
require_once 'funciones.php';
$etlModel = new etlModel();
$config = new configuracionModel();
$tiempo_inicio = microtime(true);
$proceso = $_POST['proceso'];
switch ($proceso) {
    case 'productos':
        $vaciar = $etlModel->vaciar_tabla('data_mart_productos');
        $max = $etlModel->max_registros('dw_productos');
        $count = '';
        $mensaje = '';
        $mensaje .= "- - - - - CREACION DE DATA MART DE PRODUCTOS - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= '=> Data Mart Productos vacio' . '<br>';
        $mensaje .= '=> Datos por procesar:' . $max->max . '<br>';
        for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
            $get = $etlModel->select_data_mart_productos($i);
            //echo count($get) . '<br>';
            $array = '';
            if ($get == true) {
                $count = $count + count($get);
                foreach ($get as $row) {
                    $array .= "('" . $row->codigo . "','" . $row->barras . "','" . evaluar($row->titulo) . "','" . $row->costo . "','" . $row->pvp . "'"
                            . ",'" . $row->iva . "','" . $row->descuento . "','" . $row->tipo_producto . "','" . $row->ubicacion . "','" . evaluar($row->categoria) . "'"
                            . ",'" . evaluar($row->autor) . "','" . evaluar($row->editorial) . "','" . evaluar($row->idioma) . "','" . evaluar($row->provedor) . "','" . evaluar($row->pais) . "'"
                            . ",'" . evaluar($row->tipo_provedor) . "','" . $row->cdi . "','" . $row->wb . "','" . $row->jrd . "','" . $row->sl . "'"
                            . ",'" . $row->cnd . "','" . $row->scl . "','" . $row->vl . "','" . $row->ev . "','" . $row->qc . "'"
                            . ",'" . $row->snl . "','" . $row->snm . "','" . $row->cm . "','" . $row->pcf . "','" . $row->man . "','" . $row->estado . "','" . $row->fecha_venta . "'),";
                }
                $array = substr($array, 0, -1);
                $insert = $etlModel->insert_tabla('data_mart_productos', $array);
                $mensaje .= '=> Datos Procesados:  ' . $count . ' de ' . $max->max . '<br>';
                unset($get, $array);
            }
        }
        echo $mensaje;
        $tiempo_fin = microtime(true);
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;

    case 'clientes':
        $vaciar = $etlModel->vaciar_tabla('data_mart_clientes');
        $max = $etlModel->max_registros('dw_clientes');
        $count = '';
        $mensaje = '';
        $mensaje .= "- - - - - CREACION DE DATA MART DE CLIENTES - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= '=> Data Mart Clientes vacio' . '<br>';
        $mensaje .= '=> Datos por procesar:' . $max->max . '<br>';
        for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
            $get = $etlModel->select_data_mart_clientes($i, '2017-01-01');
            $array = '';
            if ($get == true) {
                $count = $count + count($get);
                foreach ($get as $row) {
                    $array .= "('" . $row->codigo . "','" . evaluar($row->nombre) . "','" . evaluar($row->direccion) . "','" . $row->telefono . "'"
                            . ",'" . $row->cedularuc . "','" . $row->descuento . "','" . $row->saldo . "','" . $row->estado . "'"
                            . ",'" . evaluar($row->correo) . "','" . $row->tipo_cliente . "','" . evaluar($row->localidad) . "','" . $row->categoria . "'"
                            . ",'" . $row->genero . "','" . $row->usuario . "','" . $row->fecha_ingreso . "','" . $row->dia . "'"
                            . ",'" . $row->nomdia . "','" . $row->mes . "','" . $row->anio . "'),";
                }
                $array = substr($array, 0, -1);
                $insert = $etlModel->insert_tabla('data_mart_clientes', $array);
                $mensaje .= '=> Datos Procesados:  ' . $count . ' de ' . $max->max . '<br>';
                unset($get, $array);
            }
        }
        echo $mensaje;
        $tiempo_fin = microtime(true);
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;

    case 'provedores':
        $vaciar = $etlModel->vaciar_tabla('data_mart_provedores');
        $max = $etlModel->max_registros('dw_provedores');
        $count = '';
        $mensaje = '';
        $mensaje .= "- - - - - CREACION DE DATA MART DE PROVEDORES - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= '=> Data Mart Provedores vacio' . '<br>';
        $mensaje .= '=> Datos por procesar:' . $max->max . '<br>';
        for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
            $get = $etlModel->select_data_mart_provedores($i);
            $array = '';
            if ($get == true) {
                $count = $count + count($get);
                foreach ($get as $row) {
                    $array .= "('" . $row->ID . "','" . $row->cod_destino . "','" . evaluar($row->nombre) . "','" . evaluar($row->direccion) . "','" . $row->telefono . "'"
                            . ",'" . $row->cedularuc . "','" . $row->descuento . "','" . $row->saldo . "','" . $row->estado . "'"
                            . ",'" . evaluar($row->correo) . "','" . $row->localidad . "','" . $row->tipo_provedor . "','" . $row->condicion_pago . "'"
                            . ",'" . evaluar($row->destino) . "','" . $row->usuario . "','" . $row->fecha_ingreso . "','" . $row->dia . "'"
                            . ",'" . $row->nomdia . "','" . $row->mes . "','" . $row->anio . "'),";
                }
                $array = substr($array, 0, -1);
                $insert = $etlModel->insert_tabla('data_mart_provedores', $array);
                $mensaje .= '=> Datos Procesados:  ' . $count . ' de ' . $max->max . '<br>';
                unset($get, $array);
            }
        }
        echo $mensaje;
        $tiempo_fin = microtime(true);
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;

    case 'ventas':
        $vaciar = $etlModel->vaciar_tabla('data_mart_ventas');
        $max = $etlModel->max_registros('dw_facturas_detalle');
        $count = '';
        $mensaje = '';
        $mensaje .= "- - - - - CREACION DE DATA MART DE PROVEDORES - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= '=> Data Mart Ventas vacio' . '<br>';
        $mensaje .= '=> Datos procesados:' . $max->max . '<br>';
        $data_mart_ventas = $etlModel->select_data_mart_ventas('2017-01-01');

        echo $mensaje;
        $tiempo_fin = microtime(true);
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;

    case 'tablasdehechos':
        $mensaje = '';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - CREACION DE DATA TABLAS DE HECHOS - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= '=> Tabla de hechos ventas totales por anio vacio' . '<br>';
        $años_activos = $config->tabla_config_all('02');
        if ($años_activos) {
            $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
            $mensaje .= "- - - - - CREACION DE DATA TABLAS DE TOTALES - - - - - - -" . '<br>';
            $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
            foreach ($años_activos as $row) {
                $vaciar = $etlModel->eliminar_datos_tabla('dw_totales_anio', 'anio', $row->codtabla);
                $datos_años = $etlModel->select_datos_anios($row->codtabla);
            }
            $max = $etlModel->max_registros('dw_totales_anio');
            $mensaje .= '=> Datos Procesados:  ' . $max->max . '<br>';
        }
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - CREACION DE DATA TABLAS DE ANIO MENSUAL - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $vaciar = $etlModel->vaciar_tabla('data_mart_ventas_anual_mensual');
        $mensaje .= '=> Tabla de hechos ventas totales por anio y mes vacio' . '<br>';
        $llebar_ventas_anuales = $etlModel->ventas_anulaes();
        $max = $etlModel->max_registros('data_mart_ventas_anual_mensual');
        $mensaje .= '=> Datos Procesados:  ' . $max->max . '<br>';
        foreach ($años_activos as $row) {
            $valor_anio = $etlModel->total_ventas_anules($row->codtabla);
            $update_valor_anio = $etlModel->update_valor_anio($row->codtabla, $valor_anio->max);
            $mensaje .= '=> Datos Procesados:  ' . count($update_valor_anio) . '<br>';
        }
        $row_bodegas = $config->bodegas();
        foreach ($años_activos as $row) {
            foreach ($row_bodegas as $row_b) {
                $valor_bodega = $etlModel->total_ventas_anules_bodega($row->codtabla, $row_b->nombre);
                if ($valor_bodega) {
                    $update_valor_bodega = $etlModel->update_valor_bodega($row->codtabla, $row_b->nombre, $valor_bodega->max);
                    $max = $etlModel->max_registros('data_mart_ventas_anual_mensual');
                    $mensaje .= '=> Datos Procesados:  ' . $max->max . '<br>';
                }
            }
        }
        $ventas_anuales = $etlModel->sel_ventas_anuales();
        $mensaje .= '=> Datos Procesados:  ' . count($ventas_anuales) . '<br>';
        foreach ($ventas_anuales as $row) {
            $porcentaje_anual = (($row->valorbodega * 100) / $row->valoranio);
            $porcentaje_menual = (($row->valor * 100) / $row->valorbodega);
            $update = $etlModel->update_porcentajes($row->anio, $row->bodega, $row->mes, $porcentaje_anual, $porcentaje_menual);
        }
        $mensaje .= '=> Datos Procesados:  ' . count($ventas_anuales) . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - CREACION DE DATA TABLAS DE SEMANAS - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $vaciar_data_mart_venta_semanal = $etlModel->vaciar_tabla('data_mart_ventas_semanal');
        $mensaje .= '=> Tabla de hechos ventas totales por semana vacio' . '<br>';
        $crear_data_mart_venta_semanal = $etlModel->data_mart_venta_semanal();
        $max_semanal = $etlModel->max_registros('data_mart_ventas_semanal');
        $mensaje .= '=> Datos Procesados:  ' . $max_semanal->max . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $mensaje .= "- - - - - CREACION DE DATA TABLAS DE MESES - - - - - - -" . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        $vaciar_data_mart_ventas_mensual = $etlModel->vaciar_tabla('data_mart_ventas_mensual');
        $mensaje .= '=> Tabla de hechos ventas totales por mes vacio' . '<br>';
        $crear_data_mart_ventas_mensual = $etlModel->data_mart_ventas_mensual();
        $max_menual = $etlModel->max_registros('data_mart_ventas_mensual');
        $mensaje .= '=> Datos Procesados:  ' . $max_menual->max . '<br>';
        $mensaje .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . '<br>';
        echo $mensaje;
        $tiempo_fin = microtime(true);
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;
}