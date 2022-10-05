<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>   
<section class="menu_opciones_detalle_carga">
    <ul class="menu menu_superior" id="menu_opciones_detalle_carga">
        <li>
            <a id="opcion1_detalle_carga" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_detalle_carga" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="detalle_carga_principal">
    <div class="titulo titulo_editar_borrar" id="titulo_detalle_carga">
        <?php
        echo '<h2>'.carga.' '.$_SESSION['cod_carga'].'</h2>';
        $carga = fx_recoger_carga_con_privilegios( $cn, $_SESSION['cod_carga'], $_SESSION['ss_usuario'] );
        ?>
    </div>
    <?php
    if ( $carga['lvl_privilegios'] != 1 && $carga['end'] > date("Y-m-d") ) {
        echo '<ul class="menu menu_superior btns_editar_borrar centered" id="editar_borrar_detalle_carga">';
            echo '<li>';
                echo '<a class="a_des" id="opcion1_editar_borrar_carga" href="#">&#9998;';
                    echo '<form class="formulario form2" id="form_editar_carga" method="POST" action="">';
                        echo '<input type="hidden" name="cod_carga" value="'.$carga['code'].'">';
                        echo '<input type="hidden" name="lvl_privilegios" value="'.$carga['lvl_privilegios'].'">';
                        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                        echo '<input class="submit_esp" name="inv_btn_edit" type="submit" value="'.editar.'">';
                    echo '</form>';
                echo '</a>';
            echo '</li>';
        if ( $carga['lvl_privilegios'] == 3 ) {
            echo '<li>';
                echo '<a class="a_des" id="opcion2_editar_borrar_carga" href="#">&#10006;';
                    echo '<form class="formulario form2" id="form_borrar_carga" method="POST" action="">';
                        echo '<input type="hidden" name="cod_carga" value="'.$carga['code'].'">';
                        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                        echo '<input class="submit_esp" name="inv_btn_erase" type="submit" value="'.borrar.'">';
                    echo '</form>';
                echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>
    <form class="formulario" id="form_detalle_carga" method="POST" action="">
        <?php
        echo '<div class="label_form">';
            echo '<h4>&#127963;  '.entidad.':</h4>';
            echo '<input class="input" type="text" value="'.fx_recoger_entidad__id($cn, $carga['entity_id']).'" disabled>';
        echo '</div>';
        echo '<div class="label_form">';
            echo '<h4>&#128104;&#65038;  '.responsable.':</h4>';
            echo '<input class="input" type="text" value="'.fx_recoger_usuario__id($cn, $carga['supervisor_id']).'" disabled>';
        echo '</div>';
        
        echo '<br><br>';
        echo '<div class="label_form" id="label_fecha_ini_detalle">';
            echo '<h4>&#128467;   '.fecha_inicio.':</h4>';
            if ( $carga['start'] != null ) {
                echo '<input class="input" type="date" value='.$carga['start'].' disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
            }
        echo '</div>';
        echo '<div class="label_form" id="label_fecha_fin_detalle">';
            echo '<h4>&#128467;   '.fecha_final.':</h4>';
            if ( $carga['end'] != null ) {
                echo '<input class="input" type="date" value='.$carga['end'].' disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
            }
        echo '</div>';
        echo '<div class="label_form" id="label_fecha_cadu_detalle">';
            echo '<h4>&#128467;   '.fecha_caducidad.':</h4>';
            if ( $carga['expiry'] != null ) {
                echo '<input class="input" type="date" value='.$carga['expiry'].' disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
            }
        echo '</div>';

        echo '<br><br>';
        echo '<div class="label_form">';
            echo '<h4>&#128505;  '.numero_contenedores.' ('.unidades_m.'):</h4>';
            if ( $carga['containers'] != null ) {
                echo '<input class="input" type="text" value="'.$carga['containers'].'" disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
            }
        echo '</div>';
        echo '<div class="label_form">';
            echo '<h4>&#128505;  '.kilos_totales.' ('.kgs_m.'):</h4>';
            if ( $carga['weight'] != null ) {
                echo '<input class="input" type="text" value="'.$carga['weight'].'" disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
            }
        echo '</div>';
        echo '<div class="label_form">';
            echo '<h4>&#128230;&#65038;  '.producto.':</h4>';
            if ( $carga['product_id'] != null ) {
                echo '<input class="input" type="text" value="'.fx_recoger_nombre_producto( $cn, $carga['product_id'] ).'" disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>'; 
            }
        echo '</div>';

        echo '<br><br>';
        echo '<div class="label_form">';
            echo '<h4>&#11016;   '.origen.':</h4>';
            if ( $carga['origin'] != null ) {
                echo '<input class="input" type="text" value="'.$carga['origin'].'" disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>'; 
            }
        echo '</div>';
        echo '<div class="label_form">';
            echo '<h4>&#11019;   '.destino.':</h4>';
            if ( $carga['destiny'] != null ) {
                echo '<input class="input" type="text" value="'.$carga['destiny'].'" disabled>';
            } else {
                echo '<input class="input" type="text" value="'.sin_establecer_m.'" disabled>';
            }
        echo '</div>';
        echo '<br><br>';
        ?>
    </form>
    <?php
    if ( $carga['origin_latitude'] != null && $carga['origin_longitude'] != null && $carga['destiny_latitude'] != null && $carga['destiny_longitude'] != null ) {
    ?>
    <div id ="map3"> </div>
    <input type="hidden" id="lat_or_hid" value="<?php echo $carga['origin_latitude'] ?>">
    <input type="hidden" id="long_or_hid" value="<?php echo $carga['origin_longitude'] ?>">
    <input type="hidden" id="lat_dest_hid" value="<?php echo $carga['destiny_latitude'] ?>">
    <input type="hidden" id="long_dest_hid" value="<?php echo $carga['destiny_longitude'] ?>">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMapStatic" async defer></script>
    <?php } ?>
    <br><br>
    <ul class="menu menu_centrado" id="submenu_detalles_carga">
        <li><a id="opcion1_submenu_detalle_carga" href="javascript:cambiarApartadoDetalleCarga(1)"><?php echo ver_dataloggers ?></a></li>
        <!--
        <li><a id="opcion2_submenu_detalle_carga" href="javascript:cambiarApartadoDetalleCarga(2)"><?php //echo ver_subrutas ?></a></li>
        <li><a id="opcion3_submenu_detalle_carga" href="javascript:cambiarApartadoDetalleCarga(3)"><?php //echo ver_vehiculos ?></a></li>
        <li><a id="opcion4_submenu_detalle_carga" href="javascript:cambiarApartadoDetalleCarga(4)"><?php //echo ver_temperaturas ?></a></li>
        <li><a id="opcion5_submenu_detalle_carga" href="javascript:cambiarApartadoDetalleCarga(5)"><?php //echo ver_datos ?></a></li>
        -->
        <?php //if (fx_comprobar_carga_terminada($cn, $_SESSION['cod_carga'], fx_recoger_datalogger_random_carga($cn, $_SESSION['cod_carga'])) == 1) { ?>
            <!-- <li><a id="opcion6_submenu_detalle_carga" href="javascript:cambiarApartadoDetalleCarga(6)"><?php //echo ver_graficas ?></a></li> -->
        <?php //} ?>
    </ul>
    <div class="seccion_oculta" id="lista_dataloggers_detalle_carga">
        <div class="titulo titulo_secundario titulo_filtros" id="titulo_lista_dataloggers_detalle_carga">
            <h2><?php echo lista_dataloggers_M ?></h2>
        </div>
        <?php
        $enlaces = fx_recoger_dataloggers_carga($cn, $carga['id']);
        for ($i = 0, $cant = count($enlaces); $i < $cant; ++$i) {
            echo '<div class="info_carga con_btn_inv">';
                echo '<pre>'.datalogger.' '.fx_recoger_datalogger__id($cn, $enlaces[$i]['datalogger_id']).
                '            '.contenedor.' '.$enlaces[$i]['code'].'</pre>';

                echo '<form class="formulario" id="form_lista_dataloggers_carga" method="POST" action="">';
                    echo '<input type="hidden" name="session_datalogger" value="'.$_SESSION['ss_usuario'].'">';
                    echo '<input type="hidden" name="codigo_datalogger" value="'.$enlaces[$i]['datalogger_id'].'">';
                    echo '<input type="hidden" name="tipo" value="carga">';
                    echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
                echo '</form>';

            echo '</div>';
        }
        ?>
    </div>
    <div class="seccion_oculta" id="lista_subrutas_detalle_carga">
        <div class="titulo titulo_secundario titulo_filtros" id="titulo_lista_subrutas_detalle_carga">
            <h2><?php echo lista_subrutas_M ?></h2>
        </div>
        <?php
        $subrutas = fx_recoger_subrutas_carga( $cn, $carga['code'], $_SESSION['ss_usuario'] );
        for ( $i = 0, $cant = count( $subrutas ); $i < $cant; ++$i ) {
            '\')"'.' onmouseout="esconderDetalles(\'info_subr_det_'.$subrutas[$i]['codigo'].'\')".'.
            ' onmouseenter="cambiarColorPrivi(\'info_subr_det_'.$subrutas[ $i ]['codigo'].'\', \''.$subrutas[$i]['lvl_privilegios'].'\')"'.'>';
                echo '<a id="subr_det_'.$subrutas[$i]['codigo'].'" href="#">'.subruta.' '.$subrutas[$i]['codigo'].
                ' - '.producto.': '.fx_recoger_nombre_producto_carga( $cn, $subrutas[$i]['carga'] ).' - '.responsable.': '.
                fx_recoger_nombre( $cn, $subrutas[$i]['responsable'] ).'</a>';

                echo '<form class="formulario" id="form_lista_subrutas_detalle_carga_'.$subrutas[$i]['codigo'].'" method='.'"POST" action="">';
                    echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                    echo '<input type="hidden" name="cod_subruta" value="'.$subrutas[$i]['codigo'].'">';
                    echo '<input type="hidden" name="lvl_privilegios_subruta" value="'.$subrutas[$i]['lvl_privilegios'].'">';
                    echo '<input class="btn_inv" name="inv_btn_subr" type="submit">';
                echo '</form>';

            echo '</div>';

            echo '<div class="info_c" id="info_subr_det_'.$subrutas[$i]['codigo'].'">';
                echo '<pre>'.fecha_inicio.': '.$subrutas[$i]['fecha_hora_inicio'].'        '.fecha_final.': '.$subrutas[$i]['fecha_hora_final'].'</pre>';
            echo '</div>';
        }
        if ( count( $subrutas ) != 0 ) {
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
        }
        ?>
    </div>
    <div class="seccion_oculta" id="lista_vehiculos_detalle_carga">
        <div class="titulo titulo_secundario titulo_filtros" id="titulo_lista_vehiculos_detalle_carga">
            <h2><?php echo lista_vehiculos_M ?></h2>
        </div>
        <?php
        $vehiculos = fx_recoger_vehiculos_carga( $cn, $carga['codigo'] );
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
    <div class="seccion_oculta" id="lista_temperaturas_detalle_carga">
        <div class="titulo titulo_secundario" id="titulo_lista_temperaturas_detalle_carga">
            <h2><?php echo lista_temperaturas_M ?></h2>
        </div>
        <form class="formulario" id="form_temperatuas_detalle" method="POST" action="">
            <div class="label_form" id="label_temperatura_maxima_detalle">
                <h4>&#11016;   <?php echo t_maxima ?> (<?php echo oc ?>):</h4>
                <input class="input" type="number" value="<?php echo fx_recoger_temperatura_maxima_carga( $cn, $_SESSION['cod_carga'] ) ?>" disabled>
            </div>
            <div class="label_form" id="label_temperatura_minima_detalle">
                <h4>&#11019;   <?php echo t_minima ?> (<?php echo oc ?>):</h4>
                <input class="input" type="number" value="<?php echo fx_recoger_temperatura_minima_carga( $cn, $_SESSION['cod_carga'] ) ?>" disabled>
            </div>
            <div class="label_form" id="label_temperatura_media_detalle">
                <h4>&#11013;   <?php echo t_media ?> (<?php echo oc ?>):</h4>
                <input class="input" type="number" value="<?php echo fx_recoger_temperatura_media_carga( $cn, $_SESSION['cod_carga'] ) ?>" disabled>
            </div>
            <br><br>
            <div class="label_form" id="label_consigna_superior_detalle">
                <h4>&#11016;   <?php echo consigna_superior ?> (<?php echo oc ?>):</h4>
                <input class="input" type="number" value="<?php echo fx_recoger_consigna_superior_carga( $cn, $_SESSION['cod_carga'] ) ?>" disabled>
            </div>
            <div class="label_form" id="label_consigna_superior_detalle">
                <h4>&#11019;   <?php echo consigna_inferior ?> (<?php echo oc ?>):</h4> 
                <input class="input" type="number" value="<?php echo fx_recoger_consigna_inferior_carga( $cn, $_SESSION['cod_carga'] ) ?>" disabled>
            </div>
        </form>
        
    </div>
    <div class="seccion_oculta" id="lista_datos_detalle_carga">
        <div class="titulo titulo_secundario" id="titulo_lista_datos_detalle_carga">
            <h2><?php echo datos_adicionales_M ?></h2>
        </div>
        <form class="formulario" id="form_datos_detalle" method="POST" action="">
            <!-- Completar el formulario con los campos necesarios -->
        </form>
    </div>
    <div class="seccion_oculta" id="grafica_detalle_carga">
        <br><br>
        <div class="centered" id="div_form_cod_datalogger_carga">
            <form class="formulario inline" id="form_cod_datalogger_carga" method="POST" action="">
                <label><?php echo selecciona_datalogger ?>:</label>
                <select name="select_doc_datalogger_carga" id="select_doc_datalogger_carga">
                    <?php
                    for ( $i = 0, $cant = count( $enlaces ); $i < $cant; ++$i ) {
                        echo '<option value="'.$enlaces[$i]['datalogger'].'">'.$enlaces[$i]['datalogger'].'</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="session" value="<?php echo $_SESSION['ss_usuario']; ?>">
                <input type="hidden" name="cod_carga" value="<?php echo $_SESSION['cod_carga']; ?>">
                <div id="div_actualizar_cod_datalogger_carga">
                    <input class="submit" type="submit" name="btn_act_cod_datalogger_carga" value="&#10004;">
                </div>
            </form>
        </div>
        <div id="seccion_grafica_detalle_carga">
            <div class="titulo titulo_secundario" id="titulo_grafica_detalle_carga">
                <h2><?php echo evolucion_temperatura_M ?></h2>
            </div>
            <canvas id="grafica_evolucion_temperatura"></canvas>
            <script type="text/javascript">
                const grafica2 = document.querySelector("#grafica_evolucion_temperatura");
                const datos = {
                    data: <?php echo json_encode($array_temperaturas) ?>,
                    backgroundColor: "rgba(248, 248, 248, 1)",
                    borderColor: "rgba(0, 0, 0, 1)",
                    borderWidth: 1,
                };
                new Chart($grafica2, {
                    type: "line",
                    data: {
                        datasets: [
                            datos,
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                        },
                    }
                });
            </script>
        </div>
    </div>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>