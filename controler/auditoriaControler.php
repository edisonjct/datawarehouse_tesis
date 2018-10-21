<?

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auditoria
 *
 * @author EChulde
 */

function auditoria($query) {
    $diaAudotoria = date("Y-m-d");
    $fecha = date("Y-m-d H:i:s");
    $usuario = $_SESSION['nombre'];
    //$usuario = 'EDISON';
    $file = fopen("../audit/AUD-" . $diaAudotoria . ".txt", "a") or die("Problemas");
    fputs($file, "FECHA: $fecha El usuario " . $usuario . " ejecuto:");
    fputs($file, "\n");
    fputs($file, trim("$query"));
    fputs($file, "\n\n");
    fclose($file);
}

function ocon($query) {
    $insert = 1;
    $select = 1;
    $delete = 1;
    $update = 1;
    if (strpos($query, 'INSERT') !== FALSE) {
        if ($insert == 1) {
            return auditoria($query);
        } else {
            return $query;
        }
    } else if (strpos($query, 'UPDATE') !== FALSE) {
        if ($update == 1) {
            return auditoria($query);
        } else {
            return $query;
        }
    } elseif (strpos($query, 'DELETE') !== FALSE) {
        if ($delete == 1) {
            return auditoria($query);
        } else {
            return $query;
        }
    } elseif (strpos($query, 'SELECT') !== FALSE) {
        if ($select == 1) {
            return auditoria($query);
        } else {
            return $query;
        }
    } else {
        return $query;
    }
}
