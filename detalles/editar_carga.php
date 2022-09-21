<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_carga.php");
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
        <section class="menu_opciones_editar_carga">
            <ul class="menu menu_superior" id="menu_opciones_editar_carga">
                <li><a id="opcion1_editar_carga" href="../detalle_carga.php"><?php echo volver ?></a></li> <!-- Revisar esto -->
                <li><a id="opcion2_editar_carga" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                    INFORMACIÓN DE LA CARGA SELECCIONADA
        ====================================================================================================================================== -->
        <section id="editar_carga_principal">
            <div class="titulo titulo_editar_borrar" id="titulo_detalle_carga">
                <?php
                echo '<h2>'.carga.' '.$_SESSION['cod_carga'].'</h2>';
                ?>
            </div>
            <form class="formulario" id="form_editar_carga" method="POST" action="">
                <?php
                $carga = fx_recoger_carga( $cn, $_SESSION['cod_carga'] );
                ?>
                <div class="label_form">
                    <h4>&#127963;  <?php echo entidad ?>:</h4>
                    <input class="input" type="text" value="<?php echo $carga['entidad'] ?>" name="entidad" disabled>
                </div>
                <div class="label_form">
                    <h4>&#128104;&#65038;   <?php echo responsable ?>:</h4>
                    <select name="responsable">
                        <?php
                        $usuarios = fx_recoger_usuarios_entidad( $cn, $carga['entidad'] );
                        for ( $i = 0, $cant = count( $usuarios ); $i < $cant; ++$i ) {
                            if ( $usuarios[$i]['email'] == $carga['responsable'] ) {
                                echo '<option value="'.$usuarios[$i]['email'].'" selected>'.usuario.' '.($i+1).' - '.$usuarios[$i]['nombre'].' ('.$usuarios[$i]['rol'].')</option>';
                            } else { echo '<option value="'.$usuarios[$i]['email'].'">'.usuario.' '.($i+1).' - '.$usuarios[$i]['nombre'].' ('.$usuarios[$i]['rol'].')</option>'; }
                        }
                        ?>
                    </select>
                </div>
                <br><br>
                <div class="label_form">
                    <h4>&#128467;   <?php echo fecha_inicio ?>:</h4>
                    <input class="input" type="date" value="<?php echo $carga['fecha_inicio'] ?>" name="fecha_ini">
                </div>
                <div class="label_form">
                    <h4>&#128467;   <?php echo fecha_final ?>:</h4>
                    <input class="input" type="date" value="<?php echo $carga['fecha_final'] ?>" name="fecha_fin">
                </div>
                <div class="label_form">
                    <h4>&#128467;   <?php echo fecha_caducidad ?>:</h4>
                    <input class="input" type="date" value="<?php echo $carga['fecha_caducidad'] ?>" name="fecha_cadu">
                </div>
                <br><br>
                <div class="label_form">
                    <h4>&#128505;  <?php echo numero_contenedores ?> (<?php echo unidades_m ?>):</h4>
                    <input class="input" type="number" step="1" value="<?php echo $carga['num_contenedores'] ?>" name="num_cont">
                </div>
                <div class="label_form">
                    <h4>&#128505;  <?php echo kilos_totales ?> (<?php echo kgs_m ?>):</h4>
                    <input class="input" type="number" step="1" value="<?php echo $carga['kgs_totales'] ?>" name="kgs_totales">
                </div>
                <div class="label_form">
                    <h4>&#128230;&#65038;  <?php echo producto ?>:</h4>
                    <select id="select_producto_editar_carga" name="sel_prod">
                        <?php
                        $productos = fx_recoger_productos_entidad_unique( $cn, $carga['entidad'] );
                        if ( $carga['producto'] == null ) {
                            echo '<option value="" selected></option>';
                        }
                        $prod_carga = fx_recoger_producto( $cn, $carga['producto'] );
                        $other = false;
                        for ( $i = 0, $cant = count($productos); $i < $cant; ++$i ) {

                            if ( $productos[$i]['nombre'] == $prod_carga['nombre'] && $productos[$i]['variedad'] == $prod_carga['variedad'] && 
                            ( $productos[$i]['t_min'] != $prod_carga['t_min'] || $productos[$i]['t_max'] != $prod_carga['t_max'] ) ) {
                                $other = true;
                                $prod_rep = $productos[$i]['codigo'];
                            }

                            if ( $prod_rep != $productos[$i]['codigo'] ) {
                                if ( $productos[$i]['variedad'] != null ) {
                                    $pr = '<option value="'.$productos[$i]['codigo']."/".$productos[$i]["t_max"]."/".$productos[$i]["t_min"].'"';
                                    if ( $productos[$i]['codigo'] == $carga['producto'] ) {
                                        $pr .= ' selected';
                                    }
                                    $pr .= '>'.$productos[$i]['nombre'].' - '.variedad.': '.$productos[$i]['variedad'].'</option>';
                                    echo $pr;
                                } else {
                                    $pr = '<option value="'.$productos[$i]['codigo']."/".$productos[$i]["t_max"]."/".$productos[$i]["t_min"].'"';
                                    if ( $productos[$i]['codigo'] == $carga['producto'] ) {
                                        $pr .= ' selected';
                                    }
                                    $pr .= '>'.$productos[$i]['nombre'].' - '.variedad.': '.sin_establecer_m.'</option>';
                                    echo $pr;
                                }
                            }
                        }

                        if ( $other ) {
                            if ( $prod_carga['variedad'] != null ) {
                                echo '<option value="'.$prod_carga['codigo']."/".$prod_carga["t_max"]."/".$prod_carga["t_min"].'" selected>'.$prod_carga['nombre'].' - '.variedad.': '.$prod_carga['variedad'].'</option>';
                            } else {
                                echo '<option value="'.$prod_carga['codigo']."/".$prod_carga["t_max"]."/".$prod_carga["t_min"].'" selected>'.$prod_carga['nombre'].' - '.variedad.': '.sin_establecer_m.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="label_form">
                    <h4>&#127777;&#11014;  <?php echo t_maxima ?> (<?php echo oc ?>):</h4>
                    <input class="input" type="number" step="0.01" value="<?php echo $prod_carga['t_max'] ?>" name="temp_max">
                </div>
                <div class="label_form">
                    <h4>&#127777;&#11015;  <?php echo t_minima ?> (<?php echo oc ?>):</h4>
                    <input class="input" type="number" step="0.01" value="<?php echo $prod_carga['t_min'] ?>" name="temp_min">
                </div>
                <input type="hidden" name="session" value="<?php echo $_SESSION['ss_usuario'] ?>">
                <input type="hidden" name="cod_carga" value="<?php echo $carga['codigo'] ?>">
                <div class="boton" id="sig_editar_carga_btn">
                    <input class="submit" type="submit" name="btn_sig1" value="<?php echo siguiente ?>">
                </div>
            </form>
        </section>
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
        ?>
    </body>
</html>