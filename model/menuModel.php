<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menuModel
 *
 * @author EChulde
 */
require_once 'modelo.php';

class menuModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function menu($ID_PERFIL) {
        $query = "SELECT
        p.ID_PERMISOS,
        p.ID_PERFIL,
        p.ID_MENU,
        m.nombre,
        m.url,
        m.icono,
        m.tipo,
        m.submenu,
        m.orden,
        m.estado
        FROM
        dw_permisos AS p
        INNER JOIN dw_menu as m ON p.ID_MENU = m.ID_MENU
        WHERE p.ID_PERFIL = '$ID_PERFIL' AND m.tipo = '0' AND m.estado = '1';";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function submenu($ID_PERFIL, $idmenu) {
        $query = "SELECT
        p.ID_PERMISOS,
        p.ID_PERFIL,
        p.ID_MENU,
        m.nombre,
        m.url,
        m.icono,
        m.tipo,
        m.submenu,
        m.orden,
        m.estado
        FROM
        dw_permisos AS p
        INNER JOIN dw_menu as m ON p.ID_MENU = m.ID_MENU
        WHERE p.ID_PERFIL = '$ID_PERFIL' AND m.tipo = '1' AND submenu = '$idmenu' AND m.estado = '1'
        ORDER BY m.orden ASC;";
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function datosarchivo($archivo) {
        $query = "SELECT * FROM dw_menu WHERE url = '$archivo' AND estado = 1 LIMIT 1;";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

}
