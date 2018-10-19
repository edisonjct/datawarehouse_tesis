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
session_start();
if (!$_SESSION['id']) {
    header('Location: ../index.php');
}
include_once '../model/configuracionModel.php';
include_once '../model/usuarioModel.php';

$usuarioModel = new usuarioModel();
$usuarios = $usuarioModel->tabla_usuarios_all();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>USUARIOS</title>                
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- Datatables -->
        <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
        <link href="build/css/custom.min.css" rel="stylesheet">
        <script src="vendors/highcharts/highcharts.js"></script>
        <script src="vendors/highcharts/data.js"></script>
        <script src="vendors/highcharts/drilldown.js"></script>
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
                        <div class="row" id="datos-usuario">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>VENTAS POR TIENDAS</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                    </div>
                                </div>
                            </div>                                                                                    
                        </div>  
                        <script>

// Create the chart
                            Highcharts.chart('container', {
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Browser market shares. January, 2018'
                                },
                                subtitle: {
                                    text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                                },
                                xAxis: {
                                    type: 'category'
                                },
                                yAxis: {
                                    title: {
                                        text: 'Total percent market share'
                                    }

                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%'
                                        }
                                    }
                                },

                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                },

                                "series": [
                                    {
                                        "name": "Browsers",
                                        "colorByPoint": true,
                                        "data": [
                                            {
                                                "name": "Chrome",
                                                "y": 62.74,
                                                "drilldown": "Chrome"
                                            },
                                            {
                                                "name": "Firefox",
                                                "y": 10.57,
                                                "drilldown": "Firefox"
                                            },
                                            {
                                                "name": "Internet Explorer",
                                                "y": 7.23,
                                                "drilldown": "Internet Explorer"
                                            },
                                            {
                                                "name": "Safari",
                                                "y": 5.58,
                                                "drilldown": "Safari"
                                            },
                                            {
                                                "name": "Edge",
                                                "y": 4.02,
                                                "drilldown": "Edge"
                                            },
                                            {
                                                "name": "Opera",
                                                "y": 1.92,
                                                "drilldown": "Opera"
                                            },
                                            {
                                                "name": "Other",
                                                "y": 7.62,
                                                "drilldown": null
                                            }
                                        ]
                                    }
                                ],
                                "drilldown": {
                                    "series": [
                                        {
                                            "name": "Chrome",
                                            "id": "Chrome",
                                            "data": [
                                                [
                                                    "v65.0",
                                                    0.1
                                                ],
                                                [
                                                    "v64.0",
                                                    1.3
                                                ],
                                                [
                                                    "v63.0",
                                                    53.02
                                                ],
                                                [
                                                    "v62.0",
                                                    1.4
                                                ],
                                                [
                                                    "v61.0",
                                                    0.88
                                                ],
                                                [
                                                    "v60.0",
                                                    0.56
                                                ],
                                                [
                                                    "v59.0",
                                                    0.45
                                                ],
                                                [
                                                    "v58.0",
                                                    0.49
                                                ],
                                                [
                                                    "v57.0",
                                                    0.32
                                                ],
                                                [
                                                    "v56.0",
                                                    0.29
                                                ],
                                                [
                                                    "v55.0",
                                                    0.79
                                                ],
                                                [
                                                    "v54.0",
                                                    0.18
                                                ],
                                                [
                                                    "v51.0",
                                                    0.13
                                                ],
                                                [
                                                    "v49.0",
                                                    2.16
                                                ],
                                                [
                                                    "v48.0",
                                                    0.13
                                                ],
                                                [
                                                    "v47.0",
                                                    0.11
                                                ],
                                                [
                                                    "v43.0",
                                                    0.17
                                                ],
                                                [
                                                    "v29.0",
                                                    0.26
                                                ]
                                            ]
                                        },
                                        {
                                            "name": "Firefox",
                                            "id": "Firefox",
                                            "data": [
                                                [
                                                    "v58.0",
                                                    1.02
                                                ],
                                                [
                                                    "v57.0",
                                                    7.36
                                                ],
                                                [
                                                    "v56.0",
                                                    0.35
                                                ],
                                                [
                                                    "v55.0",
                                                    0.11
                                                ],
                                                [
                                                    "v54.0",
                                                    0.1
                                                ],
                                                [
                                                    "v52.0",
                                                    0.95
                                                ],
                                                [
                                                    "v51.0",
                                                    0.15
                                                ],
                                                [
                                                    "v50.0",
                                                    0.1
                                                ],
                                                [
                                                    "v48.0",
                                                    0.31
                                                ],
                                                [
                                                    "v47.0",
                                                    0.12
                                                ]
                                            ]
                                        },
                                        {
                                            "name": "Internet Explorer",
                                            "id": "Internet Explorer",
                                            "data": [
                                                [
                                                    "v11.0",
                                                    6.2
                                                ],
                                                [
                                                    "v10.0",
                                                    0.29
                                                ],
                                                [
                                                    "v9.0",
                                                    0.27
                                                ],
                                                [
                                                    "v8.0",
                                                    0.47
                                                ]
                                            ]
                                        },
                                        {
                                            "name": "Safari",
                                            "id": "Safari",
                                            "data": [
                                                [
                                                    "v11.0",
                                                    3.39
                                                ],
                                                [
                                                    "v10.1",
                                                    0.96
                                                ],
                                                [
                                                    "v10.0",
                                                    0.36
                                                ],
                                                [
                                                    "v9.1",
                                                    0.54
                                                ],
                                                [
                                                    "v9.0",
                                                    0.13
                                                ],
                                                [
                                                    "v5.1",
                                                    0.2
                                                ]
                                            ]
                                        },
                                        {
                                            "name": "Edge",
                                            "id": "Edge",
                                            "data": [
                                                [
                                                    "v16",
                                                    2.6
                                                ],
                                                [
                                                    "v15",
                                                    0.92
                                                ],
                                                [
                                                    "v14",
                                                    0.4
                                                ],
                                                [
                                                    "v13",
                                                    0.1
                                                ]
                                            ]
                                        },
                                        {
                                            "name": "Opera",
                                            "id": "Opera",
                                            "data": [
                                                [
                                                    "v50.0",
                                                    0.96
                                                ],
                                                [
                                                    "v49.0",
                                                    0.82
                                                ],
                                                [
                                                    "v12.1",
                                                    0.14
                                                ]
                                            ]
                                        }
                                    ]
                                }
                            });
                        </script>

                    </div>
                </div>
                <!-- /page content -->
                <? include_once 'templates/footer.php'; ?>
            </div>
        </div>
        <script src="vendors/jquery/dist/jquery.min.js"></script>        
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
        <script src="js/usuarios.js"></script>
    </body>
</html>
