<?php
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_superadmin.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_carga.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_datalogger.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_subruta.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_admin.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_alta_carga.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_alta_subruta.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_tecnico.php");
require($_SERVER['DOCUMENT_ROOT']."/general/sesion.php");

$superadmin = false;
$admin = false;
$tecnico = false;
$msgLogin = '';

if ( isset( $_POST['inv_btn_volver'] ) ) { // Volver
    $_SESSION['ss_usuario'] = $_POST['session'];
    $rol = fx_recoger_rol( $cn, $_POST['session'] );
    $_POST['volver'] = 'ok';

    if ( $rol == 'ROLE_ADMIN' ) {
        include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
    } else if ( $rol == 'ROLE_TECHNICIAN' ) {
        include($_SERVER['DOCUMENT_ROOT']."/inicio_tecnico.php");
    } else {
        include($_SERVER['DOCUMENT_ROOT']."/inicio_superadmin.php");
    }

}else{
    if (isset($_POST['enviado'])) {
        if ($_POST['enviado'] == 'enviado') {
            $msg = fx_login_usuario( $cn, $_POST['email'], $_POST['password'] );
            if ( $msg == $_POST['email'] ) { 
                // Guardar usuario en variable de sesión
                $_SESSION['ss_usuario'] = $_POST['email'];
                $_SESSION['enviado'] = $_POST['enviado'];
                $rol = fx_recoger_rol( $cn, $_POST['email'] );
    
                if ( $rol == 'ROLE_TECHNICIAN' ) {
                    $tecnico = true;
                    include($_SERVER['DOCUMENT_ROOT']."/inicio_tecnico.php");
                } elseif ( $rol == 'ROLE_ADMIN' ) {
                    $admin = true;
                    include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
                } elseif ( $rol == 'ROLE_SUPER_ADMIN' ) {
                    $superadmin = true;
                    include($_SERVER['DOCUMENT_ROOT']."/inicio_superadmin.php");
                }
            }else{
                $msgLogin = "Error al introducir los datos. Usuario o contraseñas incorrectos.";
            }
        }
    }
    
    if(isset($_SESSION['ss_usuario'])){
        $rol = fx_recoger_rol( $cn, $_SESSION['ss_usuario'] );
        if ( $rol == 'ROLE_TECHNICIAN' ) {
            if(!$tecnico){
                if(!isset($_POST['volver'])){
                    include($_SERVER['DOCUMENT_ROOT']."/inicio_tecnico.php");
                }
            }
        } elseif ( $rol == 'ROLE_ADMIN' ) {
            if(!$admin){
                if(!isset($_POST['volver']) && !isset($_SESSION['alta_subruta']) && !isset($_SESSION['cod_datalogger']) && isset($_SESSION['cod_carga'])){
                    include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
                }
            }
        } elseif ( $rol == 'ROLE_SUPER_ADMIN' ) {
            if(!$superadmin){
                if(!isset($_POST['volver'])){
                    include($_SERVER['DOCUMENT_ROOT']."/inicio_superadmin.php");
                }
            }
        }
    }
}
