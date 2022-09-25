<?php
if ( isset( $_POST ) ) {
    if ( isset( $_POST['term_subrutas_btn'] ) ) {
        //session_start();
        $_SESSION['ss_usuario'] = $_POST['session1'];
        
        //header("Location: ../inicio_admin.php");
        include($_SERVER['DOCUMENT_ROOT']."/inicio_admin.php");
        //exit;
    } else if ( isset( $_POST['sig_subruta_btn'] ) ) {
        //session_start();
        $_SESSION['ss_usuario'] = $_POST['session2'];
        $_SESSION['cod_carga'] = $_POST['cod_carga'];

        if ( strlen( $_SERVER["REQUEST_URI"] ) > strlen( substr( $_SERVER["REQUEST_URI"],
        0, strrpos( $_SERVER["REQUEST_URI"], "?" ) ) ) + 50 ) {

            $lat_or = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], "1=(" ) + 3,
            strpos( $_SERVER["REQUEST_URI"], ",%" ) - strpos( $_SERVER["REQUEST_URI"], "1=(" ) - 3 );

            $long_or = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], ",%" ) + 4,
            strpos( $_SERVER["REQUEST_URI"], ")&" ) - strpos( $_SERVER["REQUEST_URI"], ",%" ) - 4 );

            $lat_dest = substr( $_SERVER["REQUEST_URI"], strpos( $_SERVER["REQUEST_URI"], "2=(" ) + 3,
            strrpos( $_SERVER["REQUEST_URI"], ",%" ) - strpos( $_SERVER["REQUEST_URI"], "2=(" ) - 3 );

            $long_dest = substr( $_SERVER["REQUEST_URI"], strrpos( $_SERVER["REQUEST_URI"], ",%" ) + 4,
            strrpos( $_SERVER["REQUEST_URI"], ")" ) - strrpos( $_SERVER["REQUEST_URI"], ",%" ) - 4 );
        } else {
            $lat_or = null;
            $long_or = null;
            $lat_dest = null;
            $long_dest = null;
        }

        fx_crear_subruta_completa( $cn, $_POST['codigo'], $_POST['fecha_hora_ini'], $_POST['fecha_hora_fin'],
        $lat_or, $long_or, $lat_dest, $long_dest, $_POST['entidad'], $_POST['cod_carga'] );

        //header("Location: alta_subrutas.php");
        include($_SERVER['DOCUMENT_ROOT']."/limbo/alta_subrutas.php");
       //exit;
    }
}

?>