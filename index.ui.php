<?php
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_superadmin.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_carga.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_datalogger.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_subruta.php");

if (isset($_POST['enviado'])) {
    if ($_POST['enviado'] == 'enviado') {
        $msg = fx_login_usuario( $cn, $_POST['email'], $_POST['password'] );
        if ( $msg == $_POST['email'] ) { // Login correcto
            // Guardar usuario en variable de sesión
            $_SESSION['ss_usuario'] = $_POST['email'];
            $_SESSION['enviado'] = $_POST['enviado'];

            // Redireccionar en función del rol
            $rol = fx_recoger_rol( $cn, $_POST['email'] );

            if ( $rol == 'Técnico' ) {
                //header("Location: /inicio_tecnico.php");
                //exit;
            } elseif ( $rol == 'Administrador' ) {
                //header("Location: /inicio_admin.php");
                //include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
                //exit;
            } elseif ( $rol == 'Superadministrador' ) {
                //header("Location: ".$url_localhost."/inicio_superadmin.php");
                include($_SERVER['DOCUMENT_ROOT']."/inicio_superadmin.php");
                //exit;
            }
        }
    }
}