<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//if(!isset($_POST['cod_carga']) && !isset($_POST['codigo']) && !isset($_POST['nombre6']) && !isset($_POST['session_carga']) && !isset($_POST['codigo_datalogger']) && !isset($_POST['cod_subruta'])){
    if(!isset($_SESSION['cod_carga'])){
    require("headers_footers/header_principal.php");

        ?>
        <section class="menu_opciones_admin">
            <ul class="menu menu_superior_aviso" id="menu_admin">
                <li><a id="opcion1_admin" href="javascript:cambiarMenuAdmin(1)"><?php echo dar_alta ?></a></li>
                <li><a id="opcion2_admin" href="javascript:cambiarMenuAdmin(2)"><?php echo gestion_cargas ?></a></li>
                <li><a id="opcion3_admin" href="javascript:cambiarMenuAdmin(3)"><?php echo informacion_entidad ?></a></li>
                <li><a class="opcion_final" id="opcion4_admin" href="index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
                <?php
                if ( isset( $_SESSION['msg'] ) ) {
                    if ( $_SESSION['msg'] != 'Error' ) {
                        echo '<li><a class="opcion_bien" id="opcion5_admin" href="#">&#10004;</a></li>';
                    } else {
                        echo '<li><a class="opcion_error" id="opcion6_admin" href="#">&#10006;</a></li>';
                    }
                }
                ?>
            </ul>
            <section class="seccion_oculta" id="seccion_submenu_alta">
                <ul class="menu submenu_superior" id="submenu_alta">
                    <li><a id="opcion1_submenu_alta" href="javascript:cambiarSubmenuAltaAdmin(1)"><?php echo alta_carga ?></a></li>
                    <li><a id="opcion2_submenu_alta" href="javascript:cambiarSubmenuAltaAdmin(2)"><?php echo alta_subruta ?></a></li>
                    <li><a id="opcion3_submenu_alta" href="javascript:cambiarSubmenuAltaAdmin(3)"><?php echo alta_datalogger ?></a></li>
                    <li><a id="opcion4_submenu_alta" href="javascript:cambiarSubmenuAltaAdmin(4)"><?php echo alta_producto ?></a></li>
                    <li><a id="opcion5_submenu_alta" href="javascript:cambiarSubmenuAltaAdmin(5)"><?php echo alta_usuario ?></a></li>
                </ul>
            </section>
            <section class="seccion_oculta" id="seccion_submenu_gestion">
                <ul class="menu submenu_superior" id="submenu_gestion">
                    <li><a id="opcion1_submenu_gestion" href="javascript:cambiarSubmenuGestionAdmin(1)"><?php echo lista_cargas ?></a></li>
                    <li><a id="opcion2_submenu_gestion" href="javascript:cambiarSubmenuGestionAdmin(2)"><?php echo lista_subrutas ?></a></li>
                    <li><a id="opcion3_submenu_gestion" href="javascript:cambiarSubmenuGestionAdmin(3)"><?php echo lista_dataloggers ?></a></li>
                    <li><a id="opcion4_submenu_gestion" href="javascript:cambiarSubmenuGestionAdmin(4)"><?php echo lista_productos ?></a></li>
                </ul>
            </section>
        </section>
<?php }else if(isset($_SESSION['alta_subruta'])){
    if($_SESSION['alta_subruta'] == "alta"){
        
        //$_SESSION['alta_subruta'] = null;
    }
} 
?>
        <section class="seccion_oculta" id="alta_carga_admin">
            <div class="titulo" id="titulo_alta_carga_admin">
                <h2><?php echo alta_carga_M ?></h2>
            </div>
            
            <form class="formulario" id="form_alta_carga_admin" method="POST" action="">
                <div class="label_form">
                    <h4>&#169;   <?php echo codigo ?>:</h4>
                    <input class="input" type="text" name="codigo" required>
                </div>
                <div class="label_form">
                    <h4>&#128694;&#65038;   <?php echo responsable ?>:</h4>
                    <select id="select_usuario" name="sel_usu5" required>
                        <option value=""><?php echo selecciona_responsable ?>:</option>
                        <?php
                        $usuarios = fx_recoger_usuarios($cn, $_SESSION['ss_usuario']);
                        for ( $i = 0, $cant = count($usuarios); $i < $cant; ++$i ) {
                            echo '<option value="'.$usuarios[$i]['email'].'">'.usuario.' '.($i+1).' - '.$usuarios[$i]['first_name'].' ('.
                            $usuarios[$i]['role'].')</option>';
                        }
                        ?>
                    </select>
                </div>
                <br><br>
                <div class="label_form"  id="label_fecha_ini">
                    <h4>&#128467;   <?php echo fecha_inicio ?>:</h4>
                    <input class="input" type="date" name="fecha_ini">
                </div>
                <div class="label_form" id="label_fecha_fin">
                    <h4>&#128467;   <?php echo fecha_final ?>:</h4>
                    <input class="input" type="date" name="fecha_fin">
                </div>
                <div class="label_form" id="label_fecha_cadu">
                    <h4>&#128467;   <?php echo fecha_caducidad ?>:</h4>
                    <input class="input" type="date" name="fecha_cadu">
                </div>
                <div class="label_form">
                    <h4>&#128505;   <?php echo kilos_totales ?> (<?php echo kgs_m ?>):</h4>
                    <input class="input" type="number" name="kilos">
                </div>
                <div class="label_form">
                    <h4>&#128505;   <?php echo numero_contenedores ?> (<?php echo unidades_m ?>):</h4>
                    <input class="input" type="number" name="contenedores">
                </div>
                <br><br>
                <div class="label_form">
                    <h4>&#127991;   <?php echo producto ?>:</h4>
                    <select id="select_producto_alta_carga" name="sel_prod">
                        <option value=""><?php echo selecciona_producto ?></option>
                        <?php
                        $productos = fx_recoger_productos_entidad_unique( $cn, fx_recoger_datos_entidad( $cn, $_SESSION['ss_usuario'] )['id'] );
                        for ( $i = 0, $cant = count( $productos ); $i < $cant; ++$i ) {

                            if ( $productos[$i]['variety'] != null ) {
                                echo '<option value="'.$productos[$i]['code']."/".$productos[$i]["max_temp"]."/".$productos[$i]["min_temp"].'">'.
                                $productos[$i]['name'].' - '.variedad.': '.$productos[$i]['variety'].'</option>';
                            } else {
                                echo '<option value="'.$productos[$i]['code']."/".$productos[$i]["max_temp"]."/".$productos[$i]["min_temp"].'">'.
                                $productos[$i]['name'].' - '.variedad.': '.sin_establecer_m.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="label_form">
                    <h4>&#127777;&#11014;   <?php echo t_maxima ?> (<?php echo oc ?>):</h4>
                    <input class="input" type="number" step="0.01" name="temp_max">
                </div>
                <div class="label_form">
                    <h4>&#127777;&#11015;   <?php echo t_minima ?> (<?php echo oc ?>):</h4>
                    <input class="input" type="number" step="0.01" name="temp_min">
                </div>
                <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton" id="sig_carga_admin_btn">
                    <input class="submit" type="submit" name="sig_btn" value="<?php echo siguiente ?>">
                </div>
            </form>
        </section>
        
        <section class="seccion_oculta" id="alta_subruta_admin">
            <div class="titulo" id="titulo_alta_subruta_admin">
                <h2><?php echo alta_subruta_M ?></h2>
            </div>
            <form class="formulario" id="form_alta_subruta_admin" method="POST" action="">
                <?php
                $cargas_subruta = recoger_cargas_disponibles_subruta($cn, $_SESSION['ss_usuario']);
                ?>
                <div class="label_form" id="label_carga_subr"> 
                    <h4>&#128234;&#65038;   <?php echo carga ?>:</h4>
                    <select id="select_carga_alta_subruta" name="sel_car_subr" required>
                        <?php
                        if ( count($cargas_subruta) == 0 ) {
                            echo '<option value="">'.no_cargas_disponibles.'</option>';
                        }
                        for ( $i = 0, $cont = count($cargas_subruta); $i < $cont; ++$i ) {
                            echo '<option value="'.$cargas_subruta[$i]['code'].'">'.carga.' '.$cargas_subruta[$i]['code'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="label_form">
                    <h4>&#169;   <?php echo codigo_subruta ?>:</h4>
                    <input class="input" type="text" name="codigo" required>
                </div>
                <div class="label_form">
                    <h4>&#127963;   <?php echo entidad_asignada ?>:</h4>
                    <select name="entidad_asignada" required>
                        <option value=""><?php echo selecciona_entidad ?></option>
                        <?php
                            $entidades = fx_recoger_entidades( $cn );
                            for ( $i = 0, $cant = count( $entidades ); $i < $cant; ++$i ) {
                                if ( $entidades[$i]['name'] != fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) ) {
                                    echo '<option value="'.$entidades[$i]['name'].'">'.$entidades[$i]['name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <br><br><br><br>
                <div class="label_form" id="label_fechahora_ini">
                    <h4>&#128467;   <?php echo fecha_hora_inicio ?>:</h4>
                    <input class="input" type="datetime-local" name="fecha_hora_ini">
                </div>
                <div class="label_form" id="label_fechahora_fin">
                    <h4>&#128467;   <?php echo fecha_hora_final ?>:</h4>
                    <input class="input" type="datetime-local" name="fecha_hora_fin">
                </div>
                <div class="label_form">
                    <h4>&#128666;&#65038;   <?php echo numero_vehiculos ?>:</h4>
                    <input class="input" type="number" step="1" min="1" name="num_vehiculos">
                </div>
                <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton">
                    <input class="submit" type="submit" name="sig_alta_subruta_prin" value="<?php echo siguiente ?>">
                </div>
            </form>
        </section>

        <section class="seccion_oculta" id="alta_datalogger_admin">
            <div class="titulo" id="titulo_alta_datalogger_admin">
                <h2><?php echo alta_datalogger_M ?></h2>
            </div>
            <form class="formulario" id="form_alta_datalogger_admin" method="POST" action="">
                <div class="label_form">
                    <h4>&#128461;   <?php echo lista_dataloggers_entidad ?></h4>
                    <select name="dat_ex_adm">
                        <?php
                        $dats = fx_recoger_dataloggers_entidad( $cn, fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );
                        for ( $i = 0, $cant = count( $dats ); $i < $cant; ++$i ) {
                            echo '<option value="'.$dats[$i]['code'].'">'.$dats[$i]['code'].'</option>';
                        }
                        ?>
                    </select>
                    <select class="seccion_oculta" id="dat_ex_adm" name="dat_ex_adm2">
                        <?php
                        $dats2 = fx_recoger_dataloggers($cn);
                        for ( $j = 0, $cont = count( $dats2 ); $j < $cont; ++$j ) {
                            echo '<option value="'.$dats2[$j]['code'].'">'.$dats2[$j]['code'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <br><br>
                <div class="label_form">
                    <h4>&#169;   <?php echo codigo_nuevo_datalogger ?>:</h4>
                    <input class="input" type="text" id="cod_alta_dat_adm" name="cod_dat_adm" required>
                </div>
                <input type="hidden" name="session_dat" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton" id="alta_dat_adm_btn">
                    <input class="submit" type="submit" name="dat_btn_adm" value="<?php echo registrar ?>">
                </div>
                <h4 class="seccion_oculta msg_error" id="msg_inc_alta_dat_adm"><?php echo introduce_codigo_valido ?></h4>
            </form>
        </section>

        <section class="seccion_oculta" id="alta_producto_admin">
            <div class="titulo" id="titulo_alta_producto_admin">
                <h2><?php echo alta_producto_M ?></h2>
            </div>
            <form class="formulario" id="form_alta_producto_admin" method="POST" action="">
                <div class="label_form">
                    <h4>&#9826;   <?php echo nombre ?>:</h4>
                    <input class="input" type="text" name="nombre6" required>
                </div>
                <div class="label_form">
                    <h4>&#8981;   <?php echo variedad ?>:</h4>
                    <input class="input" type="text" name="variedad6">
                </div>
                <div class="label_form">
                    <h4>&#9195;&#65038;   <?php echo t_maxima ?> (<?php echo oc ?>):</h4>
                    <input class="input" step="0.01" type="number" name="t_max6" required>
                </div>
                <div class="label_form">
                    <h4>&#9196;&#65038;   <?php echo t_minima ?> (<?php echo oc ?>):</h4>
                    <input class="input" step="any" type="number" name="t_min6" required>
                </div>
                <input type="hidden" name="session6" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton" id="alta_producto_admin_btn">
                    <input class="submit" type="submit" name="prod_btn" value="<?php echo registrar ?>">
                </div>
            </form>
        </section>

        <section class="seccion_oculta" id="alta_usuario_admin">
            <div class="titulo" id="titulo_alta_usuario_admin">
                <h2><?php echo alta_usuario_M ?></h2>
            </div>
            <form class="formulario" id="form_alta_usuario_admin" method="POST" action="">
                <div class="label_form">
                    <h4>&#128104;&#65038;  <?php echo nombre ?>:</h4>
                    <input class="input" type="text" name="nombre4" required>
                </div>
                <div class="label_form">
                    <h4>&#127891;&#65038;  <?php echo cargo ?>:</h4>
                    <input class="input" type="text" name="cargo4" required>
                </div>
                <div class="label_form">
                    <h4>&#9993;  <?php echo correo_electronico ?>:</h4>
                    <input class="input" type="email" name="email4" required>
                </div>
                <div class="label_form">
                    <h4>&#9734;   <?php echo rol ?>:</h4>
                    <select name="rol_usu4">
                        <option value=""><?php echo selecciona_rol ?></option>
                        <option value="ROLE_ADMIN"><?php echo administrador ?></option>
                        <option value="ROLE_TECHNICIAN"><?php echo tecnico ?></option>
                    </select>
                </div>
                <div class="label_form">
                    <h4>&#9919;  <?php echo contrasena_provisional ?>:</h4>
                    <input class="input" type="password" name="password4" required>
                </div>
                <input type="hidden" name="session_usu" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton" id="alta_usuario_admin_btn">
                    <input class="submit" type="submit" id="usu_btn_alta_carga" name="usu_btn" value="<?php echo registrar ?>">
                </div>
            </form>
        </section>

        <section class="seccion_oculta" id="lista_cargas_admin">
            <div class="titulo titulo_filtros" id="titulo_lista_cargas_admin">
                <h2><?php echo lista_cargas_M ?></h2>
            </div>
            <div class="tiene_filtros" id="filtros_lista_cargas_admin"> <!-- Filtros --> 
                <div class="filtros" id="menu_filtros_lista_cargas_admin">
                    <pre><?php echo filtros ?>:</pre>
                    <ul class="menu menu_superior" id="menu_filtros_cargas_admin">
                        <li><a id="opcion1_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(1)"><?php echo id_datalogger ?></a></li>
                        <li><a id="opcion2_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(2)"><?php echo codigo_contenedor ?></a></li>
                        <li><a id="opcion3_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(3)"><?php echo activos_entre_fechas ?></a></li>
                        <li><a id="opcion4_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(4)"><?php echo inactivos_entre_fechas ?></a></li>
                        <li><a id="opcion5_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(5)"><?php echo coordenadas ?></a></li>
                        <li><a id="opcion6_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(6)"><?php echo ubicacion ?></a></li>
                        <li><a id="opcion7_filtro_cargas" href="javascript:cambiarFiltrosCargasAdmin(0)"><?php echo borrar ?></a></li>
                    </ul>
                </div>
                <input type="hidden" id="sesion_usuario" value="<?php echo $_SESSION['ss_usuario'] ?>">
                <div class="seccion_oculta" id="buscador_datalogger_filtros_admin">
                    <label><?php echo id_datalogger ?>:</label>
                    <input class="input_filtros" id="filtro_datalogger_cod" type="text" name="id_dat">
                    <input class="submit_filtros" onclick="recogerCargasFiltroDatalogger()" type="submit" name="filtros_dat_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_contenedor_filtros_admin">
                    <label><?php echo codigo_contenedor ?>:</label>
                    <input class="input_filtros" id="filtro_contenedor_cod" type="text" name="id_cont">
                    <input class="submit_filtros" onclick="recogerCargasFiltroContenedor()" type="submit" name="filtros_cont_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_activo_filtros_admin">
                    <label><?php echo inicio ?>:</label>
                    <input class="input_filtros" id="filtro_activo_fecha1" type="date" name="fec_1">
                    <label class="label_filtros"><?php echo finale ?>:</label>
                    <input class="input_filtros" id="filtro_activo_fecha2" type="date" name="fec_2">
                    <input class="submit_filtros" onclick="recogerCargasFiltroActivo()" type="submit" name="filtros_activo_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_inactivo_filtros_admin">
                    <label><?php echo inicio ?>:</label>
                    <input class="input_filtros" id="filtro_inactivo_fecha3" type="date" name="fec_3">
                    <label class="label_filtros"><?php echo finale ?>:</label>
                    <input class="input_filtros" id="filtro_inactivo_fecha4" type="date" name="fec_4">
                    <input class="submit_filtros" onclick="recogerCargasFiltroInactivo()" type="submit" name="filtros_inactivo_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_ubicacion_filtros_admin">
                    <label><?php echo latitud_origen ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_latitud_origen" type="number" step="any" name="lat_or">
                    <label class="label_filtros"><?php echo longitud_origen ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_longitud_origen" type="number" step="any" name="long_or">
                    <label class="label_filtros"><?php echo latitud_destino ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_latitud_destino" type="number" step="any" name="lat_dest">
                    <label class="label_filtros"><?php echo longitud_destino ?>:</label>
                    <input class="input_filtros" id="filtros_ubicacion_longitud_destino" type="number" step="any" name="long_dest">
                    <input class="submit_filtros" onclick="recogerCargasFiltroUbicacion()" type="submit" name="filtros_ubicacion_btn" value="&#8618;">
                </div>
                <div class="seccion_oculta" id="buscador_ubicacion_texto_filtros_admin">
                    <label><?php echo ciudad_pais_origen ?>:</label>
                    <input class="input_filtros" id="filtro_ubicacion_origen" type="text" name="ubi_or">
                    <label class="label_filtros"><?php echo ciudad_pais_destino ?>:</label>
                    <input class="input_filtros" id="filtro_ubicacion_destino" type="text" name="ubi_dest">
                    <input class="submit_filtros" onclick="recogerCargasFiltroUbicacionTexto()" type="submit" name="filtros_ubicacion_texto_btn" value="&#8618;">
                </div>
            </div>
            <section id="lista_cargas_ajax_admin">
            </section>
        </section>

        <section class="seccion_oculta" id="lista_subrutas_admin">
            <div class="titulo titulo_filtros" id="titulo_lista_subrutas_admin">
                <h2><?php echo lista_subrutas_M ?></h2>
            </div>
            <div class="filtros" id="menu_filtros_lista_subrutas_admin">
                <pre><?php echo filtros ?>:</pre>
                <ul class="menu menu_superior" id="menu_filtros_subrutas_admin">
                    <li><a id="opcion1_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(1)"><?php echo id_datalogger ?></a></li>
                    <li><a id="opcion2_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(2)"><?php echo codigo_contenedor ?></a></li>
                    <li><a id="opcion3_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(3)"><?php echo activos_entre_fechas ?></a></li>
                    <li><a id="opcion4_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(4)"><?php echo inactivos_entre_fechas ?></a></li>
                    <li><a id="opcion5_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(5)"><?php echo coordenadas ?></a></li>
                    <li><a id="opcion6_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(6)"><?php echo ubicacion ?></a></li>
                    <li><a id="opcion7_filtro_subrutas" href="javascript:cambiarFiltrosSubrutasAdmin(0)"><?php echo borrar ?></a></li>
                </ul>
            </div>
            <input type="hidden" id="sesion_usuario" value="<?php echo $_SESSION['ss_usuario'] ?>">
            <div class="seccion_oculta" id="buscador_datalogger_filtros_admin_subr">
                <input class="input_filtros" id="filtro_datalogger_cod_subr" type="text" name="id_dat">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroDatalogger()" type="submit" name="filtros_dat_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_contenedor_filtros_admin_subr">
                <input class="input_filtros" id="filtro_contenedor_cod_subr" type="text" name="id_cont">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroContenedor()" type="submit" name="filtros_cont_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_activo_filtros_admin_subr">
                <label><?php echo inicio ?>:</label>
                <input class="input_filtros" id="filtro_activo_fecha1_subr" type="date" name="fec_1">
                <label class="label_filtros"><?php echo finale ?>:</label>
                <input class="input_filtros" id="filtro_activo_fecha2_subr" type="date" name="fec_2">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroActivo()" type="submit" name="filtros_activo_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_inactivo_filtros_admin_subr">
                <label><?php echo inicio ?>:</label>
                <input class="input_filtros" id="filtro_inactivo_fecha3_subr" type="date" name="fec_3">
                <label class="label_filtros"><?php echo finale ?>:</label>
                <input class="input_filtros" id="filtro_inactivo_fecha4_subr" type="date" name="fec_4">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroInactivo()" type="submit" name="filtros_inactivo_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_ubicacion_filtros_admin_subr">
                <label><?php echo latitud_origen ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_latitud_origen_subr" type="number" step="any" name="lat_or">
                <label class="label_filtros"><?php echo longitud_origen ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_longitud_origen_subr" type="number" step="any" name="long_or">
                <label class="label_filtros"><?php echo latitud_destino ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_latitud_destino_subr" type="number" step="any" name="lat_dest">
                <label class="label_filtros"><?php echo longitud_destino ?>:</label>
                <input class="input_filtros" id="filtros_ubicacion_longitud_destino_subr" type="number" step="any" name="long_dest">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroUbicacion()" type="submit" name="filtros_ubicacion_btn" value="&#8618;">
            </div>
            <div class="seccion_oculta" id="buscador_ubicacion_texto_filtros_admin_subr">
                <label><?php echo ciudad_pais_origen ?>:</label>
                <input class="input_filtros" id="filtro_ubicacion_origen_subr" type="text" name="ubi_or">
                <label class="label_filtros"><?php echo ciudad_pais_destino ?>:</label>
                <input class="input_filtros" id="filtro_ubicacion_destino_subr" type="text" name="ubi_dest">
                <input class="submit_filtros" onclick="recogerSubrutasFiltroUbicacionTexto()" type="submit" name="filtros_ubicacion_texto_btn" value="&#8618;">
            </div>
            <section id="lista_subrutas_ajax_admin">
            </section>
        </section>
        
        <section class="seccion_oculta" id="lista_dataloggers_admin">
            <div class="titulo titulo_filtros" id="titulo_info_dataloggers_admin">
                <h2><?php echo lista_dataloggers_M ?></h2>
            </div>
            <div class="filtros" id="filtros_lista_dataloggers_admin">
                <pre><?php echo filtros ?>:</pre>
                <ul class="menu menu_superior" id="menu_filtros_dataloggers_admin">
                    <li><a href="javascript:cambiarFiltrosDataloggersAdmin(1)"><?php echo en_uso ?></a></li>
                    <li><a href="javascript:cambiarFiltrosDataloggersAdmin(2)"><?php echo apagado ?></a></li>
                    <li><a href="javascript:cambiarFiltrosDataloggersAdmin(0)"><?php echo borrar ?></a></li>
                </ul>
            </div>
            <div class="seccion_oculta" id="div_lista_dataloggers_apagados">
                <?php
                if(isset($dataloggers_apagados)){
                    for ( $i = 0, $cant = count( $dataloggers_apagados ); $i < $cant; ++$i ) {
                        $enlace3 = fx_recoger_ultimo_enlace( $cn, $dataloggers_apagados[$i]['code'] );
                        echo '<div class="info_carga con_btn_inv">';
                        if ( $enlace3['load_id'] != null ) {
                            echo '<pre>'.datalogger.' '.$dataloggers_apagados[$i]['code'].'            '.ultima_carga.': '.fx_recoger_loadding__id($cn, $enlace3['load_id']).
                            '            '.contenedor.': '.$enlace3['code'].'</pre>';
                        } else {
                            echo '<pre>'.datalogger.' '.$dataloggers_apagados[$i]['code'].'            '.datalogger_sin_cargas_registradas.'</pre>';
                        }
    
                        echo '<form class="formulario" id="form_lista_dataloggers_apagado_admin_'.$dataloggers_apagados[$i]['code'].'" method="POST" action="">';
                            echo '<input type="hidden" name="session_datalogger" value="'.$_SESSION['ss_usuario'].'">';
                            echo '<input type="hidden" name="codigo_datalogger" value="'.$dataloggers_apagados[$i]['code'].'">';
                            echo '<input type="hidden" name="tipo" value="dataloger">';
                            echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
                        echo '</form>';
    
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="seccion_oculta" id="div_lista_dataloggers_enuso">
                <?php
                if(isset($dataloggers_enuso)){
                    for ( $i = 0, $cant = count( $dataloggers_enuso ); $i < $cant; ++$i ) {
                        $enlace2 = fx_recoger_ultimo_enlace( $cn, $dataloggers_enuso[$i]['code'] );
                        echo '<div class="info_carga con_btn_inv">';
                        echo '<pre>'.datalogger.' '.$dataloggers_enuso[$i]['code'].'            '.carga_actual.': '.fx_recoger_loadding__id($cn, $enlace2['load_id']).
                        '           '.contenedor.': '.$enlace2['code'].'</pre>';
    
                        echo '<form class="formulario" id="form_lista_dataloggers_enuso_admin_'.$dataloggers_enuso[$i]['code'].'" method="POST" action="">';
                            echo '<input type="hidden" name="session_datalogger" value="'.$_SESSION['ss_usuario'].'">';
                            echo '<input type="hidden" name="codigo_datalogger" value="'.$dataloggers_enuso[$i]['code'].'">';
                            echo '<input type="hidden" name="tipo" value="dataloger">';
                            echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
                        echo '</form>';
    
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div id="div_lista_dataloggers_completa">
                <?php
                if(isset($_SESSION['ss_usuario'])){
                    $dataloggers = fx_recoger_dataloggers_entidad( $cn, fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );
                    $dataloggers_enuso = array();
                    $dataloggers_apagados = array();
                    if(isset($dataloggers)){
                        for ( $i = 0, $cant = count( $dataloggers ); $i < $cant; ++$i ) {
                            if ( $dataloggers[$i]['is_active'] == 1 ) {
                                array_push( $dataloggers_enuso, $dataloggers[$i] );
                            } else if ( $dataloggers[$i]['is_active'] == 0 ) {
                                array_push( $dataloggers_apagados, $dataloggers[$i] );
                            }
                            echo '<div class="info_carga con_btn_inv" onmouseover="mostrarDetalles(\'info_dat_'.$dataloggers[$i]['code'].
                            '\')"'.' onmouseout="esconderDetalles(\'info_dat_'.$dataloggers[$i]['code'].'\')">';
                            echo '<pre>'.datalogger.' '.$dataloggers[$i]['code'].'            '.estado.': '.$dataloggers[$i]['is_active'].'</pre>';
                            
                            echo '<form class="formulario" id="form_lista_dataloggers_admin_'.$dataloggers[$i]['code'].'" method="POST" action="">';
                                echo '<input type="hidden" name="session_datalogger" value="'.$_SESSION['ss_usuario'].'">';
                                echo '<input type="hidden" name="codigo_datalogger" value="'.$dataloggers[$i]['code'].'">';
                                echo '<input type="hidden" name="tipo" value="dataloger">';
                                echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
                            echo '</form>';
                            echo '</div>';
                            
                            echo '<div class="info_c" id="info_dat_'.$dataloggers[$i]['code'].'">';
                            if(isset($dataloggers[$i]['code'])){
                                $enlace = fx_recoger_ultimo_enlace( $cn, $dataloggers[$i]['code'] );
                                if(isset($enlace)){
                                    if ( $dataloggers[$i]['is_active'] != 0 ) {
                                        echo '<pre>'.carga_actual.': '.fx_recoger_loadding__id($cn, $enlace['load_id']).' - '.contenedor.': '.$enlace['code'].'</pre>';
                                    } elseif ( $enlace['load_id'] != null ) {
                                        echo '<pre>'.ultima_carga.': '.fx_recoger_loadding__id($cn, $enlace['load_id']).' - '.contenedor.': '.$enlace['code'].'</pre>';
                                    } else {
                                        echo '<pre>'.datalogger_sin_cargas_registradas.'</pre>';
                                    }
                                }
                            }            
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
        </section>
        
        <section class="seccion_oculta" id="lista_productos_admin">
            <div class="titulo" id="titulo_lista_productos_admin">
                <h2><?php echo lista_productos_M ?></h2>
            </div>
            <?php
            $productos = fx_recoger_productos_entidad_unique( $cn, fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ) );
            for ( $i = 0, $cant = count( $productos ); $i < $cant; ++$i ) {
                echo '<div class="info_carga">';
                $l = '<pre>'.$productos[$i]['name'].'         ';
                if ( $productos[$i]['variety'] != null ) {
                    $l .= variedad.': '.$productos[$i]['variety'].'         ';
                }
                echo $l.t_minima.': '.$productos[$i]['min_temp'].'ºC           '.t_maxima.': '.$productos[$i]['max_temp'].'ºC</pre>';
                echo '</div>';
            }
            ?>
        </section>
        
        <section class="seccion_oculta" id="seccion_info_entidad">
            <div class="titulo" id="titulo_info_entidad_admin">
                <h2><?php echo informacion_entidad_M ?></h2>
            </div>
            <form class="formulario" id="form_info_entidad_admin" method="POST" action="">
            <?php
                $entidad = fx_recoger_datos_entidad( $cn, $_SESSION['ss_usuario'] );
                if(isset($entidad)){
                    echo '<input class="input" type="text" value="&#127963;  '.nombre_entidad.':     '.$entidad['name'].'" disabled>';
                    echo '<input class="input" type="text" value="&#128712;  '.tipo.':        '.$entidad['type'].'" disabled>';
                    echo '<input class="input" type="text" value="&#9872;  '.direccion_1.':     '.$entidad['address_1'].'" disabled>';
                    echo '<input class="input" type="text" value="&#9873;  '.direccion_2.':     '.$entidad['address_2'].'" disabled>';
                    echo '<input class="input" type="text" value="&#127968;&#65038;  '.poblacion.':     '.$entidad['population'].'" disabled>';
                    echo '<input class="input" type="text" value="&#127757;&#65038;  '.pais.':     '.$entidad['country'].'" disabled>';
                }
            ?>
            </form>
            <div class="titulo titulo_secundario titulo_filtros" id="titulo_info_empleados_admin">
                <h2><?php echo lista_empleados_M ?></h2>
            </div>
            <div class="filtros" id="filtros_lista_empleados_admin">
                <pre><?php echo filtros ?>:</pre>
                <ul class="menu menu_superior" id="menu_filtros_empleados_admin">
                    <li><a href="javascript:cambiarFiltrosEmpleadosAdmin(1)"><?php echo administradores ?></a></li>
                    <li><a href="javascript:cambiarFiltrosEmpleadosAdmin(2)"><?php echo tecnicos ?></a></li>
                    <li><a href="javascript:cambiarFiltrosEmpleadosAdmin(0)"><?php echo borrar ?></a></li>
                </ul>
            </div>
            <div id="div_lista_empleados_completa">
            <?php
                $usuarios = fx_recoger_usuarios_entidad( $cn, $entidad['id']);
                $usuarios_admins = array();
                $usuarios_tecs = array();
                for ($i = 0, $cant = count($usuarios); $i < $cant; ++$i) {
                    if ($usuarios[$i]['role'] == 'ROLE_ADMIN') {
                        array_push($usuarios_admins, $usuarios[$i]);
                    } else {
                        array_push($usuarios_tecs, $usuarios[$i]);
                    }
                    echo '<div class="info_carga" onmouseover="mostrarDetalles(\'info_usu_'.$i.
                    '\')"'.' onmouseout="esconderDetalles(\'info_usu_'.$i.'\')">';
                    echo '<pre>'.$usuarios[$i]['first_name'].'          '.rol.': '.$usuarios[$i]['role'].'</pre>';
                    echo '</div>';

                    echo '<div class="info_c" id="info_usu_'.$i.'">';
                    echo '<pre>'.email.': '.$usuarios[$i]['email'].'          '.cargo.': '.$usuarios[$i]['position'].'</pre>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="seccion_oculta" id="div_lista_empleados_admins">
                <?php
                for ($i = 0, $cant = count($usuarios_admins); $i < $cant; ++$i) {
                    echo '<div class="info_carga">';
                    echo '<pre>'.$usuarios_admins[$i]['first_name'].'           '.email.': '.$usuarios_admins[$i]['email'].'            Cargo: '.$usuarios_admins[$i]['position'].'</pre>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="seccion_oculta" id="div_lista_empleados_tecs">
                <?php
                for ( $i = 0, $cant = count($usuarios_tecs); $i < $cant; ++$i ) {
                    echo '<div class="info_carga">';
                    echo '<pre>'.$usuarios_tecs[$i]['first_name'].'           '.email.': '.$usuarios_tecs[$i]['email'].'            Cargo: '.$usuarios_tecs[$i]['position'].'</pre>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
        <?php 
            if(!isset($_POST['enviado'])){
                if(!isset($_POST['cod_carga']) && !isset($_POST['codigo']) && !isset($_POST['nombre6']) && !isset($_POST['session_carga']) && !isset($_POST['codigo_datalogger']) && !isset($_POST['cod_subruta'])){
                    require("headers_footers/footer.php");
                }
            }
        ?>