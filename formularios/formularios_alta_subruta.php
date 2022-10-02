<?php

if (isset( $_POST )) {
    if ( isset( $_POST['mapas_subr_sig'] ) ) { // Alta mapa en alta de subrutas
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];
        $_SESSION['num_vehiculos'] = $_POST['num_vehiculos'];

        if ( !(strlen( $_SERVER["REQUEST_URI"] ) < strlen( substr( $_SERVER["REQUEST_URI"],
        0, strrpos( $_SERVER["REQUEST_URI"], "?" ) ) ) + 25) ) {

            $lat_or = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], "1=(" ) + 3,
            strpos( $_SERVER["REQUEST_URI"], ",%" ) - strpos( $_SERVER["REQUEST_URI"], "1=(" ) - 3 );

            $long_or = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], ",%" ) + 4,
            strpos( $_SERVER["REQUEST_URI"], ")&" ) - strpos( $_SERVER["REQUEST_URI"], ",%" ) - 4 );

            $lat_dest = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], "2=(" ) + 3,
            strrpos( $_SERVER["REQUEST_URI"], ",%" ) - strpos( $_SERVER["REQUEST_URI"], "2=(" ) - 3 );

            $long_dest = substr( $_SERVER["REQUEST_URI"], strrpos( $_SERVER["REQUEST_URI"], ",%" ) + 4,
            strrpos( $_SERVER["REQUEST_URI"], ")" ) - strrpos( $_SERVER["REQUEST_URI"], ",%" ) - 4 );

            fx_anadir_ubicacion_subruta( $cn, $_POST['cod_subruta'], $lat_or, $long_or, $_POST['origen'], $lat_dest, $long_dest, $_POST['destino'] );
        }

        include($_SERVER['DOCUMENT_ROOT']."/subrutas/alta_vehiculos.php");
    } else if ( isset( $_POST['alta_vehiculos_subruta_btn'] ) ) { // Alta vehículos en alta de subrutas
        $_SESSION['ss_usuario'] = $_POST['session'];
        $_SESSION['cod_subruta'] = $_POST['cod_subruta'];
        $_SESSION['num_vehiculos'] = $_POST['num_vehiculos'];
        $_SESSION['alta_subruta'] = "alta";

        $tipos = array();
        $matriculas = array();
        $i = 2;
        foreach ( $_POST as $valor ) {
            if ($valor == null || $valor == $_POST['session']) {
                break;
            } else if ( $i % 2 == 0 ) {
                array_push($tipos, $valor);
            } else {
                array_push($matriculas, $valor);
            }
            ++$i;
        }

        if ( $i % 2 == 0 ) {
            fx_crear_vehiculos_en_subruta($cn, $_POST['cod_subruta'], $tipos, $matriculas);
            include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
        }
    }
}

?>