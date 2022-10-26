<?php

if ( isset( $_POST ) ) {
    if ( isset( $_POST['sig_btn'] ) ) { // Alta carga
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['codigo'];
        $_SESSION['num_cont_carga'] = $_POST['contenedores'];
        $_SESSION['fecha_ini'] = $_POST['fecha_ini'];
        $_SESSION['fecha_fin'] = $_POST['fecha_fin'];

        
        if ( $_POST['sel_prod'] != null && $_POST['temp_max'] != null && $_POST['temp_min'] != null ) {
            
            list($cod_prod, $tmin_prod, $tmax_prod) = explode("/", $_POST['sel_prod']);
            $producto_elegido = fx_recoger_producto($cn, $cod_prod);
            $cod_producto_el = fx_comparar_producto($cn, $_POST['session'], $producto_elegido['name'],
            $producto_elegido['variety'], $_POST['temp_min'], $_POST['temp_max']);

            if ($cod_producto_el == 0) {
                $cod_producto_el = fx_registrar_producto( $cn, $_POST['session'], $producto_elegido['name'], 
                $producto_elegido['variety'], $_POST['temp_min'], $_POST['temp_max'] );
            }
        } else {
            $cod_producto_el = null;
        }

        $user_id = fx_recoger_usuario_id($cn, $_POST['sel_usu5']);
        if(isset($cod_producto_el)){
            $cod_producto_el = fx_recoger_producto_id($cn, $cod_producto_el);
        }
        fx_crear_carga( $cn, $_POST['codigo'], $_POST['kilos'], $_POST['contenedores'], $_POST['fecha_ini'], $_POST['fecha_fin'],
        $_POST['fecha_cadu'], $cod_producto_el, fx_recoger_entidad( $cn, $_POST['session'] ), $user_id);

        //$msgAltaProducto = "Carga dado de alta correctamente."; 
        include($_SERVER['DOCUMENT_ROOT']."/cargas/alta_mapas.php");
        

    } else if ( isset( $_POST['sig_alta_subruta_prin'] ) ) { // Alta subruta
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['codigo'];
        $_SESSION['num_vehiculos'] = $_POST['num_vehiculos'];

        fx_crear_subruta_incompleta( $cn, $_POST['codigo'], $_POST['fecha_hora_ini'], $_POST['fecha_hora_fin'],
        $_POST['entidad_asignada'], $_POST['sel_car_subr'] );

        $msgSubRuta = "Subruta creada con éxito.";
        include($_SERVER['DOCUMENT_ROOT']."/subrutas/alta_mapas_subr.php");
    } else if ( isset( $_POST['dat_btn'] ) ) { // Alta datalogger
        $_SESSION['ss_usuario'] = $_POST['session_dat'];
        fx_crear_datalogger( $cn, $_POST['cod_dat_adm'], fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );
        $msgDatalogger = "Datalogger creado con éxito.";
        include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");  
    } else if ( isset( $_POST['prod_btn'] ) ) { // Alta producto
        $_SESSION['ss_usuario'] = $_POST['session6'];
        if (empty($_POST['variedad6'])) {
            $msg = fx_registrar_producto($cn, $_POST['session6'], $_POST['nombre6'],
            null, $_POST['t_min6'], $_POST['t_max6'] );
        } else {
            $msg = fx_registrar_producto($cn, $_POST['session6'], $_POST['nombre6'],
            $_POST['variedad6'], $_POST['t_min6'], $_POST['t_max6'] );
        }
        $_POST['nombre6'] = null;
        $msgProducto = "Producto creado correctamente.";
    }else if ( isset( $_POST['alta_dataloggers_btn'] ) ) { 
        $entidad = fx_recoger_datos_entidad( $cn, $_POST['session'] )['id'];
    
        if(isset($_POST['num_cont_carga'])){
            for($i=0;$i<$_POST['num_cont_carga']; $i++){
                if(isset($_POST['dat_'.$i])){
                    $load_id = fx_recoger_carga($cn, $_POST['cod_carga']);
                    echo $load_id;
                    $msg = fx_alta_container_datalogger($cn, $_POST['cont_'.$i], $entidad, $load_id, $_POST['dat_'.$i]);
                }  
            }
        }
        
    }else if ( isset( $_POST['usu_btn'] ) ) { // Alta usuario
        $_SESSION['ss_usuario'] = $_POST['session_usu'];
        $msg = fx_registrar_usuario( $cn, $_POST['nombre4'], $_POST['cargo4'], $_POST['email4'],
        $_POST['rol_usu4'], $_POST['password4'], fx_recoger_entidad( $cn, $_POST['session_usu'] ) );
        $_SESSION['msg'] = $msg;
        $msgUsuario = "Usuario creado correctamente.";
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
        if(isset($_POST['session_datalogger']) && isset($_POST['codigo_datalogger'])){
            $_SESSION['ss_usuario'] = $_POST['session_datalogger'];
            $_SESSION['cod_datalogger'] = $_POST['codigo_datalogger'];

            if(isset($_POST['tipo']) && $_POST['tipo'] == 'dataloger'){
                //include($_SERVER['DOCUMENT_ROOT']."/detalles/detalle_datalogger.php");
            }
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
    }else if(isset($_POST['dat_btn_adm'])){
        if(isset($_POST['session_dat']) && isset($_POST['cod_dat_adm'])){
            $insert = false;
            $_SESSION['ss_usuario'] = $_POST['session_dat'];
            $_SESSION['cod_datalogger'] = $_POST['cod_dat_adm'];
            $entidad = fx_recoger_entidad($cn, $_POST['session_dat']);
            //fx_update_datalogger($cn, $_POST['cod_dat_adm'], $_POST['dat_ex_adm'], $entidad);
            $insert = fx_alta_datalogger($cn, $_POST['cod_dat_adm'], $entidad);
            
            if($insert){
                include($_SERVER['DOCUMENT_ROOT']."/detalles/detalle_datalogger.php");    
            }else{
                echo "Error al introducir los datos.";
            }
        }
    }
}

?>