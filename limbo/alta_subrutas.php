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
<section id="alta_subrutas_carga">
    <div class="titulo" id="titulo_alta_subrutas_admin">
        <?php
        echo '<h2>'.subrutas_carga.' '.$_SESSION['cod_carga'].'</h2>';
        ?>
    </div>
    <ul class="menu menu_centrado" id="menu_anadir_subruta">
        <li><a id="opcion_anadir_subruta" href="javascript:anadirSubruta()"><?php echo anadir_subruta ?></a> </li>
        <form class="formulario" id="form_terminar_alta_subrutas" method="POST" action="">
        <input type="hidden" name="session1" value=<?php echo $_SESSION['ss_usuario'] ?>>
            <div class="boton" id="term_subr_btn">
                <input class="submit" type="submit" name="term_subrutas_btn" value="<?php echo terminar ?>">
            </div>
        </form>
    </ul>
    <section class="seccion_oculta" id="sec_subruta"> 
        <form class="formulario" id="form_alta_subruta" method="POST" action="">
            <input class="input" type="text" placeholder="&#169;   <?php echo codigo ?>" name="codigo" required>
            <input class="input" type="text" placeholder="&#127963;   <?php echo entidad ?>" name="entidad" required>
            <br><br><br>
            <div class="label_form" id="label_fechahora_ini">
                <h4><?php echo fecha_hora_inicio ?>:</h4>
                <input class="input" type="datetime-local" name="fecha_hora_ini">
            </div>
            <div class="label_form" id="label_fechahora_fin">
                <h4><?php echo fecha_hora_final ?>:</h4>
                <input class="input" type="datetime-local" name="fecha_hora_fin">
            </div>
            <br><br><br>
            <div id ="map2"> </div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMap2" async defer></script>
            <br>
            <input type="hidden" name="session2" value=<?php echo $_SESSION['ss_usuario'] ?>>
            <input type="hidden" name="cod_carga" value=<?php echo $_SESSION['cod_carga'] ?>>
            <div class="boton">
                <input class="submit" type="submit" name="sig_subruta_btn" value="<?php echo siguiente ?>">
            </div>
        </form>
    </section>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>