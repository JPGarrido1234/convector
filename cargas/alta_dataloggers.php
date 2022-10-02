<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_alta_dataloggers">
    <ul class="menu menu_superior" id="menu_opciones_alta_dataloggers">
        <li>
            <a id="opcion1_alta_dataloggers" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_alta_dataloggers" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="alta_dataloggers_admin">
    <div class="titulo" id="titulo_alta_dataloggers_admin">
        <?php
        echo '<h2>'.dataloggers_carga.' '.$_SESSION['cod_carga'].'</h2>';
        ?>
    </div>
    <?php
    $dataloggers = fx_recoger_dataloggers_off_entidad( $cn, fx_recoger_datos_entidad( $cn, $_SESSION['ss_usuario'] )['id'], $_SESSION['cod_carga'] );
    ?>
    <form class="formulario" id="form_alta_dataloggers_admin" method="POST" action="">
        <?php
        
        if ( !empty( $_SESSION['num_cont_carga'] ) ) {
            $c = $_SESSION['num_cont_carga'];
        } else {
            $c = 8;
        }
        for ( $i = 0; $i < $c; ++$i ) {
            echo '<div class="label_form" id="label_dat_'.$i.'">';
                echo '<h4>&#128223;&#65038;   '.datalogger.' '.($i+1).':</h4>';
                echo '<select id="select_dat_'.$i.'" name="dat_'.$i.'">';
                    echo '<option value="">'.no_anadir_datalogger.'</option>';
                    for ( $j = 0, $cant = count( $dataloggers ); $j < $cant; ++$j ) {
                        echo '<option value="'.$dataloggers[$j].'">'.datalogger.' '.$dataloggers[$j].'</option>';
                    }
                echo '</select>';
            echo '</div>';

            echo '<div class="label_form">';
                echo '<h4>&#128505;   '.codigo_contenedor_asociado.':</h4>';
                echo '<input class="input" type="text" name="cont_'.$i.'">';
            echo '</div>';
            
            if ( $i != $c - 1 ) {
                echo '<br><br><br>';
            } else {
                echo '<br>';
            }
        }
        echo '<input type="hidden" name="enviado_log" value="enviado_log">';
        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
        echo '<input type="hidden" name="cod_carga" value="'.$_SESSION['cod_carga'].'">';
        echo '<input type="hidden" name="num_cont_carga" value="'.$_SESSION['num_cont_carga'].'">';
        
        ?>
        <div class="boton">
            <input class="submit" type="submit" name="alta_dataloggers_btn" value="<?php echo siguiente ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>