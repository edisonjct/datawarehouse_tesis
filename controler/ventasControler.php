<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ventasControler
 *
 * @author EChulde
 */
session_start();
include_once '../model/cubosModel.php';
include_once 'funciones.php';

$cubo = new cubosModel();

switch ($_POST['proceso']) {
    case 'ventas':
        $desde = $_POST['start'];
        $hasta = $_POST['end'];
        $tipo = $_POST['tipo'];

        $venta_tiendas = $cubo->datos_grafico_ventas($desde, $hasta);
        $array_nombre = '';
        $array_facturas = '';
        $array_libros = '';
        $array_venta = '';
        foreach ($venta_tiendas as $row) {
            $array_nombre .= "'" . $row->bodega . "',";
            $array_facturas .= number_format($row->facturas, 0, '', '') . ',';
            $array_libros .= number_format($row->cantidad, 0, '', '') . ',';
            $array_venta .= number_format($row->pvp, 0, '', '') . ',';
        }
        ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">                        
                <div class="x_panel">                                                       
                    <div class="x_content">
                        <div id="main" style="height:350px;"></div>
                    </div>
                </div>
            </div>                    
        </div>


        <script>
            var myChart = echarts.init(document.getElementById('main'));
            var option = {
                title: {
                    text: 'Grafico de Ventas',
                    subtext: 'Grafico de Cubos'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: ['Facturas', 'Libros', 'Venta']
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: {show: true},
                        dataView: {show: true, readOnly: false},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },

                xAxis: [
                    {
                        type: 'category',
                        data: [<?= $array_nombre; ?>]
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    {
                        name: 'Facturas',
                        type: 'bar',
                        data: [<?= $array_facturas; ?>]
                    },
                    {
                        name: 'Libros',
                        type: 'bar',
                        data: [<?= $array_libros; ?>]
                    },
                    {
                        name: 'Venta',
                        type: 'bar',
                        data: [<?= $array_venta; ?>],
                        markLine: {
                            lineStyle: {
                                normal: {
                                    type: 'dashed'
                                }
                            },
                            data: [
                                [{type: 'min'}, {type: 'max'}]
                            ]
                        }
                    }
                ]
            };


            // use configuration item and data specified to show chart
            myChart.setOption(option);
        </script>
        <?
        switch ($tipo) {
            case '0':
                $get = $cubo->cubo_ventas_totalisado($desde, $hasta);
                $array = '';
                $contfacturas = 0;
                $ultimafactura = '';
                if ($get == true) {
                    foreach ($get as $row) {
                        $array .= "['" . $row->tipo . "','" . $row->fecha_ingreso . "'," . $row->numdoc . "," . $row->cantidad . "," . $row->costo . ""
                                . "," . $row->vtabta . "," . $row->vtanet . "," . $row->desct . "," . $row->pvp . "," . $row->dia . ""
                                . ",'" . $row->mes . "'," . $row->anio . ",'" . $row->cat_cliente . "','" . $row->ciudad . "','" . $row->bodega . "'"
                                . ",'" . $row->autor . "','" . $row->editorial . "','" . $row->cat_producto . "','" . $row->idioma . "','" . $row->provedor . "'"
                                . ",'" . $row->pais . "','" . $row->tipo_provedor . "'," . $row->cdi . "], ";
                    }
                    $array = substr($array, 0, -1);
                    $respuesta = $array;
                }
                ?>               
                <div id="rr" style="padding: 7px;"></div>
                <div id="export" style="padding: 7px;"></div>
                <script type="text/javascript">
                    window.demo = {};
                    window.demo.data = [];
                    var data = getData();
                    for (var t = 0; t < 1; t++) {
                        for (var j = 0; j < data.length; j++) {
                            window.demo.data.push(data[j]);
                        }
                    }
                    function getData() {
                        return [
                <?= $respuesta ?>
                        ];
                    }
                    function addCommas(nStr) {
                        nStr += '';
                        x = nStr.split('.');
                        x1 = x[0];
                        x2 = x.length > 1 ? '.' + x[1] : '';
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                            x1 = x1.replace(rgx, '$1' + ',' + '$2');
                        }
                        return x1 + x2;
                    }

                    function exportToExcel(anchor) {
                        anchor.href = orb.export(pgridwidget);
                        return true;
                    }

                    var config = {
                        dataSource: window.demo.data,
                        canMoveFields: true,
                        dataHeadersLocation: 'columns',
                        width: 1980,
                        height: 811,
                        theme: 'gray',
                        toolbar: {visible: true},
                        grandTotal: {rowsvisible: true, columnsvisible: true},
                        subTotal: {visible: true, collapsed: true, collapsible: true},
                        rowSettings: {
                            subTotal: {
                                visible: true,
                                collapsed: true,
                                collapsible: true
                            }
                        },
                        columnSettings: {
                            subTotal: {
                                visible: true,
                                collapsed: true,
                                collapsible: true
                            }
                        },
                        fields: [
                            {name: '0', caption: 'Tipo'},
                            {name: '1', caption: 'Fecha'},
                            {name: '2', caption: '#Doc', aggregateFunc: 'sum'},
                            {name: '3', caption: 'Libros'},
                            {name: '4', caption: 'Costo', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '5', caption: 'VtBta', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '6', caption: 'VtNet', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '7', caption: 'Descu.', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '8', caption: 'PVP', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '9', caption: '#Dia'},
                            {name: '10', caption: 'Mes'},
                            {name: '11', caption: 'Año'},
                            {name: '12', caption: 'CatCliente'},
                            {name: '13', caption: 'Ciudad'},
                            {name: '14', caption: 'Bodega'},
                            {name: '15', caption: 'Autor'},
                            {name: '16', caption: 'Editorial'},
                            {name: '17', caption: 'CatProducto'},
                            {name: '18', caption: 'Idioma'},
                            {name: '19', caption: 'Provedor'},
                            {name: '20', caption: 'Pais'},
                            {name: '21', caption: 'TipProvedor'},
                            {name: '22', caption: 'CD'}
                        ],
                        rows: ['Bodega'],
                        columns: ['Año', 'Mes'],
                        data: ['Libros', 'PVP', '#Doc']

                    };
                    var elem = document.getElementById('rr');
                    var pgridwidget = new orb.pgridwidget(config);
                    pgridwidget.render(elem);
                </script>
                <?
                break;

            case '1':
                $get = $cubo->cubo_ventas_detallado($desde, $hasta);
                $array = '';
                $contfacturas = 0;
                $ultimafactura = '';
                if ($get == true) {
                    foreach ($get as $row) {
                        if ($row->documento != $ultimafactura) {
                            $contfacturas = 1;
                        } else {
                            $contfacturas = 0;
                        }
                        $array .= "['" . $row->tipo . "','" . $row->documento . "','" . $row->fecha_ingreso . "'," . $row->cantidad . "," . $row->costo . ""
                                . "," . $row->vtabta . "," . $row->vtanet . "," . $row->desct . "," . $row->pvp . "," . $row->iva . ""
                                . "," . $row->dia . ",'" . $row->dianom . "','" . $row->mes . "'," . $row->anio . "," . $row->hora . ""
                                . "," . $row->minuto . ",'" . $row->cedularuc . "','" . $row->cliente . "','" . $row->direccion . "','" . $row->telefono . "'"
                                . ",'" . $row->correo . "','" . $row->tipo_cliente . "','" . $row->cat_cliente . "','" . $row->ciudad . "','" . $row->genero . "'"
                                . ",'" . $row->vendedor . "','" . $row->cajero . "','" . $row->bodega . "','" . $row->codigo . "','" . $row->barras . "'"
                                . ",'" . $row->titulo . "','" . $row->autor . "','" . $row->editorial . "','" . $row->cat_producto . "','" . $row->idioma . "'"
                                . ",'" . $row->provedor . "','" . $row->pais . "','" . $row->tipo_provedor . "'," . $row->cdi . "," . $contfacturas . "], ";
                    }
                    $array = substr($array, 0, -1);
                    $respuesta = $array;
                }
                ?>
                <div id="rr" style="padding: 7px;"></div>
                <div id="export" style="padding: 7px;"></div>
                <script type="text/javascript">
                    window.demo = {};
                    window.demo.data = [];
                    var data = getData();
                    for (var t = 0; t < 1; t++) {
                        for (var j = 0; j < data.length; j++) {
                            window.demo.data.push(data[j]);
                        }
                    }

                    function getData() {
                        return [
                <?= $respuesta ?>
                        ];
                    }
                    function addCommas(nStr) {
                        nStr += '';
                        x = nStr.split('.');
                        x1 = x[0];
                        x2 = x.length > 1 ? '.' + x[1] : '';
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                            x1 = x1.replace(rgx, '$1' + ',' + '$2');
                        }
                        return x1 + x2;
                    }
                    function exportToExcel(anchor) {
                        anchor.href = orb.export(pgridwidget);
                        return true;
                    }
                    var config = {
                        dataSource: window.demo.data,
                        canMoveFields: true,
                        dataHeadersLocation: 'columns',
                        width: 3980,
                        height: 811,
                        theme: 'gray',
                        toolbar: {visible: true},
                        grandTotal: {rowsvisible: true, columnsvisible: true},
                        subTotal: {visible: true, collapsed: true, collapsible: true},
                        rowSettings: {
                            subTotal: {
                                visible: true,
                                collapsed: true,
                                collapsible: true
                            }
                        },
                        columnSettings: {
                            subTotal: {
                                visible: true,
                                collapsed: true,
                                collapsible: true
                            }
                        },
                        fields: [
                            {name: '0', caption: 'Tipo'},
                            {name: '1', caption: '#Documento'},
                            {name: '2', caption: 'Fecha'},
                            {name: '3', caption: 'Libros', aggregateFunc: 'sum'},
                            {name: '4', caption: 'Costo', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '5', caption: 'VtBta', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '6', caption: 'VtNet', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '7', caption: 'Descu', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '8', caption: 'PVP', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                        return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                    }
                                }},
                            {name: '9', caption: 'IVA'},
                            {name: '10', caption: '#Dia'},
                            {name: '11', caption: 'DiaNom'},
                            {name: '12', caption: 'Mes'},
                            {name: '13', caption: 'Año'},
                            {name: '14', caption: 'Hora'},
                            {name: '15', caption: 'Munuto'},
                            {name: '16', caption: 'Cedula'},
                            {name: '17', caption: 'Cliente'},
                            {name: '18', caption: 'Direcion'},
                            {name: '19', caption: 'Telefono'},
                            {name: '20', caption: 'Correo'},
                            {name: '21', caption: 'TipCliente'},
                            {name: '22', caption: 'CatCliente'},
                            {name: '23', caption: 'Ciudad'},
                            {name: '24', caption: 'Genero'},
                            {name: '25', caption: 'Vendedor'},
                            {name: '26', caption: 'Cajero'},
                            {name: '27', caption: 'Bodega'},
                            {name: '28', caption: 'Codigo'},
                            {name: '29', caption: 'Barras'},
                            {name: '30', caption: 'Titulo'},
                            {name: '31', caption: 'Autor'},
                            {name: '32', caption: 'Editorial'},
                            {name: '33', caption: 'CatProducto'},
                            {name: '34', caption: 'Idioma'},
                            {name: '35', caption: 'Provedor'},
                            {name: '36', caption: 'Pais'},
                            {name: '37', caption: 'TipProvedor'},
                            {name: '38', caption: 'CD'},
                            {name: '39', caption: '#Doc', aggregateFunc: 'count'}
                        ],
                        rows: ['Bodega'],
                        columns: ['Año', 'Mes'],
                        data: ['Libros', 'PVP', '#Doc']
                    };
                    var elem = document.getElementById('rr');
                    var pgridwidget = new orb.pgridwidget(config);
                    pgridwidget.render(elem);
                </script>
                <?
                break;
        }

        break;

    case 'clientes':
        $desde = $_POST['start'];
        $hasta = $_POST['end'];
        $cont = 1;
        $array = '';
        $get = $cubo->cubo_clientes($desde, $hasta);
        if ($get == true) {
            foreach ($get as $row) {
                $array .= "['" . $row->codigo . "','" . $row->nombre . "','" . $row->direccion . "','" . $row->telefono . "','" . $row->cedularuc . "'"
                        . ",'" . $row->descuento . "'," . $row->saldo . ",'" . $row->estado . "','" . $row->correo . "','" . $row->tipo_cliente . "'"
                        . ",'" . $row->localidad . "','" . $row->categoria . "','" . $row->genero . "','" . $row->usuario . "','" . $row->fecha_ingreso . "'"
                        . ",'" . $row->dia . "','" . $row->nomdia . "','" . $row->mes . "','" . $row->anio . "'," . $cont . "], ";
            }
            $array = substr($array, 0, -1);
            $respuesta = $array;
            ?>
            <div id="rr" style="padding: 7px;"></div>
            <div id="export" style="padding: 7px;"></div>
            <script type="text/javascript">
                window.demo = {};
                window.demo.data = [];
                var data = getData();
                for (var t = 0; t < 1; t++) {
                    for (var j = 0; j < data.length; j++) {
                        window.demo.data.push(data[j]);
                    }
                }
                function getData() {
                    return [
            <?= $respuesta ?>
                    ];
                }
                function addCommas(nStr) {
                    nStr += '';
                    x = nStr.split('.');
                    x1 = x[0];
                    x2 = x.length > 1 ? '.' + x[1] : '';
                    var rgx = /(\d+)(\d{3})/;
                    while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    }
                    return x1 + x2;
                }

                function exportToExcel(anchor) {
                    anchor.href = orb.export(pgridwidget);
                    return true;
                }

                var config = {
                    dataSource: window.demo.data,
                    canMoveFields: true,
                    dataHeadersLocation: 'columns',
                    width: 1380,
                    height: 811,
                    theme: 'gray',
                    toolbar: {visible: true},
                    grandTotal: {rowsvisible: true, columnsvisible: true},
                    subTotal: {visible: true, collapsed: true, collapsible: true},
                    rowSettings: {
                        subTotal: {
                            visible: true,
                            collapsed: true,
                            collapsible: true
                        }
                    },
                    columnSettings: {
                        subTotal: {
                            visible: true,
                            collapsed: true,
                            collapsible: true
                        }
                    },
                    fields: [
                        {name: '0', caption: 'Codigo'},
                        {name: '1', caption: 'Nombre'},
                        {name: '2', caption: 'Direccion'},
                        {name: '3', caption: 'Telefono'},
                        {name: '4', caption: 'Cedula'},
                        {name: '5', caption: 'Descuento'},
                        {name: '6', caption: 'Saldo', dataSettings: {aggregateFunc: 'sum', formatFunc: function (value) {
                                    return value ? addCommas(Number(value).toFixed(2)) + '' : '';
                                }
                            }},
                        {name: '7', caption: 'Estado'},
                        {name: '8', caption: 'Correo'},
                        {name: '9', caption: 'Tipo'},
                        {name: '10', caption: 'Ciudad'},
                        {name: '11', caption: 'Categoria'},
                        {name: '12', caption: 'Genero'},
                        {name: '13', caption: 'Usuario'},
                        {name: '14', caption: 'Fecha'},
                        {name: '15', caption: 'Dia'},
                        {name: '16', caption: 'DiaNombre'},
                        {name: '17', caption: 'Mes'},
                        {name: '18', caption: 'Año'},
                        {name: '19', caption: 'Cantidad', aggregateFunc: 'sum'}
                    ],
                    rows: ['Ciudad'],
                    columns: ['Año', 'Categoria'],
                    data: ['Cantidad', 'Saldo']

                };
                var elem = document.getElementById('rr');
                var pgridwidget = new orb.pgridwidget(config);
                pgridwidget.render(elem);
            </script>

            <?
        } else {
            
        }

        break;

    case 'productos':

        break;

    case 'provedores':

        break;
}