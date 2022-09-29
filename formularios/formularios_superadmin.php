<?php
if ( isset( $_POST ) ) {
    if ( isset( $_POST['alta_ent_sa_btn'] ) ) { // Alta entidad
        $_SESSION['ss_usuario'] = $_POST['session'];   
        if ( empty( $_POST['direccion2'] ) ) {
            $msg = fx_registrar_entidad( $cn, $_POST['session'], $_POST['nombre_entidad'],
            $_POST['tipo'], $_POST['direccion1'], null, $_POST['poblacion'], $_POST['pais'] );
        } else {
            $msg = fx_registrar_entidad( $cn, $_POST['session'], $_POST['nombre_entidad'],
            $_POST['tipo'], $_POST['direccion1'], $_POST['direccion2'], $_POST['poblacion'],
            $_POST['pais'] );
        }
        $msg2 = fx_registrar_usuario( $cn, $_POST['nombre_admin'], $_POST['cargo1'],
        $_POST['email1'], $_POST['rol1'], $_POST['password1'], $_POST['nombre_entidad'] );
        $msgNotice = "Entidad registrada correctamente.";
        $msg3 = fx_asignar_contacto( $cn, $_POST['session'], $_POST['email1'], $_POST['nombre_entidad'] );
    } else if ( isset( $_POST['alta_admin_sa_btn'] ) ) { // Alta administrador
        $_SESSION['ss_usuario'] = $_POST['session2'];

        $msg = fx_registrar_usuario( $cn, $_POST['nombre_admin2'], $_POST['cargo2'],
        $_POST['email2'], 'Administrador', $_POST['password2'], $_POST['entidad2'] );
        $msgNotice = "Alta administrador registrado correctamente.";
    } else if ( isset( $_POST['inv_btn_push'] ) ) { // Lista de cargas -> Detalle carga
        if(isset($_POST['session_carga'])){
            $_SESSION['ss_usuario'] = $_POST['session_carga'];
        }
        if(isset($_POST['codigo_carga'])){
            $_SESSION['cod_carga'] = $_POST['codigo_carga'];
        }
        if(isset($_POST['lvl_privilegios_carga'])){
            $_SESSION['lvl_privilegios_carga'] = $_POST['lvl_privilegios_carga'];
        }
    } else if ( isset( $_POST['inv_btn_push_dat'] ) ) { // Lista de dataloggers -> Detalle datalogger
        if(isset($_POST['session_datalogger'])){
            $_SESSION['ss_usuario'] = $_POST['session_datalogger'];
        }
        if(isset($_POST['codigo_datalogger'])){
            $_SESSION['cod_datalogger'] = $_POST['codigo_datalogger'];
        }
        if(isset($_POST['entidad_datalogger'])){
            $_SESSION['entidad_dat'] = $_POST['entidad_datalogger'];
        }

        if(isset($_POST['tipo']) && $_POST['tipo'] == 'dataloger'){
            include($_SERVER['DOCUMENT_ROOT']."/detalles/detalle_datalogger.php");
        }
    } else if ( isset( $_POST['inv_btn_subr'] ) ) { // Lista de subrutas -> Detalle subruta
        if(isset($_POST['session_subr'])){
            $_SESSION['ss_usuario'] = $_POST['session_subr'];
        }
        if(isset($_POST['cod_subruta'])){
            $_SESSION['cod_subruta'] = $_POST['cod_subruta'];
        }
        if(isset($_POST['lvl_privilegios_subr'])){
            $_SESSION['lvl_privilegios_subr'] = $_POST['lvl_privilegios_subr'];
        }
    }
}
?>