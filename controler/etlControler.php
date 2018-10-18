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

require_once '../model/dtsModel.php';
require_once '../model/configuracionModel.php';
require_once 'funciones.php';

$dtsSRE = new dtsModel();
$config = new configuracionModel();
$row_bodegas = $config->bodegas();

$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION["id"];

function autores() {
    $dtsSRE = new dtsModel();
    $urlrow = $dtsSRE->getdatosbyid('05', 'url');
    $sitio = $urlrow->nomtabla;

    $url = 'http://' . $sitio . '/webservicelink/index/autores';
    //$url = 'http://' . $sitio . '/webservicelink/index/max_tabla';
    $postdata = http_build_query(
            array(
                'base' => 'mrbooks',
                'tabla' => 'autores'
            )
    );
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);

//    $max_autores = json_decode($result, true);
//    foreach ($max_autores as $max){
//        $max_tabla = $max['max'];
//    }
    //for ($i = 0; $i <= millar($max_tabla); $i = $i + 1000) {
    

    //}
//        $DataArr = array();
//    foreach ($get_autores as $row) {
//        $fieldVal1 = $row['codigo'];
//        $fieldVal2 = $row['nombres'];
//        $DataArr[] = '("' . $fieldVal1 . '", "' . $fieldVal2 . '")';
//    }
//    
//
//    //var_dump(count($DataArr));
//    $dtsSRE->insert_autores(implode(',', $DataArr));
//    $sql = "INSERT INTO programming_lang (field1, field2) values ";
//    $sql .= implode(',', $DataArr);
//
//    echo $sql;
//    foreach ($get_autores as $idx => $data) {
//        $get_autores[$idx] = "'" . $data . "'";
//    }
//    $values  = implode(", ", $get_autores);
//    $dtsSRE->insert_autores($values);
//    foreach ($get_autores as $i => $row) {
//        $get_autores[$i] = "'" . $row . "'";
//        //$dtsSRE->insert_autores("('" . $row['codigo'] . "','" . evaluar($row['nombres']) . "')");       
//    }        
}

autores();
