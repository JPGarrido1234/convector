<?php

// Función que comprueba si el login (email + contraseña) es correcto
// RETURN: mensaje de error o el email del usuario si el login es correcto
// ESTADO: Funciona
function fx_login_usuario( $cn, $email, $password ) {
    $email = mysqli_real_escape_string( $cn, $email );
    $password = mysqli_real_escape_string( $cn, $password );

    if ( ( fx_comprobar_email( $cn, $email ) == 1 ) &&
    ( fx_comprobar_password( $cn, $email, $password ) == 1 ) ) {
        $msg = $email;
    } else {
        $msg = "Login incorrecto";
    }
    return $msg;
}

// Función que registra a un usuario en la aplicación
// RETURN: mensaje de error o de éxito en el registro
// ESTADO: Funciona
function fx_registrar_usuario( $cn, $nombre, $cargo, $email, $rol, $password, $entidad ) {
    $nombre = mysqli_real_escape_string( $cn, $nombre );
    $cargo = mysqli_real_escape_string( $cn, $cargo );
    $email = mysqli_real_escape_string( $cn, $email );
    $rol = mysqli_real_escape_string( $cn, $rol );
    $password = md5( mysqli_real_escape_string( $cn, $password ) );
    $entidad = mysqli_real_escape_string( $cn, $entidad );

    if ( fx_comprobar_email( $cn, $email ) == 1 ) {
        $msg = "Ya existe un usuario con el mismo email en la aplicación";
    } else {
        $sql = "INSERT INTO usuario (nombre, cargo, email, rol, password, entidad)
        VALUES ('$nombre', '$cargo', '$email', '$rol', '$password', '$entidad')";
        mysqli_query( $cn, $sql );
        $msg = "Usuario registrado";
    }
    return $msg;
}

// Función que cambia la contraseña actual de un usuario por una nueva
// RETURN: Mensaje de error o de éxito en el cambio
// ESTADO: Sin comprobar
function fx_cambiar_password( $cn, $email, $password_actual, $password_nueva ) {
    $email = mysqli_real_escape_string( $cn, $email );
    $password_actual = md5( mysqli_real_escape_string( $cn, $password_actual ) );
    $password_nueva = md5( mysqli_real_escape_string( $cn, $password_nueva ) );

    if ( ( fx_comprobar_email( $cn, $email ) == 1 ) &&
    ( fx_comprobar_password( $cn, $email, $password_actual ) == 1 ) ) {
        $sql = "UPDATE usuario SET 'password' = \''.$password_nueva.'\' WHERE 'email' = \''.$email.'\';";
        mysqli_query( $cn, $sql );
        $msg = "Contraseña cambiada";
    } else {
        $msg = "Datos incorrectos";
    }
    return $msg;
}

// Función que sirve para recoger el rol de un usuario
// RETURN: Rol del usuario o mensaje de error si no existe ese usuario
// ESTADO: Funciona (el 'else' no está comprobado)
function fx_recoger_rol( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );

    if ( fx_comprobar_email( $cn, $email ) == 1 ) {
        $sql = "SELECT rol FROM usuario WHERE email = '$email'";
        $result = mysqli_query( $cn, $sql );
        $msg = mysqli_fetch_array( $result );
    } else {
        $msg[ 0 ] = "Usuario no existente";
    }
    return $msg[ 0 ];
}

// Función que sirve para recoger el nombre de un usuario
// RETURN: Nombre del usuario o mensaje de error si no existe ese usuario
// ESTADO: Funciona (el 'else' no está comprobado)
function fx_recoger_nombre( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );

    if ( fx_comprobar_email( $cn, $email ) == 1 ) {
        $sql = "SELECT nombre FROM usuario WHERE email = '$email'";
        $result = mysqli_query( $cn, $sql );
        $msg = mysqli_fetch_array( $result );
    } else {
        $msg[ 0 ] = "Usuario no existente";
    }
    return $msg[ 0 ];
}

// Función que sirve para recoger la entidad a la que pertenece un usuario
// RETURN: Entidad del usuario o mensaje de error si no existe ese usuario
// ESTADO: Funciona
function fx_recoger_entidad( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );

    $sql = "SELECT entidad FROM usuario WHERE email = '$email'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );
    
    return $msg[ 0 ];
}

// Función que comprueba si un usuario existe en la aplicación o no
// RETURN: 1 si el email existe o 0 si no existe
// ESTADO: Funciona
function fx_comprobar_email( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $exists = mysqli_num_rows( mysqli_query( $cn, $sql ) );

    if ( $exists > 0 ) {
        $msg = 1;
    } else {
        $msg = 0;
    }
    return $msg;
}

// Función que comprueba si la contraseña introducida es correcta o no
// RETURN: 1 si la contraseña es correcta o 0 si no lo es
// ESTADO: Funciona
function fx_comprobar_password( $cn, $email, $password ) {
    $email = mysqli_real_escape_string( $cn, $email );
    $password = md5( mysqli_real_escape_string( $cn, $password ) );

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $result = mysqli_fetch_array( mysqli_query( $cn, $sql ) );

    if ( $result['password'] == $password ) {
        $msg = 1;
    } else {
        $msg = 0;
    }
    return $msg;
}

// Función que recoge las cargas de las cuales el usuario es responsable
// RETURN: Array de arrays con los datos de cada carga
// ESTADO: Funciona
function fx_recoger_cargas_responsable( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );

    $sql = "SELECT * FROM carga WHERE responsable = '$email'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array; 
}

// Función que recoge las subrutas de las cuales el usuario es responsable
// RETURN: Array de arrays con los datos de las subrutas
// ESTADO: Sin comprobar
function fx_recoger_subrutas_responsable( $cn, $email ) {
    $email = mysqli_real_escape_string( $cn, $email );

    $sql = "SELECT * FROM subruta WHERE responsable = '$email'";
    $array = array();
    $result = mysqli_query( $cn, $sql );
    while ( $fila = mysqli_fetch_array( $result ) ) {
        array_push( $array, $fila );
    }
    return $array; 
}

// Función que reocge el email del superadministrador de la aplicación
// RETURN: Email del superadministrador
// ESTADO: Sin comprobar
function fx_recoger_email_superadmin( $cn ) {
    $sql = "SELECT email FROM usuario WHERE rol = 'Superadministrador'";
    $result = mysqli_query( $cn, $sql );
    $msg = mysqli_fetch_array( $result );
    return $msg[0];
}

?>