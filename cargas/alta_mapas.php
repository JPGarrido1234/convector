<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_alta_mapas">
    <ul class="menu menu_superior" id="menu_opciones_alta_mapas">
        <li>
            <a id="opcion1_alta_mapas" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_alta_mapas" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="alta_mapas_admin">
    <div class="titulo" id="titulo_alta_mapas_admin">
        <?php
        echo '<h2>'.origen_destino_carga.' '.$_SESSION['cod_carga'].'</h2>';
        ?>
    </div>
    <div id ="map"> </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMap" async defer></script>
    <br>
    <form class="formulario" id="form_alta_mapas_admin" method="POST" action="">
        <div class="label_form">
            <h4>&#11016;   <?php echo origen ?>:</h4>
            <input class="input" id="nombre_origen_carga_input" type="text" name="origen">
        </div>
        <div class="label_form">
            <h4>&#11019;   <?php echo destino ?>:</h4>
            <input class="input" id="nombre_destino_carga_input" type="text" name="destino">
        </div>
        <div class="boton" id="form_alta_mapas_admin_btn">
            <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
            <input type="hidden" name="cod_carga" value=<?php echo $_SESSION['cod_carga'] ?>>
            <input type="hidden" name="num_cont_carga" value=<?php echo $_SESSION['num_cont_carga'] ?>>
            <input type="hidden" name="fecha_ini" value=<?php echo $_SESSION['fecha_ini'] ?>>
            <input type="hidden" name="fecha_fin" value=<?php echo $_SESSION['fecha_fin'] ?>>
            <?php
            if ( $_SESSION['fecha_ini'] != null && $_SESSION['fecha_fin'] != null ) {
                $bot = siguiente;
            } else {
                $bot = crear;
            }
            ?>
            <input class="submit" type="submit" name="mapas_sig" value=<?php echo $bot ?>>
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>
