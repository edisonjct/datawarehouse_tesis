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

class usuarioModel extends Modelo {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function tabla_usuarios_all() {
        $query = "SELECT
        u.ID_USUARIO,
        u.usuario,
        u.nombre,
        u.clave,
        u.ID_PERFIL,
        u.correo,
        u.telefono,
        u.avatar,
        u.ver_valores,
        u.estado,
        p.nombre as perfil,
        u.fechaIng as fecha
        FROM
        dw_usuario as u
        INNER JOIN dw_perfil as p ON u.ID_PERFIL = p.ID_PERFIL
        WHERE u.estado != '9'
        ORDER BY fechaIng DESC;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function tabla_perfil_all() {
        $query = "SELECT * FROM dw_perfil WHERE estado != '9';";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function tabla_menu_all() {
        $query = "SELECT * FROM dw_menu WHERE estado = '1' order by orden;";
        ocon($query);
        $result = $this->db->query($query);
        $array = '';
        while ($row = $result->fetch_object()) {
            $array[] = $row;
        }
        return $array;
    }

    public function add_usuario($nombre, $usuario, $clave, $tipo, $correo, $costos, $fecha_actual, $estado) {
        $query = "INSERT INTO dw_usuario (nombre, usuario, clave, ID_PERFIL, correo, fechaIng,ver_valores,estado) VALUES ('$nombre', '$usuario', '$clave', '$tipo', '$correo', '$fecha_actual', '$costos', '$estado')";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function sel_usuario_by_id($ID) {
        $query = "SELECT * FROM dw_usuario WHERE ID_USUARIO = '$ID' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function update_usuario($ID_USUARIO, $nombre, $usuario, $perfil, $correo, $fecha_actual, $estado, $costo) {
        $query = "UPDATE dw_usuario SET nombre='$nombre', usuario='$usuario', ID_PERFIL='$perfil', correo='$correo', fechaMod='$fecha_actual', ver_valores='$costo', estado='$estado' WHERE (ID_USUARIO='$ID_USUARIO') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function eliminar_usuario($ID_USUARIO) {
        $query = "UPDATE dw_usuario SET estado='9' WHERE (ID_USUARIO='$ID_USUARIO') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function add_perfil($nombre) {
        $query = "INSERT INTO dw_perfil (nombre) VALUES ('$nombre')";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function update_perfil($ID_PERFIL, $nombre, $estado) {
        $query = "UPDATE dw_perfil SET nombre='$nombre', estado='$estado' WHERE (ID_PERFIL='$ID_PERFIL') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function eliminar_perfil($ID_PERFIL) {
        $query = "UPDATE dw_perfil SET estado='9' WHERE (ID_PERFIL='$ID_PERFIL') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function sel_perfil_by_id($ID_PERFIL) {
        $query = "SELECT * FROM dw_perfil WHERE ID_PERFIL = '$ID_PERFIL' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function valida_permiso($ID_PERFIL, $ID_MENU) {
        $query = "SELECT * FROM dw_permisos WHERE ID_PERFIL = '$ID_PERFIL' AND ID_MENU = '$ID_MENU' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function valida_padre_menu($ID_PADRE) {
        $query = "SELECT * FROM dw_menu WHERE submenu = '0' AND ID_MENU = '$ID_PADRE' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function add_permiso($ID_PERFIL, $ID_MENU) {
        $query = "INSERT INTO dw_permisos (ID_PERFIL, ID_MENU) VALUES ('$ID_PERFIL', '$ID_MENU');";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function eliminar_permiso($ID_PERFIL, $ID_MENU) {
        $query = "DELETE FROM dw_permisos WHERE (ID_PERFIL='$ID_PERFIL') AND (ID_MENU='$ID_MENU');";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function url_base_activation() {
        $query = "SELECT * FROM dw_configuraciones WHERE numtabla = '03' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function url_base() {
        $query = "SELECT * FROM dw_configuraciones WHERE numtabla = '04' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function max_user() {
        $query = "SELECT max(ID_USUARIO) as max FROM dw_usuario LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function validate_activation_user($id, $hash, $estado) {
        $query = "SELECT * FROM dw_usuario WHERE estado = '$estado' AND ID_USUARIO = '$id' AND clave = '$hash' LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    public function activate_user($ID_PERFIL) {
        $query = "UPDATE dw_usuario SET estado='1' WHERE (ID_USUARIO='$ID_PERFIL') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

    public function update_password($ID_USUARIO, $pass, $estado, $fecha_actual) {
        $query = "UPDATE dw_usuario SET clave='$pass', fechaMod='$fecha_actual', estado='$estado' WHERE (ID_USUARIO='$ID_USUARIO') LIMIT 1;";
        ocon($query);
        $result = $this->db->query($query);
        return $result;
    }

}
