<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioModel
 *
 * @author EChulde
 */
require_once 'modelo.php';
require_once '../controler/auditoriaControler.php';

class procesosgeneralesModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function add_backup($fecha, $nombre, $usuario, $estado) {
        $query = "INSERT INTO dw_backups (fecha, nombre, usuario, estado) VALUES ('$fecha', '$nombre', '$usuario', '$estado');";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function sel_backup() {
        $query = "SELECT * FROM dw_backups WHERE estado != '9';";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function delete_backup($id) {
        $query = "DELETE FROM dw_backups WHERE (id='$id');";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function sel_backup_by_id($id) {
        $query = "SELECT * FROM dw_backups WHERE (id='$id') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

}
