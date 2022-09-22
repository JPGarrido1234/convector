<?php

if ( isset( $_POST ) ) {
    if ( isset( $_POST['sig_btn'] ) ) { // Alta carga
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['codigo'];
        $_SESSION['num_cont_carga'] = $_POST['contenedores'];
        $_SESSION['fecha_ini'] = $_POST['fecha_ini'];
        $_SESSION['fecha_fin'] = $_POST['fecha_fin'];

        if ( $_POST['sel_prod'] != null && $_POST['temp_max'] != null && $_POST['temp_min'] != null ) {
            list($cod_prod, $tmin_prod, $tmax_prod) = explode("/", $_POST['sel_prod']);
            $producto_elegido = fx_recoger_producto( $cn, $cod_prod );

            $cod_producto_el = fx_comparar_producto( $cn, $_POST['session'], $producto_elegido['nombre'],
            $producto_elegido['variedad'], $_POST['temp_min'], $_POST['temp_max'] );

            if ( $cod_producto_el == 0 ) {
                $cod_producto_el = fx_registrar_producto( $cn, $_POST['session'], $producto_elegido['nombre'], 
                $producto_elegido['variedad'], $_POST['temp_min'], $_POST['temp_max'] );
            }
        } else {
            $cod_producto_el = null;
        }

        fx_crear_carga( $cn, $_POST['codigo'], $_POST['kilos'], $_POST['contenedores'], $_POST['fecha_ini'], $_POST['fecha_fin'],
        $_POST['fecha_cadu'], $cod_producto_el, fx_recoger_entidad( $cn, $_POST['session'] ), $_POST['sel_usu5'] );

        header("Location: cargas/alta_mapas.php");
        exit;

    } else if ( isset( $_POST['sig_alta_subruta_prin'] ) ) { // Alta subruta
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['codigo'];
        $_SESSION['num_vehiculos'] = $_POST['num_vehiculos'];

        fx_crear_subruta_incompleta( $cn, $_POST['codigo'], $_POST['fecha_hora_ini'], $_POST['fecha_hora_fin'],
        $_POST['entidad_asignada'], $_POST['sel_car_subr'] );

        header("Location: subrutas/alta_mapas_subr.php");
        exit;
    } else if ( isset( $_POST['dat_btn'] ) ) { // Alta datalogger
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session_dat'];

        fx_crear_datalogger( $cn, $_POST['cod_dat_adm'], fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );
    
    } else if ( isset( $_POST['prod_btn'] ) ) { // Alta producto
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session6'];

        if ( empty( $_POST['variedad6'] ) ) {
            $msg = fx_registrar_producto($cn, $_POST['session6'], $_POST['nombre6'],
            null, $_POST['t_min6'], $_POST['t_max6'] );
        } else {
            $msg = fx_registrar_producto($cn, $_POST['session6'], $_POST['nombre6'],
            $_POST['variedad6'], $_POST['t_min6'], $_POST['t_max6'] );
        }

    } else if ( isset( $_POST['usu_btn'] ) ) { // Alta usuario
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session_usu'];

        $msg = fx_registrar_usuario( $cn, $_POST['nombre4'], $_POST['cargo4'], $_POST['email4'],
        $_POST['rol_usu4'], $_POST['password4'], fx_recoger_entidad( $cn, $_POST['session_usu'] ) );

        $_SESSION['msg'] = $msg;
    
    } else if ( isset( $_POST['inv_btn_push'] ) ) { // Lista de cargas -> Detalle carga
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session_carga'];
        $_SESSION['cod_carga'] = $_POST['codigo_carga'];
        $_SESSION['lvl_privilegios_carga'] = $_POST['lvl_privilegios_carga'];

        header("Location: detalles/detalle_carga.php");
        exit;
    } else if ( isset( $_POST['inv_btn_push_dat'] ) ) { // Lista de dataloggers -> Detalle datalogger
        //session_start();
        $_SESSION['ss_usuario'] = $_POST['session_datalogger'];
        $_SESSION['cod_datalogger'] = $_POST['codigo_datalogger'];

        
        //header("Location: detalles/detalle_datalogger.php");
        
        //exit;
    } else if ( isset( $_POST['inv_btn_subr'] ) ) { // Lista de subrutas -> Detalle subruta
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session_subr'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];
        $_SESSION['lvl_privilegios_subr'] = $_POST['lvl_privilegios_subr'];

        header("Location: detalles/detalle_subruta.php");
        exit;
    }
}

?>