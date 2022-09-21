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
    if ( isset( $_GET['dat'] ) ) {
        $cargas = fx_recoger_cargas_datalogger( $cn, $_GET['dat'], $_GET['usu'] );
    } else if ( isset( $_GET['cont'] ) ) {
        $cargas = fx_recoger_cargas_contenedor( $cn, $_GET['cont'], $_GET['usu'] );
    } else if ( isset( $_GET['fec1'] ) ) {
        $cargas = fx_recoger_cargas_activo_fecha( $cn, $_GET['fec1'], $_GET['fec2'], $_GET['usu'] );
    } else if ( isset( $_GET['fec3'] ) ) {
        $cargas = fx_recoger_cargas_inactivo_fecha( $cn, $_GET['fec3'], $_GET['fec4'], $_GET['usu'] );
    } else if ( isset( $_GET['lat_or'] ) || isset( $_GET['lat_dest'] ) ) {
        $cargas = fx_recoger_cargas_ubicacion( $cn, $_GET['lat_or'], $_GET['long_or'], $_GET['lat_dest'], $_GET['long_dest'], $_GET['usu'] );
    } else if ( isset( $_GET['or'] ) || isset( $_GET['dest'] ) ) {
        $cargas = fx_recoger_cargas_ubicacion_texto( $cn, $_GET['or'], $_GET['dest'], $_GET['usu'] );
    } else if ( isset( $_GET['dat_sa'] ) ) {
        $cargas = fx_recoger_cargas_datalogger_entidad( $cn, $_GET['dat_sa'], $_GET['ent'] );
    } else if ( isset( $_GET['cont_sa'] ) ) {
        $cargas = fx_recoger_cargas_contenedor_entidad( $cn, $_GET['cont_sa'], $_GET['ent'] );
    } else if ( isset( $_GET['fec1_sa'] ) ) {
        $cargas = fx_recoger_cargas_activo_fecha_entidad( $cn, $_GET['fec1_sa'], $_GET['fec2_sa'], $_GET['ent'] );
    } else if ( isset( $_GET['fec3_sa'] ) ) {
        $cargas = fx_recoger_cargas_inactivo_fecha_entidad( $cn, $_GET['fec3_sa'], $_GET['fec4_sa'], $_GET['ent'] );
    } else if ( isset( $_GET['lat_or_sa'] ) || isset( $_GET['lat_dest_sa'] ) ) {
        $cargas = fx_recoger_cargas_ubicacion_entidad( $cn, $_GET['lat_or_sa'], $_GET['long_or_sa'], $_GET['lat_dest_sa'], $_GET['long_dest_sa'], $_GET['ent'] );
    } else if ( isset( $_GET['or_sa'] ) || isset( $_GET['dest_sa'] ) ) {
        $cargas = fx_recoger_cargas_ubicacion_texto_entidad( $cn, $_GET['or_sa'], $_GET['dest_sa'], $_GET['ent'] );
    } else if ( isset( $_GET['ent'] ) ) {
        $cargas = fx_recoger_cargas_entidad_superadmin( $cn, $_GET['ent'] );
    } else {
        $cargas = fx_recoger_cargas_entidad_usuario( $cn, fx_recoger_entidad( $cn, $_GET['usu'] ), $_GET['usu'] );
    }
    if ( count( $cargas ) != 0 ) {
        for ( $i = 0, $cant = count( $cargas ); $i < $cant; ++$i ) {
            echo '<div class="info_carga con_btn_inv" id="car_com_'.$cargas[ $i ][ 'codigo' ].'"'.
            ' onmouseenter="cambiarColorPrivi(\'info_ca_com1_'.$cargas[ $i ][ 'codigo' ].'\', \''.$cargas[$i]['lvl_privilegios'].'\')"'.
            ' onmouseover="mostrarDetalles(\'info_ca_com1_'.$cargas[ $i ][ 'codigo' ].'\')"'.
            ' onmouseout="esconderDetalles(\'info_ca_com1_'.$cargas[ $i ][ 'codigo' ].'\')">';
            if ( $cargas[$i]['producto'] != null ) {
                echo '<a id="ca_'.$cargas[ $i ][ 'codigo' ].'" href="#">'.carga.' '.$cargas[ $i ][ 'codigo' ].
                ' - '.producto.': '.fx_recoger_nombre_producto( $cn, $cargas[ $i ][ 'producto' ] ).' - '.responsable.': '.
                fx_recoger_nombre( $cn, $cargas[ $i ][ 'responsable' ] ).'</a>';
            } else {
                echo '<a id="ca_'.$cargas[ $i ][ 'codigo' ].'" href="#">'.carga.' '.$cargas[ $i ][ 'codigo' ].
                ' - '.responsable.': '.fx_recoger_nombre( $cn, $cargas[ $i ][ 'responsable' ] ).'</a>';
            }
            echo '<form class="formulario" id="form_lista_cargas_admin_'.$cargas[ $i ][ 'codigo' ].'" method='.'"POST" action="">';
                if ( isset( $_GET['usu'] ) ) {
                    echo '<input type="hidden" name="session_carga" value="'.$_GET['usu'].'">';
                } else if ( isset( $_GET['ent'] ) ) {
                    echo '<input type="hidden" name="session_carga" value="'.fx_recoger_email_superadmin( $cn ).'">';
                }
                echo '<input type="hidden" name="codigo_carga" value="'.$cargas[$i]['codigo'].'">';
                echo '<input type="hidden" name="lvl_privilegios_carga" value="'.$cargas[$i]['lvl_privilegios'].'">';
                echo '<input class="btn_inv" name="inv_btn_push" type="submit">';
            echo '</form>';
            echo '</div>';
            echo '<div class="info_c" id="info_ca_com1_'.$cargas[ $i ][ 'codigo' ].'">';
            $pre = '<pre>'.fecha_inicio.': ';
            if ( $cargas[ $i ][ 'fecha_inicio' ] != null ) {
                $pre .= $cargas[ $i ][ 'fecha_inicio' ].'        '.fecha_final.': ';
            } else {
                $pre .= sin_establecer_m.'        '.fecha_final.': ';
            } if ( $cargas[ $i ][ 'fecha_final' ] != null ) {
                $pre .= $cargas[ $i ][ 'fecha_final' ].'        '.fecha_caducidad.': ';
            } else {
                $pre .= sin_establecer_m.'        '.fecha_caducidad.': ';
            } if ( $cargas[ $i ][ 'fecha_caducidad' ] != null ) {
                $pre .= $cargas[ $i ][ 'fecha_caducidad' ].'</pre>';
            } else {
                $pre .= sin_establecer_m.'</pre>';
            }
            echo $pre;
            echo '</div>';
        }
        echo '<div class="permisos">
            <pre class="permisos_titulo">'.permisos.': </pre>
            <div>
                <img src="../images/cuadrado_azul.png" alt="'.azul.'">
                <pre>'.ver.'</pre>
            </div>
            <div>
                <img src="../images/cuadrado_verde.png" alt="'.verde.'">
                <pre>'.ver_editar_dataloggers.'</pre>
            </div>
            <div>
                <img src="../images/cuadrado_rojo.png" alt="'.rojo.'">
                <pre>'.ver_editar_borrar.'</pre>
            </div>
        </div>';
    } else {
        echo ' ';
    }
    ?>
</body>
</html>