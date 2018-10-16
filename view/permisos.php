<?
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permisos
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
$perfiles = $usuarioModel->tabla_perfil_all();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PERMISOS</title>                
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
                        <div class="row" id="editar-producto"></div>

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
