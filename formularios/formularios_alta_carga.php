<?php
if ( isset( $_POST ) ) {
    if ( isset( $_POST['enviado_log'] ) ) { // Alta dataloggers en alta de carga
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];
    
        $conts = array();
        $dats = array();
        $i = 2;
        foreach ( $_POST as $valor ) {
            if ( $valor == null || $valor == 'enviado_log' ) {
                break;
            } else if ( $i % 2 == 0 ) {
                array_push( $dats, $valor );
            } else {
                array_push( $conts, $valor );
            }
            ++$i;
        }
    
        if ( $i % 2 == 0 ) { // Se ha metido bien los pares datalogger-contenedor
            //fx_crear_enlace( $cn, $_POST['cod_carga'], $dats, $conts );
        }
    
        include($_SERVER['DOCUMENT_ROOT']."/cargas/alta_vehiculos.php");
    } else if ( isset( $_POST['mapas_sig'] ) ) { // Alta mapa en alta de carga
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];
        $_SESSION['num_cont_carga'] = $_POST['num_cont_carga'];

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

            fx_anadir_lugares( $cn, $_POST['cod_carga'], $lat_or, $long_or, $_POST['origen'], $lat_dest, $long_dest, $_POST['destino'] );
        }

        if ( $_POST['fecha_ini'] != null && $_POST['fecha_fin'] != null ) {
            include($_SERVER['DOCUMENT_ROOT']."/cargas/alta_dataloggers.php");
        } else {
            include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
        }

    } else if ( isset( $_POST['alta_vehiculos_carga_btn'] ) ) { // Alta vehículos en alta de carga
        $_SESSION['ss_usuario'] = $_POST['session'];
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
            fx_insertar_vehiculos_carga( $cn, $_POST['cod_carga'], $tipos, $matriculas );
        }

        $_POST['cod_carga'] = null;
    }
}

?>