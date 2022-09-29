<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_alta_mapas_subr">
    <ul class="menu menu_superior" id="menu_opciones_alta_mapas_subr">
        <li>
            <a id="opcion1_alta_mapas_subr" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_alta_mapas_subr" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="alta_mapas_subrutas">
    <div class="titulo" id="titulo_alta_mapas_subrutas">
        <?php echo '<h2>'.origen_destino_subruta.' '.$_SESSION['cod_subruta'].'</h2>'; ?>
    </div>
    <div id= "map4"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMap4" async defer></script>
    <br>
    <form class="formulario" id="form_alta_mapas_subrutas" method="POST" action="">
        <div class="label_form">
            <h4>&#11016;   <?php echo origen ?>:</h4>
            <input class="input" id="nombre_origen_subruta_input" type="text" name="origen">
        </div>
        <div class="label_form">
            <h4>&#11019;   <?php echo destino ?>:</h4>
            <input class="input" id="nombre_destino_subruta_input" type="text" name="destino">
        </div>
        <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
        <input type="hidden" name="cod_subruta" value=<?php echo $_SESSION['cod_subruta'] ?>>
        <input type="hidden" name="num_vehiculos" value=<?php echo $_SESSION['num_vehiculos'] ?>>
        <div class="boton" id="form_alta_mapas_subrutas_btn">
            <input class="submit" type="submit" name="mapas_subr_sig" value="<?php echo siguiente ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>
