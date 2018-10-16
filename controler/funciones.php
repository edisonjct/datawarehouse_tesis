<?php

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
date_default_timezone_set("America/Guayaquil");

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
}

function getBrowser($user_agent) {
    if (strpos($user_agent, 'MSIE') !== FALSE)
        return 'Internet explorer';
    elseif (strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
        return 'Microsoft Edge';
    elseif (strpos($user_agent, 'Trident') !== FALSE) //IE 11
        return 'Internet explorer';
    elseif (strpos($user_agent, 'Opera Mini') !== FALSE)
        return "Opera Mini";
    elseif (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
        return "Opera";
    elseif (strpos($user_agent, 'Firefox') !== FALSE)
        return 'Mozilla Firefox';
    elseif (strpos($user_agent, 'Chrome') !== FALSE)
        return 'Google Chrome';
    elseif (strpos($user_agent, 'Safari') !== FALSE)
        return "Safari";
    else
        return 'No hemos podido detectar su navegador';
}

function getPlatform($user_agent_os) {
    $plataformas = array(
        'Windows 10' => 'Windows NT 10.0+',
        'Windows 8.1' => 'Windows NT 6.3+',
        'Windows 8' => 'Windows NT 6.2+',
        'Windows 7' => 'Windows NT 6.1+',
        'Windows Vista' => 'Windows NT 6.0+',
        'Windows XP' => 'Windows NT 5.1+',
        'Windows 2003' => 'Windows NT 5.2+',
        'Windows' => 'Windows otros',
        'iPhone' => 'iPhone',
        'iPad' => 'iPad',
        'Mac OS X' => '(Mac OS X+)|(CFNetwork+)',
        'Mac otros' => 'Macintosh',
        'Android' => 'Android',
        'BlackBerry' => 'BlackBerry',
        'Linux' => 'Linux',
    );
    foreach ($plataformas as $plataforma => $pattern) {
        if (preg_match('/' . $pattern . '/', $user_agent_os))
            return $plataforma;
    }
    return 'Otras';
}

function secuencial($ultimo) {
    $num = $ultimo + 1;
    $largo = strlen($num);
    if ($largo == 1) {
        $ultimo_se = '001-001-00000000' . $num;
    } else if ($largo == 2) {
        $ultimo_se = '001-001-0000000' . $num;
    } else if ($largo == 3) {
        $ultimo_se = '001-001-000000' . $num;
    } else if ($largo == 4) {
        $ultimo_se = '001-001-00000' . $num;
    } else if ($largo == 5) {
        $ultimo_se = '001-001-0000' . $num;
    } else if ($largo == 6) {
        $ultimo_se = '001-001-000' . $num;
    } else if ($largo == 7) {
        $ultimo_se = '001-001-00' . $num;
    } else if ($largo == 8) {
        $ultimo_se = '001-001-0' . $num;
    } else if ($largo == 9) {
        $ultimo_se = '001-001-' . $num;
    }
    return $ultimo_se;
}

function ultimo_secuencial($ultimo) {
    $num = $ultimo;
    $largo = strlen($num);
    if ($largo == 1) {
        $ultimo_se = '001-001-00000000' . $num;
    } else if ($largo == 2) {
        $ultimo_se = '001-001-0000000' . $num;
    } else if ($largo == 3) {
        $ultimo_se = '001-001-000000' . $num;
    } else if ($largo == 4) {
        $ultimo_se = '001-001-00000' . $num;
    } else if ($largo == 5) {
        $ultimo_se = '001-001-0000' . $num;
    } else if ($largo == 6) {
        $ultimo_se = '001-001-000' . $num;
    } else if ($largo == 7) {
        $ultimo_se = '001-001-00' . $num;
    } else if ($largo == 8) {
        $ultimo_se = '001-001-0' . $num;
    } else if ($largo == 9) {
        $ultimo_se = '001-001-' . $num;
    }
    return $ultimo_se;
}

function evaluar($valor) {
    $nopermitido = array("'", '\\', '<', '>', "\"");
    $valor = str_replace($nopermitido, "", $valor);
    return rtrim(ltrim($valor));
}

function conversorSegundosHoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
    return $horas . ':' . $minutos . ":" . $segundos;
}

function millar($numero) {
    $aprox = (1000 - substr($numero, -3));
    return $numero + $aprox;
}

function kas($numero) {    

    switch (strlen($numero)) {
        case '3':
            return $numero;
            break;
        case '4':
            return substr($numero, 0, 1) . ' K';
            break;
        case '5':
            return substr($numero, 0, 2) . ' K';
            break;
        case '6':
            return substr($numero, 0, 3) . ' K';
            break;
        case '7':
            return substr($numero, 0, 4) . ' K';
            break;
        case '8':
            return substr($numero, 0, 5) . ' K';
            break;
        case '9':
            return substr($numero, 0, 6) . ' K';
            break;
        case '10':
            return substr($numero, 0, 7) . ' K';
            break;
        case '11':
            return substr($numero, 0, 8) . ' K';
            break;
        case '12':
            return substr($numero, 0, 9) . ' K';
            break;
    }
}

function codigo_bodega($numero) {
    switch (substr($numero, 0, 3)) {
        case '001':
            switch (substr($numero, 0, 7)) {
                case '001-001':
                    return '01';
                    break;
                case '001-006':
                    return '09';
                    break;
                case '001-007':
                    return '01';
                    break;
                case '001-008':
                    return '02';
                    break;
                case '001-009':
                    return '09';
                    break;
                case '001-010':
                    return '09';
                    break;
                case '001-011':
                    return '09';
                    break;
                case '001-012':
                    return '09';
                    break;
                case '001-013':
                    return '09';
                    break;
            }
            break;
        case '002':
            return '03';
            break;
        case '003':
            return '04';
            break;
        case '004':
            return '05';
            break;
        case '006':
            return '07';
            break;
        case '007':
            return '06';
            break;
        case '008':
            return '16';
            break;
        case '009':
            return '15';
            break;
        case '010':
            return '14';
            break;
        case '011':
            return '17';
            break;
        case '012':
            return '13';
            break;
        case '013':
            return '18';
            break;
        case '014':
            return '19';
            break;
    }
}

function nombre_bodega($numero) {
    switch (substr($numero, 0, 3)) {
        case '001':
            switch (substr($numero, 0, 7)) {
                case '001-001':
                    return 'CDI';
                    break;
                case '001-006':
                    return 'EVENTOS';
                    break;
                case '001-007':
                    return 'CDI';
                    break;
                case '001-008':
                    return 'WEB';
                    break;
                case '001-009':
                    return 'EVENTOS';
                    break;
                case '001-010':
                    return 'EVENTOS';
                    break;
                case '001-011':
                    return 'EVENTOS';
                    break;
                case '001-012':
                    return 'EVENTOS';
                    break;
                case '001-013':
                    return 'EVENTOS';
                    break;
            }
            break;
        case '002':
            return 'JARDIN';
            break;
        case '003':
            return 'SOL';
            break;
        case '004':
            return 'CONDADO';
            break;
        case '006':
            return 'VILLAGE';
            break;
        case '007':
            return 'SCALA';
            break;
        case '008':
            return 'QUICENTRO';
            break;
        case '009':
            return 'SAN LUIS';
            break;
        case '010':
            return 'SAN MARINO';
            break;
        case '011':
            return 'JUAN LEON MERA';
            break;
        case '012':
            return 'CUMBAYA';
            break;
        case '013':
            return 'PACIFICO';
            break;
        case '014':
            return 'ANDES';
            break;
    }
}

function negativo($numero) {
    return $numero * -1;
}
