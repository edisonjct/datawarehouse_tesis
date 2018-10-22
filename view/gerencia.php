<?
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gerencia
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
        <title>GERENCIA</title>                
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">        
        <link href="build/css/custom.min.css" rel="stylesheet">
        <script src="vendors/highcharts/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="vendors/highcharts/data.js"></script>
        <script src="vendors/highcharts/drilldown.js"></script>
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
                        <h1>REPORTES ESTADISTICOS</h1>
                        <? foreach ($años_activos as $row) { ?>
                            <?
                            $result_semana = $data_graficos->venta_semanal($row->nomtabla, $semana);
                            $result_mes = $data_graficos->venta_mensual($row->nomtabla, $mes);
                            $result_anio = $data_graficos->venta_anual($row->nomtabla);
                            ?>
                            <h3><?= $row->nomtabla ?></h3>
                            <div class="row top_tiles">                            
                                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-money"></i></div>
                                        <div class="count"><?= kas($result_semana->semana) ?></div>
                                        <h3>Ventas Semanal <?= $row->nomtabla ?></h3>                                        
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-money"></i></div>
                                        <div class="count"><?= kas($result_mes->mes) ?></div>
                                        <h3>Venta Mensual <?= $row->nomtabla ?></h3>                                        
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon"><i class="fa fa-money"></i></div>
                                        <div class="count"><?= kas($result_anio->anio) ?></div>
                                        <h3>Venta Anual <?= $row->nomtabla ?></h3>                                        
                                    </div>
                                </div>                                
                            </div>
                        <? } ?>

                        <div class="row" id="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>VENTAS ANUALES</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <select class="form-control" id="anioventas" onchange="cargar_venta_anaul();">
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                            </select>
                                        </ul>
                                        <div class="clearfix"></div>                                        
                                    </div>
                                    <div class="x_content">
                                        <div id="ventastiendas" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                    </div>
                                </div>
                            </div>                                                                                    
                        </div>

                        <div class="row" id="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>VENTAS POR PAIS</h2>
                                        <ul class="nav navbar-right panel_toolbox">                                            
                                        </ul>
                                        <div class="clearfix"></div>                                        
                                    </div>
                                    <div class="x_content">
                                        <div id="ventaspaises" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                    </div>
                                </div>
                            </div>                                                                                    
                        </div>
                        <div class="row" id="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>TOP 10 CATEGORIAS</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <select class="form-control" id="aniocategoria" onchange="cargar_categoria();">
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                            </select>
                                        </ul>
                                        <div class="clearfix"></div>                                        
                                    </div>
                                    <div class="x_content">
                                        <div id="ventascategoria" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                    </div>
                                </div>
                            </div>                                                                                    
                        </div>
                        <div class="row" id="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>TOP 10 VENDEDORES</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <select class="form-control" id="aniovendedor" onchange="cargar_vendedores();">
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                            </select>
                                        </ul>
                                        <div class="clearfix"></div>                                        
                                    </div>
                                    <div class="x_content">
                                        <div id="ventasvendedor" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row" id="">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>TOP 10 CLIENTES</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <select class="form-control" id="anioclientes" onchange="cargar_ventas_clientes();">
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                            </select>
                                        </ul>
                                        <div class="clearfix"></div>                                        
                                    </div>
                                    <div class="x_content">
                                        <div id="ventasclientes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
        <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="vendors/jszip/dist/jszip.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>        
        <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>        
        <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="vendors/pdfmake/build/vfs_fonts.js"></script>        
        <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="build/js/custom.js"></script>
        <script src="vendors/sweetalert/sweetalert2.all.min.js"></script>
        <script src="js/graficos.js"></script>
    </body>
</html>
