<?
$archivo = preg_replace('/^.+[\\\\\\/]/', '', $_SERVER['SCRIPT_NAME']);
$archivo_sin_extension = basename($archivo, ".php");
if ($archivo_sin_extension == 'index') {
    $archivo_sin_extension = 'clientes';
}
include_once '../model/menuModel.php';
$menuModel = new menuModel();
$menu = $menuModel->menu($_SESSION["perfil"]);
?>
<br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <? foreach ($menu as $row) { ?>
                <? $submenu = $menuModel->submenu($_SESSION["perfil"], $row->ID_MENU); ?>
                <? $datosarchivo = $menuModel->datosarchivo($archivo_sin_extension); ?>
                <? if ($row->ID_MENU == $datosarchivo->submenu) { ?>
                    <li class="active">
                        <a><i class="<?= $row->icono; ?>"></i> <?= $row->nombre; ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: block;">
                            <? foreach ($submenu as $col) { ?>
                                <? if ($col->url == $archivo_sin_extension) { ?>
                                    <li class="current-page"><a href="<?= $col->url; ?>"><?= $col->nombre; ?></a></li>
                                <? } else { ?>
                                    <li><a href="<?= $col->url; ?>"><?= $col->nombre; ?></a></li>
                                <? } ?>                                
                            <? } ?>                            
                        </ul>
                    </li>
                <? } else { ?>
                    <li>
                        <a><i class="<?= $row->icono; ?>"></i> <?= $row->nombre; ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <? foreach ($submenu as $col) { ?>
                                <li><a href="<?= $col->url; ?>"><?= $col->nombre; ?></a></li> 
                            <? } ?>
                        </ul>
                    </li>
                <? } ?>

            <? } ?>            
        </ul>
    </div>    
</div>
<!-- /sidebar menu -->