<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
session_start();
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_subruta.php");
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
        <section class="menu_opciones_editar_subruta">
            <ul class="menu menu_superior" id="menu_opciones_editar_subruta">
                <li><a id="opcion1_editar_subruta" href="../detalle_carga.php"><?php echo volver ?></a></li> <!-- Revisar esto -->
                <li><a id="opcion2_editar_subruta" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                    INFORMACIÓN DE LA SUBRUTA SELECCIONADA
        ====================================================================================================================================== -->
        <section id="editar_subruta_principal">
            <div class="titulo titulo_editar_borrar" id="titulo_detalle_subruta">
                <?php
                echo '<h2>'.subruta.' '.$_SESSION['cod_subruta'].'</h2>';
                ?>
            </div>
            <form class="formulario" id="form_editar_subruta" method="POST" action="">
                <?php
                $subruta = fx_recoger_subruta_con_privilegios( $cn, $_SESSION['cod_subruta'], $_SESSION['ss_usuario'] );
                ?>
                <div class="label_form">
                    <h4>&#128234;&#65038;   <?php echo carga ?>:</h4>
                    <input class="input" type="text" value="<?php echo $subruta['carga'] ?>" name="carga" disabled>
                </div>
                <div class="label_form">
                    <h4>&#127963;   <?php echo entidad ?>:</h4>
                    <input class="input" type="text" value="<?php echo $subruta['entidad'] ?>" name="entidad" disabled>
                </div>
                <div class="label_form">
                    <h4>&#128104;&#65038;   <?php echo responsable ?>:</h4>
                    <?php if ( $subruta['responsable'] != null ) { ?>
                        <input class="input" type="email" value="<?php echo $subruta['responsable'] ?>" name="responsable" required>
                    <?php } else { ?>
                        <input class="input" type="email" placeholder="<?php echo sin_establecer_m ?>" name="responsable">
                    <?php } ?>
                </div>
                <br><br>
                <div class="label_form">
                    <h4>&#128467;   <?php echo fecha_hora_inicio ?>:</h4>
                    <?php
                    if ( $subruta['fecha_hora_inicio'] != null ) { $fh_ini = date('Y-m-d\TH:i', strtotime($subruta['fecha_hora_inicio'])); }
                    else { $fh_ini = null; }
                    ?>
                    <input class="input" type="datetime-local" value="<?php echo $fh_ini ?>" name="fecha_hora_ini">
                </div>
                <div class="label_form">
                    <h4>&#128467;   <?php echo fecha_hora_final ?>:</h4>
                    <?php
                    if ( $subruta['fecha_hora_final'] != null ) { $fh_fin = date('Y-m-d\TH:i', strtotime($subruta['fecha_hora_final'])); }
                    else { $fh_fin = null; }
                    ?>
                    <input class="input" type="datetime-local" value="<?php echo $fh_fin ?>" name="fecha_hora_fin">
                </div>
                <input type="hidden" name="session" value="<?php echo $_SESSION['ss_usuario'] ?>">
                <input type="hidden" name="cod_subruta" value="<?php echo $_SESSION['cod_subruta'] ?>">
                <div class="boton" id="sig_editar_subruta_btn">
                    <input class="submit" type="submit" name="btn_sig_subr1" value="<?php echo siguiente ?>">
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