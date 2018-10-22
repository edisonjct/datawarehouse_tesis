<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dtsControler
 *
 * @author EChulde
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('mysql.connect_timeout', 1200);
ini_set('default_socket_timeout', 1200);
ini_set('default_socket_timeout', 1200);
ini_set('max_execution_time', 10800);
ini_set('memory_limit', '15600M');

require_once '../model/dtsModel.php';
require_once '../model/dtsModelPac.php';
require_once '../model/configuracionModel.php';
require_once 'funciones.php';

$tiempo_inicio = microtime(true);
$dtsSRE = new dtsModel();
$dtsPAC = new dtsModelPac();
$config = new configuracionModel();
$row_bodegas = $config->bodegas();
$fecha = $config->tabla_config_by_id('01', '01');
$fecha_inicia = $fecha->dato5;
$carga = $config->tabla_config_all('01');

$tabla = $config->tabla_config_by_id('01', '02');
if ($tabla->codtabla == '02' && $tabla->dato1 == 1) {
    $vaciar_autores = $dtsSRE->vaciar_tabla($tabla->dato5);
    $max_autores = $dtsPAC->count_tabla($tabla->dato6);
    for ($i = 0; $i <= millar($max_autores->max); $i = $i + 1000) {
        $get_autores = $dtsPAC->autores($i);
        if ($get_autores == true) {
            $array = '';
            foreach ($get_autores as $row) {
                $array .= "('" . $row->codigo . "','" . evaluar($row->nombres) . "'),";
            }
            $array = substr($array, 0, -1);
            $insert_autores = $dtsSRE->insert_autores($array);
            unset($array, $get_autores);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max_autores->max . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '03');
if ($tabla->codtabla == '03' && $tabla->dato1 == 1) {
    $vaciar_editoriales = $dtsSRE->vaciar_tabla($tabla->dato5);
    $get_editoriales = $dtsPAC->editorial();
    $datos_editoriales = '';
    foreach ($get_editoriales as $row) {
        $datos_editoriales .= "('" . $row->codigo . "','" . evaluar($row->razon) . "'),";
    }
    $datos_editoriales = substr($datos_editoriales, 0, -1);
    $insert_editoriales = $dtsSRE->insert_editoriales($datos_editoriales);
    unset($datos_editoriales, $get_editoriales);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '04');
if ($tabla->codtabla == '04' && $tabla->dato1 == 1) {
    $vaciar_clientes = $dtsSRE->eliminar_datos_tabla($tabla->dato5, $tabla->dato7, $fecha_inicia);
    $max_clientes = $dtsPAC->count_tabla_all('mrbooks', $tabla->dato6, $tabla->dato7, $fecha_inicia);
    for ($i = 0; $i <= millar($max_clientes->max); $i = $i + 1000) {
        $get = $dtsPAC->clientes($i, $fecha_inicia);
        $array = '';
        if ($get == true) {
            foreach ($get as $row) {
                $array .= "('" . $row->codcte01 . "','" . evaluar($row->nomcte01) . "','" . $row->tipcte01 . "','" . $row->loccte01 . "','" . evaluar($row->dircte01) . "'"
                        . ",'" . $row->telcte01 . "','" . $row->cascte01 . "','" . $row->fecing01 . "','" . $row->desctocte01 . "','" . $row->sdoact01 . "'"
                        . ",'" . $row->statuscte01 . "','" . evaluar($row->emailcte01) . "','" . $row->UID . "','" . $row->catcte01 . "','" . $row->razcte01 . "','" . $row->sexo01 . "'),";
            }
            $array = substr($array, 0, -1);
            $insert = $dtsSRE->insert_clientes($array);
            unset($get, $array);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max_clientes->max . '<br>';
}


$tabla = $config->tabla_config_by_id('01', '06');
if ($tabla->codtabla == '06' && $tabla->dato1 == 1) {
    $vaciar_productos = $dtsSRE->vaciar_tabla($tabla->dato5);
    $max_productos = $dtsPAC->count_tabla($tabla->dato6);
    for ($i = 0; $i <= millar($max_productos->max); $i = $i + 1000) {
        $get_maepro = $dtsPAC->maepro($i);
        $datos_maepro = '';
        if ($get_maepro == true) {
            foreach ($get_maepro as $row) {
                $datos_maepro .= "('" . $row->ID . "','" . $row->codigo . "','" . evaluar($row->titulo) . "','" . $row->cantidad . "','" . $row->costo . "','" . $row->fecha_venta . "','" . $row->pvp . "','" . $row->iva . "'"
                        . ",'" . $row->descuento . "','" . $row->provedor . "','" . $row->categoria . "','" . $row->tipo . "','" . $row->estado . "','" . $row->autor . "','" . $row->editorial . "','" . $row->idioma . "','" . $row->ubicacion . "'"
                        . ",'" . $row->cdi . "','" . $row->wb . "','" . $row->jrd . "','" . $row->sl . "','" . $row->cnd . "','" . $row->scl . "','" . $row->vl . "','" . $row->ev . "'"
                        . ",'" . $row->qc . "','" . $row->snl . "','" . $row->snm . "','" . $row->cm . "','" . $row->pcf . "','" . $row->man . "'),";
            }
            $datos_maepro = substr($datos_maepro, 0, -1);
            $insert_maepro = $dtsSRE->insert_maepro($datos_maepro);
            unset($get_maepro, $datos_maepro);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max_productos->max . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '07');
if ($tabla->codtabla == '07' && $tabla->dato1 == 1) {
    $vaciar_facturas_c = $dtsSRE->eliminar_datos_tabla($tabla->dato5, $tabla->dato7, $fecha_inicia);
    foreach ($row_bodegas as $bod) {
        $max = $dtsPAC->count_tabla_all($bod->base, $tabla->dato6, $tabla->dato7, $fecha_inicia);
        for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
            $get_maefac = $dtsPAC->maefac($bod->base, $i, $fecha_inicia);
            $datos_maefac = '';
            if ($get_maefac == true) {
                foreach ($get_maefac as $row) {
                    $datos_maefac .= "('" . $row->nofact31 . "','" . $row->nocte31 . "','" . evaluar($row->nomcte31) . "','" . $row->localid31 . "','" . $row->vtabta31 . "','" . $row->descto31 . "'"
                            . ",'" . $row->fecfact31 . "','" . $row->formapago31 . "','" . $row->cvanulado31 . "','" . $row->ruc31 . "','" . $row->tel31 . "','" . $row->desctofp31 . "','" . $row->UID . "','" . $bod->cod_local . "','" . $bod->nombre . "','" . $row->novend31 . "'),";
                }
                $datos_maefac = substr($datos_maefac, 0, -1);
                $insert_maefac = $dtsSRE->insert_maefac($datos_maefac);
                unset($get_maefac, $datos_maefac);
            }
        }
        echo $tabla->nomtabla . ' - ' . $bod->nombre . ' => ' . $max->max . '<br>';
    }
}

$tabla = $config->tabla_config_by_id('01', '08');
if ($tabla->codtabla == '08' && $tabla->dato1 == 1) {
    $vaciar_facturas_d = $dtsSRE->eliminar_datos_tabla($tabla->dato5, $tabla->dato7, $fecha_inicia);
    foreach ($row_bodegas as $bod) {
        $max = $dtsPAC->count_tabla_by_id($bod->base, $tabla->dato6, $tabla->dato7, 'TIPOTRA03', $tabla->dato2, $fecha_inicia);
        for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
            $get_detalle_factura = $dtsPAC->detalle_facturas($bod->base, $i, $fecha_inicia);
            $array = '';
            if ($get_detalle_factura == true) {
                foreach ($get_detalle_factura as $row) {
                    $array .= "('" . $row->TIPOTRA03 . "','" . $row->NOCOMP03 . "','" . $row->CODPROD03 . "','" . $row->FECMOV03 . "','" . $row->CANTID03 . "','" . $row->PU03 . "','" . $row->CODDEST03 . "'"
                            . ",'" . $row->PRECVTA03 . "','" . $row->DESCVTA03 . "','" . $row->nomdest03 . "','" . $row->UID . "','" . $row->cvanulado03 . "','" . $row->iva03 . "',"
                            . "'" . $bod->cod_local . "','" . $bod->nombre . "','" . $row->desctotvta03 . "','" . $row->desctotfp03 . "'),";
                }
                $array = substr($array, 0, -1);
                $insert = $dtsSRE->insert_detalle_facturas($array);
                unset($get_detalle_factura, $array);
            }
        }
        echo $tabla->nomtabla . ' - ' . $bod->nombre . ' => ' . $max->max . '<br>';
    }
}

$tabla = $config->tabla_config_by_id('01', '05');
if ($tabla->codtabla == '05' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->vaciar_tabla($tabla->dato5);
    $max = $dtsPAC->count_tabla_all('mrbooks', $tabla->dato6, $tabla->dato7, '1990-01-01');
    for ($i = 0; $i <= millar($max->max); $i = $i + 100) {
        $get = $dtsPAC->provedor($i);
        $array = '';
        if ($get == true) {
            foreach ($get as $row) {
                $array .= "('" . $row->codcte01 . "','" . evaluar($row->nomcte01) . "','" . $row->tipcte01 . "','" . $row->loccte01 . "'"
                        . ",'" . evaluar($row->dircte01) . "','" . $row->telcte01 . "','" . $row->cascte01 . "','" . $row->fecing01 . "'"
                        . ",'" . $row->condpag01 . "','" . $row->desctocte01 . "','" . $row->sdoact01 . "','" . $row->statuscte01 . "'"
                        . ",'" . evaluar($row->emailcte01) . "','" . $row->UID . "','" . $row->catcte01 . "','" . $row->coddest01 . "'),";
            }
            $array = substr($array, 0, -1);
            $insert = $dtsSRE->insert_provedores($array);
            unset($get, $array);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max->max . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '09');
if ($tabla->codtabla == '09' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->eliminar_datos_tabla($tabla->dato5, $tabla->dato7, $fecha_inicia);
    $max = $dtsPAC->count_tabla_by_id('mrbooks', $tabla->dato6, $tabla->dato7, 'tipodoc43', $tabla->dato2, $fecha_inicia);
    for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
        $get_array = $dtsPAC->notas_credito($i, $fecha_inicia);
        $datos = '';
        if ($get_array == true) {
            foreach ($get_array as $row) {
                $datos .= "('" . $row->numdoc43 . "','" . $row->codcte43 . "','" . $row->totdoc43 . "'"
                        . ",'" . $row->fecdoc43 . "','" . $row->cvanulado43 . "','" . $row->UID . "'"
                        . ",'" . codigo_bodega($row->numdoc43) . "','" . nombre_bodega($row->numdoc43) . "'),";
            }
            $datos = substr($datos, 0, -1);
            $dtsSRE->insert_notas_credito($datos);
            unset($get_array, $datos);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max->max . '<br>';
}
$tabla = $config->tabla_config_by_id('01', '10');
if ($tabla->codtabla == '10' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->eliminar_datos_tabla($tabla->dato5, $tabla->dato7, $fecha_inicia);
    foreach ($row_bodegas as $bod) {
        $max = $dtsPAC->count_tabla_by_id($bod->base, $tabla->dato6, $tabla->dato7, 'TIPOTRA03', $tabla->dato2, $fecha_inicia);
        for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
            $get_array = $dtsPAC->detalle_notas_credito($bod->base, $i, $fecha_inicia);
            $array = '';
            if ($get_array == true) {
                foreach ($get_array as $row) {
                    $array .= "('" . $row->NOCOMP03 . "','" . $row->CODPROD03 . "','" . $row->FECMOV03 . "','" . $row->CANTACT03 . "','" . $row->PU03 . "','" . $row->CODDEST03 . "'"
                            . ",'" . $row->PRECVTA03 . "','" . $row->DESCVTA03 . "','" . $row->nomdest03 . "','" . $row->UID . "','" . $row->cvanulado03 . "','" . $row->iva03 . "','" . $bod->cod_local . "','" . $bod->nombre . "'),";
                }
                $array = substr($array, 0, -1);
                $insert = $dtsSRE->insert_detalle_notas_credito($array);
                unset($get_array, $array);
            }
        }
        echo $tabla->nomtabla . ' - ' . $bod->nombre . ' => ' . $max->max . '<br>';
    }
}

$tabla = $config->tabla_config_by_id('01', '14');
if ($tabla->codtabla == '14' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}


$tabla = $config->tabla_config_by_id('01', '15');
if ($tabla->codtabla == '15' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '16');
if ($tabla->codtabla == '16' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '17');
if ($tabla->codtabla == '17' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_categorias($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codcate . "','" . evaluar($row->desccate) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '18');
if ($tabla->codtabla == '18' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_categorias($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codcate . "','" . evaluar($row->desccate) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '19');
if ($tabla->codtabla == '19' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_categorias($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codcate . "','" . evaluar($row->desccate) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '20');
if ($tabla->codtabla == '20' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '21');
if ($tabla->codtabla == '21' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}


$tabla = $config->tabla_config_by_id('01', '22');
if ($tabla->codtabla == '22' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '23');
if ($tabla->codtabla == '23' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '24');
if ($tabla->codtabla == '24' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '25');
if ($tabla->codtabla == '25' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '26');
if ($tabla->codtabla == '26' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->tabla_maetab($tabla->dato6, $tabla->dato2);
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->codtab . "','" . evaluar($row->nomtab) . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '27');
if ($tabla->codtabla == '27' && $tabla->dato1 == 1) {
    $dtsSRE->vaciar_tabla($tabla->dato5);
    $get = $dtsPAC->usuarios_pac();
    $array = '';
    foreach ($get as $row) {
        $array .= "('" . $row->UID . "','" . $row->username . "','" . $row->userpwd . "','" . $row->nombreusuario . "'),";
    }
    $array = substr($array, 0, -1);
    $dtsSRE->insert_tabla($tabla->dato5, $array);
    unset($array, $get);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}


$tabla = $config->tabla_config_by_id('01', '28');
if ($tabla->codtabla == '28' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->eliminar_datos_tabla($tabla->dato6, $tabla->dato8, $fecha_inicia);
    $max = $dtsSRE->count_tabla_all($tabla->dato5, $tabla->dato7, $fecha_inicia);
    for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
        $get = $dtsSRE->select_data_mart_clientes($i, $fecha_inicia);
        $array = '';
        if ($get == true) {
            foreach ($get as $row) {
                $array .= "('" . $row->codigo . "','" . evaluar($row->nombre) . "','" . evaluar($row->direccion) . "','" . $row->telefono . "'"
                        . ",'" . $row->cedularuc . "','" . $row->descuento . "','" . $row->saldo . "','" . $row->estado . "'"
                        . ",'" . evaluar($row->correo) . "','" . $row->tipo_cliente . "','" . evaluar($row->localidad) . "','" . $row->categoria . "'"
                        . ",'" . $row->genero . "','" . $row->usuario . "','" . $row->fecha_ingreso . "','" . $row->dia . "'"
                        . ",'" . $row->nomdia . "','" . $row->mes . "','" . $row->anio . "'),";
            }
            $array = substr($array, 0, -1);
            $insert = $dtsSRE->insert_tabla($tabla->dato6, $array);
            unset($get, $array);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max->max . '<br>';
}


$tabla = $config->tabla_config_by_id('01', '29');
if ($tabla->codtabla == '29' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->eliminar_datos_tabla($tabla->dato6, $tabla->dato8, $fecha_inicia);
    $max = $dtsSRE->count_tabla_all($tabla->dato5, $tabla->dato7, $fecha_inicia);
    for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
        $get = $dtsSRE->select_data_mart_provedores($i, $fecha_inicia);
        $array = '';
        if ($get == true) {
            foreach ($get as $row) {
                $array .= "('" . $row->ID . "','" . $row->cod_destino . "','" . evaluar($row->nombre) . "','" . evaluar($row->direccion) . "','" . $row->telefono . "'"
                        . ",'" . $row->cedularuc . "','" . $row->descuento . "','" . $row->saldo . "','" . $row->estado . "'"
                        . ",'" . evaluar($row->correo) . "','" . $row->localidad . "','" . $row->tipo_provedor . "','" . $row->condicion_pago . "'"
                        . ",'" . evaluar($row->destino) . "','" . $row->usuario . "','" . $row->fecha_ingreso . "','" . $row->dia . "'"
                        . ",'" . $row->nomdia . "','" . $row->mes . "','" . $row->anio . "'),";
            }
            $array = substr($array, 0, -1);
            $insert = $dtsSRE->insert_tabla($tabla->dato6, $array);
            unset($get, $array);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max->max . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '13');
if ($tabla->codtabla == '13' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->vaciar_tabla($tabla->dato6);
    $max = $dtsSRE->count_tabla($tabla->dato5);
    for ($i = 0; $i <= millar($max->max); $i = $i + 1000) {
        $get = $dtsSRE->select_data_mart_productos($i, $fecha_inicia);
        $array = '';
        if ($get == true) {
            foreach ($get as $row) {
                $array .= "('" . $row->codigo . "','" . $row->barras . "','" . evaluar($row->titulo) . "','" . $row->costo . "','" . $row->pvp . "'"
                        . ",'" . $row->iva . "','" . $row->descuento . "','" . $row->tipo_producto . "','" . $row->ubicacion . "','" . evaluar($row->categoria) . "'"
                        . ",'" . evaluar($row->autor) . "','" . evaluar($row->editorial) . "','" . evaluar($row->idioma) . "','" . evaluar($row->provedor) . "','" . evaluar($row->pais) . "'"
                        . ",'" . evaluar($row->tipo_provedor) . "','" . $row->cdi . "','" . $row->wb . "','" . $row->jrd . "','" . $row->sl . "'"
                        . ",'" . $row->cnd . "','" . $row->scl . "','" . $row->vl . "','" . $row->ev . "','" . $row->qc . "'"
                        . ",'" . $row->snl . "','" . $row->snm . "','" . $row->cm . "','" . $row->pcf . "','" . $row->man . "','" . $row->estado . "'),";
            }
            $array = substr($array, 0, -1);
            $insert = $dtsSRE->insert_tabla($tabla->dato6, $array);
            unset($get, $array);
        }
    }
    echo $tabla->nomtabla . ' => ' . $max->max . '<br>';
}

$tabla = $config->tabla_config_by_id('01', '11');
if ($tabla->codtabla == '11' && $tabla->dato1 == 1) {
    $vaciar = $dtsSRE->vaciar_tabla('data_mart_ventas');
    $data_mart_ventas = $dtsSRE->select_data_mart_ventas($fecha_inicia);
    echo $tabla->nomtabla . ' => TODOS' . '<br>';
}


$tabla = $config->tabla_config_by_id('01', '30');
if ($tabla->codtabla == '30' && $tabla->dato1 == 1) {
    $años_activos = $config->tabla_config_all('02');
    if ($años_activos) {
        foreach ($años_activos as $row) {
            $vaciar = $dtsSRE->eliminar_datos_tabla('dw_totales_anios', 'anio', $row->codtabla);
            $datos_años = $dtsSRE->select_datos_anios($row->codtabla);
        }
        echo $tabla->nomtabla . ' => TODOS' . '<br>';
    }
}

$vaciar = $dtsSRE->vaciar_tabla('data_mart_ventas_anual_mensual');
$llebar_ventas_anuales = $dtsSRE->ventas_anulaes();

$años_activos = $config->tabla_config_all('02');

foreach ($años_activos as $row) {
    $valor_anio = $dtsSRE->total_ventas_anules($row->codtabla);
    $update_valor_anio = $dtsSRE->update_valor_anio($row->codtabla, $valor_anio->max);
}

foreach ($años_activos as $row) {
    foreach ($row_bodegas as $row_b) {
        $valor_bodega = $dtsSRE->total_ventas_anules_bodega($row->codtabla, $row_b->nombre);
        if ($valor_bodega) {
            $update_valor_bodega = $dtsSRE->update_valor_bodega($row->codtabla, $row_b->nombre, $valor_bodega->max);
        }
    }
}

$ventas_anuales = $dtsSRE->sel_ventas_anuales();

foreach ($ventas_anuales as $row) {
    $porcentaje_anual = (($row->valorbodega * 100) / $row->valoranio);
    $porcentaje_menual = (($row->valor * 100) / $row->valorbodega);
    $update = $dtsSRE->update_porcentajes($row->anio, $row->bodega, $row->mes, $porcentaje_anual, $porcentaje_menual);
}


$vaciar_data_mart_venta_semanal = $dtsSRE->vaciar_tabla('data_mart_ventas_semanal');
$crear_data_mart_venta_semanal = $dtsSRE->data_mart_venta_semanal();


$vaciar_data_mart_ventas_mensual = $dtsSRE->vaciar_tabla('data_mart_ventas_mensual');
$crear_data_mart_ventas_mensual = $dtsSRE->data_mart_ventas_mensual();

$tiempo_fin = microtime(true);
echo "El script ha tardado en ejecutarse: " . conversorSegundosHoras(round(($tiempo_fin - $tiempo_inicio)), 0);
