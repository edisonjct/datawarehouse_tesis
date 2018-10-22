<?
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tablas de hechos
 *
 * @author EChulde
 */
date_default_timezone_set("America/Guayaquil");
session_start();
if (!$_SESSION['id']) {
    header('Location: ../index.php');
}
include_once '../model/configuracionModel.php';
include_once '../model/datagraficosModel.php';
include_once '../controler/funciones.php';
$config = new configuracionModel();
$data_graficos = new datagraficosModel();
$row_bodegas = $config->bodegas();
$años_activos = $config->tabla_config_all('02');
$fecha_actual = date("Y-m-d H:i:s");
$anio_actual = date("Y");
$sem = date("W");
$semana = $sem - 1;
$mes = date("m");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ETL TABLAS DE HECHOS</title>                
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">        
        <link href="build/css/custom.min.css" rel="stylesheet">                       
        <script src="vendors/jquery/dist/jquery.min.js"></script>             
        <script src="vendors/blockUI/jquery.blockUI.js"></script>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <? include_once 'menuprofile.php'; ?>
                <? include_once 'menusidebar.php'; ?>
                <? include_once 'menufooter.php'; ?>
                <? include_once 'menusiderbar2.php'; ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>
                        <div class="alert alert-info alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Info!</strong> Procesos ETL para generación de tablas de Hechos
                        </div>
                        <div class="clearfix"></div>                        
                        <div class="row" id="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>ETL TABLAS DE HECHOS</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <button id="btn-tablas" class="btn btn-danger" onclick="etltablas();">Procesar</button>
                                        </ul>
                                        <div class="clearfix"></div>                                        
                                    </div>
                                    <div class="x_content">
                                        <div id="etltablas" style="min-width: 310px; height: auto; margin: 0 auto"></div>
                                    </div>
                                </div>
                            </div>                                                                                    
                        </div>                       
                    </div>
                </div>
                <!-- /page content -->
                <? include_once 'templates/footer.php'; ?>
            </div>
        </div>

        <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>        
        <script src="vendors/fastclick/lib/fastclick.js"></script>        
        <script src="vendors/nprogress/nprogress.js"></script>        
        <script src="build/js/custom.js"></script>
        <script src="vendors/sweetalert/sweetalert2.all.min.js"></script>
        <script src="js/etl.js"></script>
    </body>
</html>