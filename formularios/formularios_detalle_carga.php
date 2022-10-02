<?php
if ( isset( $_POST ) ) {
    if ( isset( $_POST['inv_btn_edit'] ) ) { // Detalle carga -> Editar carga
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];

        if ( $_POST['lvl_privilegios'] == 2 ) { // Ver y editar dataloggers
            include($_SERVER['DOCUMENT_ROOT']."/detalles/editar_carga_dataloggers.php");
        } else { // Ver, editar y borrar
            include($_SERVER['DOCUMENT_ROOT']."/detalles/editar_carga.php");
        }
    } else if ( isset( $_POST['inv_btn_erase'] ) ) { // Detalle carga -> Borrar carga
        if(isset($_POST['session']) && isset($_POST['cod_carga'])){
            $_SESSION['ss_usuario'] = $_POST['session'];
            fx_borrar_carga( $cn, $_POST['cod_carga'], $_POST['session'] );
            $_POST['cod_carga'] = null;
            $rol = fx_recoger_rol( $cn, $_SESSION['ss_usuario'] );
            if ( $rol == 'ROLE_ADMIN' ) {
                include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
    
            } else {
                include($_SERVER['DOCUMENT_ROOT']."/inicio_tecnico.php");
            }
        }
    } else if ( isset( $_POST['inv_btn_subr'] ) ) { // Detalle carga -> Detalle subruta

    } else if ( isset( $_POST['inv_btn_push_dat'] ) ) { // Detalle carga -> Detalle datalogger

        if(isset($_POST['session_datalogger'])){
            $_SESSION['ss_usuario'] = $_POST['session_datalogger'];
        }
        if(isset($_POST['codigo_datalogger'])){
            $_SESSION['cod_datalogger'] = $_POST['codigo_datalogger'];
        }
        if(isset($_POST['tipo']) && $_POST['tipo'] == 'carga'){
            include($_SERVER['DOCUMENT_ROOT']."/detalles/detalle_datalogger.php");
        }

    } else if ( isset( $_POST['btn_sig1'] ) ) { // Editar carga -> Editar mapas
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];
        $carga_antes_de_cambios = fx_recoger_carga( $cn, $_POST['cod_carga'] );

        if ( $_POST['sel_prod'] != null && $_POST['temp_max'] != null && $_POST['temp_min'] != null ) {
            list($cod_prod, $tmin_prod, $tmax_prod) = explode("/", $_POST['sel_prod']);
            $prod_el = fx_recoger_producto( $cn, $cod_prod );
            $cod_prod_el = fx_comparar_producto( $cn, $_POST['session'], $prod_el['nombre'], 
            $prod_el['variedad'], $_POST['temp_min'], $_POST['temp_max'] );

            if ( $cod_prod_el == 0 ) {
                $cod_prod_el = fx_registrar_producto( $cn, $_POST['session'], $prod_el['nombre'], 
                $prod_el['variedad'], $_POST['temp_min'], $_POST['temp_max'] );
            }
        } else {
            $cod_prod_el = null;
        }

        fx_editar_carga( $cn, $_POST['cod_carga'], $_POST['responsable'], $_POST['fecha_ini'], 
        $_POST['fecha_fin'], $_POST['fecha_cadu'], $_POST['num_cont'], $_POST['kgs_totales'], 
        $cod_prod_el );

        if ( $carga_antes_de_cambios['num_contenedores'] > $_POST['num_cont'] ) {
            fx_eliminar_dataloggers_carga_cantidad( $cn, $_POST['cod_carga'], $_POST['num_cont'] );
        }
        if ( $carga_antes_de_cambios['fecha_inicio'] != null && $carga_antes_de_cambios['fecha_final'] != null &&
        ( $carga_antes_de_cambios['fecha_inicio'] !=  $_POST['fecha_ini'] || $carga_antes_de_cambios['fecha_final'] !=  $_POST['fecha_fin'] ) ) {
            fx_eliminar_dataloggers_carga( $cn, $_POST['cod_carga'] );
        }

        include($_SERVER['DOCUMENT_ROOT']."/detalles/editar_carga_mapas.php");

    } else if ( isset( $_POST['btn_sig2'] ) ) { // Editar mapas -> Editar dataloggers o Inicio (si no hay fechas aún)
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];
        $carga = fx_recoger_carga( $cn, $_POST['cod_carga'], $_POST['session'] );

        if ( !(strlen( $_SERVER["REQUEST_URI"] ) < strlen( substr( $_SERVER["REQUEST_URI"],
        0, strrpos( $_SERVER["REQUEST_URI"], "?" ) ) ) + 25) && isset( $_POST['origen'] ) && isset( $_POST['destino'] ) ) {

            $lat_or = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], "1=(" ) + 3,
            strpos( $_SERVER["REQUEST_URI"], ",%" ) - strpos( $_SERVER["REQUEST_URI"], "1=(" ) - 3 );

            $long_or = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], ",%" ) + 4,
            strpos( $_SERVER["REQUEST_URI"], ")&" ) - strpos( $_SERVER["REQUEST_URI"], ",%" ) - 4 );

            $lat_dest = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], "2=(" ) + 3,
            strrpos( $_SERVER["REQUEST_URI"], ",%" ) - strpos( $_SERVER["REQUEST_URI"], "2=(" ) - 3 );

            $long_dest = substr( $_SERVER["REQUEST_URI"], strrpos( $_SERVER["REQUEST_URI"], ",%" ) + 4,
            strrpos( $_SERVER["REQUEST_URI"], ")" ) - strrpos( $_SERVER["REQUEST_URI"], ",%" ) - 4 );

            fx_editar_lugares( $cn, $_POST['cod_carga'], $lat_or, $long_or, $_POST['origen'], $lat_dest, $long_dest, $_POST['destino'] );
        }

        if ( $carga['fecha_inicio'] != null && $carga['fecha_final'] != null ) {
            include($_SERVER['DOCUMENT_ROOT']."/detalles/editar_carga_dataloggers.php");
        } else {
            if ( fx_recoger_rol( $cn, $_POST['session'] ) == 'ROLE_ADMIN' ) {
                include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
            } else {
                include($_SERVER['DOCUMENT_ROOT']."/inicio_tecnico.php");
            }
        }

    } else if ( isset( $_POST['editar_dataloggers_end_btn'] ) ) { // Editar dataloggers -> Editar vehículos
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];
        $carga = fx_recoger_carga_con_privilegios( $cn, $_POST['cod_carga'], $_POST['session'] );

        $conts = array();
        $dats = array();
        $i = 2;

        foreach ( $_POST as $valor ) {
            if ( $valor == null || $valor == $_POST['session'] ) {
                break;
            } else if ( $i % 2 == 0 ) {
                array_push( $dats, $valor );
            } else {
                array_push( $conts, $valor );
            }
            ++$i;
        }
        
        if ( $i % 2 == 0 ) {
            fx_editar_enlaces( $cn, $_POST['cod_carga'], $dats, $conts );
        }
        
        include($_SERVER['DOCUMENT_ROOT']."/detalles/editar_carga_vehiculos.php");

    } else if ( isset( $_POST['btn_sig_subr3'] ) ) { // Editar vehículos -> FIN -> Inicio
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_POST['cod_carga'] = null;

        $tipos = array();
        $matriculas = array();
        $i = 2;
        $valorAnterior = "a";

        foreach ( $_POST as $valor ) {
            if ( $valor == null && $valorAnterior == null ) {
                array_pop( $tipos );
                break;
            } else if ( $i % 2 == 0 ) {
                array_push( $tipos, $valor );
            } else {
                array_push( $matriculas, $valor );
            }
            ++$i;
            $valorAnterior = $valor;
        }

        $incorrecto = false;
        foreach ( $matriculas as $mat ) {
            if ( $mat == null ) {
                $incorrecto = true;
                break;
            }
        }

        if ( !$incorrecto ) {
            fx_editar_vehiculos_carga( $cn, $_POST['cod_carga'], $tipos, $matriculas );
        }

        if ( fx_recoger_rol( $cn, $_POST['session'] ) == 'ROLE_ADMIN' ) {
            //header("Location: ../inicio_admin.php");
        } else {
            //header("Location: ../inicio_tecnico.php");
        }
        //exit;

    }  else if ( isset( $_POST['btn_act_cod_datalogger_carga'] ) ) { // Recargar gráfica
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];

        $array_temperaturas = fx_recoger_temperaturas_datalogger_carga( $cn, $_POST['cod_carga'], $_POST['select_doc_datalogger_carga'] );
        
    }
}

?>