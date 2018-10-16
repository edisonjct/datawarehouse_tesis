<?
include_once '../model/loginModel.php';
$loginModel = new loginModel();
$usuario = $loginModel->getbyid($_SESSION["id"]);
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index" class="site_title"><i class="fa fa-cubes"></i> <span>Data WareHouse</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="images/<?= $usuario->avatar; ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?= $usuario->nombre; ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->