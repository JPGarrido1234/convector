<?php

// Función que crea una nueva subruta en la abse de datos en bae a los parámetros pasados
// (estén completos o no)
// RETURN: -
// ESTADO: Funciona
function fx_crear_subruta_completa( $cn, $cod_subruta, $fecha_hora_ini, $fecha_hora_fin, $lat_or, $long_or, $lat_dest, $long_dest, $entidad, $cod_carga ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $entidad = mysqli_real_escape_string( $cn, $entidad );
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql_suj = "INSERT INTO subruta(codigo, entidad, ";
    $sql_pre = "VALUES ('$cod_subruta', '$entidad', '";

    if ( $fecha_hora_ini != null ) {
        $sql_suj .= "fecha_hora_inicio, ";
        $sql_pre .= $fecha_hora_ini."', '";
    } if ( $fecha_hora_fin != null ) {
        $sql_suj .= "fecha_hora_final, ";
        $sql_pre .= $fecha_hora_fin."', '";
    } if ( $lat_or != null ) {
        $sql_suj .= "latitud_origen, ";
        $sql_pre .= $lat_or."', '";
    } if ( $long_or != null ) {
        $sql_suj .= "longitud_origen, ";
        $sql_pre .= $long_or."', '";
    } if ( $lat_dest != null ) {
        $sql_suj .= "latitud_destino, ";
        $sql_pre .= $lat_dest."', '";
    } if ( $long_dest != null ) {
        $sql_suj .= "longitud_destino, ";
        $sql_pre .= $long_dest."', '";
    }

    $sql_suj .= "carga) ";
    $sql_pre .= $cod_carga."');";
    $sql_suj .= $sql_pre;

    mysqli_query($cn, $sql_suj);
}

// Función que crea una nueva subruta en la base de datos en base a los parámetros pasados sin
// añadir ubicación (estén completos o no)
// RETURN: -
// ESTADO: Funciona
function fx_crear_subruta_incompleta( $cn, $cod_subruta, $fh_ini, $fh_fin, $entidad, $cod_carga ) {
    $cod_subruta = mysqli_real_escape_string($cn, $cod_subruta);
    $entidad = mysqli_real_escape_string($cn, $entidad);
    $cod_carga = mysqli_real_escape_string($cn, $cod_carga);

    $load_id = fx_recoger_carga($cn, $cod_carga);
    $entidad_id = fx_recoger_entidad_id($cn, $entidad);

    $sql_suj = "INSERT INTO subroute (code, managing_entity_id, ";
    $sql_pre = "VALUES ('$cod_subruta', '$entidad_id', '";

    if ( $fh_ini != null ) {
        $sql_suj .= "start, "; $sql_pre .= $fh_ini."', '";
    } if ( $fh_fin != null ) {
        $sql_suj .= "end, "; $sql_pre .= $fh_fin."', '";
    }
    $sql_suj .= "entity_id, load_id) ";
    $sql_pre .= $entidad_id."', '".$load_id."');";
    $sql_suj .= $sql_pre;

    mysqli_query($cn, $sql_suj);
}

// Función que añade las coordenadas y nombre de origen y destino a una subruta ya creada
// RETURN: -
// ESTADO: Funciona
function fx_anadir_ubicacion_subruta( $cn, $cod_subruta, $lat_or, $long_or, $nombre_origen, $lat_dest, $long_dest, $nombre_destino ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $nombre_origen = mysqli_real_escape_string( $cn, $nombre_origen );
    $nombre_destino = mysqli_real_escape_string( $cn, $nombre_destino );

    if(strlen($lat_dest) > 20){
        $lat_destino = explode(",", $lat_dest);
        $sql = "UPDATE subroute SET origin_latitude = '$lat_or', origin_longitude = '$long_or',
        destiny_latitude = '$lat_destino[0]', destiny_longitude = '$long_dest', origin = '$nombre_origen', 
        destiny = '$nombre_destino' WHERE code = '$cod_subruta'";
    }else{
        $sql = "UPDATE subroute SET origin_latitude = '$lat_or', origin_longitude = '$long_or',
        destiny_latitude = '$lat_dest', destiny_longitude = '$long_dest', origin = '$nombre_origen', 
        destiny = '$nombre_destino' WHERE code = '$cod_subruta'";
    }
    mysqli_query( $cn, $sql );
}

// Función que añade los vehículos a una carga
function fx_crear_vehiculos_en_subruta($cn, $cod_subruta, $lista_tipos, $lista_matriculas) {
    $cod_subruta = mysqli_real_escape_string($cn, $cod_subruta);

    for ( $i = 0, $cant = count( $lista_tipos ); $i < $cant; ++$i ) {
        $tipo = mysqli_real_escape_string( $cn, $lista_tipos[$i] );
        $matricula = mysqli_real_escape_string($cn, $lista_matriculas[$i]);

        $load_id = fx_recoger_carga_subruta($cn, $cod_subruta);

        $sql = "INSERT INTO vehicle (license_number, type_car) VALUES ('$matricula', '$tipo')";
        $msg = mysqli_query($cn, $sql);
        $select_sql = "SELECT id FROM vehicle WHERE license_number = '$matricula' LIMIT 1";
        $result = mysqli_query($cn, $select_sql);
        $vehicle_id = mysqli_fetch_array($result);
        if(isset($vehicle_id[0])){
            $insert_vehicle_subruta = "INSERT INTO subroute_vehicle (subroute_id, vehicle_id) VALUES ('$load_id', '$vehicle_id[0]')";
            $result2 = mysqli_query($cn, $insert_vehicle_subruta) or die(mysqli_error($cn));
        }
    }
}

// Función que recoge todas las subrutas que tiene una carga con el lvl de privilegios del usuario que las pide
// RETURN: Array con las subrutas deseadas
// ESTADO: Sin comprobar
function fx_recoger_subrutas_carga( $cn, $carga, $email ) {
    $carga = mysqli_real_escape_string( $cn, $carga );

    $sql = "SELECT * from subruta WHERE carga = '$carga'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $email );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge el código de la carga a la que pertenece la subruta
// RETURN: Código de la carga
// ESTADO: Sin comprobar
function fx_recoger_carga_subruta($cn, $cod_subruta) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql = "SELECT load_id FROM subroute WHERE code = '$cod_subruta'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    return $msg[0];
}

// Función que asigna un responsable a una subruta
// RETURN: -
// ESTADO: Sin comprobar
function fx_asignar_responsable_subruta( $cn, $cod_subruta, $email ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $email = mysqli_real_escape_string( $cn, $email );

    $sql = "UPDATE subruta SET responsable = '$email' WHERE codigo = '$cod_subruta'";
    mysqli_query( $cn, $sql );
}

// Función que recoge el producto de una subruta
// RETURN: Nombre del producto deseado
// ESTADO: Sin comprobar
function fx_recoger_producto_subruta($cn, $cod_subruta) {
    $cod_subruta = mysqli_real_escape_string($cn, $cod_subruta);

    $sql = "SELECT name FROM product WHERE code = (
        SELECT product_id FROM loading WHERE code = (
            SELECT load_id FROM subroute WHERE code = '$cod_subruta'
        )
    )";

    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    if(isset($msg)){
        return $msg[0];
    }
    
    return $msg;
}

// Función que recoge el responsable de una subruta
// RETURN: Email de responsable de la subruta
// ESTADO: Sin comprobar
function fx_recoger_responsable_subruta( $cn, $cod_subruta ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql = "SELECT responsable FROM subruta WHERE codigo = '$cod_subruta'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    if(isset($msg)){
        return $msg[0];
    }
    
    return $msg;
}

// Función que recoge el responsable de una carga a partir de una subruta
// RETURN: Email de responsable de la carga
// ESTADO: Sin comprobar
function fx_recoger_responsable_carga_subruta( $cn, $cod_subruta ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql = "SELECT responsable FROM carga WHERE codigo = (
        SELECT carga FROM subruta WHERE codigo = '$cod_subruta'
    )";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    return $msg[0];
}

// Función que recoge la entidad de una subruta
// RETURN: Entidad de la subruta
// ESTADO: Sin comprobar
function fx_recoger_entidad_subruta( $cn, $cod_subruta ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql = "SELECT entity_id FROM subroute WHERE code = '$cod_subruta'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    if(isset($msg)){
        return $msg[0];
    }
    
    return $msg;
}

// Función que calcula y deveulve el nivel de privilegios de un usuario en una subruta
// RETURN: 1 -> Solo ver, 3 -> Ver, editar y borrar
// ESTADO: Funciona
function fx_calcular_privilegios_subruta_usuario( $cn, $subruta, $usuario ) {
    $subruta = mysqli_real_escape_string( $cn, $subruta );
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $rol_usu = fx_recoger_rol( $cn, $usuario );
    $resp_carga = fx_recoger_responsable_carga( $cn, fx_recoger_carga_subruta( $cn, $subruta ) );
    $resp_subruta = fx_recoger_responsable_subruta( $cn, $subruta );

    $entidad_carga = fx_recoger_entidad_carga( $cn, fx_recoger_carga_subruta( $cn, $subruta ) );
    $entidad_subruta = fx_recoger_entidad_subruta( $cn, $subruta );
    $entidad_usuario = fx_recoger_entidad( $cn, $usuario );

    if ( $usuario == $resp_carga || $usuario == $resp_subruta ) {
        $lvl = 3; // ver, editar y borrar
    } else if ( $rol_usu == 'ROLE_TECHNICIAN' ) {
        $lvl = 1; // ver
    } else if ( $entidad_usuario == $entidad_carga || $entidad_usuario == $entidad_subruta ) {
        $lvl = 3; // ver, editar y borrar
    } else {
        $lvl = 1; // ver
    }
    return $lvl;

}

// Función que sirve para recoger todas las subrutas que puede ver un usuario
// con su respectivo nivel de privilegio
function fx_recoger_subrutas_usuario( $cn, $usuario ) {
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $entidad = fx_recoger_entidad($cn, $usuario);

    if(!is_numeric($usuario)){
        $usuario = fx_recoger_usuario_id($cn, $usuario);
    }

    $sql = "SELECT * FROM subroute WHERE entity_id = '$entidad' UNION 
    SELECT * FROM subroute WHERE load_id IN (
        SELECT load_id FROM view_load_permission WHERE user_id = '$usuario'
    ) UNION SELECT * FROM subroute WHERE load_id IN (
        SELECT code FROM loading WHERE entity_id = '$entidad'
    )";
    $array = array();
    $result = mysqli_query($cn, $sql);
    while ( $fila = mysqli_fetch_array($result) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario($cn, $fila['code'], $usuario);
        array_push($array, $fila);
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa( $cn, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' UNION 
    SELECT * FROM subruta WHERE carga IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas que puede ver un usuario
// con su respectivo nivel de privilegio y con el filtro de datalogger
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_datalogger( $cn, $usuario, $cod_datalogger ) {
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $entidad = fx_recoger_entidad( $cn, $usuario );
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND carga IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND carga IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND carga IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// con el filtro de datalogger
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa_datalogger( $cn, $entidad, $cod_datalogger ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND carga IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND carga IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND carga IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    
    return $array;
}

// Función que sirve para recoger todas las subrutas que puede ver un usuario
// con su respectivo nivel de privilegio y con el filtro de contenedor
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_contenedor( $cn, $usuario, $cod_contenedor ) {
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $entidad = fx_recoger_entidad( $cn, $usuario );
    $cod_contenedor = mysqli_real_escape_string( $cn, $cod_contenedor );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND carga IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND carga IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND carga IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// con el filtro de contenedor
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa_contenedor( $cn, $entidad, $cod_contenedor ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );
    $cod_contenedor = mysqli_real_escape_string( $cn, $cod_contenedor );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND carga IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND carga IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND carga IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    
    return $array;
}

// Función que sirve para recoger todas las subrutas que puede ver un usuario
// con su respectivo nivel de privilegio y con el filtro de fechas en activo
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_activo_fecha( $cn, $usuario, $fecha_ini, $fecha_fin ) {
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND NOT (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND NOT (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND NOT (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// con el filtro de fechas en activo
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa_activo_fecha( $cn, $entidad, $fecha_ini, $fecha_fin ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND NOT (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND NOT (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND NOT (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger todas las subrutas que puede ver un usuario
// con su respectivo nivel de privilegio y con el filtro de fechas no activas
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_inactivo_fecha( $cn, $usuario, $fecha_ini, $fecha_fin ) {
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// con el filtro de fechas no activas
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa_inactivo_fecha( $cn, $entidad, $fecha_ini, $fecha_fin ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM subruta WHERE entidad = '$entidad' AND (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    ) UNION SELECT * FROM subruta WHERE carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    ) AND (
        ( '$fecha_ini 00:00:00' < fecha_hora_inicio AND '$fecha_fin 23:59:59' <= fecha_hora_inicio ) OR 
        ( '$fecha_ini 00:00:00' >= fecha_hora_final AND '$fecha_fin 23:59:59' > fecha_hora_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas que puede ver un usuario
// con su respectivo nivel de privilegio y con el filtro de ubicación por coordenadas
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_ubicacion( $cn, $usuario, $latitud_or, $longitud_or, $latitud_dest, $longitud_dest ) {
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM subruta WHERE ";
    if ( $latitud_or != null ) {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND entidad = '$entidad' UNION SELECT * FROM subruta WHERE ";
    if ( $latitud_or != null ) {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $longitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND carga IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) UNION SELECT * FROM subruta WHERE ";
    if ( $latitud_or != null ) {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// con el filtro de ubicación por coordenadas
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa_ubicacion( $cn, $entidad, $latitud_or, $longitud_or, $latitud_dest, $longitud_dest ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM subruta WHERE ";
    if ( $latitud_or != null ) {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND entidad = '$entidad' UNION SELECT * FROM subruta WHERE ";
    if ( $latitud_or != null ) {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $longitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND carga IN (
        SELECT codigo FROM carga WHERE codigo IN (
            SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
                SELECT email FROM usuario WHERE entidad = '$entidad'
            )
        )
    ) UNION SELECT * FROM subruta WHERE ";
    if ( $latitud_or != null ) {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND carga IN (
        SELECT codigo FROM carga WHERE entidad = '$entidad'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas que puede ver un usuario con su respectivo nivel de
// privilegio y con el filtro de ubicación por texto
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_ubicacion_texto( $cn, $usuario, $origen, $destino ) {
    $entidad = fx_recoger_entidad( $cn, mysqli_real_escape_string( $cn, $usuario ) );

    $sql1 = "SELECT * FROM subruta WHERE entidad = '$entidad'";
    $sql2 = " UNION SELECT * FROM subruta WHERE carga IN (SELECT carga FROM acceso_informacion WHERE email = '$usuario')";
    $sql3 = " UNION SELECT * FROM subruta WHERE carga IN (SELECT codigo FROM carga WHERE entidad = '$entidad')";
    if ( $origen != null ) {
        $origen_f = "%".mysqli_real_escape_string( $cn, $origen )."%";
        $sql1 .= " AND nombre_origen LIKE '$origen_f'";
        $sql2 .= " AND nombre_origen LIKE '$origen_f'";
        $sql3 .= " AND nombre_origen LIKE '$origen_f'";
    } if ( $destino != null ) {
        $destino_f = "%".mysqli_real_escape_string( $cn, $destino )."%";
        $sql1 .= " AND nombre_destino LIKE '$destino_f'";
        $sql2 .= " AND nombre_destino LIKE '$destino_f'";
        $sql3 .= " AND nombre_destino LIKE '$destino_f'";
    }
    $sql1 .= $sql2 . $sql3;
    $array = array();
    $result = mysqli_query( $cn, $sql1 );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger todas las subrutas de una entidad para el superadmin
// con el filtro de ubicación por texto
// RETURN: Array con las subrutas
// ESTADO: Funciona
function fx_recoger_subrutas_sa_ubicacion_texto( $cn, $entidad, $origen, $destino ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql1 = "SELECT * FROM subruta WHERE entidad = '$entidad'";
    $sql2 = " UNION SELECT * FROM subruta WHERE carga IN (SELECT DISTINCT carga FROM acceso_informacion WHERE email IN 
    (SELECT email FROM usuario WHERE entidad = '$entidad'))";
    $sql3 = " UNION SELECT * FROM subruta WHERE carga IN (SELECT codigo FROM carga WHERE entidad = '$entidad')";
    if ( $origen != null ) {
        $origen_f = "%".mysqli_real_escape_string( $cn, $origen )."%";
        $sql1 .= " AND nombre_origen LIKE '$origen_f'";
        $sql2 .= " AND nombre_origen LIKE '$origen_f'";
        $sql3 .= " AND nombre_origen LIKE '$origen_f'";
    } if ( $destino != null ) {
        $destino_f = "%".mysqli_real_escape_string( $cn, $destino )."%";
        $sql1 .= " AND nombre_destino LIKE '$destino_f'";
        $sql2 .= " AND nombre_destino LIKE '$destino_f'";
        $sql3 .= " AND nombre_destino LIKE '$destino_f'";
    }
    $sql1 .= $sql2 . $sql3;
    $array = array();
    $result = mysqli_query( $cn, $sql1 );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }

    return $array;
}

// Función que sirve para recoger toda la información sobre una subruta en base a su código
// con el lvl de privilegios del usuario sobre esta
// RETURN: Array con la información de la subruta deseada
// ESTADO: Funciona
function fx_recoger_subruta_con_privilegios( $cn, $cod_subruta, $usuario ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $usuario = mysqli_real_escape_string( $cn, $usuario );

    $sql = "SELECT * FROM subroute WHERE code = '$cod_subruta'";
    $result = mysqli_query( $cn, $sql );
    $array = mysqli_fetch_array( $result );
    $array['lvl_privilegios'] = fx_calcular_privilegios_subruta_usuario( $cn, $cod_subruta, $usuario );
    return $array;
}

// Función que recoge todos los dataloggers y su contenedor correspondiente de una subruta
// RETURN: Array con los dataloggers y contenedores correspondientes
// ESTADO: Funciona
function fx_recoger_dataloggers_subruta( $cn, $cod_subruta ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql = "SELECT * FROM container WHERE load_id =
    (SELECT load_id FROM subroute WHERE code = '$cod_subruta')";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge todos los vehículos de una subruta
// RETURN: Array con los vehículos
// ESTADO: Funciona
function fx_recoger_vehiculos_subruta( $cn, $cod_subruta ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql = "SELECT * FROM subroute_vehicle WHERE subroute_id = '$cod_subruta'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que borra una subruta comprobando que el usuario tiene permisos para hacerlo
// RETURN: -
// ESTADO: Funciona
function fx_borrar_subruta( $cn, $cod_subruta, $email ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $email = mysqli_real_escape_string( $cn, $email );

    if ( fx_calcular_privilegios_subruta_usuario( $cn, $cod_subruta, $email ) == 3 ) {
        $sql = "DELETE FROM subruta WHERE codigo = '$cod_subruta'";
        mysqli_query( $cn, $sql );
    }
}

// Función que actualiza los datos de una subruta en la DB en función de las modificaciones hechas
// RETURN: -
// ESTADO: Funciona
function fx_editar_subruta( $cn, $cod_subruta, $responsable, $fecha_hora_inicio, $fecha_hora_final ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $responsable = mysqli_real_escape_string( $cn, $responsable );

    $sql = "UPDATE subruta SET responsable = ";
    if ( $responsable != null ) { $sql .= "'$responsable'"; }
    else { $sql .= "NULL"; }
    $sql .= ", fecha_hora_inicio = ";
    if ( $fecha_hora_inicio != null ) { $sql .= "'$fecha_hora_inicio'"; }
    else { $sql .= "NULL"; }
    $sql .= ", fecha_hora_final = ";
    if ( $fecha_hora_final != null ) { $sql .= "'$fecha_hora_final'"; }
    else { $sql .= "NULL"; }
    $sql .= " WHERE codigo = '$cod_subruta'";

    mysqli_query( $cn, $sql );
}

// Función que actualiza los datos de origen y destino de una carga
// RETURN: -
// ESTADO: Funciona
function fx_editar_lugares_subruta( $cn, $cod_subruta, $lat_origen, $long_origen, $nombre_origen,
$lat_destino, $long_destino, $nombre_destino ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );
    $nombre_origen = mysqli_real_escape_string( $cn, $nombre_origen );
    $nombre_destino = mysqli_real_escape_string( $cn, $nombre_destino );

    $sql = "UPDATE subruta SET latitud_origen = $lat_origen, longitud_origen = $long_origen, 
    nombre_origen = '$nombre_origen', latitud_destino = $lat_destino, longitud_destino = $long_destino, 
    nombre_destino = '$nombre_destino' WHERE codigo = '$cod_subruta'";

    mysqli_query( $cn, $sql );
}

// Función que edita (borra y crea nuevas instancias) de vehículos en una subruta
// RETURN: -
// ESTADO: Funciona
function fx_editar_vehiculos( $cn, $cod_subruta, $lista_tipos, $lista_matriculas ) {
    $cod_subruta = mysqli_real_escape_string( $cn, $cod_subruta );

    $sql1 = "DELETE FROM vehiculo WHERE subruta = '$cod_subruta'";
    mysqli_query( $cn, $sql1 );
    for ( $i = 0, $cont = count( $lista_tipos ); $i < $cont; ++$i ) {
        $mat = mysqli_real_escape_string( $cn, $lista_matriculas[$i] );
        if ( $lista_tipos[$i] != null ) {
            $tipo = mysqli_real_escape_string( $cn, $lista_tipos[$i] );
            $sql2 = "INSERT INTO vehiculo (matricula, tipo, subruta) VALUES ('$mat', '$tipo', '$cod_subruta')";
        } else {
            $sql2 = "INSERT INTO vehiculo (matricula, subruta) VALUES ('$mat', '$cod_subruta')";
        }
        mysqli_query( $cn, $sql2 );
    }
}

?>