<?php

// Función que registra un nuevo producto de la entidad correspondiente
// RETURN: Código del producto recién registrado
// ESTADO: Funciona
function fx_registrar_producto($cn, $email, $nombre, $variedad, $t_min, $t_max) {
    $email = mysqli_real_escape_string($cn, $email);
    $nombre = mysqli_real_escape_string($cn, $nombre);
    $t_max = mysqli_real_escape_string($cn, $t_max);
    $t_min = mysqli_real_escape_string($cn, $t_min);
    $entidad = mysqli_real_escape_string($cn, fx_recoger_entidad($cn, $email));

    if (!is_null($variedad)){
        $variedad = mysqli_real_escape_string($cn, $variedad);
        $sql = "INSERT INTO product (code, name, variety, min_temp, max_temp, entity_id)
        VALUES ('$nombre', '$nombre', '$variedad', '$t_min', '$t_max', '$entidad')";
    } else {
        $sql = "INSERT INTO product (code, name, min_temp, max_temp, entity_id)
        VALUES ('$nombre', '$nombre', '$t_min', '$t_max', '$entidad')";
    }

    mysqli_query($cn, $sql);
    $query = mysqli_query($cn, "SELECT @@identity AS code");
    if ( $row = mysqli_fetch_row($query) ) {
        $cod = trim( $row[0] );
    }
    return $cod;
}

// Función que recoge el nombre de un producto en función de su código
// RETURN: Nombre del producto deseado
function fx_recoger_nombre_producto($cn, $codigo) {
    $codigo = mysqli_real_escape_string( $cn, $codigo );

    $sql = "SELECT name FROM product WHERE id = '$codigo'";
    $result = mysqli_query($cn, $sql);
    $msg = mysqli_fetch_array($result);

    return $msg[ 0 ];
}

function fx_recoger_producto_id($cn, $codigo){
    $codigo = mysqli_real_escape_string( $cn, $codigo );

    $sql = "SELECT id FROM product WHERE code = '$codigo'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    return $msg[0];
}

// Función que recoge el nombre de un producto en base de la carga
// RETURN: Nombre del producto deseado
// ESTADO: Sin comprobar
function fx_recoger_nombre_producto_carga( $cn, $carga ) {
    $carga = mysqli_real_escape_string( $cn, $carga );

    $sql = "SELECT nombre FROM producto WHERE codigo = 
    (SELECT producto FROM carga WHERE codigo = '$carga')";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );

    return $msg[0];
}

// Función que recoge los datos de un producto
// RETURN: El producto
// ESTADO: Sin comprobar
function fx_recoger_producto($cn, $cod_producto) {
    $cod_producto = mysqli_real_escape_string( $cn, $cod_producto );

    $sql = "SELECT * FROM product WHERE code = '$cod_producto'";
    $result = mysqli_query($cn, $sql);
    $resultf = mysqli_fetch_array($result);
    return $resultf;
}

function fx_recoger_producto_by_id($cn, $cod_producto) {
    //$cod_producto = mysqli_real_escape_string( $cn, $cod_producto );

    $sql = "SELECT * FROM product WHERE id = '$cod_producto'";
    $result = mysqli_query($cn, $sql);
    $resultf = mysqli_fetch_array($result);
    return $resultf;
}

// Función que compara si hay algún registro de un producto ya metido en la BD y devuelve su código
// RETURN: Código del producto existente si existe y 0 si no hay casos
// ESTADO: Funciona
function fx_comparar_producto( $cn, $email, $nombre, $variedad, $t_min, $t_max ) {
    $entidad = fx_recoger_entidad( $cn, mysqli_real_escape_string($cn, $email) );
    $nombre = mysqli_real_escape_string($cn, $nombre);
    $variedad = mysqli_real_escape_string($cn, $variedad);

    if ( $variedad != null ) {
        $sql = "SELECT * FROM product WHERE entity_id = '$entidad' AND name = '$nombre' AND variety = '$variedad'";
    } else {
        $sql = "SELECT * FROM product WHERE entity_id = '$entidad' AND name = '$nombre' AND variety = null";
    }
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        if ( $t_min == $fila['min_temp'] && $t_max == $fila['max_temp'] ) {
            return $fila['code'];
        }
    }
    return 0;
}

?>