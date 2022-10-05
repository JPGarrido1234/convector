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
        $subrutas = fx_recoger_subrutas_datalogger( $cn, $_GET['usu'], $_GET['dat'] );
    } else if ( isset( $_GET['cont'] ) ) {
        $subrutas = fx_recoger_subrutas_contenedor( $cn, $_GET['usu'], $_GET['cont'] );
    } else if ( isset( $_GET['fec1'] ) ) {
        $subrutas = fx_recoger_subrutas_activo_fecha( $cn, $_GET['usu'], $_GET['fec1'], $_GET['fec2'] );
    } else if ( isset( $_GET['fec3'] ) ) {
        $subrutas = fx_recoger_subrutas_inactivo_fecha( $cn, $_GET['usu'], $_GET['fec3'], $_GET['fec4'] );
    } else if ( isset( $_GET['lat_or'] ) || isset( $_GET['lat_dest'] ) ) {
        $subrutas = fx_recoger_subrutas_ubicacion( $cn, $_GET['usu'], $_GET['lat_or'], $_GET['long_or'], $_GET['lat_dest'], $_GET['long_dest'] );
    } else if ( isset( $_GET['or'] ) || isset( $_GET['dest'] ) ) {
        $subrutas = fx_recoger_subrutas_ubicacion_texto( $cn, $_GET['usu'], $_GET['or'], $_GET['dest'] );
    } else if ( isset( $_GET['dat_sa'] ) ) {
        $subrutas = fx_recoger_subrutas_sa_datalogger( $cn, $_GET['ent'], $_GET['dat_sa'] );
    } else if ( isset( $_GET['cont_sa'] ) ) {
        $subrutas = fx_recoger_subrutas_sa_contenedor( $cn, $_GET['ent'], $_GET['cont_sa'] );
    } else if ( isset( $_GET['fec1_sa'] ) ) {
        $subrutas = fx_recoger_subrutas_sa_activo_fecha( $cn, $_GET['ent'], $_GET['fec1_sa'], $_GET['fec2_sa'] );
    } else if ( isset( $_GET['fec3_sa'] ) ) {
        $subrutas = fx_recoger_subrutas_sa_inactivo_fecha( $cn, $_GET['ent'], $_GET['fec3_sa'], $_GET['fec4_sa'] );
    } else if ( isset( $_GET['lat_or_sa'] ) || isset( $_GET['lat_dest_sa'] ) ) {
        $subrutas = fx_recoger_subrutas_sa_ubicacion( $cn, $_GET['ent'], $_GET['lat_or_sa'], $_GET['long_or_sa'], $_GET['lat_dest_sa'], $_GET['long_dest_sa'] );
    } else if ( isset( $_GET['or_sa'] ) || isset( $_GET['dest_sa'] ) ) {
        $subrutas = fx_recoger_subrutas_sa_ubicacion_texto( $cn, $_GET['ent'], $_GET['or_sa'], $_GET['dest_sa'] );
    } else if ( isset( $_GET['ent'] ) ) {
        $subrutas = fx_recoger_subrutas_sa( $cn, $_GET['ent'] );
    } else {
        $subrutas = fx_recoger_subrutas_usuario( $cn, $_GET['usu'] );
    }
    if (count($subrutas) != 0) {
        for ($i = 0, $cant = count($subrutas); $i < $cant; ++$i) {
            echo '<div class="info_carga con_btn_inv" id="subr_com_'.$subrutas[$i]['code'].'"'.
            ' onmouseenter="cambiarColorPrivi(\'info_subr_com1_'.$subrutas[$i]['code'].'\', \''.$subrutas[$i]['lvl_privilegios'].'\')"'.
            ' onmouseover="mostrarDetalles(\'info_subr_com1_'.$subrutas[$i]['code'].'\')"'.
            ' onmouseout="esconderDetalles(\'info_subr_com1_'.$subrutas[$i]['code'].'\')">';
                echo '<a id="subr_'.$subrutas[$i]['code'].'" href="#">'.subruta.' '.$subrutas[$i]['code'].
                ' - '.carga.' '.fx_recoger_loadding__id($cn, $subrutas[$i]['load_id']).' - '.responsable.': '.fx_recoger_entidad__id($cn, $subrutas[$i]['managing_entity_id']).'</a>';

                echo '<form class="formulario" id="form_lista_subrutas_admin_'.$subrutas[$i]['code'].'" method='.'"POST" action="">';
                    if ( isset( $_GET['usu'] ) ) {
                        echo '<input type="hidden" name="session_subr" value="'.$_GET['usu'].'">';
                    } else if ( isset( $_GET['ent'] ) ) {
                        echo '<input type="hidden" name="session_subr" value="'.fx_recoger_email_superadmin( $cn ).'">';
                    }
                    echo '<input type="hidden" name="cod_subruta" value="'.$subrutas[$i]['code'].'">';
                    echo '<input type="hidden" name="lvl_privilegios_subr" value="'.$subrutas[$i]['lvl_privilegios'].'">';
                    echo '<input class="btn_inv" name="inv_btn_subr" type="submit">';
                echo '</form>';

            echo '</div>';

            echo '<div class="info_c" id="info_subr_com1_'.$subrutas[$i]['code'].'">';
                $producto = fx_recoger_producto_subruta( $cn, $subrutas[$i]['code'] );
                $pre = '<pre>'.producto.': ';
                if ( $producto != null ) {
                    $pre .= $producto.'         '.fecha_hora_inicio.': ';
                } else {
                    $pre .= sin_establecer_m.'         '.fecha_hora_inicio.': ';
                } if ( $subrutas[$i]['start'] != null ) {
                    $pre .= $subrutas[$i]['start'].'            '.fecha_hora_final.': ';
                } else {
                    $pre .= sin_establecer_m.'         '.fecha_hora_final.': ';
                } if ( $subrutas[$i]['end'] != null ) {
                    $pre .= $subrutas[$i]['end'].'</pre>';
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
                <img src="../images/cuadrado_rojo.png" alt="'.rojo.'">
                <pre>'.ver_editar_borrar.'</pre>
            </div>
        </div>';
    } else {
        echo ' Lista de subrutas vacía ';
    }
    ?>
</body>
</html>