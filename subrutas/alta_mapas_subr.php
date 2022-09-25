<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
session_start();
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_alta_subruta.php");
require($_SERVER['DOCUMENT_ROOT']."/general/sesion.php");
*/
?>
<!--
<!DOCTYPE html>
<html>
-->
    <?php
    require($_SERVER['DOCUMENT_ROOT']."/headers_footers/head_maps.php");
    ?>
    <!-- <body> -->
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
        ?>
        <!-- ======================================================================================================================================
                                                         MENÚ HORIZONTAL DE OPCIONES
        ====================================================================================================================================== -->
        <section class="menu_opciones_alta_mapas_subr">
            <ul class="menu menu_superior" id="menu_opciones_alta_mapas_subr">
                <li><a id="opcion1_alta_mapas_subr" href="../inicio_admin.php"><?php echo volver ?></a></li>
                <li><a id="opcion2_alta_mapas_subr" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                MAPAS DE GOOGLE MAPS PARA SELECCIONAR LOCALIZACIONES
        ====================================================================================================================================== -->
        <section id="alta_mapas_subrutas">
            <div class="titulo" id="titulo_alta_mapas_subrutas">
                <?php echo '<h2>'.origen_destino_subruta.' '.$_SESSION['cod_subruta'].'</h2>'; ?>
            </div>
            <div id= "map4"> </div>
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
        <!--
    </body>
</html>
-->