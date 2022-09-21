<?php

if ( isset( $_POST ) ) {
    if ( isset( $_POST['inv_btn_push'] ) ) { // Detalle datalogger -> Detalle carga
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session_carga'];
        $_SESSION['cod_carga'] = $_POST['codigo_carga'];
        $_SESSION['lvl_privilegios'] = $_POST['lvl_privilegios'];

        header("Location: detalle_carga.php");
        exit;
    } else if ( isset( $_POST['inv_btn_baja'] ) ) { // Detalle datalogger -> DAR DE BAJA
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_datalogger'] = $_POST['cod_datalogger'];

        fx_baja_datalogger( $cn, $_POST['cod_datalogger'], true );

    } else if ( isset( $_POST['inv_btn_alta'] ) ) { // Detalle datalogger -> DAR DE ALTA
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_datalogger'] = $_POST['cod_datalogger'];

        fx_baja_datalogger( $cn, $_POST['cod_datalogger'], false );
    }
}

?>