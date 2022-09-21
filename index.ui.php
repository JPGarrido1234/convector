<?php
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/c_usuario.php");

if ( isset( $_POST['enviado'] ) ) {
    if ( $_POST['enviado'] == 'enviado' ) {
        $msg = fx_login_usuario( $cn, $_POST['email'], $_POST['password'] );

        if ( $msg == $_POST['email'] ) { // Login correcto
            // Guardar usuario en variable de sesión
            session_start();
            $_SESSION['ss_usuario'] = $_POST['email'];

            // Redireccionar en función del rol
            $rol = fx_recoger_rol( $cn, $_POST['email'] );

            if ( $rol == 'Técnico' ) {
                header("Location: /inicio_tecnico.php");
                header('HTTP/1.1 200 OK');
                //exit;
            } elseif ( $rol == 'Administrador' ) {
                header("Location: /inicio_admin.php");
                header('HTTP/1.1 200 OK');
                //exit;
            } elseif ( $rol == 'Superadministrador' ) {
                header("Location: ".$url_localhost."/inicio_superadmin.php");
                header('HTTP/1.1 200 OK');
                //exit;
            }
        }
    }
}