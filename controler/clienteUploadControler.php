<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clienteUploadControler
 *
 * @author EChulde
 */
session_start();
include_once '../model/clienteModel.php';
$clienteModel = new clienteModel();

switch ($_GET['proceso']) {
    case 'agregar_documento_cliente':
        $cliente = $_GET['cliente'];
        $nombre = $_GET['nombre'];
        $tipo_archivo = $_FILES['documento']['type'];
        if ($tipo_archivo != "image/jpeg" && $tipo_archivo != "image/png" && $tipo_archivo != "image/jpeg" && $tipo_archivo != "application/pdf") {
            ?>
            <script>swal("¡Error!", "Solo se permite subir archivos PDF e IMAGENES", "error");</script>
            <?
        } else {
            $documento = $cliente . $nombre . date('Y-m-d') . date('H-i-s') . trim($_FILES['documento']['name']);
            $agrega_clave_tmp = $clienteModel->add_documentos_cliente($nombre, $documento, $cliente);
            move_uploaded_file($_FILES['documento']['tmp_name'], '../view/upload/' . $documento);
            if ($agrega_clave_tmp) {
                ?>
                <script>
                    mostrar_documento('<?= $cliente ?>');
                    swal("¡Exito!", "Documento Subido Con Exito", "success");
                </script>


            <? } else { ?>
                <script>swal("¡Error!", "Servicio No Ingresado", "error");</script>
                <?
            }
        }

        break;
}
