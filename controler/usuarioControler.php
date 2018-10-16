<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioControler
 *
 * @author EChulde
 */
session_start();


include_once '../model/usuarioModel.php';
$usuarioModel = new usuarioModel();
$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION["id"];

$perfil = $usuarioModel->tabla_perfil_all();


switch ($_POST['proceso']) {
    case 'nuevo':
        ?>
        <div class="row" id="ingresar-usuario">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>INGRESAR USUARIO </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_usuario();">Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="nombre" class="form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Nombre">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Usuario<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="usuario" class="form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Usuario">
                                </div>
                            </div>                                                                                                     
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Clave<span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="clave" class="form-control col-md-7 col-xs-12" required="required" type="password" placeholder="Ingrese Clave">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Ver Costos</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="costos">
                                        <option value="">Selecione Opcion</option>                                        
                                        <option value="S">SI</option>
                                        <option value="N">NO</option>
                                    </select>
                                </div>
                            </div>                                                    
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Perfil <span class="required">*</span></label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <select class="form-control" id="tipo">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($perfil as $row) { ?>
                                            <option value="<?= $row->ID_PERFIL; ?>"><?= $row->nombre; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Correo</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <input id="correo" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Correo">
                                </div>
                            </div>                                                                            
                        </form>
                        <hr>
                        <div class="form-group alignright">
                            <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                                <button type="button" class="btn btn-success" onclick="guardar_usuario();">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
        break;

    case 'guardar':
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $tipo = $_POST['tipo'];
        $correo = $_POST['correo'];
        $costos = $_POST['costos'];
        $add_usuario = $usuarioModel->add_usuario($nombre, $usuario, md5($clave), $tipo, $correo, $costos, $fecha_actual);
        if ($add_usuario) {
            ?>
            <script>
                swal("¡Exito!", "Usuario Ingresado Con Exito", "success");
                setTimeout("cargar_usuarios();", 1000);
            </script>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se ingreso consulte con el administrador", "error");
            </script>
            <?
        }
        break;

    case 'cargar':
        $usuarios = $usuarioModel->tabla_usuarios_all();
        ?>
        <script>
            $("#table-usuarios").DataTable({
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
        <div class="row" id="datos-usuario">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>DATOS DE USUARIOS</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-info" onclick="nuevo_usuario();" >Nuevo</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <? if ($usuarios) { ?>
                            <table id="table-usuarios" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr>                                                        
                                        <th>NOMBRE</th>
                                        <th>USUARIO</th>
                                        <th>CORREO</th>                                        
                                        <th>TIPO</th>
                                        <th>ESTADO</th>
                                        <th>FECHA</th>                                                        
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($usuarios as $row) { ?>
                                        <tr>
                                            <td><?= $row->nombre; ?></td>
                                            <td><?= $row->usuario; ?></td>
                                            <td><?= $row->correo; ?></td>
                                            <td><?= $row->perfil; ?></td>                                                            
                                            <td>
                                                <? if ($row->estado == '1') { ?>
                                                    <span class="label label-success">Activo</span>
                                                <? } else if ($row->estado == '2') { ?>
                                                    <span class="label label-warning">Inactivo</span>
                                                <? } else if ($row->estado == '3') { ?>
                                                    <span class="label label-danger">Bloqueado</span>
                                                <? } ?>
                                            </td>
                                            <td><?= $row->fecha; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-xs" type="button">Option <span class="caret"></span>
                                                    </button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a onclick="mostrar_usuario('<?= $row->ID_USUARIO; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar</a></li>
                                                        <li><a onclick="mostrar_usuario('<?= $row->ID_USUARIO; ?>');"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></li>                                                                        
                                                        <li class="divider"></li>
                                                        <li><a onclick="mostrar_usuario('<?= $row->ID_USUARIO; ?>');"><span class="glyphicon glyphicon-duplicate"></span> Resetear Clave</a></li>
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

    case 'mostrar_usuario':
        $ID = $_POST['id'];
        $row = $usuarioModel->sel_usuario_by_id($ID);
        ?>
        <script>
            $('#id').val('<?= $row->ID_USUARIO; ?>');
            $('#nombre').val('<?= $row->nombre; ?>');
            $('#usuario').val('<?= $row->usuario; ?>');
            $('#tipo').val('<?= $row->ID_PERFIL; ?>');
            $('#correo').val('<?= $row->correo; ?>');
            $('#costos').val('<?= $row->ver_valores; ?>');
            $('#estado').val('<?= $row->estado; ?>');
        </script>
        <div class="row" id="ingresar-cliente">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>INGRESAR USUARIO </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_usuario();">Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <input id="id" hidden type="text">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Nombre <span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input id="nombre" class="form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Nombre">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Usuario<span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input id="usuario" class="form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Usuario">
                                </div>
                            </div>                                                                                                     
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Perfil <span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select class="form-control" id="tipo">
                                        <option value="">Selecione Opcion</option>
                                        <? foreach ($perfil as $row) { ?>
                                            <option value="<?= $row->ID_PERFIL; ?>"><?= $row->nombre; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Ver Costos</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select class="form-control" id="costos">
                                        <option value="">Selecione Opcion</option>                                        
                                        <option value="S">SI</option>
                                        <option value="N">NO</option>
                                    </select>
                                </div>
                            </div>                                                    
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Correo</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input id="correo" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Correo">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Estado <span class="required">*</span></label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select class="form-control" id="estado">
                                        <option value="">Selecione Opcion</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>

                                    </select>
                                </div>
                            </div>                            
                        </form>
                        <hr>
                        <div class="form-group alignright">
                            <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                                <button type="button" class="btn btn-success" onclick="modificar_usuario();">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
        break;

    case 'modificar':
        $ID_USUARIO = $_POST['id'];
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $perfil = $_POST['tipo'];
        $correo = $_POST['correo'];
        $costos = $_POST['costos'];
        $estado = $_POST['estado'];
        $update = $usuarioModel->update_usuario($ID_USUARIO, $nombre, $usuario, $perfil, $correo, $fecha_actual, $estado, $costos);
        if ($update) {
            ?>
            <script>
                swal("¡Exito!", "Usuario Modificado Con Exito", "success");
                setTimeout("cargar_usuarios();", 1000);
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

    case 'eliminar':
        $ID_USUARIO = $_POST['id'];
        $eliminar = $usuarioModel->eliminar_usuario($ID_USUARIO);
        if ($eliminar) {
            ?>
            <script>
                swal("¡Exito!", "Usuario Eliminado Con Exito", "success");
                setTimeout("cargar_usuarios();", 100);
            </script>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se Eimino consulte con el administrador", "error");
            </script>
            <?
        }
        break;

    case 'nuevo_perfil':
        ?>
        <div class="row" id="ingresar-perfil">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>INGRESAR PERFIL </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_perfil();">Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="nombre" class="form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Nombre">
                                </div>                                
                            </div>                                                                                                      
                        </form>
                        <hr>
                        <div class="form-group alignright">
                            <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                                <button type="button" class="btn btn-success" onclick="guardar_perfil();">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
        break;

    case 'cargar_perfil':
        $perfiles = $usuarioModel->tabla_perfil_all();
        ?>
        <script>
            $("#table-perfil").DataTable({
                order: [[0, "desc"]],
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
        <div class="row" id="datos-perfil">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>DATOS DE PERFIL</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-info" onclick="nuevo_perfil();" >Nuevo</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <? if ($perfiles) { ?>
                            <table id="table-perfil" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr>                                                        
                                        <th>ID</th>
                                        <th>PERFIL</th>
                                        <th>ESTADO</th>                                                        
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($perfiles as $row) { ?>
                                        <tr>
                                            <td><?= $row->ID_PERFIL; ?></td>
                                            <td><?= $row->nombre; ?></td>                                                            
                                            <td>
                                                <? if ($row->estado == '1') { ?>
                                                    <span class="label label-success">Activo</span>
                                                <? } else if ($row->estado == '2') { ?>
                                                    <span class="label label-warning">Inactivo</span>
                                                <? } else if ($row->estado == '3') { ?>
                                                    <span class="label label-danger">Bloqueado</span>
                                                <? } ?>
                                            </td>                                                            
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-xs" type="button">Option <span class="caret"></span></button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a onclick="mostrar_permisos('<?= $row->ID_PERFIL; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar Permisos</a></li>
                                                        <li class="divider"></li>
                                                        <li><a onclick="mostrar_perfil('<?= $row->ID_PERFIL; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar Perfil</a></li>
                                                        <li><a onclick="eliminar_perfil('<?= $row->ID_PERFIL; ?>');"><span class="glyphicon glyphicon-remove"></span> Eliminar Perfil</a></li>
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

    case 'mostrar_perfil':
        $ID_PERFIL = $_POST['id'];
        $row = $usuarioModel->sel_perfil_by_id($ID_PERFIL);
        ?>
        <script>
            $('#id').val('<?= $row->ID_PERFIL; ?>');
            $('#nombre').val('<?= $row->nombre; ?>');
            $('#estado').val('<?= $row->estado; ?>');
        </script>
        <div class="row" id="ingresar-perfil">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>INGRESAR PERFIL </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="cancelar_perfil();">Cancelar</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <input id="id" hidden type="text">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="nombre" class="form-control col-md-7 col-xs-12" required="required" type="text" placeholder="Ingrese Nombre">
                                </div>                                
                            </div> 
                            <div class="form-group">                                
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="estado">
                                        <option value="">Selecione Opcion</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>

                                    </select>
                                </div>                               
                            </div> 
                        </form>
                        <hr>
                        <div class="form-group alignright">
                            <div class="col-md-9 col-sm-9 col-xs-12">                                                                                        
                                <button type="button" class="btn btn-success" onclick="modificar_perfil();">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
        break;

    case 'eliminar_perfil':
        $ID_PERFIL = $_POST['id'];
        $eliminar = $usuarioModel->eliminar_perfil($ID_PERFIL);
        if ($eliminar) {
            ?>
            <script>
                swal("¡Exito!", "Perfil Eliminado Con Exito", "success");
                setTimeout("cargar_perfil();", 100);
            </script>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se Eimino consulte con el administrador", "error");
            </script>
            <?
        }

        break;

    case 'modificar_perfil':
        $ID_PERFIL = $_POST['id'];
        $nombre = $_POST['nombre'];
        $estado = $_POST['estado'];
        $update = $usuarioModel->update_perfil($ID_PERFIL, $nombre, $estado);
        if ($update) {
            ?>
            <script>
                swal("¡Exito!", "Usuario Modificado Con Exito", "success");
                setTimeout("cargar_perfil();", 100);
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

    case 'guardar_perfil':
        $nombre = $_POST['nombre'];
        $insert_perfil = $usuarioModel->add_perfil($nombre);
        if ($insert_perfil) {
            ?>
            <script>
                swal("¡Exito!", "Perfil Ingresado Con Exito", "success");
                setTimeout("cargar_perfil();", 1000);
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

    case 'mostrar_menu':
        $ID_PERFIL = $_POST['id'];
        $menu = $usuarioModel->tabla_menu_all();
        $perfil = $usuarioModel->sel_perfil_by_id($ID_PERFIL);
        ?>
        <script>
            $("#table-perfil").DataTable({
                order: [[6, "asc"]],
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
        <div class="row" id="datos-perfil">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>MENU DE <?= $perfil->nombre ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <button type="button" class="btn btn-round btn-warning" onclick="location.reload(true);">Salir</button>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <? if ($menu) { ?>
                            <table id="table-perfil" class="table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info" style="width: 100%;">
                                <thead>
                                    <tr>                                                        
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>URL</th>
                                        <th>ICONO</th>
                                        <th>TIPO</th>
                                        <th>PADRE</th>
                                        <th>ORDEN</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($menu as $row) { ?>
                                        <tr>
                                            <td><?= $row->ID_MENU; ?></td>
                                            <td><?= $row->nombre; ?></td>
                                            <td><?= $row->url; ?></td>
                                            <td><?= $row->icono; ?></td>                                            
                                            <td>
                                                <? if ($row->tipo == '0') { ?>
                                                    <span class="label label-success">Padre</span>                                               
                                                <? } else if ($row->tipo == '1') { ?>
                                                    <span class="label label-danger">Hijo</span>
                                                <? } ?>
                                            </td>
                                            <td>
                                                <? $padre = $usuarioModel->valida_padre_menu($row->submenu); ?>
                                                <? if ($padre == true) { ?>
                                                    <span class="label label-info"><?= $padre->nombre ?></span>
                                                <? } ?>
                                            </td>
                                            <td><?= $row->orden; ?></td>                                            
                                            <td>
                                                <div id="permiso-<?= $row->ID_MENU; ?>">
                                                    <? $permiso = $usuarioModel->valida_permiso($ID_PERFIL, $row->ID_MENU) ?>
                                                    <? if ($permiso == false) { ?>
                                                        <button class="btn btn-success btn-xs" type="button" onclick="agregar_permiso('<?= $ID_PERFIL ?>', '<?= $row->ID_MENU ?>');">+</button>
                                                    <? } else { ?>
                                                        <button class="btn btn-danger btn-xs" type="button" onclick="quitar_permiso('<?= $ID_PERFIL ?>', '<?= $row->ID_MENU ?>');">-</button>
                                                    <? } ?>
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

    case 'agregar_permiso':
        $ID_PERFIL = $_POST['perfil'];
        $ID_MENU = $_POST['menu'];
        $add_permiso = $usuarioModel->add_permiso($ID_PERFIL, $ID_MENU);
        if ($add_permiso) {
            ?>
            <script>
                swal("¡Exito!", "Permiso Ingresado Con Exito", "success");
            </script>
            <button class="btn btn-danger btn-xs" type="button" onclick="quitar_permiso('<?= $ID_PERFIL ?>', '<?= $ID_MENU ?>');">-</button>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se modifico consulte con el administrador", "error");
            </script>
            <?
        }
        break;

    case 'quitar_permiso':
        $ID_PERFIL = $_POST['perfil'];
        $ID_MENU = $_POST['menu'];
        $eliminar = $usuarioModel->eliminar_permiso($ID_PERFIL, $ID_MENU);
        if ($eliminar) {
            ?>
            <script>
                swal("¡Exito!", "Permiso Eliminado Con Exito", "success");
            </script>
            <button class="btn btn-success btn-xs" type="button" onclick="agregar_permiso('<?= $ID_PERFIL ?>', '<?= $ID_MENU ?>');">+</button>
            <?
        } else {
            ?>
            <script>
                swal("¡Error!", "No se modifico consulte con el administrador", "error");
            </script>
            <?
        }
        break;
}

