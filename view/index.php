<?
session_start();
if (!$_SESSION['id']) {
    header('Location: ../index.php');
}
include_once '../model/cubosModel.php';
include_once '../model/configuracionModel.php';
include_once '../controler/funciones.php';
$cubo = new cubosModel();
$config = new configuracionModel();
$provedores = $cubo->max_tabla('data_mart_provedores');
$clientes = $cubo->max_tabla('data_mart_clientes');
$productos = $cubo->max_tabla('data_mart_productos');
$usuarios = $cubo->max_tabla('dw_usuario');

$años_activos = $config->tabla_config_all('02');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DATA WAREHOUSE</title>        
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">        
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">        
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">        
        <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">        
        <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>        
        <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">        
        <link href="build/css/custom.css" rel="stylesheet">
        <script src="js/echarts.min.js"></script>
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
                    <!-- top tiles -->
                    <div class="row tile_count">
                        <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total Clientes</span>
                            <div class="count"><?= number_format($clientes->max, 0, '.', ',') ?></div>                            
                        </div>                                                
                        <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total Provedores</span>
                            <div class="count"><?= number_format($provedores->max, 0, '.', ',') ?></div>                            
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total Productos</span>
                            <div class="count"><?= number_format($productos->max, 0, '.', ',') ?></div>                            
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Total Usuarios</span>
                            <div class="count"><?= number_format($usuarios->max, 0, '.', ',') ?></div>                            
                        </div>
                    </div>
                    <!-- /top tiles -->

                    <br />

                    <div class="row">
                        <? foreach ($años_activos as $col) { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel tile fixed_height_420">
                                    <div class="x_title">
                                        <h2><?= $col->codtabla ?></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">                                    
                                        <? $venta_tiendas = $cubo->datos_totales_anios($col->codtabla); ?>
                                        <? foreach ($venta_tiendas as $row) { ?>
                                            <div class="widget_summary">
                                                <div class="w_left w_25">
                                                    <span><?= $row->bodega ?></span>
                                                </div>
                                                <div class="w_center w_55">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?= $row->porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $row->porcentaje ?>%;">
                                                            <span class="sr-only"><?= $row->porcentaje ?>% Complete</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w_right w_20">
                                                    <span><?= kas($row->venta) ?></span>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>


                        <? } ?>   


                        <? foreach ($años_activos as $col) { ?>
                            <?
                            $venta_tiendas = $cubo->datos_totales_anios($col->codtabla);
                            $array = '';
                            $max = 0;
                            foreach ($venta_tiendas as $row) {
                                $array .= "{value: " . $row->venta . " , name: '" . $row->bodega . "'},";
                                $max = $row->total;
                            }
                            $array2 = '';
                            foreach ($venta_tiendas as $row2) {
                                $array2 .= "'" . $row2->bodega . "'" . ",";
                            }



                            $maximo = $max;
                            ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>VENTAS <?= $col->codtabla ?></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="">
                                        <div id="main<?= $col->codtabla ?>" style="width: 100%;height:400px;"></div>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                                var myChart = echarts.init(document.getElementById('main<?= $col->codtabla ?>'));
                                option = {
                                    tooltip: {trigger: 'item', formatter: "{a} <br/>{b} : {c} ({d}%)"},
                                    legend: {x: 'center', y: 'bottom', data: [<?= $array ?>]},
                                    toolbox: {
                                        show: true,
                                        feature: {
                                            mark: {show: true},
                                            dataView: {show: true, readOnly: false},
                                            magicType: {
                                                show: true,
                                                type: ['pie', 'funnel'],
                                                option: {funnel: {x: '25%', width: '50%', funnelAlign: 'left', max: <?= $maximo ?>}}
                                            },
                                            restore: {show: true},
                                            saveAsImage: {show: true}
                                        }
                                    },
                                    calculable: true,
                                    series: [
                                        {
                                            name: '<?= $col->codtabla ?>',
                                            type: 'pie',
                                            radius: '55%',
                                            center: ['50%', '38%'],
                                            data: [<?= $array ?>]
                                        }
                                    ]
                                };
                                myChart.setOption(option);
                            </script>
                        <? } ?>





                    </div>





                </div>
                <!-- /page content -->
                <? include_once 'templates/footer.php'; ?>
            </div>
        </div>

        <!-- jQuery -->
        <script src="vendors/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap -->
        <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="vendors/nprogress/nprogress.js"></script>
        <!-- ECharts -->

<!--<script src="vendors/echarts/map/js/world.js"></script>-->
        <!-- gauge.js -->
        <script src="vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="vendors/Flot/jquery.flot.js"></script>
        <script src="vendors/Flot/jquery.flot.pie.js"></script>
        <script src="vendors/Flot/jquery.flot.time.js"></script>
        <script src="vendors/Flot/jquery.flot.stack.js"></script>
        <script src="vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="vendors/DateJS/build/date.js"></script>
        <!-- JQVMap -->
        <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
        <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="vendors/moment/min/moment.min.js"></script>
        <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.js"></script>



    </body>
</html>
