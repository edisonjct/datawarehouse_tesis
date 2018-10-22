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
        $url_base = $usuarioModel->url_base_activation();
        $max_user = $usuarioModel->max_user();
        $max_id = $max_user->max + 1;
        require '../view/vendors/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "mail.mrbooks.com";
        $mail->Port = 26;
        $mail->SMTPAuth = true;
        $mail->Username = "agenda";
        $mail->Password = "GNdvntsÑ2410";
        $mail->setFrom('agenda@mrbooks.com', 'Data Warehouse Mr Books');
        $mail->addReplyTo('edisonjct@gmail.com', 'Edison Chulde');
        $mail->addAddress($correo, $nombre);
        $mail->Subject = 'ACTIVACION DE USUARIO';
        $body = '';
        $body .= '<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">        
        <title>MR BOOKS</title>    
    </head>';

        $body .= "<style>datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #997011; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #DE8723), color-stop(1, #DE8723) );background:-moz-linear-gradient( center top, #DE8723 5%, #DE8723 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#DE8723', endColorstr='#DE8723');background-color:#DE8723; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #A8995C; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #A8995C;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #F4E3AB; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #997011;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #DE8723;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #DE8723), color-stop(1, #DE8723) );background:-moz-linear-gradient( center top, #DE8723 5%, #DE8723 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#DE8723', endColorstr='#DE8723');background-color:#DE8723; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #DE8723; color: #FFFFFF; background: none; background-color:#DE8723;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }</style>";
        $body .= '<body>
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">            
            <tr>
                <td align="center" valign="top" bgcolor="#f1f69d" style="background-color:#ffffe6; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000; padding:10px;">
                    <div style="font-family:Times New Roman; font-size:25px; color:#000000;">ACTIVACION DEL USUARIO: ' . $usuario . '</div>                   
                    <hr>
                    Para activar su usuario ingrese a la siguiente url <br>
                    <a href="' . $url_base->nomtabla . md5($clave) . '&i=' . $max_id . '&p=a">Click Aqui para Activar su usuario</a>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" bgcolor="#ffa64d" style="background-color:#ffa64d;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="15">
                        <tr>
                            <td align="left" valign="top" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px;">Mr Books<br>
                                Mr Books @ Power By Edison Chulde<br>
                                Telefono: 0993729268 <br>
                                Correo: <a href="mailto:edisonjct@gmail.com" style="color:#ffffff; text-decoration:none;">edisonjct@gmail.com </a><br>
                                Website: <a href="http://www.mrbooks.com" target="_blank" style="color:#ffffff; text-decoration:none;">www.mrbooks.com</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>';
        $body .= '</html>';
        $mail->Body = $body;
        $mail->AltBody = 'Este es un correo de prueba';
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $add_usuario = $usuarioModel->add_usuario($nombre, $usuario, md5($clave), $tipo, $correo, $costos, $fecha_actual, '8');
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
        }
        break;

    case 'reset_password':
        $ID_USUARIO = $_POST['id'];
        $user = $usuarioModel->sel_usuario_by_id($ID_USUARIO);
        $url_base = $usuarioModel->url_base_activation();
        require '../view/vendors/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "mail.mrbooks.com";
        $mail->Port = 26;
        $mail->SMTPAuth = true;
        $mail->Username = "agenda";
        $mail->Password = "GNdvntsÑ2410";
        $mail->setFrom('agenda@mrbooks.com', 'Data Warehouse Mr Books');
        $mail->addReplyTo('edisonjct@gmail.com', 'Edison Chulde');
        $mail->addAddress($user->correo, $user->nombre);
        $mail->Subject = 'RESETEO DE CLAVE';
        $body = '';
        $body .= '<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">        
        <title>MR BOOKS</title>    
    </head>';

        $body .= "<style>datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #997011; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #DE8723), color-stop(1, #DE8723) );background:-moz-linear-gradient( center top, #DE8723 5%, #DE8723 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#DE8723', endColorstr='#DE8723');background-color:#DE8723; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #A8995C; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #00496B; border-left: 1px solid #A8995C;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #F4E3AB; color: #00496B; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #997011;background: #E1EEF4;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #DE8723;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #DE8723), color-stop(1, #DE8723) );background:-moz-linear-gradient( center top, #DE8723 5%, #DE8723 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#DE8723', endColorstr='#DE8723');background-color:#DE8723; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #DE8723; color: #FFFFFF; background: none; background-color:#DE8723;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }</style>";
        $body .= '<body>
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">            
            <tr>
                <td align="center" valign="top" bgcolor="#f1f69d" style="background-color:#ffffe6; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000; padding:10px;">
                    <div style="font-family:Times New Roman; font-size:25px; color:#000000;">RESETEO DE CLAVE DEL USUARIO: ' . $user->usuario . '</div>                   
                    <hr>
                    Para cambiar su clave ingrese a la siguiente url <br>
                    <a href="' . $url_base->nomtabla . $user->clave . '&i=' . $ID_USUARIO . '&p=r">Click Aqui para Cambiar su clave</a>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" bgcolor="#ffa64d" style="background-color:#ffa64d;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="15">
                        <tr>
                            <td align="left" valign="top" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px;">Mr Books<br>
                                Mr Books @ Power By Edison Chulde<br>
                                Telefono: 0993729268 <br>
                                Correo: <a href="mailto:edisonjct@gmail.com" style="color:#ffffff; text-decoration:none;">edisonjct@gmail.com </a><br>
                                Website: <a href="http://www.mrbooks.com" target="_blank" style="color:#ffffff; text-decoration:none;">www.mrbooks.com</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>';
        $body .= '</html>';
        $mail->Body = $body;
        $mail->AltBody = 'Este es un correo de prueba';
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $update_user = $usuarioModel->update_usuario($ID_USUARIO, $user->nombre, $user->usuario, $user->ID_PERFIL, $user->correo, $fecha_actual, 8, $user->ver_valores);
            if ($update_user) {
                ?>
                <script>
                    swal("¡Exito!", "Se envio un correo para la modificacion de la clave del usuario seleccionado", "success");
                    setTimeout("cargar_usuarios();", 1000);
                </script>
                <?
            } else {
                ?>
                <script>
                    swal("¡Error!", "consulte con el administrador", "error");
                </script>
                <?
            }
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
                                        <th></th>
                                        <th>NOMBRE</th>
                                        <th>USUARIO</th>
                                        <th>CORREO</th>                                        
                                        <th>TIPO</th>
                                        <th>ESTADO</th>
                                        <th>FECHA</th>                                                                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($usuarios as $row) { ?>
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-xs" type="button"><span class="fa fa-cogs"> <span class="caret"></span></span></button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a onclick="mostrar_usuario('<?= $row->ID_USUARIO; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar</a></li>
                                                        <li><a onclick="eliminar_usuario('<?= $row->ID_USUARIO; ?>');"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></li>                                                                        
                                                        <li class="divider"></li>
                                                        <li><a onclick="reset_password('<?= $row->ID_USUARIO; ?>');"><span class="glyphicon glyphicon-duplicate"></span> Resetear Clave</a></li>
                                                    </ul>
                                                </div>
                                            </td>
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
                                                <? } else if ($row->estado == '8') { ?>
                                                    <span class="label label-info">Por Activar</span>
                                                <? } ?>
                                            </td>
                                            <td><?= $row->fecha; ?></td>                                            
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
                order: [[1, "desc"]],
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
                                        <th></th>
                                        <th>ID</th>
                                        <th>PERFIL</th>
                                        <th>ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($perfiles as $row) { ?>
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-xs" type="button"><span class="fa fa-cogs"> <span class="caret"></span></span></button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a onclick="mostrar_permisos('<?= $row->ID_PERFIL; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar Permisos</a></li>
                                                        <li class="divider"></li>
                                                        <li><a onclick="mostrar_perfil('<?= $row->ID_PERFIL; ?>');"><span class="glyphicon glyphicon-pencil"></span> Editar Perfil</a></li>
                                                        <li><a onclick="eliminar_perfil('<?= $row->ID_PERFIL; ?>');"><span class="glyphicon glyphicon-remove"></span> Eliminar Perfil</a></li>
                                                    </ul>
                                                </div>

                                            </td>
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
                cargar_perfil();
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

    case 'reset_pass':
        $ID_USUARIO = $_POST['id'];
        $pass = $_POST['pass'];
        $validapass = $usuarioModel->sel_usuario_by_id($ID_USUARIO);
        //echo md5($pass) . ' <br> ' . $validapass->clave;
        $url_base = $usuarioModel->url_base();
        if (md5($pass) == $validapass->clave) {
            ?>
            <script>
                swal("¡Error!", "Su nueva clave debe ser diferente a la anterior", "error");
            </script>
            <div id="result">
                <input type="hidden" value="<?= $ID_USUARIO; ?>" id="id">
                Nueva Clave: 
                <input type="password" class="form-control" id="pass" placeholder="Ingrese su nueva contraseña"> <hr>
                <button class="btn btn-success" onclick="cambiar_pass();" id="btn-cambiarp"> Cambiar </button>
            </div>
            <?
        } else {
            $update_pass = $usuarioModel->update_password($ID_USUARIO, md5($pass), 1, $fecha_actual)
            ?>
            <script>
                swal("¡Exito!", "Clave cambiada Con Exito", "success");
            </script>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>Exito!</strong> Su usuario a sido activado, Para ingresar al sistema Ingrese <a href="<?= $url_base->nomtabla ?>">aqui</a>.
            </div>
            <?
        }

        break;
}