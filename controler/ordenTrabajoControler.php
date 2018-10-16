<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ordenTrabajoControler
 *
 * @author EChulde
 */
session_start();
include_once '../model/productoModel.php';
include_once '../model/ordenTrabajoModel.php';
include_once '../model/clienteModel.php';
include_once '../model/usuarioModel.php';
include_once '../model/configuracionModel.php';
include_once 'funciones.php';
$productoModel = new productoModel();
$clienteModel = new clienteModel();
$ordenTrabajoModel = new ordenTrabajoModel();
$usuarioModel = new usuarioModel();
$configModel = new configuracionModel();

switch ($_POST['proceso']) {
    case 'mostrar_datos_cliente':
        $cedula = $_POST['cedula'];
        $cliente = $clienteModel->valida_cedula($cedula);
        if ($cliente) {
            ?>
            <script>
                $('#nombre').val('<?= $cliente->nombres; ?>');
                $('#razonsocial').val('<?= $cliente->razonsocial; ?>');
                $('#representante').val('<?= $cliente->representante; ?>');
                $('#referido').val('<?= $cliente->referido; ?>');
                $('#profecion').val('<?= $cliente->profecion; ?>');
                $('#telefono').val('<?= $cliente->telefono; ?>');
                $('#direccion').val('<?= $cliente->direccion; ?>');
                $('#ciudad').val('<?= $cliente->ciudad; ?>');
                $('#correo').val('<?= $cliente->correo; ?>');
                $('#clavesri').val('<?= $cliente->clavesri; ?>');
                $('#clavesotras').val('<?= $cliente->clavesotras; ?>');
                $('#grupo').val('<?= $cliente->grupo; ?>');
            </script>
        <? } else { ?>
            <script>
                swal("¡Error!", "No se encontro nungun cliente con este numero de Cedula/Ruc, Ingrese primero los datos del Cliente", "error");
            </script>
            <?
        }
        break;

    case 'calculartotal':
        $ID_PRODUCTO = $_POST['id'];
        $datosproducto = $productoModel->sel_producto_by_id($ID_PRODUCTO);
        $datos = array(
            'pvp' => $datosproducto->pvp,
            'iva' => $datosproducto->iva
        );
        echo json_encode($datos);
        break;

    case 'add_tmp_productos':
        $codtmp = $_POST['codtmp'];
        $año = $_POST['año'];
        $ID_PRODUCTO = $_POST['id_producto'];
        $pvp = $_POST['pvp'];
        $cantidad = $_POST['cantidad'];
        $desc = $_POST['descuento'];
        $total = $_POST['total'];
        $cedula = $_POST['cedula'];
        $datosproducto = $productoModel->sel_producto_by_id($ID_PRODUCTO);
        $iva = $datosproducto->iva;
        $totalsiniva = ($pvp * $cantidad) - (($pvp * $cantidad) * ($desc / 100));
        $totalconiva = (($pvp * $cantidad) - (($pvp * $cantidad) * ($desc / 100))) + ((($pvp * $cantidad) - (($pvp * $cantidad) * ($desc / 100))) * ($iva / 100));
        $add_tmp_productos = $ordenTrabajoModel->add_producto_tmp_orden($codtmp, $cedula, $ID_PRODUCTO, $año, $pvp, $cantidad, $iva, $desc, $totalsiniva, $totalconiva);
        $sel_tmp_productos = $ordenTrabajoModel->sel_all_pruductos_tmp($codtmp, $cedula);
        if ($sel_tmp_productos) {
            $subtotal = 0;
            $descuento = 0;
            $iva = 0;
            $total = 0;
            ?>
            <style>
                .pull-right {
                    width: 35%;
                    float: right !important;
                }
            </style>
            <table id="table-productos_tmp" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>NOMBRE</th>
                        <th>AÑO</th>
                        <th>PVP</th>
                        <th>IVA</th>
                        <th>CANT</th>
                        <th>DESC</th>
                        <th>TOTAL</th>                        
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sel_tmp_productos as $row) { ?>
                        <?
                        $subtotal = $subtotal + $row->totalsiniva;
                        $descuento = $descuento + ($row->pvp - $row->totalsiniva);
                        $iva = $iva + $row->iva;
                        $total = $total + $row->totalconiva;
                        ?>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-default btn-xs" onclick=""><span class="glyphicon glyphicon-remove"></span></button>                                                                
                            </td>
                            <td><?= $row->nombre; ?></td>
                            <td><?= $row->anio; ?></td>
                            <td><?= number_format($row->pvp, 2); ?></td>
                            <td><?= number_format($row->iva, 2); ?></td>
                            <td><?= number_format($row->cantidad, 0); ?></td>
                            <td><?= number_format($row->descuento, 2); ?></td>                            
                            <td><?= number_format($row->totalsiniva, 2); ?></td>                            
                        </tr>
                    <? } ?>
                </tbody>
            </table>
            <div class="pull-right">
                <table id="table-total_tmp" class="table table-bordered table-condensed dt-responsive dataTable text-right no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width:100%;">                
                    <tbody>                  
                        <tr>
                            <td>SUB TOTAL</td>
                            <td><label><?= number_format($subtotal, 2) ?></label></td>
                        </tr>
                        <tr>                            
                            <td>DESCUENTO</td>
                            <td><label><?= number_format($descuento, 2) ?></label></td>      
                        </tr>
                        <tr>
                            <td>IVA</td>
                            <td><label><?= number_format($iva, 2) ?></label></td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td><label><?= number_format($total, 2) ?></label></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <script>
                $('#valor').val('<?= number_format($total, 2); ?>');
            </script>

            <?
        } else {
            
        }

        break;

    case 'add_tmp_formas':
        $codtmp = $_POST['codtmp'];
        $total = $_POST['total'];
        $cedula = $_POST['cedula'];
        $valor = $_POST['valor'];

        $datosproducto = $productoModel->sel_producto_by_id($ID_PRODUCTO);
        $iva = $datosproducto->iva;
        $totalsiniva = ($pvp * $cantidad) - (($pvp * $cantidad) * ($desc / 100));
        $totalconiva = (($pvp * $cantidad) - (($pvp * $cantidad) * ($desc / 100))) + ((($pvp * $cantidad) - (($pvp * $cantidad) * ($desc / 100))) * ($iva / 100));
        $add_tmp_productos = $ordenTrabajoModel->add_producto_tmp_orden($codtmp, $cedula, $ID_PRODUCTO, $año, $pvp, $cantidad, $iva, $desc, $totalsiniva, $totalconiva);
        $sel_tmp_productos = $ordenTrabajoModel->sel_all_pruductos_tmp($codtmp, $cedula);
        if ($sel_tmp_productos) {
            $subtotal = 0;
            $descuento = 0;
            $iva = 0;
            $total = 0;
            ?>
            <style>
                .pull-right {
                    width: 35%;
                    float: right !important;
                }
            </style>
            <table id="table-productos_tmp" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>NOMBRE</th>
                        <th>AÑO</th>
                        <th>PVP</th>
                        <th>IVA</th>
                        <th>CANT</th>
                        <th>DESC</th>
                        <th>TOTAL</th>                        
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sel_tmp_productos as $row) { ?>
                        <?
                        $subtotal = $subtotal + $row->totalsiniva;
                        $descuento = $descuento + ($row->pvp - $row->totalsiniva);
                        $iva = $iva + $row->iva;
                        $total = $total + $row->totalconiva;
                        ?>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-default btn-xs" onclick=""><span class="glyphicon glyphicon-remove"></span></button>                                                                
                            </td>
                            <td><?= $row->nombre; ?></td>
                            <td><?= $row->anio; ?></td>
                            <td><?= number_format($row->pvp, 2); ?></td>
                            <td><?= number_format($row->iva, 2); ?></td>
                            <td><?= number_format($row->cantidad, 0); ?></td>
                            <td><?= number_format($row->descuento, 2); ?></td>                            
                            <td><?= number_format($row->totalsiniva, 2); ?></td>                            
                        </tr>
                    <? } ?>
                </tbody>
            </table>
            <div class="pull-right">
                <table id="table-total_tmp" class="table table-bordered table-condensed dt-responsive dataTable text-right no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width:100%;">                
                    <tbody>                  
                        <tr>
                            <td>SUB TOTAL</td>
                            <td><label><?= number_format($subtotal, 2) ?></label></td>
                        </tr>
                        <tr>                            
                            <td>DESCUENTO</td>
                            <td><label><?= number_format($descuento, 2) ?></label></td>      
                        </tr>
                        <tr>
                            <td>IVA</td>
                            <td><label><?= number_format($iva, 2) ?></label></td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td><label><?= number_format($total, 2) ?></label></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <script>
                $('#valor').val('<?= number_format($total, 2); ?>');
            </script>

            <?
        } else {
            
        }

        break;


    case 'mostrar_fp':
        $id = $_POST['id'];
        switch ($id) {
            case '01':
                ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>PAGO EN EFECTIVO</h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />                        
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Valor</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Ingrese el Valor">
                                </div>
                            </div>                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">                                    
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                    <button type="button" class="btn btn-success">Agregar</button>
                                </div>
                            </div>

                        </form> 

                    </div>
                </div>

                <?
                break;

            case '02':
                ?>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>PAGO CON TARJETA DE CREDITO</h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />                        
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">OPERADOR</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control">
                                        <option>DATAFAST</option>
                                        <option>MEDIANET</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">PLAZO</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control">
                                        <option>DATAFAST</option>
                                        <option>MEDIANET</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">BANCO</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control">
                                        <option>DATAFAST</option>
                                        <option>MEDIANET</option>                                        
                                    </select>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">                                    
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                    <button type="button" class="btn btn-success">Agregar</button>
                                </div>
                            </div>

                        </form> 

                    </div>
                </div>
                <?
                break;
        }

        break;


    case 'nueva_orden':
        $estado_civil = $configModel->tabla_config_all('03');
        $usuarios = $usuarioModel->tabla_usuarios_all_comision();
        $tipo_servicio = $configModel->tabla_config_all('02');
        $formadepago = $configModel->tabla_config_all('13');
        $prioridad = $configModel->tabla_config_all('15');
        $ultimodoc = $configModel->tabla_config_by_id('12', '01');
        $productos = $productoModel->sel_all_pruductos();
        $cedula = $_POST['id'];
        $cliente = $clienteModel->valida_cedula($cedula);
        $fecha = date("Y-m-d");
        ?>
        <script>
            $('#div-fp').hide();
            $('#div-deta-fp').hide();
            $('#div-totales').hide();
            $('#cedula').val('<?= $cliente->cedula; ?>');
            $('#nombre').val('<?= $cliente->nombres; ?>');
            $('#razonsocial').val('<?= $cliente->razonsocial; ?>');
            $('#representante').val('<?= $cliente->representante; ?>');
            $('#referido').val('<?= $cliente->referido; ?>');
            $('#profecion').val('<?= $cliente->profecion; ?>');
            $('#telefono').val('<?= $cliente->telefono; ?>');
            $('#direccion').val('<?= $cliente->direccion; ?>');
            $('#ciudad').val('<?= $cliente->ciudad; ?>');
            $('#correo').val('<?= $cliente->correo; ?>');
            $('#clavesri').val('<?= $cliente->clavesri; ?>');
            $('#clavesotras').val('<?= $cliente->clavesotras; ?>');
            $('#grupo').val('<?= $cliente->grupo; ?>');
        </script>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nueva Orden de Trabajo <br><small>Datos Personales</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_orden();" >Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                                <input type="text" id="cod-tmp" hidden="" value="<?= (rand(100000, 99999999999)); ?>">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="cedula" disabled="" class="form-control col-md-7 col-xs-12">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Fecha<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="date" id="fecha" value="<?= $fecha ?>" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="nombre" class="form-control col-md-7 col-xs-12">
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Razon Social<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="razonsocial" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Representante<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="representante" class="form-control col-md-7 col-xs-12">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Ultimo Documento<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label col-xs-12"><?= ultimo_secuencial($ultimodoc->dato1) ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Referido<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="referido" class="form-control col-md-7 col-xs-12">
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Actividad<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="profecion" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefonos<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="telefono" class="form-control col-md-7 col-xs-12">
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Direccion<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="direccion" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ciudad<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="ciudad" class="form-control col-md-7 col-xs-12">
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Correo<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="correo" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Clave SRI<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="clavesri" class="form-control col-md-7 col-xs-12">
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Otras Claves<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="clavesotras" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Grupo<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="grupo" class="form-control col-md-7 col-xs-12">
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Venta De<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select class="form-control" id="comisionita">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($usuarios as $row) { ?>
                                            <option value="<?= $row->ID_USUARIO; ?>"><?= $row->nombre; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Servicios<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select class="form-control" id="servicio-tiempo">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($tipo_servicio as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>  
                                </div>              
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Prioridad<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">                                    
                                    <select class="form-control" id="prioridad">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($prioridad as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <div id="mensaje"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detalle Servicios</h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form class="form-horizontal form-label-left input_mask">
                            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                                <label>SERVICIOS</label><br>
                                <select class="form-control" id="id_producto" onchange="id_datos_productos();">
                                    <option value="">Selecione Producto</option>
                                    <? foreach ($productos as $row) { ?>
                                        <option value="<?= $row->ID_PRODUCTO; ?>"><?= $row->nombre; ?></option>
                                    <? } ?>
                                </select>  
                            </div>
                            <div id="id_datos_productos"></div>
                            <div id="mostrar_productos_tmp"></div>
                            <div class="form-group"></div>

                        </form>
                    </div>
                </div>                                                               

            </div>
            <div class="col-md-3 col-xs-12" id="div-fp">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Formas de Pago</h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form class="form-horizontal form-label-left input_mask">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label>SERVICIOS</label><br>
                                <select class="form-control" id="id_forma_pago" onchange="mostrar_fp(this.value);">
                                    <option value="">Selecione Forma de Pago</option>
                                    <? foreach ($formadepago as $row) { ?>
                                        <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                    <? } ?>
                                </select>  
                            </div>
                            <div id="detalle-fp"></div>
                            <div class="form-group"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12" id="div-deta-fp">

            </div>
            <div class="col-md-3 col-xs-12" id="div-totales">        

            </div> 
        </div>

        <?
        break;


    case 'cargar_clientes':
        $sel_clientes = $clienteModel->sel_clientes_activos();
        ?>
        <script>
            $("#clientes").DataTable({
                order: [[5, "desc"]],
                dom: "Bfrtip",
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                responsive: true
            });
        </script>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>SELECIONE CLIENTE PARA GENERAR LA ORDEN DE TRABAJO</h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <? if ($sel_clientes) { ?>
                        <table id="clientes" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NOMBRES</th>
                                    <th>CEDULA</th>
                                    <th>DIRECCION</th>
                                    <th>TELEFONO</th>
                                    <th>SALDO</th>                                                        
                                    <th>ESTADO</th>
                                    <th>FECHA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($sel_clientes as $row) { ?>
                                    <tr>
                                        <td><?= $row->nombres; ?></td>
                                        <td><?= $row->cedula; ?></td>
                                        <td><?= $row->direccion; ?></td>
                                        <td><?= $row->telefono; ?></td>
                                        <td><?= $row->saldo; ?></td>                                                            
                                        <td>
                                            <? if ($row->estado == '1') { ?>
                                                <span class="label label-success">Activo</span>
                                            <? } else if ($row->estado == '2') { ?>
                                                <span class="label label-warning">Inactivo</span>
                                            <? } else if ($row->estado == '3') { ?>
                                                <span class="label label-danger">Bloqueado</span>
                                            <? } ?>
                                        </td>
                                        <td><?= $row->fecha_ingreso; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-xs" type="button">Option <span class="caret"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li><a onclick="nuevo_orden('<?= $row->cedula; ?>');"><span class="glyphicon glyphicon-file"></span> Nuevo</a></li>                                                                        
                                                </ul>
                                            </div>                                                                
                                        </td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    <? } else { ?>
                        <h2>NO HAS INGRESADO NINGUN CLIENTE</h2>
                    <? } ?>
                </div>
            </div>
        </div> 

        <?
        break;
}