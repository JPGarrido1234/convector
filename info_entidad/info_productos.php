<?php
require_once($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require_once($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require_once($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
    <?php
    $productos = fx_recoger_productos_entidad_unique( $cn, $_GET['entidad'] );
    echo '<div class="titulo" id="titulo_info_productos_entidad_superadmin">';
    echo '<h2>'.lista_productos_de_M.' '.strtoupper( $_GET['entidad'] ).'</h2>';
    echo '</div>';

    for ( $i = 0, $cant = count( $productos ); $i < $cant; ++$i ) {
        echo '<div class="info_carga">';
        $l = '<pre>'.$productos[$i]['nombre'].'         ';
        if ( $productos[$i]['variedad'] != null ) {
            $l .= variedad.': '.$productos[$i]['variedad'].'         ';
        }
        echo $l.t_minima.': '.$productos[$i]['t_min'].oc.'           '.t_maxima.': '.$productos[$i]['t_max'].oc.'</pre>';
        echo '</div>';
    }
    ?>
</body>
</html>