<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of productoControler
 *
 * @author EChulde
 */
session_start();
include_once '../model/productoModel.php';
include_once '../model/configuracionModel.php';
include_once '../model/usuarioModel.php';
include_once '../model/clienteModel.php';
$productoModel = new productoModel();
$configModel = new configuracionModel();
$usuarioModel = new usuarioModel();
$clienteModel = new clienteModel();
$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION["id"];
$estado = $configModel->tabla_config_all('07');
$tipo = $configModel->tabla_config_all('09');
$consideracion = $configModel->tabla_config_all('10');
switch ($_POST['proceso']) {
    case 'cargar_producto':
        $sel_productos = $productoModel->sel_all_pruductos();
        ?>
        <script>
            $("#table-productos").DataTable({
                order: [[6, "desc"]],
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
        <div class="row" id="datos-producto">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>DATOS DE PRODUCTOS</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-info" onclick="nuevo_producto();" >Nuevo</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <? if ($sel_productos) { ?>
                            <table id="table-productos" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>TIPO</th>
                                        <th>NOMBRE</th>
                                        <th>PVP</th>
                                        <th>IVA</th>
                                        <th>DESCUENTO</th>
                                        <th>ESTADO</th>
                                        <th>FECHA</th>                                                        
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($sel_productos as $row) { ?>
                                        <tr>
                                            <td><?= $row->tipo; ?></td>
                                            <td><?= $row->nombre; ?></td>
                                            <td><?= $row->pvp; ?></td>
                                            <td><?= $row->iva; ?></td>
                                            <td><?= $row->descuento; ?></td>                                                            
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
                                                        <li><a onclick="mostrar_producto('<?= $row->ID_PRODUCTO; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar</a></li>
                                                        <li><a onclick="mostrar_producto('<?= $row->ID_PRODUCTO; ?>');"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></li>                                                                        
                                                        <li class="divider"></li>
                                                        <li><a onclick="mostrar_producto('<?= $row->ID_PRODUCTO; ?>');"><span class="glyphicon glyphicon-duplicate"></span> Documentos</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        <? } else { ?>
                            <h2>NO HAS INGRESADO NINGUN PRODUCTO</h2>
                        <? } ?>
                    </div>
                </div>
            </div>                                                                                    
        </div>
        <?
        break;

    case 'nuevo':
        ?>
        <div class="row" id="ingresar-cliente">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>INGRESAR PRODUCTO </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_producto();">Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Producto <span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="tipo">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($tipo as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Consideración<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="considera">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($consideracion as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>  
                                </div>
                            </div>                                                                                                     
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="nombre" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Cantidad<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="cantidad" class="date-picker form-control col-md-7 col-xs-12" required="required" type="number">
                                </div>
                            </div>                                                    
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Costo <span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="costo" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">PVP</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="pvp" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                            </div>                                                   
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">IVA</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" id="iva" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Descuento</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" id="descuento" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="observacion" required="required" class="form-control col-md-7 col-xs-12">
                                </div>                                
                            </div>                            
                        </form>
                        <hr>
                        <div class="form-group alignright">
                            <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                                <button type="button" class="btn btn-success" onclick="guardar_producto();">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?
        break;


    case 'mostrar_producto':
        $ID_PRODUCTO = $_POST['id'];
        $row_producto = $productoModel->sel_producto_by_id($ID_PRODUCTO);
        ?>

        <script>
            $('#id').val('<?= $row_producto->ID_PRODUCTO; ?>');
            $('#tipo').val('<?= $row_producto->tipo; ?>');
            $('#considera').val('<?= $row_producto->consideracion; ?>');
            $('#nombre').val('<?= $row_producto->nombre; ?>');
            $('#cantidad').val('<?= $row_producto->cantidad; ?>');
            $('#costo').val('<?= $row_producto->costo; ?>');
            $('#pvp').val('<?= $row_producto->pvp; ?>');
            $('#iva').val('<?= $row_producto->iva; ?>');
            $('#descuento').val('<?= $row_producto->descuento; ?>');
            $('#observacion').val('<?= $row_producto->observacion; ?>');
            $('#estado').val('<?= $row_producto->estado; ?>');
        </script>

        <div class="row" id="ingresar-cliente">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>EDITAR PRODUCTO </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_producto();">Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <input id="id" hidden type="text">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Producto <span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="tipo">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($tipo as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Consideración<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="considera">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($consideracion as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>  
                                </div>
                            </div>                                                                                                     
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="nombre" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Cantidad<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="cantidad" class="date-picker form-control col-md-7 col-xs-12" required="required" type="number">
                                </div>
                            </div>                                                    
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Costo <span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="costo" class="form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">PVP</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="pvp" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                </div>
                            </div>                                                   
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">IVA</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" id="iva" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Descuento</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="text" id="descuento" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="observacion" required="required" class="form-control col-md-7 col-xs-12">
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="estado">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($estado as $row) { ?>
                                            <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                        <? } ?>
                                    </select>  
                                </div>                                
                            </div>
                        </form>
                        <hr>
                        <div class="form-group alignright">
                            <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                                <button type="button" class="btn btn-success" onclick="modificar_producto();">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
        break;

    case 'guardar_producto':
        $tipo = $_POST['tipo'];
        $considera = $_POST['considera'];
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $costo = $_POST['costo'];
        $pvp = $_POST['pvp'];
        $iva = $_POST['iva'];
        $descuento = $_POST['descuento'];
        $observacion = $_POST['observacion'];
        $add_producto = $productoModel->add_producto($tipo, $considera, $nombre, $cantidad, $costo, $pvp, $iva, $descuento, $observacion, $fecha_actual, $usuario);
        if ($add_producto) {
            ?>
            <script>
                swal("¡Exito!", "Producto Ingresado Con Exito", "success");
                setTimeout("cargar_producto();", 1000);
            </script>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se modifico consulte con el administrador", "error");
            </script>
            <?
        }
        break;

    case 'modificar_producto':
        $ID_PRODUCTO = $_POST['id'];
        $tipo = $_POST['tipo'];
        $considera = $_POST['considera'];
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $costo = $_POST['costo'];
        $pvp = $_POST['pvp'];
        $iva = $_POST['iva'];
        $descuento = $_POST['descuento'];
        $observacion = $_POST['observacion'];
        $estado = $_POST['estado'];
        $update_producto = $productoModel->update_producto($ID_PRODUCTO, $tipo, $considera, $nombre, $cantidad, $costo, $pvp, $iva, $descuento, $observacion, $estado, $fecha_actual, $usuario);
        if ($update_producto) {
            ?>
            <script>
                swal("¡Exito!", "Producto Modificado Con Exito", "success");
                setTimeout("cargar_producto();", 1000);
            </script>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se modifico consulte con el administrador", "error");
            </script>
            <?
        }
        break;


    case 'id_datos_productos':
        $producto = $productoModel->sel_producto_by_id($_POST['id']);
        $años = $configModel->tabla_config_all('11');
        ?>
        <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>AÑOS</label><br>
            <select class="form-control" id="año">

                <? foreach ($años as $row) { ?>
                    <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                <? } ?>
            </select>  
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>PVP</label><br>
            <input type="text" class="form-control" id="pvp" onchange="calcular();" value="<?= $producto->pvp ?>" placeholder="PVP">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12 form-group">
            <label>CANT.</label><br>
            <input type="number" class="form-control" id="cantidad" onchange="calcular();" placeholder="Cant">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>DESC.</label><br>
            <input type="text" class="form-control" id="desc" onchange="calcular();" value="<?= $producto->descuento ?>" placeholder="Desc">
        </div> 
        <div class="col-md-2 col-sm-2 col-xs-12 form-group">
            <label>TOTA</label><br>
            <input type="text" class="form-control" id="total" disabled="" placeholder="Total">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12 form-group">
            <label></label><br>
            <button type="button" class="btn btn-round btn-info" onclick="agregar_producto_tmp();">+</button>
        </div>
        <?
        break;
}