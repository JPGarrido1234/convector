<?php
if ( isset( $_POST ) ) {
    if ( isset( $_POST['dat_btn_tec'] ) ) { // Alta datalogger
        $_SESSION['ss_usuario'] = $_POST['session_dat_tec'];
        fx_crear_datalogger( $cn, $_POST['cod_dat_tec'], fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );   
        $msgTecnico = "Alta de datalogger correcta.";
    } else if ( isset( $_POST['inv_btn_push'] ) ) { // Lista de cargas -> Detalle carga
        $_SESSION['ss_usuario'] = $_POST['session_carga'];
        $_SESSION['cod_carga'] = $_POST['codigo_carga'];
        $_SESSION['lvl_privilegios_carga'] = $_POST['lvl_privilegios_carga'];
        include($_SERVER['DOCUMENT_ROOT']."/detalles/detalle_carga.php");
    } else if ( isset( $_POST['inv_btn_subr'] ) ) { // Lista de subrutas -> Detalle subruta
        $_SESSION['ss_usuario'] = $_POST['session_subr'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];
        $_SESSION['lvl_privilegios_subr'] = $_POST['lvl_privilegios_subr'];
        include($_SERVER['DOCUMENT_ROOT']."/detalles/detalle_subruta.php");
    }
}
?>