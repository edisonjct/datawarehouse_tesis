<?
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of productos
 *
 * @author EChulde
 */
$user = '118';
$userName = 'Edison Chulde';
session_start();
$_SESSION['id'] = $user;
$_SESSION['nombre'] = $userName;
if (!$_SESSION['id']) {
    header('Location: ../index.php');
}
include_once '../model/configuracionModel.php';
include_once '../model/usuarioModel.php';

$proceso = $_GET['p'];
$hash = $_GET['hash'];
$id = $_GET['i'];


$usuarioModel = new usuarioModel();
$usuarios = $usuarioModel->tabla_usuarios_all();
$url_base = $usuarioModel->url_base();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data WareHouse</title>                
        <link href="../view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../view/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="../view/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- Datatables -->        
        <link href="../view/build/css/custom.min.css" rel="stylesheet">
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">                
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>                        
                        <div class="row" id="datos-usuario">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?
                                switch ($proceso) {
                                    case 'a':
                                        $validar_hash = $usuarioModel->validate_activation_user($id, $hash, 8);
                                        ?>
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Activación de Usuario</h2>                                            
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <? if ($validar_hash) { ?>
                                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <strong>Exito!</strong> Su usuario a sido activado, Para ingresar al sistema Ingrese <a href="<?= $url_base->nomtabla ?>">aqui</a>.
                                                    </div>
                                                    <? $activar_usuario = $usuarioModel->activate_user($id); ?>
                                                <? } else { ?>
                                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <strong>Error!</strong> Algo salio mal consulte con el administrador del sistema</a>.
                                                    </div>
                                                <? } ?>
                                            </div>
                                        </div>
                                        <?
                                        break;

                                    case 'r':
                                        $validar_hash = $usuarioModel->validate_activation_user($id, $hash, 8);
                                        ?>
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Reseteo De Contraseña</h2>                                            
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <? if ($validar_hash) { ?>
                                                    <div id="result">
                                                        <input type="hidden" value="<?= $id; ?>" id="id">
                                                        Nueva Clave: 
                                                        <input type="password" class="form-control" id="pass" placeholder="Ingrese su nueva contraseña"> <hr>
                                                        <button class="btn btn-success" onclick="cambiar_pass();" id="btn-cambiarp"> Cambiar </button>
                                                    </div>
                                                <? } else { ?>
                                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <strong>Error!</strong> Algo salio mal consulte con el administrador del sistema</a>.
                                                    </div>
                                                <? } ?>                                                                                            
                                            </div>
                                        </div>
                                        <?
                                        break;
                                }
                                ?>



                            </div>                                                                                    
                        </div>                                                                                                   
                    </div>
                </div>                               
            </div>
        </div>
        <script src="../view/vendors/jquery/dist/jquery.min.js"></script>   
        <script src="../view/vendors/blockUI/jquery.blockUI.js"></script>
        <script src="../view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>        
        <script src="../view/vendors/fastclick/lib/fastclick.js"></script>        
        <script src="../view/vendors/nprogress/nprogress.js"></script>        
        <script src="../view/build/js/custom.js"></script>
        <script src="../view/vendors/sweetalert/sweetalert2.all.min.js"></script>
        <script src="../view/js/usuarios.js"></script>
    </body>
</html>
