<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_editar_dataloggers">
    <ul class="menu menu_superior" id="menu_opciones_editar_dataloggers">
        <li>
            <a id="opcion1_editar_dataloggers" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_editar_dataloggers" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="editar_dataloggers_detalle_carga">
    <div class="titulo" id="titulo_editar_dataloggers_detalle_carga">
        <?php echo '<h2>'.dataloggers_carga.' '.$_SESSION['cod_carga'].'</h2>'; ?>
    </div>
    <?php
    $enlaces_carga = fx_recoger_dataloggers_carga( $cn, $_SESSION['cod_carga'] );
    $num_enlaces = count( $enlaces_carga );
    $dataloggers_disp = fx_recoger_dataloggers_disponibles( $cn, fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ), $_SESSION['cod_carga'] );
    $carga = fx_recoger_carga_con_privilegios( $cn, $_SESSION['cod_carga'], $_SESSION['ss_usuario'] );
    if ( $carga['num_contenedores'] != 0 ) {
        $cont = $carga['num_contenedores'];
    } else {
        $cont = 8;
    }
    ?>
    <form class="formulario" id="form_editar_dataloggers_detalle_carga" method="POST" action="">
        <?php
        for ( $i = 0; $i < $cont; ++$i ) {
            echo '<div class="label_form" id="label_edit_dat_'.$i.'">';
                echo '<h4>&#128223;&#65038;   '.datalogger.' '.($i+1).':</h4>';
                echo '<select id="select_edit_dat_'.$i.'" name="edit_dat_'.$i.'">';
                    echo '<option value="">'.no_anadir_datalogger.'</option>';
                    if ( $i < $num_enlaces ) {
                        echo '<option value="'.$enlaces_carga[$i]['datalogger'].'" selected>'.datalogger.' '.$enlaces_carga[$i]['datalogger'].'</option>';
                    }
                    for ( $j = 0, $cant = count( $dataloggers_disp ); $j < $cant; ++$j ) {
                        if ( $enlaces_carga[$i]['datalogger'] != $dataloggers_disp[$j] ) {
                            echo '<option value="'.$dataloggers_disp[$j].'">'.datalogger.' '.$dataloggers_disp[$j].'</option>';
                        }
                    }
                echo '</select>';
            echo '</div>';

            echo '<div class="label_form">';
                echo '<h4>&#128505;  '.codigo_contenedor_asociado.':</h4>';
                if ( $i < $num_enlaces ) {
                    echo '<input class="input" type="text" value="'.$enlaces_carga[$i]['contenedor'].'" name="edit_cont_'.$i.'">';
                } else {
                    echo '<input class="input" type="text" placeholder="'.sin_establecer_m.'" name="edit_cont_'.$i.'">';
                }
            echo '</div>';

            if ( $i != 7 ) {
                echo '<br><br><br>';
            }
        }
        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
        echo '<input type="hidden" name="cod_carga" value="'.$_SESSION['cod_carga'].'">';
        ?>
        <div class="boton">
            <input class="submit" type="submit" name="editar_dataloggers_end_btn" value="<?php echo siguiente ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>