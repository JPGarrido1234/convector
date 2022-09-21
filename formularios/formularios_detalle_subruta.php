<?php

if ( isset( $_POST ) ) {
    if ( isset( $_POST['inv_btn_edit'] ) ) { // Detalle subruta -> Editar subruta
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];

        header("Location: editar_subruta.php");
        exit;

    } else if ( isset( $_POST['inv_btn_erase'] ) ) { // Borrar subruta
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];

        fx_borrar_subruta( $cn, $_POST['cod_subruta'], $_POST['session'] );

        $rol = fx_recoger_rol( $cn, $_POST['session'] );
        if ( $rol == 'Administrador' ) {
            header("Location: ../inicio_admin.php");
        } else {
            header("Location: ../inicio_tecnico.php");
        }
        exit;

    } else if ( isset( $_POST['inv_btn_push_dat'] ) ) { // Detalle subruta -> Detalle datalogger
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_datalogger'] = $_POST['cod_datalogger'];

        header("Location: detalle_datalogger.php");
        exit;

    } else if ( isset( $_POST['btn_sig_subr1'] ) ) { // Editar subruta -> Editar mapa
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];

        fx_editar_subruta( $cn, $_POST['cod_subruta'], $_POST['responsable'],
        $_POST['fecha_hora_ini'], $_POST['fecha_hora_fin'] );

        header("Location: editar_subruta_mapas.php");
        exit;

    } else if ( isset( $_POST['btn_sig_subr2'] ) ) { // Editar mapa -> Editar vehículos
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];

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

            fx_editar_lugares_subruta( $cn, $_POST['cod_subruta'], $lat_or, $long_or, $_POST['origen'], $lat_dest, $long_dest, $_POST['destino'] );
        }

        header("Location: editar_subruta_vehiculos.php");
        exit;

    } else if ( isset( $_POST['btn_sig_subr3'] ) ) { // Editar vehículos -> FIN -> Inicio
        session_start();
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];

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
            fx_editar_vehiculos( $cn, $_POST['cod_subruta'], $tipos, $matriculas );
        }

        if ( fx_recoger_rol( $cn, $_POST['session'] ) == 'Administrador' ) {
            header("Location: ../inicio_admin.php");
        } else {
            header("Location: ../inicio_tecnico.php");
        }
        exit;

    }
}

?>