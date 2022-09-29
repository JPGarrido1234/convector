<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section class="menu_opciones_editar_mapas_subr">
    <ul class="menu menu_superior" id="menu_opciones_editar_mapas_subr">
        <li>
            <a id="opcion1_editar_mapas_subr" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_editar_mapas_subr" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="editar_mapas_subruta">
    <div class="titulo" id="titulo_editar_mapas_subruta">
        <?php
        echo '<h2>'.origen_destino_subruta.' '.$_SESSION['cod_subruta'].'</h2>';
        $subruta = fx_recoger_subruta_con_privilegios( $cn, $_SESSION['cod_subruta'], $_SESSION['ss_usuario'] );
        ?>
    </div>
    <div id= "map7"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIgR-ebv3xMaS0nXVS_533d3m9xx1LT2o&callback=initMap7" async defer></script>
    <form class="formulario" id="form_editar_subruta_mapas" method="POST" action="">
        <input type="hidden" id="lat_or_hid_subr" value="<?php echo $subruta['latitud_origen'] ?>">
        <input type="hidden" id="long_or_hid_subr" value="<?php echo $subruta['longitud_origen'] ?>">
        <input type="hidden" id="lat_dest_hid_subr" value="<?php echo $subruta['latitud_destino'] ?>">
        <input type="hidden" id="long_dest_hid_subr" value="<?php echo $subruta['longitud_destino'] ?>">
        <br><br>
        <div class="label_form">
            <h4>&#11016;   <?php echo origen ?>:</h4>
            <input class="input" id="nombre_origen_subruta_editar_input" type="text" value="<?php echo $subruta['nombre_origen'] ?>" name="origen">
        </div>
        <div class="label_form">
            <h4>&#11019;   <?php echo destino ?>:</h4>
            <input class="input" id="nombre_destino_subruta_editar_input" type="text" value="<?php echo $subruta['nombre_destino'] ?>" name="destino">
        </div>
        <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
        <input type="hidden" name="cod_subruta" value=<?php echo $_SESSION['cod_subruta'] ?>>
        <div class="boton" id="form_editar_subruta_mapas_btn">
            <input class="submit" type="submit" name="btn_sig_subr2" value="<?php echo siguiente ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>
