<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section id="menu_opciones_detalle_datalogger">
    <ul class="menu menu_superior" id="menu_opciones_detalle_datalogger">
        <li>
            <a id="opcion1_detalle_datalogger" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_detalle_datalogger" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section style="color:green;">
    <?php
    if(isset($_POST['msgData'])){
        echo '<span>'.$_POST['msgData'].'</span>';
    }
    ?>
</section>
<section id="detalle_datalogger_principal">
    <div class="titulo" id="titulo_detalle_datalogger">
        <?php echo '<h2>'.datalogger.' '.fx_recoger_datalogger__id($cn, $_SESSION['cod_datalogger']).'</h2>'; ?>
    </div>
    <?php
    $datalogger = fx_recoger_datalogger($cn, $_SESSION['cod_datalogger']);
    $enlace = fx_recoger_ultimo_enlace( $cn, $datalogger['code']);
    if ( ($datalogger['is_active'] == 0) && !( isset( $_SESSION['entidad_dat'] ) ) ) {
        echo '<ul class="menu menu_superior btns_dar_baja centered">';
            echo '<li>';
            if ( $datalogger['is_active'] != 0 ) {
                echo '<a class="a_des" id="btn_dar_baja" href="#">&#10008;';
                    echo '<form class="formulario form2" id="form_dar_baja_dat" method="POST" action="">';
                        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                        echo '<input type="hidden" name="cod_datalogger" value="'.$datalogger['code'].'">';
                        if ( isset( $_SESSION['entidad_dat'] ) ) {
                            echo '<input type="hidden" name="entidad_dat" value="'.$_SESSION['entidad_dat'].'">';
                        }
                        echo '<input class="submit_esp" name="inv_btn_baja" type="submit" value="'.dar_baja.'">';
                    echo '</form>';
                echo '</a>';
            } else {
                echo '<a class="a_des" id="btn_dar_alta" href="#">&#10004;';
                    echo '<form class="formulario form2" id="form_dar_baja_dat" method="POST" action="">';
                        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                        echo '<input type="hidden" name="cod_datalogger" value="'.$datalogger['code'].'">';
                        if ( isset( $_SESSION['entidad_dat'] ) ) {
                            echo '<input type="hidden" name="entidad_dat" value="'.$_SESSION['entidad_dat'].'">';
                        }
                        echo '<input class="submit_esp" name="inv_btn_alta" type="submit" value="'.dar_alta.'">';
                    echo '</form>';
                echo '</a>';
            }
            echo '</li>';
        echo '</ul>';
    }
    ?>
    <form class="formulario" id="form_detalle_datalogger" method="POST" action="">
        <?php
        echo '<div class="label_form">';
            echo '<h4>&#128269;&#65038;   '.estado.':</h4>';
            if($datalogger['is_active'] == 1){
                $estadoDataLogger = "Activado";
            }else{
                $estadoDataLogger = "Desactivado";
            }
            echo '<input class="input" type="text" value="'.$estadoDataLogger.'" disabled>';
        echo '</div>';
        echo '<div class="label_form">';
            if ( $datalogger['is_active'] == 1 ) {
                echo '<h4>&#128234;&#65038;   '.carga_activa.':</h4>';
            } else {
                echo '<h4>&#128235;&#65038;   '.ultima_carga.':</h4>';
            }
            if(isset($enlace['load_id'])){
                echo '<input class="input" type="text" value="'.fx_recoger_loadding__id($cn, $enlace['load_id']).'" disabled>';
            }
        echo '</div>';
        echo '<div class="label_form">';
            echo '<h4>&#128274;&#65038;   '.contenedor.':</h4>';
            if(isset($enlace['code'])){
                echo '<input class="input" type="text" value="'.$enlace['code'].'" disabled>';
            }
        echo '</div>';
        ?>
    </form>
    <br><br><br>
    <ul class="menu menu_centrado" id="submenu_detalles_datalogger">
        <li><a id="opcion1_submenu_detalle_datalogger" href="javascript:cambiarApartadoDetalleDatalogger(1)"><?php echo ver_cargas ?></a></li>
        <li><a id="opcion2_submenu_detalle_datalogger" href="javascript:cambiarApartadoDetalleDatalogger(2)"><?php echo ver_alertas ?></a></li>
    </ul>
    <div class="seccion_oculta" id="lista_cargas_detalle_datalogger">
        <div class="titulo titulo_secundario titulo_filtros" id="titulo_lista_cargas_detalle_datalogger">
            <h2><?php echo lista_cargas_M ?></h2>
        </div>
        <?php
        //$cargas = array();
        if ( !( isset( $_SESSION['entidad_dat'] ) ) ) {
            $cargas = fx_recoger_cargas_datalogger( $cn, $_SESSION['cod_datalogger'], $_SESSION['ss_usuario'] );
        } else {
            echo $_SESSION['entidad_dat'];
            $cargas = fx_recoger_cargas_datalogger_entidad( $cn, $_SESSION['cod_datalogger'], $_SESSION['entidad_dat'] );
        }

        
        if (isset($cargas)){
            if(count($cargas) >0){
                for ($i = 0, $cant = count($cargas); $i < $cant; ++$i) {
                    echo '<div class="info_carga con_btn_inv" id="car_com_detda_'.$cargas[$i]['code'].'"'.
                    ' onmouseenter="cambiarColorPrivi(\'info_ca_com1_detda_'.$cargas[$i][ 'code'].'\', \''.$cargas[$i]['lvl_privilegios'].'\')"'.
                    ' onmouseover="mostrarDetalles(\'info_ca_com1_detda_'.$cargas[$i]['code'].'\')"'.
                    ' onmouseout="esconderDetalles(\'info_ca_com1_detda_'.$cargas[$i]['code'].'\')">';
                    if ( $cargas[$i]['product_id'] != null ) {
                        echo '<a id="ca_detda_'.$cargas[$i]['code'].'" href="#">'.carga.' '.$cargas[$i]['code'].
                        ' - '.producto.': '.fx_recoger_nombre_producto( $cn, $cargas[$i]['product_id'] ).' - '.responsable.': '.
                        fx_recoger_nombre( $cn, $cargas[$i][ 'supervisor_id' ] ).'</a>';
                    } else {
                        echo '<a id="ca_detda_'.$cargas[$i]['code'].'" href="#">'.carga.' '.$cargas[ $i ][ 'code' ].
                        ' - '.responsable.': '.fx_recoger_nombre( $cn, $cargas[ $i ][ 'supervisor_id' ] ).'</a>';
                    }
                    echo '<form class="formulario" id="form_lista_cargas_detalle_datalogger_'.$cargas[ $i ][ 'code' ].'" method='.'"POST" action="">';
                        echo '<input type="hidden" name="session_carga" value="'.$_SESSION['ss_usuario'].'">';
                        echo '<input type="hidden" name="codigo_carga" value="'.$cargas[$i]['code'].'">';
                        echo '<input type="hidden" name="lvl_privilegios_carga" value="'.$cargas[$i]['lvl_privilegios'].'">';
                        echo '<input class="btn_inv" name="inv_btn_push" type="submit">'; // Mirar aquí detalles para botón invisible
                    echo '</form>';
                    echo '</div>';
        
                    echo '<div class="info_c" id="info_ca_com1_detda_'.$cargas[ $i ][ 'code' ].'">';
                    $pre = '<pre>'.fecha_inicio.': ';
                    if ( $cargas[ $i ][ 'start' ] != null ) {
                        $pre .= $cargas[ $i ][ 'start' ].'        '.fecha_final.': ';
                    } else {
                        $pre .= sin_establecer_m.'        '.fecha_final.': ';
                    } if ( $cargas[ $i ][ 'end' ] != null ) {
                        $pre .= $cargas[ $i ][ 'end' ].'        '.fecha_caducidad.': ';
                    } else {
                        $pre .= sin_establecer_m.'        '.fecha_caducidad.': ';
                    } if ( $cargas[ $i ][ 'expiry' ] != null ) {
                        $pre .= $cargas[ $i ][ 'expiry' ].'</pre>';
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
            }else{
                echo "Lista de cargas del datalogger vacía";
            }
        }
        ?>
    </div>
    <div class="seccion_oculta" id="lista_alertas_detalle_datalogger"> <!-- POR HACER -->
    <?php
        if (!isset( $_SESSION['entidad_dat'])) {
            $cargas = fx_recoger_cargas_datalogger($cn, $_SESSION['cod_datalogger'], $_SESSION['ss_usuario']);
            if(isset($cargas)){
                for ( $i = 0, $cant = count($cargas); $i < $cant; ++$i ) {
                    ?>
                    <div style="width:100%;">
                    CARGA
                    <?php   
                    echo 'código : '.$cargas[$i]['code'].' - Producto : '.$cargas[$i]['product_id'].' - Nombre Destino : '.$cargas[$i]['destiny'].'- Nombre Origen : '.$cargas[$i]['origin'].' - Cliente:'.$cargas[$i]['supervisor_id'].' - Fecha Inicio :'.$cargas[$i]['start'].' - Fecha Fin: '.$cargas[$i]['end'].' - Fecha caducidad: '.$cargas[$i]['expiry'];
                    $producto = fx_recoger_producto_by_id($cn, $cargas[$i]['product_id']);
                    ?>
                    </div>
                    <?php
                }
            }
        } 
    ?>   
        </div>
        <div style="width:100%;">
            DATALOGGER
            <?php 
            if(isset($producto)){
                echo 'Código contenedor : '.$enlace['contenedor'].' - Código datalogger : '.$_SESSION['cod_datalogger'].' - Temperatura Inferior : '.$producto['t_min'].' - Temperatura Superior: '.$producto['t_max'];
            }
            ?>
        </div>
        <div style="width:100%;">
            MAPA
            <div id="mapAlertas"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMapAlertas" async defer></script>
        </div>
        <div style="width:100%;">
            LISTA DE ALERTAS
            <?php 
                $alarmas = fx_show_alarm_datalogger($cn, $_SESSION['cod_datalogger']); 
                if(isset($alarmas)){
                    ?>
                    <ul class="list-group">
                        <?php
                        for ($i = 0, $cant = count($alarmas); $i < $cant; ++$i) {
                         if($alarmas[$i]['in_range'] == 0){ ?>
                                <li class="list-group-item list-group-item-success">
                                    <span>[Temperatura : <?php echo $alarmas[$i]['temperature']; ?>]</span>
                                    <span>[Fuera de rango]</span>
                                    <span>[Station: <?php echo $alarmas[$i]['station']; ?>]</span>
                                    <span>[Fecha/Hora : <?php echo $alarmas[$i]['timestamp']; ?>]</span>
                                </li>
                            <?php 
                            }else{
                            ?>
                                <li class="list-group-item list-group-item-danger">
                                    <span>[Temperatura : <?php echo $alarmas[$i]['temperature']; ?>]</span>
                                    <span>[Dentro de rango]</span>
                                    <span>[Station: <?php echo $alarmas[$i]['station']; ?>]</span>
                                    <span>[Fecha/Hora : <?php echo $alarmas[$i]['timestamp']; ?>]</span>
                                </li>
                            <?php
                            }
                        ?>
                    </ul>
                    <?php
                    }
                }
            ?>
            
        </div>
    </div>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>
