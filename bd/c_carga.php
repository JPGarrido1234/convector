<?php

// Función que recoge el nombre de una entidad en función del código de una carga
// RETURN: Nombre de la entidad deseada
// ESTADO: Sin comprobar
function fx_recoger_entidad_carga( $cn, $carga ) {
    $carga = mysqli_real_escape_string( $cn, $carga );

    $sql = "SELECT entidad FROM carga WHERE codigo='$carga'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    return $msg[0];
}

// Función que crea una nueva carga en la base de datos en base a los parámetros pasados
// (estén completos o no) sin utilizar aquellos de ubicación
// RETURN: -
// ESTADO: Funciona
function fx_crear_carga( $cn, $codigo, $kgs_totales, $num_cont, $fecha_ini, $fecha_fin,
$fecha_cadu, $prod, $entidad, $resp ) {
    $codigo = mysqli_real_escape_string( $cn, $codigo );
    $resp = mysqli_real_escape_string( $cn, $resp );

    $sql_suj = "INSERT INTO carga(codigo, ";
    $sql_pre = "VALUES ('$codigo', '";

    if ( $kgs_totales != null ) {
        $sql_suj .= "kgs_totales, ";
        $sql_pre .= $kgs_totales."', '";
    } if ( $num_cont != null ) {
        $sql_suj .= "num_contenedores, ";
        $sql_pre .= $num_cont."', '";
    } if ( $fecha_ini != null ) {
        $sql_suj .= "fecha_inicio, ";
        $sql_pre .= $fecha_ini."', '";
    } if ( $fecha_fin != null ) {
        $sql_suj .= "fecha_final, ";
        $sql_pre .= $fecha_fin."', '";
    } if ( $fecha_cadu != null ) {
        $sql_suj .= "fecha_caducidad, ";
        $sql_pre .= $fecha_cadu."', '";
    } if ( $prod != null ) {
        $sql_suj .= "producto, ";
        $sql_pre .= $prod."', '";
    } if ( $entidad != null ) {
        $sql_suj .= "entidad, ";
        $sql_pre .= $entidad."', '";
    }

    $sql_suj .= "responsable) ";
    $sql_pre .= $resp."');";
    $sql_suj .= $sql_pre;

    mysqli_query( $cn, $sql_suj );
}

// Función que añade las coordenadas de origen y destino junto a un nombre identificativo a una carga ya creada 
// RETURN: -
// ESTADO: Funciona
function fx_anadir_lugares( $cn, $carga, $lat_origen, $long_origen, $nombre_origen, $lat_destino, $long_destino, $nombre_destino ) {
    $carga = mysqli_real_escape_string( $cn, $carga );
    $nombre_origen = mysqli_real_escape_string( $cn, $nombre_origen );
    $nombre_destino = mysqli_real_escape_string( $cn, $nombre_destino );
    
    $sql = "UPDATE carga SET latitud_origen = '$lat_origen', longitud_origen = '$long_origen', latitud_destino = '$lat_destino',
    longitud_destino = '$long_destino', nombre_origen = '$nombre_origen', nombre_destino = '$nombre_destino' WHERE codigo = '$carga'";

    mysqli_query( $cn, $sql );
}

// Función que borra una carga comprobando que el usuario tiene permisos para ello
// RETURN: -
// ESTADO: Funciona
function fx_borrar_carga( $cn, $cod_carga, $email ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $email = mysqli_real_escape_string( $cn, $email );
    
    if ( fx_calcular_privilegios_carga_usuario( $cn, $cod_carga, $email ) == 3 ) {
        $sql = "DELETE FROM carga WHERE codigo = '$cod_carga'";
        mysqli_query( $cn, $sql );
    }
}

// Función que recoge toda la información sobre una carga en base a su código
// RETURN: Array con la información de la carga deseada
// ESTADO: Sin comprobar
function fx_recoger_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "SELECT * FROM carga WHERE codigo = '$cod_carga'";
    $result = mysqli_query( $cn, $sql );
    $array = mysqli_fetch_array( $result );
    return $array;
}

// Función que recoge toda la información sobre una carga en base a su código con lvl de privilegios
// RETURN: Array con la información de la carga deseada
// ESTADO: Funciona
function fx_recoger_carga_con_privilegios( $cn, $cod_carga, $usuario ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $usuario = mysqli_real_escape_string( $cn, $usuario );

    $sql = "SELECT * FROM carga WHERE codigo = '$cod_carga'";
    $result = mysqli_query( $cn, $sql );
    $array = mysqli_fetch_array( $result );
    $array['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $cod_carga, $usuario );
    return $array;
}

// Función que sirve para recoger todas las cargas de una entidad en base a su nombre y contando con el nombre de usuario
// RETURN: Array de arrays con los datos de las cargas de la entidad
// ESTADO: Funciona
function fx_recoger_cargas_entidad_usuario( $cn, $entidad, $usuario ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' 
    UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que sirve para recoger todas las cargas de una entidad en base a su nombre (método para superadmin)
// RETURN: Array de arrays con los datos de las cargas de la entidad
// ESTADO: Funciona
function fx_recoger_cargas_entidad_superadmin( $cn, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' 
    UNION SELECT * FROM carga WHERE codigo IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de una carga de una entidad en base a en las que ha estado
// utilizado un datalogger
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_datalogger( $cn, $cod_datalogger, $usuario ) {
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger );
    $entidad = fx_recoger_entidad( $cn, $usuario );
    
    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND codigo IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND codigo IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND codigo IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de una carga de una entidad en base a en las que ha estado
// utilizado un datalogger (método para superadmin)
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_datalogger_entidad( $cn, $cod_datalogger, $entidad ) {
    $cod_datalogger = mysqli_real_escape_string( $cn, $cod_datalogger );
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND codigo IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND codigo IN (
        SELECT carga FROM enlace WHERE datalogger = '$cod_datalogger'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND codigo IN (
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

// Función que recoge toda la información de unas cargas de una entidad en base a en las que
// ha estado un contenedor
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_contenedor( $cn, $cod_contenedor, $usuario ) {
    $cod_contenedor = mysqli_real_escape_string( $cn, $cod_contenedor );
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND codigo IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND codigo IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND codigo IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de unas cargas de una entidad en base a en las que
// ha estado un contenedor (método para superadmin)
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_contenedor_entidad( $cn, $cod_contenedor, $entidad ) {
    $cod_contenedor = mysqli_real_escape_string( $cn, $cod_contenedor );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND codigo IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND codigo IN (
        SELECT carga FROM enlace WHERE contenedor = '$cod_contenedor'
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND codigo IN (
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

// Función que recoge toda la información de cargas activas entre dos fechas de una entidad
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_activo_fecha( $cn, $fecha_ini, $fecha_fin, $usuario ) {
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND NOT (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND NOT (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND NOT (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de cargas activas entre dos fechas de una entidad (método para superadmin)
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_activo_fecha_entidad( $cn, $fecha_ini, $fecha_fin, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND NOT (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND NOT (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND NOT (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de cargas no activas entre dos fechas de una entidad
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_inactivo_fecha( $cn, $fecha_ini, $fecha_fin, $usuario ) {
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) AND (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de cargas no activas entre dos fechas de una entidad (método para superadmin)
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_inactivo_fecha_entidad( $cn, $fecha_ini, $fecha_fin, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) AND (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    ) UNION SELECT * FROM carga WHERE codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    ) AND (
        ( '$fecha_ini' < fecha_inicio AND '$fecha_fin' <= fecha_inicio ) OR 
        ( '$fecha_ini' >= fecha_final AND '$fecha_fin' > fecha_final )
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de cargas con un origen y destino en coordenadas concretos
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_ubicacion( $cn, $latitud_or, $longitud_or, $latitud_dest, $longitud_dest, $usuario ) {
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql = "SELECT * FROM carga WHERE ";
    if ( $latitud_or != null )  {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND entidad = '$entidad' UNION SELECT * FROM carga WHERE ";
    if ( $latitud_or != null )  {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND codigo IN (
        SELECT carga FROM acceso_informacion WHERE email = '$usuario'
    ) UNION SELECT * FROM carga WHERE ";
    if ( $latitud_or != null )  {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;
}

// Función que recoge toda la información de cargas con un origen y destino en coordenadas concretos (método para superadmin)
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_ubicacion_entidad( $cn, $latitud_or, $longitud_or, $latitud_dest, $longitud_dest, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql = "SELECT * FROM carga WHERE ";
    if ( $latitud_or != null )  {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND entidad = '$entidad' UNION SELECT * FROM carga WHERE ";
    if ( $latitud_or != null )  {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND codigo IN (
        SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
            SELECT email FROM usuario WHERE entidad = '$entidad'
        )
    ) UNION SELECT * FROM carga WHERE ";
    if ( $latitud_or != null )  {
        $sql .= "(latitud_origen > ('$latitud_or' - 0.05) AND latitud_origen < ('$latitud_or' + 0.05) AND 
        longitud_origen > ('$longitud_or' - 0.1) AND longitud_origen < ('$longitud_or' + 0.1) )";
    } if ( $latitud_or != null && $latitud_dest != null ) {
        $sql .= " AND ";
    } if ( $latitud_dest != null ) {
        $sql .= "(latitud_destino > ('$latitud_dest' - 0.05) AND latitud_destino < ('$latitud_dest' + 0.05) AND 
        longitud_destino > ('$longitud_dest' - 0.1) AND longitud_destino < ('$longitud_dest' + 0.1) )";
    }
    $sql .= " AND codigo IN (
        SELECT carga FROM subruta WHERE entidad = '$entidad'
    )";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 1;
        array_push( $array, $fila );
    }
    return $array;
}

// Función que reocge toda la información de cargas con un origen y/o destino concretos
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_ubicacion_texto( $cn, $origen, $destino, $usuario ) {
    $entidad = fx_recoger_entidad( $cn, $usuario );

    $sql1 = "SELECT * FROM carga WHERE entidad = '$entidad'";
    $sql2 = " UNION SELECT * FROM carga WHERE codigo IN (SELECT carga FROM acceso_informacion WHERE email = '$usuario')";
    $sql3 = " UNION SELECT * FROM carga WHERE codigo IN (SELECT carga FROM subruta WHERE entidad = '$entidad')";
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
        $fila['lvl_privilegios'] = fx_calcular_privilegios_carga_usuario( $cn, $fila['codigo'], $usuario );
        array_push( $array, $fila );
    }
    return $array;

}

// Función que recoge toda la información de cargas con un origen y destino concretos (método para superadmin)
// RETURN: Array con la información de todas las cargas buscadas
// ESTADO: Funciona
function fx_recoger_cargas_ubicacion_texto_entidad( $cn, $origen, $destino, $entidad ) {
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    $sql1 = "SELECT * FROM carga WHERE entidad = '$entidad'";
    $sql2 = " UNION SELECT * FROM carga WHERE codigo IN (SELECT DISTINCT carga FROM acceso_informacion WHERE email IN (
        SELECT email FROM usuario WHERE entidad = '$entidad')
    )";
    $sql3 = " UNION SELECT * FROM carga WHERE codigo IN (SELECT carga FROM subruta WHERE entidad = '$entidad')";
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

// Función que recoge todos los dataloggers y su contenedor correspondiente de una carga
// RETURN: Array con los dataloggers y contenedores correspondientes
// ESTADO: Funciona
function fx_recoger_dataloggers_carga( $cn, $carga ) {
    $carga = mysqli_real_escape_string( $cn, $carga );
    $sql = "SELECT * FROM enlace WHERE carga = '$carga'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que calcula y devuelve el nivel de privilegios de un usuario en una carga
// RETURN: 1 -> Solo ver, 2 -> Ver y editar dataloggers, 3 -> Ver, editar y borrar
// ESTADO: Funciona
function fx_calcular_privilegios_carga_usuario( $cn, $carga, $usuario ) {
    $carga = fx_recoger_carga( $cn, mysqli_real_escape_string( $cn, $carga ) );
    $usuario = mysqli_real_escape_string( $cn, $usuario );
    $rol_usu = fx_recoger_rol( $cn, $usuario );
    $resp_carga = fx_recoger_responsable_carga( $cn, $carga['codigo'] );
    $entidad_usu = fx_recoger_entidad( $cn, $usuario );

    if ( fx_comprobar_acceso_carga_usuario( $cn, $carga['codigo'], $usuario) ) {
        $lvl = 2; // ver y editar dataloggers
    } else if ( ($rol_usu == 'Administrador' && $entidad_usu == $carga['entidad'] ) ||
    $resp_carga == $usuario ) {
        $lvl = 3; // ver, editar y borrar
    } else {
        $lvl = 1;
    }
    return $lvl;
}

// Función que recoge el responsable de una carga
// RETURN: Responsable de la carga introducida
// ESTADO: Funciona
function fx_recoger_responsable_carga( $cn, $carga ) {
    $carga = mysqli_real_escape_string( $cn, $carga );

    $sql = "SELECT responsable FROM carga WHERE codigo = '$carga'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    return $msg[0];
}

// Función que comprueba si el usuario tiene acceso a la información de una carga de otra entidad
// RETURN: true si tiene acceso, false si no
// ESTADO: Funciona
function fx_comprobar_acceso_carga_usuario( $cn, $carga, $usuario ) {
    $carga = mysqli_real_escape_string( $cn, $carga );
    $usuario = mysqli_real_escape_string( $cn, $usuario );

    $sql = "SELECT carga FROM acceso_informacion WHERE carga = '$carga' AND email = '$usuario'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );
    if ( $msg[0] != null ) {
        $ret = true;
    } else {
        $ret = false;
    }
    return $ret;
}

// Función que actualiza los datos de una carga en la DB en función de las modificaciones hechas
// RETURN: -
// ESTADO: Funciona
function fx_editar_carga( $cn, $cod_carga, $responsable, $fecha_ini, $fecha_fin, $fecha_cadu,
$num_contenedores, $kgs_totales, $producto ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $responsable = mysqli_real_escape_string( $cn, $responsable );

    $sql = "UPDATE carga SET kgs_totales = ";
    if ( $kgs_totales != null ) {
        $sql .= "$kgs_totales";
    } else {
        $sql .= "NULL";
    } $sql .= ", num_contenedores = ";
    if ( $num_contenedores != null ) {
        $sql .= "$num_contenedores";
    } else {
        $sql .= "NULL";
    } $sql .= ", fecha_inicio = ";
    if ( $fecha_ini != null ) {
        $sql .= "'$fecha_ini'";
    } else {
        $sql .= "NULL";
    } $sql .= ", fecha_final = ";
    if ( $fecha_fin != null ) {
        $sql .= "'$fecha_fin'";
    } else {
        $sql .= "NULL";
    } $sql .= ", fecha_caducidad = ";
    if ( $fecha_cadu != null ) {
        $sql .= "'$fecha_cadu'";
    } else {
        $sql .= "NULL";
    } $sql .= ", producto = ";
    if ( $producto != null ) {
        $sql .= "$producto";
    } else {
        $sql .= "NULL";
    } $sql .= ", responsable = ";
    if ( $responsable != null ) {
        $sql .= "'$responsable'";
    } else {
        $sql .= "NULL";
    } $sql .= " WHERE codigo = '$cod_carga'";
    
    mysqli_query( $cn, $sql );
}

// Función que actualiza los datos de origen y destino de una carga
// RETURN: -
// ESTADO: Funciona
function fx_editar_lugares( $cn, $cod_carga, $lat_origen, $long_origen, $nombre_origen, $lat_destino, $long_destino, $nombre_destino ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $nombre_origen = mysqli_real_escape_string( $cn, $nombre_origen );
    $nombre_destino = mysqli_real_escape_string( $cn, $nombre_destino );

    $sql = "UPDATE carga SET latitud_origen = $lat_origen, longitud_origen = $long_origen, 
    nombre_origen = '$nombre_origen', latitud_destino = $lat_destino, longitud_destino = $long_destino, 
    nombre_destino = '$nombre_destino' WHERE codigo = '$cod_carga'";

    mysqli_query( $cn, $sql );
}

// Función que edita (borra y crea nuevas instancias) de enlaces en una carga
// RETURN: -
// ESTADO: Funciona (aunque el bucle se ejecuta una iteración de más)
function fx_editar_enlaces( $cn, $cod_carga, $lista_dataloggers, $lista_contenedores ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql1 = "DELETE FROM enlace WHERE carga = '$cod_carga'";
    mysqli_query( $cn, $sql1 );
    for ( $i = 0, $cont = count( $lista_dataloggers ); $i < $cont; ++$i ) {
        $dat = mysqli_real_escape_string( $cn, $lista_dataloggers[$i] );
        $cont = mysqli_real_escape_string( $cn, $lista_contenedores[$i] );
        $sql2 = "INSERT INTO enlace (contenedor, carga, datalogger) VALUES ('$cont', '$cod_carga', '$dat')";
        mysqli_query( $cn, $sql2 );
    }
}

// Función que recoge las cargas que cumplen las condiciones para poder crear
// subrutas en ellas para un usuario
// RETURN: Cargas que cumplen los requisitos
// ESTADO: Sin comprobar
function recoger_cargas_disponibles_subruta( $cn, $usuario ) {
    $entidad = fx_recoger_entidad( $cn, mysqli_real_escape_string( $cn, $usuario ) );

    $sql = "SELECT * FROM carga WHERE entidad = '$entidad' AND fecha_inicio > DATE( NOW() ) AND 
    fecha_final > DATE( NOW() ) AND latitud_origen IS NOT NULL AND longitud_origen IS NOT NULL AND 
    latitud_destino IS NOT NULL AND longitud_destino IS NOT NULL";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        $fila['lvl_privilegios'] = 3;
        array_push( $array, $fila );
    }
    return $array;
}

// Función que inserta nuevos vehículos en una carga
// RETURN: -
// ESTADO: Funciona
function fx_insertar_vehiculos_carga( $cn, $cod_carga, $lista_tipos, $lista_matriculas ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    for ( $i = 0, $cont = count( $lista_tipos ); $i < $cont; ++$i ) {
        $mat = mysqli_real_escape_string( $cn, $lista_matriculas[$i] );
        if ( $lista_tipos[$i] != null ) {
            $tipo = mysqli_real_escape_string( $cn, $lista_tipos[$i] );
            $sql = "INSERT INTO vehiculo_carga (matricula, tipo, carga) VALUES ('$mat', '$tipo', '$cod_carga')";
        } else {
            $sql = "INSERT INTO vehiculo_carga (matricula, carga) VALUES ('$mat', '$cod_carga')";
        }
        mysqli_query( $cn, $sql );
    }
}

// Función que recoge todos los vehículos de una carga
// RETURN: Array con los vehículos
// ESTADO: Sin comprobar
function fx_recoger_vehiculos_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "SELECT * FROM vehiculo_carga WHERE carga = '$cod_carga'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array;
}

// Función que edita (borra y crea nuevas instancias) de vehículos en una carga
// RETURN: -
// ESTADO: Sin comprobar
function fx_editar_vehiculos_carga( $cn, $cod_carga, $lista_tipos, $lista_matriculas ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql1 = "DELETE FROM vehiculo_carga WHERE carga = '$cod_carga'";
    mysqli_query( $cn, $sql1 );
    for ( $i = 0, $cont = count( $lista_tipos ); $i < $cont; ++$i ) {
        $mat = mysqli_real_escape_string( $cn, $lista_matriculas[$i] );
        if ( $lista_tipos[$i] != null ) {
            $tipo = mysqli_real_escape_string( $cn, $lista_tipos[$i] );
            $sql2 = "INSERT INTO vehiculo_carga (matricula, tipo, carga) VALUES ('$mat', '$tipo', '$cod_carga')";
        } else {
            $sql2 = "INSERT INTO vehiculo_carga (matricula, carga) VALUES ('$mat', '$cod_carga')";
        }
        mysqli_query( $cn, $sql2 );
    }
}

// Función que comprueba si una carga ha terminado y se ha descargado su histórico en la DB
// RETURN: 0 si no ha terminado/descargado el histórico, 1 en caso afirmativo
// ESTADO: Funciona
function fx_comprobar_carga_terminada( $cn, $cod_carga, $dat ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    
    $sql = "SELECT COUNT(*) FROM registro WHERE datalogger = '$dat' AND fecha <= (SELECT fecha_final FROM carga WHERE codigo = '$cod_carga') AND 
    fecha >= (SELECT fecha_inicio FROM carga WHERE codigo = '$cod_carga')";
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    if ( $fila[0] == 0 ) { // No hay registros
        $msg = 0;
    } else { // Histórico de esa carga existente en la DB
        $msg = 1; 
    }
    return $msg;
}

// Función que recoge la temperatura máxima de una carga a partir de sus alertas o histórico
// (si es a partir de las alertas coge la localización también)
// RETURN: Temperatura máxima alcanzada de la carga
// ESTADO: Sin terminar
function fx_recoger_temperatura_maxima_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $enlaces_carga = fx_recoger_dataloggers_carga( $cn, $cod_carga );
    $dat = $enlaces_carga[0]['datalogger'];
    $terminada = fx_comprobar_carga_terminada( $cn, $cod_carga, $dat );
    if ( $terminada == 0 ) { // No terminada -> Coger temperaturas de alertas
        // Implementar cuando haya alertas
    } else { // Sí terminada -> Coger temperatutas de registro
        $sql = "SELECT max(temperatura) FROM registro WHERE datalogger = '$dat' AND fecha <= (SELECT fecha_final FROM carga WHERE codigo = '$cod_carga') AND 
        fecha >= (SELECT fecha_inicio FROM carga WHERE codigo = '$cod_carga')";
    }
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    return $fila[0];
}

// Función que recoge la temperatura mínima de una carga a partir de sus alertas o histórico
// (si es a partir de las alertas coge la localización también)
// RETURN: Temperatura mínima alcanzada de la carga
// ESTADO: Sin terminar
function fx_recoger_temperatura_minima_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $enlaces_carga = fx_recoger_dataloggers_carga( $cn, $cod_carga );
    $dat = $enlaces_carga[0]['datalogger'];
    $terminada = fx_comprobar_carga_terminada( $cn, $cod_carga, $dat );
    if ( $terminada == 0 ) { // No terminada -> Coger temperaturas de alertas
        // Implementar cuando haya alertas
    } else { // Sí terminada -> Coger temperatutas de registro
        $sql = "SELECT min(temperatura) FROM registro WHERE datalogger = '$dat' AND fecha <= (SELECT fecha_final FROM carga WHERE codigo = '$cod_carga') AND 
        fecha >= (SELECT fecha_inicio FROM carga WHERE codigo = '$cod_carga')";
    }
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    return $fila[0];
}

// Función que recoge la temperatura media de una carga a partir de sus alertas o histórico
// (si es a partir de las alertas coge la localización también)
// RETURN: Temperatura media alcanzada de la carga
// ESTADO: Sin terminar
function fx_recoger_temperatura_media_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $enlaces_carga = fx_recoger_dataloggers_carga( $cn, $cod_carga );
    $dat = $enlaces_carga[0]['datalogger'];
    $terminada = fx_comprobar_carga_terminada( $cn, $cod_carga, $dat );
    if ( $terminada == 0 ) { // No terminada -> Coger temperaturas de alertas
        // Implementar cuando haya alertas
    } else { // Sí terminada -> Coger temperatutas de registro
        $sql = "SELECT avg(temperatura) FROM registro WHERE datalogger = '$dat' AND fecha <= (SELECT fecha_final FROM carga WHERE codigo = '$cod_carga') AND 
        fecha >= (SELECT fecha_inicio FROM carga WHERE codigo = '$cod_carga')";
    }
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    return round($fila[0], 2);
}

// Función que recoge la consigna superior de temperatura de una carga
// RETURN: Consigna superior
// ESTADO: Funciona
function fx_recoger_consigna_superior_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "SELECT t_max FROM producto WHERE codigo = (SELECT producto FROM carga WHERE codigo = '$cod_carga')";
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    return $fila[0];
}

// Función que recoge la consigna inferior de temperatura de una carga
// RETURN: Consigna inferior
// ESTADO: Funciona
function fx_recoger_consigna_inferior_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "SELECT t_min FROM producto WHERE codigo = (SELECT producto FROM carga WHERE codigo = '$cod_carga')";
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    return $fila[0];
}

// Función que recoge el código de un datalogger aleatorio de una carga
// RETURN: Código de una datalogger
// ESTADO: Sin comprobar
function fx_recoger_datalogger_random_carga( $cn, $cod_carga ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );

    $sql = "SELECT datalogger FROM enlace WHERE carga = '$cod_carga'";
    $result = mysqli_query( $cn, $sql );
    $fila = mysqli_fetch_array( $result );
    return $fila[0];
}

// Función que recoge las temperaturas de un datalogger en una carga ordenadas por fecha/hora
// RETURN: Lista con las temperaturas
// ESTADO: Sin comprobar
function fx_recoger_temperaturas_datalogger_carga( $cn, $cod_carga, $dat ) {
    $cod_carga = mysqli_real_escape_string( $cn, $cod_carga );
    $dat = mysqli_real_escape_string( $cn, $dat );

    $sql = "SELECT * FROM registro WHERE datalogger = '$dat' AND fecha <= (SELECT fecha_final FROM carga WHERE codigo = '$cod_carga') AND 
        fecha >= (SELECT fecha_inicio FROM carga WHERE codigo = '$cod_carga') ORDER BY fecha, hora";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila['temperatura'] );
    }
    return $array;
}

?>