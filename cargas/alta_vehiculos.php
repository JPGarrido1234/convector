<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_alta_carga.php");
require($_SERVER['DOCUMENT_ROOT']."/general/sesion.php");
?>
<!DOCTYPE html>
<html>
    <?php
    require($_SERVER['DOCUMENT_ROOT']."/headers_footers/head.php");
    ?>
    <body>
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
        ?>
        <!-- ======================================================================================================================================
                                                         MENÚ HORIZONTAL DE OPCIONES
        ====================================================================================================================================== -->
        <section id="menu_opciones_alta_vehiculos_carga">
            <ul class="menu menu_superior" id="menu_opciones_alta_vehiculos_carga">
                <li><a id="opcion1_alta_vehiculos_carga" href="../inicio_admin.php"><?php echo volver ?></a></li>
                <li><a id="opcion2_alta_vehiculos_carga" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                    LISTA PARA INCLUIR VEHÍCULOS EN LA CARGA
        ====================================================================================================================================== -->
        <section id="alta_vehiculos_carga">
            <div class="titulo" id="titulo_alta_vehiculos_carga">
                <?php
                echo '<h2>'.vehiculos_carga.' '.$_SESSION['cod_carga'].'</h2>';
                ?>
            </div>

            <div class="centered" id="div_form_num_vehiculos_carga">
                <form class="formulario inline" id="form_num_vehiculos_carga" method="POST" action="javascript:desplegarNumeroVehiculosCarga()">
                    <label><?php echo numero_vehiculos ?>:</label>
                    <select name="select_num_vehiculos_carga" id="select_num_vehiculos_carga">
                        <?php
                        for ( $j = 0; $j < 5; ++$j ) {
                            echo '<option value="'.($j+1).'">'.($j+1).'</option>';
                        }
                        ?>
                    </select>
                    <div id="div_actualizar_num_vehiculos_carga">
                        <input class="submit" type="submit" value="&#8635;">
                    </div>
                </form>
            </div>

            <form class="formulario" id="form_alta_vehiculos_carga" method="POST" action="">
                <?php
                for ( $i = 0; $i < 5; ++$i ) {
                    if ( $i == 0 ) {
                        echo '<div id="seccion_vehiculo_carga_'.($i+1).'">';
                    } else {
                        echo '<div id="seccion_vehiculo_carga_'.($i+1).'" class="seccion_oculta">';
                    }
                    echo '<div class="label_form" id="label_alta_vehiculo_carga_'.$i.'">';
                        echo '<h4>&#128666;&#65038;  '.tipo_vehiculo.' '.($i+1).':</h4>';
                        echo '<input class="input" id="alta_tipo_'.($i+1).'" type="text" name="tipo_'.($i+1).'">';
                    echo '</div>';
                    echo '<div class="label_form">';
                        echo '<h4>&#1011'.($i+2).';  '.matricula.':</h4>';
                        echo '<input class="input" id="alta_matricula_'.($i+1).'" type="text" name="matricula_'.($i+1).'">';
                    echo '</div>';
                    echo '</div>';
                    echo '<br>';
                }
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input type="hidden" name="cod_carga" value="'.$_SESSION['cod_carga'].'">';
                ?>
                <div class="boton">
                    <input class="submit" type="submit" name="alta_vehiculos_carga_btn" value="<?php echo crear_M ?>">
                </div>
            </form>
        </section>
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
        ?>
    </body>
</html>