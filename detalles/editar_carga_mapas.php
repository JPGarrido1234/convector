<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_editar_mapas">
    <ul class="menu menu_superior" id="menu_opciones_editar_mapas">
        <li>
            <a id="opcion1_editar_mapas" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_editar_mapas" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="editar_mapas_carga">
    <div class="titulo" id="titulo_editar_mapas_carga">
        <?php
        echo '<h2>'.origen_destino_carga.' '.$_SESSION['cod_carga'].'</h2>';
        $carga = fx_recoger_carga_con_privilegios( $cn, $_SESSION['cod_carga'], $_SESSION['ss_usuario'] );
        ?>
    </div>
    <div id="map5"> </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMap5" async defer></script>
    <form class="formulario" id="form_editar_carga_mapas" method="POST" action="">
        <input type="hidden" id="lat_or_hid" value="<?php echo $carga['latitud_origen'] ?>">
        <input type="hidden" id="long_or_hid" value="<?php echo $carga['longitud_origen'] ?>">
        <input type="hidden" id="lat_dest_hid" value="<?php echo $carga['latitud_destino'] ?>">
        <input type="hidden" id="long_dest_hid" value="<?php echo $carga['longitud_destino'] ?>">
        <br><br>
        <div class="label_form">
            <h4>&#11016;  <?php echo origen ?>:</h4>
            <input class="input" id="nombre_origen_carga_editar_input" type="text" value="<?php echo $carga['nombre_origen'] ?>" name="origen">
        </div>
        <div class="label_form">
            <h4>&#11019;  <?php echo destino ?>:</h4>
            <input class="input" id="nombre_destino_carga_editar_input" type="text" value="<?php echo $carga['nombre_destino'] ?>" name="destino">
        </div>
        <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
        <input type="hidden" name="cod_carga" value=<?php echo $_SESSION['cod_carga'] ?>>
        <div class="boton" id="form_editar_carga_mapas_btn">
            <input class="submit" type="submit" name="btn_sig2" value="<?php echo siguiente ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>