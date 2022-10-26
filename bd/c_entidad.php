<?php

// Función que registra una nueva entidad en la base de datos (solo usada por superadmin)
// RETURN: Mensaje de error o de éxito en el registro
// ESTADO: Funciona
function fx_registrar_entidad( $cn, $email, $nombre, $tipo, $direccion1, $direccion2, $poblacion, $pais ) {
    $email = mysqli_real_escape_string( $cn, $email );
    $nombre = mysqli_real_escape_string( $cn, $nombre );
    $tipo = mysqli_real_escape_string( $cn, $tipo );
    $direccion1 = mysqli_real_escape_string( $cn, $direccion1 );
    $poblacion = mysqli_real_escape_string( $cn, $poblacion );
    $pais = mysqli_real_escape_string( $cn, $pais );

    if ( fx_recoger_rol( $cn, $email ) == 'ROLE_SUPER_ADMIN' ) {
        if ( !is_null( $direccion2 ) ) {
            $direccion2 = mysqli_real_escape_string( $cn, $direccion2 );
            $sql = "INSERT INTO entidad (nombre, tipo, direccion1, direccion2, poblacion, pais) 
            VALUES ('$nombre', '$tipo', '$direccion1', '$direccion2', '$poblacion', '$pais')";
        } else {
            $sql = "INSERT INTO entidad (nombre, tipo, direccion1, poblacion, pais) 
            VALUES ('$nombre', '$tipo', '$direccion1', '$poblacion', '$pais')";
        }
        mysqli_query( $cn, $sql );
        $msg = "Entidad registrada";
    } else {
        $msg = "No tienes permisos para realizar esto. Contacta con el superadmin";
    }
    return $msg;
}

// Función que registra un nuevo datalogger en la BD si no hay uno con el mismo código ya creado
// RETURN: -
// ESTADO: Sin comprobar
function fx_crear_datalogger( $cn, $codigo, $entidad ) {
    $codigo = mysqli_real_escape_string( $cn, $codigo );
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "INSERT INTO datalogger (code, is_active, entidad) VALUES ('$codigo', 0, '$entidad')";
    mysqli_query( $cn, $sql );
}

// Función que sirve para asignar una persona de contacto a una entidad
// RETURN: Mensaje de error o de éxito en la actualización
// ESTADO: Funciona
function fx_asignar_contacto( $cn, $email_superadmin, $email_usuario, $nombre_entidad ) {
    $email_superadmin = mysqli_real_escape_string( $cn, $email_superadmin );
    $email_usuario = mysqli_real_escape_string( $cn, $email_usuario );
    $nombre_entidad = mysqli_real_escape_string( $cn, $nombre_entidad );

    if ( fx_recoger_rol( $cn, $email_superadmin ) == 'ROLE_SUPER_ADMIN' ) {
        $sql = "UPDATE entidad SET persona_contacto = '$email_usuario' WHERE nombre = '$nombre_entidad'";
        mysqli_query( $cn, $sql );
        $msg = "Contacto de la entidad actualizado";
    } else {
        $msg = $msg = "No tienes permisos para realizar esto. Contacta con el superadmin";
    }
    return $msg;
}

// Función que sirve para que el superadministrador recoja todas las entidades de la base de datos
// RETURN: Array de arrays con los datos de cada entidad o array vacío en caso de error
// ESTADO: Funciona
function fx_recoger_entidades( $cn ) {
    $sql = "SELECT * FROM entity WHERE NOT name = 'Inkoa'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger todos los usuarios que pertenecen a una entidad en base a su email
// RETURN: Array de arrays con los datos de cada usuario o array vacío en caso de error
// ESTADO: Funciona
function fx_recoger_usuarios($cn, $email) {
    $email = mysqli_real_escape_string($cn, $email);
    $entidad = mysqli_real_escape_string($cn, fx_recoger_entidad($cn, $email));
    
    if (fx_recoger_rol($cn, $email) == 'ROLE_ADMIN' ) {
        $sql = "SELECT * FROM user WHERE entity_id = '$entidad'";
        $array = array();
        $result = mysqli_query($cn, $sql);
        
        while ($fila = mysqli_fetch_array($result)) {
            array_push($array, $fila);
        }
        return $array;
    } else {
        return array();
    }
}

function fx_recoger_entidad__id($cn, $entity_id){
    $msg = null;
    $sql = "SELECT name FROM entity WHERE id = '$entity_id'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }

    return $msg;
}

function fx_recoger_usuario__id($cn, $user_id){
    $msg = null;
    $sql = "SELECT first_name FROM user WHERE id = '$user_id'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }

    return $msg;
}

function fx_recoger_datalogger__id($cn, $datalogger_id){
    $msg = null;
    $sql = "SELECT code FROM datalogger WHERE id = '$datalogger_id'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }

    return $msg;
}

function fx_recoger_loadding__id($cn, $load_id){
    $msg = null;
    $sql = "SELECT code FROM loading WHERE id = '$load_id'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }

    return $msg;
}

function fx_recoger_vehicleType__id($cn, $vehicle_id){
    $msg = null;
    $sql = "SELECT type_car FROM vehicle WHERE id = '$vehicle_id'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }

    return $msg;
}

function fx_recoger_vehicleMatricula__id($cn, $vehicle_id){
    $msg = null;
    $sql = "SELECT license_number FROM vehicle WHERE id = '$vehicle_id'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }

    return $msg;
}

// Función que sirve para recoger todos los usuarios que pertenecen a una entidad en base a esta
// RETURN: Array de arrays con los datos de los usuarios de la entidad
// ESTADO: Funciona
function fx_recoger_usuarios_entidad($cn, $entidad) {
    $entidad = mysqli_real_escape_string($cn, $entidad);

    $sql = "SELECT * FROM user WHERE entity_id = '$entidad' ORDER BY first_name";
    $array = array();
    $result = mysqli_query($cn, $sql);
    while ($fila = mysqli_fetch_array($result)) {
        array_push($array, $fila);
    }
    return $array;
}

// Función que sirve para recoger todas las cargas de la entidad
// RETURN: Array de arrays con los datos de cada carga
// ESTADO: Funciona
function fx_recoger_cargas( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );
    $entidad = mysqli_real_escape_string( $cn, fx_recoger_entidad( $cn, $email ) );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger todas las cargas de una entidad en base a su nombre
// RETURN: Array de arrays con los datos de las cargas de la entidad
// ESTADO: Funciona
function fx_recoger_cargas_entidad( $cn, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger la entidad a la que pertenece el usuario
function fx_recoger_datos_entidad($cn, $email) {
    $email = mysqli_real_escape_string( $cn, $email );
    $entidad = mysqli_real_escape_string($cn, fx_recoger_entidad($cn, $email));

    $sql = "SELECT * FROM entity WHERE id = '$entidad'";
    $result = mysqli_query($cn, $sql);
    $array = mysqli_fetch_array($result);
    return $array;
    
}

// Función que sirve para recoger los dataloggers de la entidad
// RETURN: Array con los datos de los dataloggers de la entidad
// ESTADO: Sin comprobar
function fx_recoger_dataloggers_entidad( $cn, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );
    
    $sql = "SELECT * FROM datalogger WHERE entity_id = '$entidad' AND is_active = 0";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger los datos de una entidad en base a su nombre
// RETURN: Array con los datos de los datalogger de la entidad
// ESTADO: Funciona
function fx_recoger_info_entidad( $cn, $nombre_entidad ) {
    $nombre_entidad = mysqli_real_escape_string( $cn, $nombre_entidad );

    $sql = "SELECT * FROM entity WHERE name = '$nombre_entidad'";
    $result = mysqli_query( $cn, $sql );
    $array = mysqli_fetch_array( $result );
    return $array;
}

// Función qur sirve para recoger todas las subrutas de la entidad
// RETURN: Array con los datos de las subrutas de la entidad
// ESTADO: Sin comprobar
function fx_recoger_subrutas_entidad( $cn, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger todos los productos únicos de la entidad, sin nombre+variedad repetidos
// RETURN: Array con los datos de los productos
// ESTADO: Sin comprobar
function fx_recoger_productos_entidad_unique( $cn, $entidad) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT code, name, variety, min_temp, max_temp, entity_id FROM (
        SELECT *, row_number() OVER (PARTITION BY name, variety ORDER BY code) rn 
        FROM product WHERE entity_id = '$entidad'
    ) r WHERE r.rn = 1 ORDER BY r.code";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push($array, $fila);
    }
    return $array;
}

// Función que sirve para recoger todos los dataloggers de la entidad
// que no vayan a estar en uso durante las fechas de la carga
// RETURN: Array con los dataloggers que no estarán en uso de la entidad
// ESTADO: Funciona (solo comprobado en los casos 'normales')
function fx_recoger_dataloggers_off_entidad( $cn, $entidad, $carga ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );
    $carga = mysqli_real_escape_string( $cn, $carga );

    $sql2 = "SELECT code, start, end FROM loading WHERE entity_id = '$entidad' AND code = '$carga'";
    $result2 = mysqli_fetch_array( mysqli_query( $cn, $sql2 ));

    $sql3 = "SELECT id, start, end FROM loading WHERE entity_id = '$entidad' AND NOT code = '$carga' AND end BETWEEN '".date( "Y-m-d" )."' AND ". "'2200-12-31'";
    $array_result3 = array();
    $result3 = mysqli_query($cn, $sql3);
    while ($fila = mysqli_fetch_array($result3)) {
        array_push($array_result3, $fila);
    }
    $array_cargas = array();
    if(isset($result2['start']) && isset($result2['end'])){
        $v = explode( "-", $result2['start'] );
        $fecha_ini_nueva = intval( $v[0].$v[1].$v[2] );
        $v = explode( "-", $result2['end'] );
        $fecha_fin_nueva = intval( $v[0].$v[1].$v[2] );
        for ( $i = 0, $cont = count( $array_result3 ); $i < $cont; ++$i ) { // Cods de cargas que dan problemas
    
            $v = explode( "-", $array_result3[$i]['start'] );
            $fecha_ini_vieja = intval( $v[0].$v[1].$v[2] );
            $v = explode( "-", $array_result3[$i]['end'] );
            $fecha_fin_vieja = intval( $v[0].$v[1].$v[2] );
    
            if ( !( ( $fecha_ini_nueva < $fecha_ini_vieja && $fecha_fin_nueva < $fecha_ini_vieja ) ||
            ( $fecha_ini_nueva > $fecha_fin_vieja && $fecha_fin_nueva > $fecha_fin_vieja ) ) ) {
                array_push( $array_cargas, $array_result3[$i]['id'] );
            }
        }
    }
    

    $sql_final = "SELECT * FROM datalogger WHERE entity_id = '$entidad'";
    if ( !empty( $array_cargas ) ) {
        $sql_final .= " AND code NOT IN (SELECT datalogger_id FROM container WHERE ";
        $j = 0;
        if(count($array_cargas) > 0){
            foreach($array_cargas as $carga){    
                if ($j == 0) {
                    $sql_final.= " load_id = ".$carga;
                } else {
                    $sql_final .= " OR load_id = ".$carga."";
                }
                ++$j;
            }
        }
        $sql_final .= ")";
    }

    $result_final = mysqli_query( $cn, $sql_final );
    $array_resultf = array();
    while ( $fila = mysqli_fetch_array( $result_final ) ) {
        array_push( $array_resultf, $fila['code'] );
    }
    return $array_resultf;

}

function fx_alta_container_datalogger($cn, $code, $entidad, $load_id, $sel_datalogger) {
    $cod_datalogger = mysqli_real_escape_string( $cn, $code );

    $info_datalogger = fx_recoger_datalogger($cn, $sel_datalogger);
    $sql = "INSERT INTO container (entity_id, load_id, datalogger_id, code) VALUES ('$entidad', ".$load_id.", ".$info_datalogger['id'].", '$cod_datalogger')";
    //echo "sql :".$sql."<br>";
    //$msg = mysqli_query($cn, $sql) or die( mysqli_error( $cn ) );
}

?>