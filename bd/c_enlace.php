<?php

// Función que recoge la última carga y contenedor en el que ha estado el datalogger
// RETURN: Carga y código del contenedor últimos en los que ha estado el datalogger
// ESTADO: Funciona
function fx_recoger_ultimo_enlace($cn, $datalogger) {
    $dataloggers = mysqli_real_escape_string($cn, $datalogger);
    $datalogger_id = fx_recoger_datalogger_code($cn, $dataloggers);
    $sql = "SELECT load_id, code FROM container WHERE datalogger_id = ".$datalogger_id[0]['id']." ORDER BY id DESC";
    
    // Probar el siguiente para solucionar el problema descrito en "notas.txt"
    /* $sql = "SELECT carga, contenedor FROM enlace WHERE datalogger = '$datalogger' AND carga IN (
        SELECT codigo FROM carga WHERE fecha_inicio < NOW() AND fecha_final < NOW() ORDER BY codigo DESC
    )"; */

    $result = mysqli_query($cn, $sql);
    $array = mysqli_fetch_array($result);
    return $array;
}

// Función que crea un nuevo enlace entre carga, datalogger y contenedor en la BD
// RETURN: -
// ESTADO: Funciona
function fx_crear_enlace( $cn, $carga, $lista_dataloggers, $lista_contenedores ) { {
    $carga = mysqli_real_escape_string( $cn, $carga );

    for ( $i = 0, $cont = count( $lista_dataloggers ); $i < $cont; ++$i ) {
        $dat = mysqli_real_escape_string( $cn, $lista_dataloggers[$i] );
        $cont = mysqli_real_escape_string( $cn, $lista_contenedores[$i] );
        $sql = "INSERT INTO enlace (contenedor, carga, datalogger) VALUES ('$cont', '$carga', '$dat')";
        mysqli_query( $cn, $sql );
    }
}
    
}

?>