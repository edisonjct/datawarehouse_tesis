<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clienteControler
 *
 * @author EChulde
 */
session_start();
include_once '../model/clienteModel.php';
include_once '../model/configuracionModel.php';
include_once '../model/usuarioModel.php';
$clienteModel = new clienteModel();
$configModel = new configuracionModel();
$usuarioModel = new usuarioModel();
$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION["id"];

switch ($_POST['proceso']) {

    case 'nuevo_cliente':
        break;


    case 'agregar_servicios':
        $codtmp = $_POST['codtemp'];
        $servicio = $_POST['servicio'];
        $agrega_serivio_tmp = $clienteModel->add_servicio_tmp($codtmp, '02', $servicio, '', '', '');
        if ($agrega_serivio_tmp) {
            $mostrar_servicios_tmp = $clienteModel->mostrar_servicio_tmp($codtmp, '02');
            ?>
            <script>swal("¡Exito!", "Servicio Ingresado Con Exito", "success");</script>
            <table id="tabla-servicios" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th>SERVICIOS</th>                        
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($mostrar_servicios_tmp as $row) { ?>
                        <tr>
                            <td><?= $row->nomtabla; ?></td>                       
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        <? } else { ?>
            <script>swal("¡Error!", "Servicio No Ingresado", "error");</script>
            <?
        }

        break;
    case 'agregar_claves':
        $ID_CLIENTE = $_POST['id'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $agrega_clave_tmp = $clienteModel->add_claves_cliente($nombre, $clave, $ID_CLIENTE);
        if ($agrega_clave_tmp) {
            ?>
            <script>
                mostrar_clave('<?= $ID_CLIENTE; ?>');
                swal("¡Exito!", "Claves Ingresada Con Exito", "success");
            </script>            
        <? } else { ?>
            <script>swal("¡Error!", "Clave No Ingresada", "error");</script>
            <?
        }
        break;
    case 'agregar_cliente':
        $cedula = $_POST['cedula'];
        $sector = $_POST['sector'];
        $fechadeclaracion = $_POST['fechadeclaracion'];
        $nombres = $_POST['nombres'];
        $razonsocial = $_POST['razonsocial'];
        $representante = $_POST['representante'];
        $referido = $_POST['referido'];
        $profecion = $_POST['profecion'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $ciudad = $_POST['ciudad'];
        $correo = $_POST['correo'];
        $tipocliente = $_POST['tipocliente'];
        $gender = $_POST['gender'];
        $fechanacimiento = $_POST['fechanacimiento'];
        $estadocivil = $_POST['estadocivil'];
//        $clavesri = $_POST['clavesri'];
//        $clavesotras = $_POST['clavesotras'];
        $grupo = $_POST['grupo'];
        $observacion = $_POST['observacion'];
        $add_cliente = $clienteModel->add_cliente($cedula, $fechadeclaracion, $nombres, $razonsocial, $representante, $referido, $profecion, $direccion, $telefono, $ciudad, $correo, $tipocliente, $gender, $fechanacimiento, $estadocivil, $grupo, $observacion, $fecha_actual, $usuario, $sector);
        if ($add_cliente) {
            ?>            
            <script>
                swal("¡Exito!", "Cliente Ingresado Con Exito", "success");
            </script>
            <?
        } else {
            ?>
            <script>swal("¡Error!", "Cliente No se ingreso", "error");</script>
            <?
        }

        break;
    case 'valida_cedula':
        $cedula = $_POST['cedula'];
        $valida_cedula = $clienteModel->valida_cedula($cedula);
        if ($valida_cedula) {
            ?>
            <script>
                $('#cedula').focus();
                $('#cedula').val('');
                swal("¡Error!", "Cedula Pertenece a otro cliente", "error");
            </script>
            <?
        } else {
            $fechadeclaracion = $configModel->tabla_config_by_id('08', substr($cedula, 8, 1));
            ?>            
            <script>
                $('#fecha-declaracion').val('<?= $fechadeclaracion->nomtabla; ?>');
            </script>
            <?
        }

        break;

    case 'modificar_cliente':
        $ID_CLIENTE = $_POST['id'];
        $cedula = $_POST['cedula'];
        $fechadeclaracion = $_POST['fechadeclaracion'];
        $nombres = $_POST['nombres'];
        $razonsocial = $_POST['razonsocial'];
        $representante = $_POST['representante'];
        $referido = $_POST['referido'];
        $profecion = $_POST['profecion'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $ciudad = $_POST['ciudad'];
        $correo = $_POST['correo'];
        $tipocliente = $_POST['tipocliente'];
        $gender = $_POST['gender'];
        $fechanacimiento = $_POST['fechanacimiento'];
        $estadocivil = $_POST['estadocivil'];
//        $clavesri = $_POST['clavesri'];
//        $clavesotras = $_POST['clavesotras'];
        $grupo = $_POST['grupo'];
        $observacion = $_POST['observacion'];
        $estado = $_POST['estado'];
        $sector = $_POST['sector'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $update_cliente = $clienteModel->update_cliente($ID_CLIENTE, $cedula, $fechadeclaracion, $nombres, $razonsocial, $representante, $referido, $profecion, $direccion, $telefono, $ciudad, $correo, $tipocliente, $gender, $fechanacimiento, $estadocivil, $grupo, $observacion, $fecha_actual, $usuario, $estado, $sector, $fecha_ingreso);
        if ($update_cliente) {
            ?>
            <script>
                //alert("modifique");
                swal("¡Exito!", "Usuario Modificado Con Exito", "success");
                setTimeout("window.location.href = '../view/clientes'", 1500);
            </script>
            <?
        } else {
            ?>
            <script>
                alert("no modifique");
                swal("¡Error!", "No se modifico consulte con el administrador", "error");
            </script>
            <?
        }

        break;


    case 'editar_cliente':
        $ID_CLIENTE = $_POST['id'];
        $estado_civil = $configModel->tabla_config_all('03');
        $tipo_cliente = $configModel->tabla_config_all('01');
        $genero = $configModel->tabla_config_all('04');
        $estado_cliente = $configModel->tabla_config_all('07');
        $sector = $configModel->tabla_config_all('14');
        $row_cliente = $clienteModel->sel_clientes_by_id($ID_CLIENTE);
        ?>
        <script>
            $('#id_cliente').val('<?= $row_cliente->ID_CLIENTE; ?>');
            $('#cedula_c').val('<?= $row_cliente->cedula; ?>');
            $('#fecha-declaracion_c').val('<?= $row_cliente->fechadeclaracion; ?>');
            $('#nombres_c').val('<?= $row_cliente->nombres; ?>');
            $('#razonsocial_c').val('<?= $row_cliente->razonsocial; ?>');
            $('#representante_c').val('<?= $row_cliente->representante; ?>');
            $('#referido_c').val('<?= $row_cliente->referido; ?>');
            $('#profecion_c').val('<?= $row_cliente->profecion; ?>');
            $('#direccion_c').val('<?= $row_cliente->direccion; ?>');
            $('#telefono_c').val('<?= $row_cliente->telefono; ?>');
            $('#ciudad_c').val('<?= $row_cliente->ciudad; ?>');
            $('#correo_c').val('<?= $row_cliente->correo; ?>');
            $('#tipo-cliente_c').val('<?= $row_cliente->tipocliente; ?>');
            $('#gender_c').val('<?= $row_cliente->gender; ?>');
            $('#fecha-nacimiento_c').val('<?= $row_cliente->fechanacimiento; ?>');
            $('#estado-civil_c').val('<?= $row_cliente->estadocivil; ?>');
        //            $('#clavesri_c').val('<?= $row_cliente->clavesri; ?>');
        //            $('#clavesotras_c').val('<?= $row_cliente->clavesotras; ?>');
            $('#grupo_c').val('<?= $row_cliente->grupo; ?>');
            $('#observacion_c').val('<?= $row_cliente->observacion; ?>');
            $('#estado_c').val('<?= $row_cliente->estado; ?>');
            $('#sector_c').val('<?= $row_cliente->sector; ?>');
            $('#modificar-cliente').click(function () {
                var id = $('#id_cliente').val();
                var cedula = $('#cedula_c').val();
                var fechadeclaracion = $('#fecha-declaracion_c').val();
                var nombres = $('#nombres_c').val();
                var razonsocial = $('#razonsocial_c').val();
                var representante = $('#representante_c').val();
                var referido = $("#referido_c").val();
                var profecion = $('#profecion_c').val();
                var direccion = $('#direccion_c').val();
                var telefono = $('#telefono_c').val();
                var ciudad = $('#ciudad_c').val();
                var correo = $('#correo_c').val();
                var tipocliente = $('#tipo-cliente_c').val();
                var gender = $('#gender_c').val();
                var fechanacimiento = $('#fecha-nacimiento_c').val();
                var estadocivil = $("#estado-civil_c").val();
                //var clavesri = $("#clavesri_c").val();
                //var clavesotras = $('#clavesotras_c').val();
                var grupo = $('#grupo_c').val();
                var observacion = $('#observacion_c').val();
                var estado = $('#estado_c').val();
                var sector = $('#sector_c').val();
                if (id !== '' && cedula !== '' && fechadeclaracion !== '' && nombres !== '' && profecion !== '' && direccion !== '' && telefono !== '' && ciudad !== '' && correo !== '' && tipocliente !== '' && gender !== '' && fechanacimiento !== '' && estadocivil !== '') {
                    //$('ingresar-cliente').html('<div align="center"><i class="fa fa-refresh fa-spin" style="font-size:40px"></i></div>');
                    var url = '../controler/clienteControler.php';
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'proceso=modificar_cliente&id=' + id + '&cedula=' + cedula + '&fechadeclaracion=' + fechadeclaracion + '&nombres=' + nombres + '&razonsocial=' + razonsocial +
                                '&representante=' + representante + '&referido=' + referido + '&profecion=' + profecion + '&direccion=' + direccion + '&telefono=' + telefono + '&ciudad=' + ciudad +
                                '&correo=' + correo + '&tipocliente=' + tipocliente + '&gender=' + gender + '&fechanacimiento=' + fechanacimiento + '&estadocivil=' + estadocivil + +'&grupo=' + grupo + '&observacion=' + observacion + '&estado=' + estado + '&sector=' + sector,
                        success: function (datos) {
                            $('#mensaje').html(datos);
                        }
                    });
                    return false;
                } else {
                    swal("¡Error!", "Ingrese los datos obligatorios", "error");
                }
            });

            mostrar_documento('<?= $row_cliente->ID_CLIENTE; ?>');
            mostrar_clave('<?= $row_cliente->ID_CLIENTE; ?>');

        </script>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-align-left"></i> Editar Datos de Cliente <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <button type="button" class="btn btn-round btn-warning" onclick="cancelar_cliente()" >Cancelar</button>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">Datos Personales</h4>
                            </a>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <form class="form-horizontal form-label-left">
                                        <input type="text" hidden="" id="id_cliente">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cedula/RUC <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input type="text" id="cedula_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Fecha Declaracion <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input type="text" id="fecha-declaracion_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombres <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="nombres_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Razon Social  <span class="required"></span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="razonsocial_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Representante Legal  <span class="required"></span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="representante_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Referido de  <span class="required"></span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input type="text" id="referido_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Actividad Economica <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input id="profecion_c" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                            </div>
                                        </div>                                                   
                                        <div class="form-group">
                                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Dirección <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="direccion_c" class="form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Telefono <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input id="telefono_c" class="form-control col-md-7 col-xs-12" type="text">
                                            </div>
                                            <label for="middle-name" class="control-label col-md-2 col-sm-2 col-xs-12">Correo <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input id="correo_c" class="form-control col-md-7 col-xs-12" type="text">
                                            </div>
                                        </div>                                                    
                                        <div class="form-group">
                                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Ciudad <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input id="ciudad_c" class="form-control col-md-7 col-xs-12" type="text" >
                                            </div>
                                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Sector</label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <select class="form-control" id="sector_c">
                                                    <option value="">Selecione Opcion</option>
                                                    <? foreach ($sector as $row) { ?>
                                                        <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                                    <? } ?>
                                                </select>  
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 class="panel-title">Otros Datos</h4>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">                                    
                                    <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Cliente <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <select class="form-control" id="tipo-cliente_c">
                                                    <option value="">Selecione Opcion</option>
                                                    <? foreach ($tipo_cliente as $row) { ?>
                                                        <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Genero<span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <select class="form-control" id="gender_c">
                                                    <option value="">Selecione Opcion</option>
                                                    <? foreach ($genero as $row) { ?>
                                                        <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                                    <? } ?>
                                                </select>  
                                            </div>
                                        </div>                                                                                                     
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Nacimiento <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input id="fecha-nacimiento_c" class="date-picker form-control col-md-7 col-xs-12" required="required" type="date">
                                            </div>
                                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Estado Civil <span class="required">*</span></label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <select class="form-control" id="estado-civil_c">
                                                    <option value="">Selecione Opcion</option>
                                                    <? foreach ($estado_civil as $row) { ?>
                                                        <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Grupo</label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input type="text" id="grupo_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Observación</label>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <input type="text" id="observacion_c" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="estado_c">
                                                    <option value="">Selecione Opcion</option>
                                                    <? foreach ($estado_cliente as $row) { ?>
                                                        <option value="<?= $row->codtabla; ?>"><?= $row->nomtabla; ?></option>
                                                    <? } ?>
                                                </select>
                                            </div>                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTre" data-toggle="collapse" data-parent="#accordion" href="#collapseTre" aria-expanded="false" aria-controls="collapseTre">
                                <h4 class="panel-title">Claves</h4>
                            </a>
                            <div id="collapseTre" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTre">
                                <div class="panel-body">                                    
                                    <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre<span class="required">*</span></label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="nombre-clave" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                            </div>
                                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Clave</label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="clave" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <button type="button" class="btn btn-info" onclick="agregar_clave('<?= $ID_CLIENTE ?>');">+</button>
                                            </div>
                                        </div>                                                                                                     
                                        <div class="form-group" id="mostrar-clave-cliente"></div>                 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingcuatro" data-toggle="collapse" data-parent="#accordion" href="#collapsecuatro" aria-expanded="false" aria-controls="collapsecuatro">
                                <h4 class="panel-title">Documentos</h4>
                            </a>
                            <div id="collapsecuatro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingcuatro">
                                <div class="panel-body">                                    
                                    <form class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Documento<span class="required">*</span></label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="nombre-documento" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                            </div>
                                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Archivo</label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input id="documento" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <button type="button" class="btn btn-info" onclick="agregar_documento('<?= $ID_CLIENTE ?>');">+</button>
                                            </div>
                                        </div>                                                                                                     
                                        <div class="form-group" id="mostrar-documentos-cliente"></div>                 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group alignright">
                        <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                            <button type="button" class="btn btn-success" id="modificar-cliente">Modificar</button>
                        </div>
                    </div>
                    <div id="mensaje"></div>
                </div>
            </div>
        </div>
        <?
        break;

    case 'mostrar_documentos':
        $cliente = $_POST['id'];
        $sel_documentos = $clienteModel->sel_documentos_cliente_by_id($cliente);
        if ($sel_documentos) {
            ?>
            <table id="tabla-documentos" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>DOCUMENTOS</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sel_documentos as $row) { ?>
                        <tr>
                            <td><?= $row->nombre_documento; ?></td>
                            <td><?= $row->documento; ?></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
            <?
        } else {
            echo '<h3>NO EXISTEN DOCUMENTOS PARA ESTE CLIENTE</h3>';
        }
        break;

    case 'mostrar_claves':
        $cliente = $_POST['id'];
        $sel_claves = $clienteModel->sel_clave_cliente_by_id($cliente);
        if ($sel_claves) {
            ?>
            <table id="tabla-documentos" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>CLAVE</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sel_claves as $row) { ?>
                        <tr>
                            <td><?= $row->nombre_clave; ?></td>
                            <td><?= $row->clave; ?></td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
            <?
        } else {
            echo '<h3>NO EXISTEN DOCUMENTOS PARA ESTE CLIENTE</h3>';
        }
        break;
}