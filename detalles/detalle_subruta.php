<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_subruta.php");
require($_SERVER['DOCUMENT_ROOT']."/general/sesion.php");
?>
<!DOCTYPE html>
<html>
    <?php
    require($_SERVER['DOCUMENT_ROOT']."/headers_footers/head_maps.php");
    ?>
    <body>
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
        ?>
        <!-- ======================================================================================================================================
                                                         MENÚ HORIZONTAL DE OPCIONES
        ====================================================================================================================================== -->
        <section class="menu_opciones_detalle_subruta">
            <ul class="menu menu_superior" id="menu_opciones_detalle_subruta">
                <li><a id="opcion1_detalle_subruta" href="../inicio_superadmin.php"><?php echo volver ?></a></li> <!-- Revisar esto -->
                <li><a id="opcion2_detalle_subruta" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                    INFORMACIÓN DE LA SUBRUTA SELECCIONADA
        ====================================================================================================================================== -->
        <section id="detalle_subruta_principal">
            <div class="titulo titulo_editar_borrar" id="titulo_detalle_subruta">
                <?php
                echo '<h2>'.subruta.' '.$_SESSION['cod_subruta'].'</h2>';
                $subruta = fx_recoger_subruta_con_privilegios( $cn, $_SESSION['cod_subruta'], $_SESSION['ss_usuario'] );
                ?>
            </div>
            <?php
            if ( $subruta['lvl_privilegios'] == 3 && $subruta['fecha_hora_final'] > date("Y-m-d") ) {
                echo '<ul class="menu menu_superior btns_editar_borrar centered" id="editar_borrar_detalle_subruta">';
                    echo '<li>';
                        echo '<a class="a_des" id="opcion1_editar_borrar_subruta" href="#">&#9998;';
                            echo '<form class="formulario form2" id="form_editar_subruta" method="POST" action="">';
                                echo '<input type="hidden" name="cod_subruta" value="'.$subruta['codigo'].'">';
                                echo '<input type="hidden" name="lvl_privilegios" value="'.$subruta['lvl_privilegios'].'">';
                                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                                echo '<input class="submit_esp" name="inv_btn_edit" type="submit" value="'.editar.'">';
                            echo '</form>';
                        echo '</a>';
                    echo '</li>';
                    echo '<li>';
                        echo '<a class="a_des" id="opcion2_editar_borrar_subruta" href="#">&#10006;';
                            echo '<form class="formulario form2" id="form_borrar_subruta" method="POST" action="">';
                                echo '<input type="hidden" name="cod_subruta" value="'.$subruta['codigo'].'">';
                                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                                echo '<input class="submit_esp" name="inv_btn_erase" type="submit" value="'.borrar.'">';
                            echo '</form>';
                        echo '</a>';
                    echo '</li>';
                echo '</ul>';
            }
            ?>
            <form class="formulario" id="form_detalle_subruta" method="POST" action="">
                <?php
                echo '<div class="label_form">';
                    echo '<h4>&#128234;&#65038;   '.carga.':</h4>';
                    echo '<input class="input" type="text" value="'.$subruta['carga'].'" disabled>';
                echo '</div>';
                echo '<div class="label_form">';
                    echo '<h4>&#127963;   '.entidad.':</h4>';
                    echo '<input class="input" type="text" value="'.$subruta['entidad'].'" disabled>';
                echo '</div>';
                echo '<div class="label_form">';
                    echo '<h4>&#128104;&#65038;   '.responsable.':</h4>';
                    if ( $subruta['responsable'] != null ) {
                        echo '<input class="input" type="text" value="'.$subruta['responsable'].'" disabled>';
                    } else {
                        echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
                    }
                echo '</div>';

                echo '<br><br>';
                echo '<div class="label_form">';
                    echo '<h4>&#128467;   '.fecha_hora_inicio.':</h4>';
                    if ( $subruta['fecha_hora_inicio'] != null ) {
                        $fh_ini = date('Y-m-d\TH:i', strtotime($subruta['fecha_hora_inicio']));
                        echo '<input class="input" type="datetime-local" value='.$fh_ini.' disabled>';
                    } else {
                        echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
                    }
                echo '</div>';
                echo '<div class="label_form">';
                    echo '<h4>&#128467;   '.fecha_hora_final.':</h4>';
                    if ( $subruta['fecha_hora_final'] != null ) {
                        $fh_fin = date('Y-m-d\TH:i', strtotime($subruta['fecha_hora_final']));
                        echo '<input class="input" type="datetime-local" value='.$fh_fin.' disabled>';
                    } else {
                        echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
                    }
                echo '</div>';
                ?>
            </form>
            <br><br>
            <?php
            if ( $subruta['latitud_origen'] != null && $subruta['longitud_origen'] != null && $subruta['latitud_destino'] != null && $subruta['longitud_destino'] != null ) {
            ?>
            <div id ="map6"> </div>
            <input type="hidden" id="lat_or_hid" value="<?php echo $subruta['latitud_origen'] ?>">
            <input type="hidden" id="long_or_hid" value="<?php echo $subruta['longitud_origen'] ?>">
            <input type="hidden" id="lat_dest_hid" value="<?php echo $subruta['latitud_destino'] ?>">
            <input type="hidden" id="long_dest_hid" value="<?php echo $subruta['longitud_destino'] ?>">
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMapStatic2" async defer></script>
            <?php } ?>
            <br><br>
            <ul class="menu menu_centrado" id="submenu_detalle_subruta">
                <li><a id="opcion1_submenu_detalle_subruta" href="javascript:cambiarApartadoDetalleSubruta(1)"><?php echo ver_alertas ?></a></li>
                <li><a id="opcion2_submenu_detalle_subruta" href="javascript:cambiarApartadoDetalleSubruta(2)"><?php echo ver_dataloggers ?></a></li>
                <li><a id="opcion3_submenu_detalle_subruta" href="javascript:cambiarApartadoDetalleSubruta(3)"><?php echo ver_vehiculos ?></a></li>
            </ul>
            <div class="seccion_oculta" id="lista_alertas_detalle_subruta">
                <!-- POR HACER -->
            </div>
            <div class="seccion_oculta" id="lista_dataloggers_detalle_subruta">
                <div class="titulo titulo_secundario titulo_filtros" id="titulo_lista_dataloggers_detalle_subruta">
                    <h2><?php echo lista_dataloggers_M ?></h2>
                </div>
                <?php
                $enlaces = fx_recoger_dataloggers_subruta( $cn, $subruta['codigo'] );
                for ( $i = 0, $cant = count( $enlaces ); $i < $cant; ++$i ) {
                    echo '<div class="info_carga con_btn_inv">';
                        echo '<pre>'.datalogger.' '.$enlaces[$i]['datalogger'].
                        '            '.contenedor.' '.$enlaces[$i]['contenedor'].'</pre>';

                        echo '<form class="formulario" id="form_lista_dataloggers_subruta" method="POST" action="">';
                            echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                            echo '<input type="hidden" name="cod_datalogger" value="'.$enlaces[$i]['datalogger'].'">';
                            echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
                        echo '</form>';

                    echo '</div>';
                }
                ?>
            </div>
            <div class="seccion_oculta" id="lista_vehiculos_detalle_subruta">
                <div class="titulo titulo_secundario titulo_filtros" id="titulo_lista_vehiculos_detalle_subruta">
                    <h2><?php echo lista_vehiculos_M ?></h2>
                </div>
                <?php
                $vehiculos = fx_recoger_vehiculos_subruta( $cn, $subruta['codigo'] );
                for ( $j = 0, $cont = count( $vehiculos ); $j < $cont; ++$j ) {
                    echo '<div class="info_carga">';
                        if ( $vehiculos[$j]['tipo'] != null ) {
                            echo '<pre>'.tipo_vehiculo.': '.$vehiculos[$j]['tipo'].
                            '        '.matricula.': '.$vehiculos[$j]['matricula'].'</pre>';
                        } else {
                            echo '<pre>'.tipo_vehiculo.': '.sin_establecer_m.'        '.matricula.': '.
                            $vehiculos[$j]['matricula'].'</pre>';
                        }
                    echo '</div>';
                }
                ?>
            </div>
        </section>
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
        ?>
    </body>
</html>