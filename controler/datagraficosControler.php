<?
/**
 * Description of Gerencia
 *
 * @author EChulde
 */
session_start();
include_once '../model/datagraficosModel.php';
include_once '../model/configuracionModel.php';
include_once '../controler/funciones.php';
$data_graficos = new datagraficosModel();
$config = new configuracionModel();
$años_activos = $config->tabla_config_all('02');

$proceso = $_POST['proceso'];

switch ($proceso) {
    case 'ventasanuales':
        $anio_actual = $_POST['anio'];
        $sel_ventas_tiendas = $data_graficos->sel_ventas_tienda($anio_actual);
        $array = '';
        foreach ($sel_ventas_tiendas as $row) {
            $array .= '{ "name": "' . $row->bodega . '","y": ' . $row->porcentaje_anual . ',"drilldown": "' . $row->bodega . '"},';
        }
        $array = substr($array, 0, -1);
        $array_datos = '';
        foreach ($sel_ventas_tiendas as $row2) {
            $array_datos .= '{ "name": "' . $row2->bodega . '","id": "' . $row2->bodega . '","data": [';
            $datos_meses = $data_graficos->sel_ventas_tienda_mes($anio_actual, $row2->bodega);
            foreach ($datos_meses as $mes) {
                $array_datos .= '["' . $mes->mes . '",' . $mes->porcentaje_menual . '],';
            }
            $array_datos .= ']},';
        }
        $array_datos = substr($array_datos, 0, -1);
        ?>
        <script>
            Highcharts.chart('ventastiendas', {
                chart: {type: 'column'},
                title: {text: 'Ventas Del año <?= $anio_actual ?>'},
                xAxis: {type: 'category'},
                yAxis: {title: {text: 'Porcentaje Total'}},
                legend: {enabled: false},
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
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> Del Total<br/>'
                },
                "series": [
                    {
                        "name": "Tiendas",
                        "colorByPoint": true,
                        "data": [<?= $array ?>]
                    }
                ],
                "drilldown": {
                    "series": [<?= $array_datos ?>
                    ]
                }
            });
        </script>
        <?
        break;

    case 'ventaspaises':
        $sel_nombre_pais = $data_graficos->sel_nombres_paises();
        $nombre_pais = '';
        foreach ($sel_nombre_pais as $row) {
            $nombre_pais .= "'" . $row->pais . "',";
        }
        $valores_pais = '';
        foreach ($años_activos as $row) {
            //echo $row_a->nomtabla;
            $sel_ventas_pais = $data_graficos->sel_ventas_paises($row->nomtabla);
            $valores_pais .= "{ name: 'Año " . $row->nomtabla . "', data: [";
            foreach ($sel_ventas_pais as $row_p) {
                $valores_pais .= ($row_p->valor) . ",";
            }
            $valores_pais .= ']},';
        }
        ?>
        <script>
            Highcharts.chart('ventaspaises', {
                chart: {type: 'bar'},
                title: {text: 'Venta por Paises'},
                xAxis: {
                    categories: [<?= $nombre_pais ?>],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population (millions)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' Mil'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {enabled: false},
                series: [<?= $valores_pais ?>]
            });
        </script>
        <?
        break;

    case 'ventascategoria':
        $anio = $_POST['anio'];
        $sel_ventas_categoria = $data_graficos->sel_ventas_categoria($anio);
        $nombres_categoria = '';
        $valores_categoria = '';
        foreach ($sel_ventas_categoria as $row) {
            $nombres_categoria .= "'" . $row->cat_producto . "',";
            $valores_categoria .= "['" . $row->cat_producto . "'," . $row->valor . ",false],";
        }
        ?>
        <script>
            Highcharts.chart('ventascategoria', {
                title: {text: 'TOP 10 CATEGORIAS <?= $anio ?>'},
                xAxis: {categories: [<?= $nombres_categoria ?>]},
                series: [{
                        type: 'pie',
                        allowPointSelect: true,
                        keys: ['name', 'y', 'selected', 'sliced'],
                        data: [<?= $valores_categoria ?>],
                        showInLegend: true
                    }]
            });
        </script>
        <?
        break;

    case 'ventasvendedor':
        $anio = $_POST['anio'];
        $sel_ventas_vendedor = $data_graficos->sel_ventas_vendedores($anio);
        $nombres_vendedor = '';
        $valores_vendedor = '';
        foreach ($sel_ventas_vendedor as $row) {
            $nombres_vendedor .= "'" . $row->vendedor . "',";
            $valores_vendedor .= "['" . $row->vendedor . "'," . $row->valor . ",false],";
        }
        ?>
        <script>
            Highcharts.chart('ventasvendedor', {
                title: {text: 'TOP 10 VENDEDOR <?= $anio ?>'},
                xAxis: {categories: [<?= $nombres_vendedor ?>]},
                series: [{
                        type: 'pie',
                        allowPointSelect: true,
                        keys: ['name', 'y', 'selected', 'sliced'],
                        data: [<?= $valores_vendedor ?>],
                        showInLegend: true
                    }]
            });
        </script>
        <?
        break;

    case 'ventasclientes':
        $anio = $_POST['anio'];
        $sel_ventas_clientes = $data_graficos->sel_ventas_clientes($anio);
        $nombres_clientes = '';
        $valores_clientes = '';
        foreach ($sel_ventas_clientes as $row) {
            $nombres_clientes .= "'" . $row->cliente . "',";
            $valores_clientes .= "['" . $row->cliente . "'," . $row->valor . ",false],";
        }
        ?>
        <script>
            Highcharts.chart('ventasclientes', {
                title: {text: 'TOP 10 CLIENTES <?= $anio ?>'},
                xAxis: {categories: [<?= $nombres_clientes ?>]},
                series: [{
                        type: 'pie',
                        allowPointSelect: true,
                        keys: ['name', 'y', 'selected', 'sliced'],
                        data: [<?= $valores_clientes ?>],
                        showInLegend: true
                    }]
            });
        </script>
        <?
        break;
}