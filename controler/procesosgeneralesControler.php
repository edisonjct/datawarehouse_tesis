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

date_default_timezone_set("America/Guayaquil");


error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('mysql.connect_timeout', 1200);
ini_set('default_socket_timeout', 1200);
ini_set('default_socket_timeout', 1200);
ini_set('max_execution_time', 10800);
ini_set('memory_limit', '15600M');

require_once '../model/procesosgeneralesModel.php';
require_once '../model/configuracionModel.php';
require_once 'funciones.php';
$procesos = new procesosgeneralesModel();
$config = new configuracionModel();
$tiempo_inicio = microtime(true);
$fecha_actual = date("Y-m-d H:i:s");
$usuario = $_SESSION["nombre"];
$proceso = $_POST['proceso'];
switch ($proceso) {
    case 'backup':
        $host = "localhost";
        $username = "root";
        $password = "";
        $database_name = "ligas_app";
        $fecha = date("Ymd-His");
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $backupSQL = "";
        foreach ($tables as $table) {
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            $backupSQL .= "\n\n" . $row[1] . ";\n\n";
            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);
            $columnCount = mysqli_num_fields($result);
            for ($i = 0; $i < $columnCount; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $backupSQL .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $row[$j] = $row[$j];
                        if (isset($row[$j])) {
                            $backupSQL .= '"' . $row[$j] . '"';
                        } else {
                            $backupSQL .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $backupSQL .= ',';
                        }
                    }
                    $backupSQL .= ");\n";
                }
            }
            $backupSQL .= "\n";
        }

        if (!empty($backupSQL)) {
            $backup_file_name = $database_name . '_backup_' . $fecha . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $backupSQL);
            fclose($fileHandler);
            ob_clean();
            flush();

            $zip = new ZipArchive();
            $filename = $database_name . '_backup_' . $fecha . '.zip';
            if ($zip->open('../backups/' . $filename, ZipArchive::CREATE) == TRUE) {
                //$zip->addFromString($backup_file_name, "//BACKUP GENERADO.\n");
                $zip->addFile($backup_file_name);
                $zip->close();
                unlink($backup_file_name);
                $add_backup = $procesos->add_backup($fecha_actual, $filename, $usuario, '1');
            }
        }

        $tiempo_fin = microtime(true);
        echo '<br>';
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;

    case 'mostrar_backups':
        $sel_backups = $procesos->sel_backup();
        if ($sel_backups) {
            ?>
            <script>
                $("#table-usuarios").DataTable({
                    order: [[3, "desc"]],
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
            <table id = "table-usuarios" class = "table table-striped table-bordered table-hover table-condensed dt-responsive dataTable no-footer dtr-inline" cellspacing = "0" width = "100%" role = "grid" aria-describedby = "datatable-responsive_info" style = "width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>FECHA</th>
                        <th>USUARIO</th>
                        <th>ESTADO</th>                        
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($sel_backups as $row) {
                        ?>
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-xs" type="button"><span class="fa fa-cogs"> <span class="caret"></span></span></button>
                                    <ul role="menu" class="dropdown-menu">                                        
                                        <li><a onclick="eliminar_backup('<?= $row->id; ?>');"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></li>                                        
                                    </ul>
                                </div>
                            </td>
                            <td><?= $row->id; ?></td>
                            <td><?= $row->nombre; ?></td>
                            <td><?= $row->fecha; ?></td>
                            <td><?= $row->usuario; ?></td>                                                            
                            <td>
                                <? if ($row->estado == '1') { ?>
                                    <span class="label label-success">Correcto</span>
                                <? } else if ($row->estado == '2') { ?>
                                    <span class="label label-warning">Inactivo</span>
                                <? } else if ($row->estado == '3') { ?>
                                    <span class="label label-danger">Bloqueado</span>
                                <? } else if ($row->estado == '8') { ?>
                                    <span class="label label-info">Por Activar</span>
                                <? } ?>
                            </td>                                                                     
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        <? } else { ?>
            <h2>NO HAS INGRESADO NINGUN PRODUCTO</h2>
        <? } ?>
        <?
        break;

    case 'eliminar_backup':
        $id = $_POST['id'];
        $result = $procesos->sel_backup_by_id($id);
        if ($result) {
            $delete = $procesos->delete_backup($id);
            unlink('../backups/' . $result->nombre);
        }
        break;
}