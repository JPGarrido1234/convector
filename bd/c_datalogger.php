<?php

// Función que recoge un datalogger en base a su código
function fx_recoger_datalogger($cn, $cod_datalogger) {
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger);

    if(is_numeric($cod_datalogger)){
        $sql = "SELECT * FROM datalogger WHERE id = '$cod_datalogger'";
    }else{
        $sql = "SELECT * FROM datalogger WHERE code = '$cod_datalogger'";
    }
    
    $result = mysqli_query($cn, $sql);
    $array = mysqli_fetch_array($result);
    return $array;
}

// Función que recoge todos los dataloggers registrados en la aplicación
function fx_recoger_dataloggers( $cn ) {
    $sql = "SELECT * FROM datalogger";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge los dataloggers de una entidad que estén disponibles para usar
// para una carga concreta
// RETURN: Lista de códigos de los dataloggers
function fx_recoger_dataloggers_disponibles( $cn, $entidad, $cod_carga ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );
    $carga = fx_recoger_carga( $cn, mysqli_real_escape_string( $cn, $cod_carga ) );
    $carga_ini = $carga['fecha_inicio']; $carga_fin = $carga['fecha_final'];

    $sql = "SELECT * FROM datalogger WHERE entidad = '$entidad' AND NOT is_active = 0 AND NOT code IN (
        SELECT datalogger FROM enlace WHERE carga IN (
            SELECT code FROM carga WHERE NOT ( (fecha_inicio < $carga_ini AND fecha_final < $carga_ini) OR (fecha_inicio > $carga_fin AND fecha_final > $carga_fin) )
        )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila['code'] );
    }

    return $array;

}

// Función que elimina los últimos enlaces de una carga si al editarla se reduce el número de contenedores/dataloggers
// RETURN: -
// ESTADO: Funciona
function fx_eliminar_dataloggers_carga_cantidad( $cn, $cod_carga, $num_cont_nuevo ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "SELECT * FROM enlace WHERE carga = '$cod_carga'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila['datalogger'] );
    }
    for ( $i = 0; $i < $num_cont_nuevo; ++$i ) {
        array_shift( $array );
    }

    $sql2 = "DELETE FROM enlace WHERE datalogger IN ('".$array[0]."'";
    for ( $j = 1, $cant = count( $array ); $j < $cant; ++$j ) {
        $sql2 .= ", '$array[$j]'";
    }
    $sql2 .= ") AND carga = '$cod_carga'";
    mysqli_query( $cn, $sql2 );
}

// Función que elimina los enlaces (dataloggers asociados a una carga) de una carga
// RETURN: -
// ESTADO: Funciona
function fx_eliminar_dataloggers_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "DELETE FROM enlace WHERE carga = '$cod_carga'";
    mysqli_query( $cn, $sql );
}

// Función que da de baja o alta un datalogger:
// $baja: true -> dar de baja, false -> dar de alta
// RETURN: -
// ESTADO: Funciona
function fx_baja_datalogger( $cn, $cod_datalogger, $baja ) {
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger );

    if ($baja) { 
        $sql = "UPDATE datalogger SET is_active = 0 WHERE code = '$cod_datalogger'";
    } else {
        $sql = "UPDATE datalogger SET is_active = 1 WHERE code = '$cod_datalogger'";
    }
    $msg = mysqli_query( $cn, $sql ) or die( mysqli_error( $cn ) );
}

function fx_update_datalogger($cn, $tochange, $cod_datalogger, $entidad){
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger );
    $sql = "UPDATE datalogger SET code = '$tochange', is_active = 0 WHERE code = '$cod_datalogger' AND entity_id = '$entidad'";
    $msg = mysqli_query($cn, $sql) or die(mysqli_error($cn));
}

?>