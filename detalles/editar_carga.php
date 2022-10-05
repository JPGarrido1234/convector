<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_editar_carga">
    <ul class="menu menu_superior" id="menu_opciones_editar_carga">
        <li>
            <a id="opcion1_editar_carga" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_editar_carga" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="editar_carga_principal">
    <div class="titulo titulo_editar_borrar" id="titulo_detalle_carga">
        <?php
        echo '<h2>'.carga.' '.$_SESSION['cod_carga'].'</h2>';
        ?>
    </div>
    <form class="formulario" id="form_editar_carga" method="POST" action="">
        <?php
        $carga = fx_recoger_carga_all( $cn, $_SESSION['cod_carga'] );
        ?>
        <div class="label_form">
            <h4>&#127963;  <?php echo entidad ?>:</h4>
            <input class="input" type="text" value="<?php echo fx_recoger_entidad__id($cn, $carga['entity_id']) ?>" name="entidad" disabled>
        </div>
        <div class="label_form">
            <h4>&#128104;&#65038;   <?php echo responsable ?>:</h4>
            <select name="responsable">
                <?php
                $usuarios = fx_recoger_usuarios_entidad( $cn, $carga['entity_id'] );
                for ( $i = 0, $cant = count( $usuarios ); $i < $cant; ++$i ) {
                    if ( $usuarios[$i]['id'] == $carga['supervisor_id'] ) {
                        echo '<option value="'.$usuarios[$i]['email'].'" selected>'.usuario.' '.($i+1).' - '.$usuarios[$i]['first_name'].' ('.$usuarios[$i]['role'].')</option>';
                    } else { echo '<option value="'.$usuarios[$i]['email'].'">'.usuario.' '.($i+1).' - '.$usuarios[$i]['first_name'].' ('.$usuarios[$i]['role'].')</option>'; }
                }
                ?>
            </select>
        </div>
        <br><br>
        <div class="label_form">
            <h4>&#128467;   <?php echo fecha_inicio ?>:</h4>
            <input class="input" type="date" value="<?php echo $carga['start'] ?>" name="fecha_ini">
        </div>
        <div class="label_form">
            <h4>&#128467;   <?php echo fecha_final ?>:</h4>
            <input class="input" type="date" value="<?php echo $carga['end'] ?>" name="fecha_fin">
        </div>
        <div class="label_form">
            <h4>&#128467;   <?php echo fecha_caducidad ?>:</h4>
            <input class="input" type="date" value="<?php echo $carga['expiry'] ?>" name="fecha_cadu">
        </div>
        <br><br>
        <div class="label_form">
            <h4>&#128505;  <?php echo numero_contenedores ?> (<?php echo unidades_m ?>):</h4>
            <input class="input" type="number" step="1" value="<?php echo $carga['containers'] ?>" name="num_cont">
        </div>
        <div class="label_form">
            <h4>&#128505;  <?php echo kilos_totales ?> (<?php echo kgs_m ?>):</h4>
            <input class="input" type="number" step="1" value="<?php echo $carga['weight'] ?>" name="kgs_totales">
        </div>
        <div class="label_form">
            <h4>&#128230;&#65038;  <?php echo producto ?>:</h4>
            <select id="select_producto_editar_carga" name="sel_prod">
                <?php
                $productos = fx_recoger_productos_entidad_unique( $cn, $carga['entity_id'] );
                if ( $carga['product_id'] == null ) {
                    echo '<option value="" selected></option>';
                }
                $prod_carga = fx_recoger_producto( $cn, $carga['product_id'] );
                $other = false;
                for ( $i = 0, $cant = count($productos); $i < $cant; ++$i ) {

                    if ( $productos[$i]['name'] == $prod_carga['name'] && $productos[$i]['variety'] == $prod_carga['variety'] && 
                    ( $productos[$i]['min_temp'] != $prod_carga['min_temp'] || $productos[$i]['max_temp'] != $prod_carga['max_temp'] ) ) {
                        $other = true;
                        $prod_rep = $productos[$i]['code'];
                    }

                    if ( $prod_rep != $productos[$i]['code'] ) {
                        if ( $productos[$i]['variety'] != null ) {
                            $pr = '<option value="'.$productos[$i]['code']."/".$productos[$i]["max_temp"]."/".$productos[$i]["min_temp"].'"';
                            if ( $productos[$i]['id'] == $carga['product_id'] ) {
                                $pr .= ' selected';
                            }
                            $pr .= '>'.$productos[$i]['name'].' - '.variedad.': '.$productos[$i]['variety'].'</option>';
                            echo $pr;
                        } else {
                            $pr = '<option value="'.$productos[$i]['code']."/".$productos[$i]["max_temp"]."/".$productos[$i]["min_temp"].'"';
                            if ( $productos[$i]['id'] == $carga['product_id'] ) {
                                $pr .= ' selected';
                            }
                            $pr .= '>'.$productos[$i]['name'].' - '.variedad.': '.sin_establecer_m.'</option>';
                            echo $pr;
                        }
                    }
                }

                if ( $other ) {
                    if ( $prod_carga['variety'] != null ) {
                        echo '<option value="'.$prod_carga['code']."/".$prod_carga["max_temp"]."/".$prod_carga["min_temp"].'" selected>'.$prod_carga['name'].' - '.variedad.': '.$prod_carga['variety'].'</option>';
                    } else {
                        echo '<option value="'.$prod_carga['code']."/".$prod_carga["max_temp"]."/".$prod_carga["min_temp"].'" selected>'.$prod_carga['name'].' - '.variedad.': '.sin_establecer_m.'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="label_form">
            <h4>&#127777;&#11014;  <?php echo t_maxima ?> (<?php echo oc ?>):</h4>
            <input class="input" type="number" step="0.01" value="<?php echo $prod_carga['max_temp'] ?>" name="temp_max">
        </div>
        <div class="label_form">
            <h4>&#127777;&#11015;  <?php echo t_minima ?> (<?php echo oc ?>):</h4>
            <input class="input" type="number" step="0.01" value="<?php echo $prod_carga['min_temp'] ?>" name="temp_min">
        </div>
        <input type="hidden" name="session" value="<?php echo $_SESSION['ss_usuario'] ?>">
        <input type="hidden" name="cod_carga" value="<?php echo $carga['code'] ?>">
        <div class="boton" id="sig_editar_carga_btn">
            <input class="submit" type="submit" name="btn_sig1" value="<?php echo siguiente ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>