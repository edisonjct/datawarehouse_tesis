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
$proceso = $_POST['proceso'];
switch ($proceso) {
    case 'backup':
        $host = "localhost";
        $username = "root";
        $password = "";
        $database_name = "mrbooks_datawarehouse";
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

            ///////////////////////


            $zip = new ZipArchive();
            $filename = $database_name . '_backup_' . $fecha . '.zip';
            if ($zip->open('../backups/' . $filename, ZipArchive::CREATE) == TRUE) {
                //$zip->addFromString($backup_file_name, "//BACKUP GENERADO.\n");
                $zip->addFile($backup_file_name);
                $zip->close();
                unlink($backup_file_name);
            }
        }

        $tiempo_fin = microtime(true);
        echo '<br>';
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;
    case 'backup2':
        $db_host = 'localhost';
        $db_name = 'ligas_app';
//$db_name = 'mrbooks_datawarehouse'; //Nombre de la Base de datos
        $db_user = 'root';
        $db_pass = '';
        $fecha = date("Ymd-His");
        $salida_sql = $db_name . '_' . $fecha . '.sql';
        $dump = "mysqldump --h$db_host -u$db_user -p$db_pass --opt $db_name > $salida_sql";
        system($dump, $output);
        $zip = new ZipArchive();
//Construimos el nombre del archivo ZIP Ejemplo: mibase_20160101-081120.zip
        $salida_zip = $db_name . '_' . $fecha . '.zip';

        if ($zip->open($salida_zip, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile($salida_sql);
            $zip->close();
            unlink($salida_sql);
            header("Location: $salida_zip");
        } else {
            echo 'Error a';
        }


        $tiempo_fin = microtime(true);
        echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
        break;
}