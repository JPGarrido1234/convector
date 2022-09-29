<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    require("headers_footers/header_principal.php");
        ?>
        <section class="menu_opciones_tecnico">
            <ul class="menu menu_superior" id="menu_tecnico">
                <li><a id="opcion1_tecnico" href="javascript:cambiarOpcionesTecnico(1)"><?php echo lista_cargas ?></a></li>
                <li><a id="opcion2_tecnico" href="javascript:cambiarOpcionesTecnico(2)"><?php echo lista_subrutas ?></a></li>
                <li><a id="opcion3_tecnico" href="javascript:cambiarOpcionesTecnico(3)"><?php echo alta_datalogger ?></a></li>
                <li><a id="opcion4_tecnico" href="index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <section style="color:green;">
        <?php 
            if(isset($msgTecnico)){
                echo $msgTecnico;
            }
            ?>
        </section>
        <section class="seccion_oculta" id="info_cargas_tecnico">
            <div class="titulo" id="titulo_info_cargas_tecnico">
                <h2><?php echo lista_cargas_M ?></h2>
            </div>
            <div class="tiene_filtros" id="filtros_lista_cargas_tecnico">
                <div class="filtros" id="menu_filtros_lista_cargas_tecnico">
                    <pre><?php echo filtros ?>:</pre>
                    <ul class="menu menu_superior" id="menu_filtros_cargas_tecnico">
                        <li><a id="opcion1_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(1)"><?php echo id_datalogger ?></a></li>
                        <li><a id="opcion2_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(2)"><?php echo codigo_contenedor ?></a></li>
                        <li><a id="opcion3_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(3)"><?php echo activos_entre_fechas ?></a></li>
                        <li><a id="opcion4_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(4)"><?php echo inactivos_entre_fechas ?></a></li>
                        <li><a id="opcion5_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(5)"><?php echo coordenadas ?></a></li>
                        <li><a id="opcion6_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(6)"><?php echo ubicacion ?></a></li>
                        <li><a id="opcion7_filtro_cargas_tec" href="javascript:cambiarFiltrosCargasTecnico(0)"><?php echo borrar ?></a></li>
                    </ul>
                </div>
                <input type="hidden" id="sesion_usuario" value="<?php echo $_SESSION['ss_usuario'] ?>">
                <div class="seccion_oculta" id="buscador_datalogger_filtros_tecnico">
                    <input class="input_filtros" id="filtro_datalogger_cod_tec" type="text" name="id_dat">
                    <input class="submit_filtros" onclick="recogerCargasFiltroDataloggerTEC()" type="submit" name="filtros_dat_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_contenedor_filtros_tecnico">
                    <input class="input_filtros" id="filtro_contenedor_cod_tec" type="text" name="id_cont">
                    <input class="submit_filtros" onclick="recogerCargasFiltroContenedorTEC()" type="submit" name="filtros_cont_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_activo_filtros_tecnico">
                    <label><?php echo inicio ?>:</label>
                    <input class="input_filtros" id="filtro_activo_fecha1_tec" type="date" name="fec_1">
                    <label class="label_filtros"><?php echo finale ?>:</label>
                    <input class="input_filtros" id="filtro_activo_fecha2_tec" type="date" name="fec_2">
                    <input class="submit_filtros" onclick="recogerCargasFiltroActivoTEC()" type="submit" name="filtros_activo_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_inactivo_filtros_tecnico">
                    <label><?php echo inicio ?>:</label>
                    <input class="input_filtros" id="filtro_inactivo_fecha3_tec" type="date" name="fec_3">
                    <label class="label_filtros"><?php echo finale ?>:</label>
                    <input class="input_filtros" id="filtro_inactivo_fecha4_tec" type="date" name="fec_4">
                    <input class="submit_filtros" onclick="recogerCargasFiltroInactivoTEC()" type="submit" name="filtros_inactivo_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_ubicacion_filtros_tecnico">
                    <label><?php echo latitud_origen ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_latitud_origen_tec" type="number" step="any" name="lat_or">
                    <label class="label_filtros"><?php echo longitud_origen ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_longitud_origen_tec" type="number" step="any" name="long_or">
                    <label class="label_filtros"><?php echo latitud_destino ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_latitud_destino_tec" type="number" step="any" name="lat_dest">
                    <label class="label_filtros"><?php echo longitud_destino ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_longitud_destino_tec" type="number" step="any" name="long_dest">
                    <input class="submit_filtros" onclick="recogerCargasFiltroUbicacionTEC()" type="submit" name="filtros_ubicacion_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_ubicacion_texto_filtros_tecnico">
                    <label><?php echo ciudad_pais_origen ?>:</label>
                    <input class="input_filtros" id="filtro_ubicacion_origen_tec" type="text" name="ubi_or">
                    <label class="label_filtros"><?php echo ciudad_pais_destino ?>:</label>
                    <input class="input_filtros" id="filtro_ubicacion_destino_tec" type="text" name="ubi_dest">
                    <input class="submit_filtros" onclick="recogerCargasFiltroUbicacionTextoTEC()" type="submit" name="filtros_ubicacion_texto_btn" value="&#8618;">
                </div>
            </div>

            <section id="lista_cargas_ajax_tecnico"></section>
        </section>
        <!-- ======================================================================================================================================
                                                        2. LISTA DE SUBRUTAS
        ====================================================================================================================================== -->
        <section class="seccion_oculta" id="info_subrutas_tecnico">
            <div class="titulo" id="titulo_lista_subrutas_tecnico">
                <h2><?php echo lista_subrutas_M ?></h2>
            </div>
            <div class="filtros" id="menu_filtros_lista_subrutas_tecnico">
                <pre><?php echo filtros ?>:</pre>
                <ul class="menu menu_superior" id="menu_filtros_subrutas_tecnico">
                    <li><a id="opcion1_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(1)"><?php echo id_datalogger ?></a></li>
                    <li><a id="opcion2_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(2)"><?php echo codigo_contenedor ?></a></li>
                    <li><a id="opcion3_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(3)"><?php echo activos_entre_fechas ?></a></li>
                    <li><a id="opcion4_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(4)"><?php echo inactivos_entre_fechas ?></a></li>
                    <li><a id="opcion5_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(5)"><?php echo coordenadas ?></a></li>
                    <li><a id="opcion6_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(6)"><?php echo ubicacion ?></a></li>
                    <li><a id="opcion7_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasTecnico(0)"><?php echo borrar ?></a></li>
                </ul>
            </div>
            <input type="hidden" id="sesion_usuario" value="<?php echo $_SESSION['ss_usuario'] ?>">
            <div class="seccion_oculta" id="buscador_datalogger_filtros_tecnico_subr">
                <input class="input_filtros" id="filtro_datalogger_cod_subr" type="text" name="id_dat">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroDataloggerTEC()" type="submit" name="filtros_dat_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_contenedor_filtros_tecnico_subr">
                <input class="input_filtros" id="filtro_contenedor_cod_subr" type="text" name="id_cont">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroContenedorTEC()" type="submit" name="filtros_cont_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_activo_filtros_tecnico_subr">
                <label><?php echo inicio ?>:</label>
                <input class="input_filtros" id="filtro_activo_fecha1_subr" type="date" name="fec_1">
                <label class="label_filtros"><?php echo finale ?>:</label>
                <input class="input_filtros" id="filtro_activo_fecha2_subr" type="date" name="fec_2">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroActivoTEC()" type="submit" name="filtros_activo_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_inactivo_filtros_tecnico_subr">
                <label><?php echo inicio ?>:</label>
                <input class="input_filtros" id="filtro_inactivo_fecha3_subr" type="date" name="fec_3">
                <label class="label_filtros"><?php echo finale ?>:</label>
                <input class="input_filtros" id="filtro_inactivo_fecha4_subr" type="date" name="fec_4">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroInactivoTEC()" type="submit" name="filtros_inactivo_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_ubicacion_filtros_tecnico_subr">
                <label><?php echo latitud_origen ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_latitud_origen_subr" type="number" step="any" name="lat_or">
                <label class="label_filtros"><?php echo longitud_origen ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_longitud_origen_subr" type="number" step="any" name="long_or">
                <label class="label_filtros"><?php echo latitud_destino ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_latitud_destino_subr" type="number" step="any" name="lat_dest">
                <label class="label_filtros"><?php echo longitud_destino ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_longitud_destino_subr" type="number" step="any" name="long_dest">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroUbicacionTEC()" type="submit" name="filtros_ubicacion_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_ubicacion_texto_filtros_tecnico_subr">
                <label><?php echo ciudad_pais_origen ?>:</label>
                <input class="input_filtros" id="filtro_ubicacion_origen_subr" type="text" name="ubi_or">
                <label class="label_filtros"><?php echo ciudad_pais_destino ?>:</label>
                <input class="input_filtros" id="filtro_ubicacion_destino_subr" type="text" name="ubi_dest">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroUbicacionTextoTEC()" type="submit" name="filtros_ubicacion_texto_btn" value="&#8618;">
            </div>
            <section id="lista_subrutas_ajax_tecnico">
            </section>
        </section>
        <!-- ======================================================================================================================================
                                                        3. ALTA DE DATALOGGER
        ====================================================================================================================================== -->
        <section class="seccion_oculta" id="alta_datalogger_tecnico">
            <div class="titulo" id="titulo_alta_datalogger_tecnico">
                <h2><?php echo alta_datalogger_M ?></h2>
            </div>
            <form class="formulario" id="form_alta_datalogger_tecnico" method="POST" action="">
                <div class="label_form">
                    <h4>&#128461;   <?php echo lista_dataloggers_entidad ?>:</h4>
                    <select name="dat_ex_tec">
                        <?php
                        $dats = fx_recoger_dataloggers_entidad( $cn, fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );
                        for ( $i = 0, $cant = count( $dats ); $i < $cant; ++$i ) {
                            echo '<option value="'.$dats[$i]['codigo'].'">'.$dats[$i]['codigo'].'</option>';
                        }
                        ?>
                    </select>
                    <select class="seccion_oculta" id="dat_ex_tec" name="dat_ex_tec2">
                        <?php
                        $dats2 = fx_recoger_dataloggers( $cn );
                        for ( $j = 0, $cont = count( $dats2 ); $j < $cont; ++$j ) {
                            echo '<option value="'.$dats2[$j]['codigo'].'">'.$dats2[$j]['codigo'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <br><br>
                <div class="label_form">
                    <h4>&#169;   <?php echo codigo_nuevo_datalogger ?>:</h4>
                    <input class="input" type="text" id="cod_alta_dat_tec" name="cod_dat_tec" required>
                </div>
                <input type="hidden" name="session_dat_tec" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton" id="alta_dat_tec_btn">
                    <input class="submit" type="submit" name="dat_btn_tec" value="<?php echo registrar ?>">
                </div>
                <h4 class="seccion_oculta msg_error" id="msg_inc_alta_dat_tec"><?php echo introduce_codigo_valido ?></h4>
            </form>
        </section>
        <?php
        require("headers_footers/footer.php");
        ?>
        <!--
    </body>
</html>
                    -->