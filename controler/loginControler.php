<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginControler
 *
 * @author EChulde
 */

include_once '../model/loginModel.php';
include_once 'funciones.php';
$loginModel = new loginModel();
$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_POST['usuario'];
$clave = $_POST['password'];
$rows = $loginModel->valida_usuario($usuario, md5($clave));
if ($rows) {
    session_start();
    $_SESSION["id"] = $rows->ID_USUARIO;
    $_SESSION["perfil"] = $rows->ID_PERFIL;
    $_SESSION["nombre"] = $rows->nombre;
    $navegador = getBrowser($_SERVER['HTTP_USER_AGENT']);
    $OS = getPlatform($_SERVER['HTTP_USER_AGENT']);
    $bitacora = $loginModel->bitacora($fecha_actual, $usuario, getRealIP(), $navegador, $OS);
    echo $bitacora;
}



