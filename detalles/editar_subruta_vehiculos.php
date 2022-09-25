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
    require($_SERVER['DOCUMENT_ROOT']."/headers_footers/head.php");
    ?>
    <!-- <body> -->
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
        ?>
        <!-- ======================================================================================================================================
                                                         MENÚ HORIZONTAL DE OPCIONES
        ====================================================================================================================================== -->
        <section class="menu_opciones_editar_vehiculos_subr">
            <ul class="menu menu_superior" id="menu_opciones_editar_vehiculos_subr">
                <li><a id="opcion1_editar_vehiculos_subr" href="../inicio_admin.php"><?php echo volver ?></a></li>
                <li><a id="opcion2_editar_vehiculos_subr" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                    FORMULARIO PARA EDITAR VEHÍCULOS EN LA SUBRUTA
        ====================================================================================================================================== -->
        <section id="editar_vehiculos_subruta">
            <div class="titulo" id="titulo_editar_vehiculos_subruta">
                <?php
                echo '<h2>'.vehiculos_subruta.' '.$_SESSION['cod_subruta'].'</h2>';
                $vehiculos = fx_recoger_vehiculos_subruta( $cn, $_SESSION['cod_subruta'] );
                $num_vehiculos = count( $vehiculos );
                ?>
            </div>

            <div class="centered" id="div_form_num_vehiculos">
                <form class="formulario inline" id="form_num_vehiculos" method="POST" action="javascript:desplegarNumeroVehiculos()">
                    <label><?php echo numero_vehiculos ?>:</label>
                    <select name="select_num_vehiculos" id="select_num_vehiculos">
                        <?php
                        for ( $j = 0; $j < 5; ++$j ) {
                            if ( $j + 1 == $num_vehiculos ) {
                                echo '<option value="'.($j+1).'" selected>'.($j+1).'</option>';
                            } else {
                                echo '<option value="'.($j+1).'">'.($j+1).'</option>';
                            }
                        }
                        ?>
                    </select>
                    <div id="div_actualizar_num_vehiculos">
                        <input class="submit" type="submit" value="&#8635;">
                    </div>
                </form>
            </div>

            <form class="formulario" id="form_editar_vehiculos_subruta" method="POST" action="">
                <?php
                for ( $i = 0; $i < 5; ++$i ) {
                    if ( !( $i < $num_vehiculos ) ) {
                        echo '<div id="seccion_vehiculo_'.($i+1).'" class="seccion_oculta">';
                    } else {
                        echo '<div id="seccion_vehiculo_'.($i+1).'">';
                    }
                    echo '<div class="label_form" id="label_edit_vehiculo_'.$i.'">';
                        echo '<h4>&#128666;&#65038;  '.tipo_vehiculo.' '.($i+1).':</h4>';
                        if ( $i < $num_vehiculos ) {
                            if ( $vehiculos[$i]['tipo'] != null ) {
                                echo '<input class="input" id="edit_tipo_'.($i+1).'" type="text" value="'.$vehiculos[$i]['tipo'].'" name="edit_tipo_'.($i+1).'">';
                            } else {
                                echo '<input class="input" id="edit_tipo_'.($i+1).'" type="text" placeholder="'.sin_establecer_m.'" name="edit_tipo_'.($i+1).'">';
                            }
                        } else {
                            echo '<input class="input" id="edit_tipo_'.($i+1).'" type="text" name="edit_tipo_'.($i+1).'">';
                        }
                    echo '</div>';
                    echo '<div class="label_form">';
                        echo '<h4>&#1011'.($i+2).';  '.matricula.':</h4>';
                        if ( $i < $num_vehiculos ) {
                            echo '<input class="input" id="edit_matricula_'.($i+1).'" type="text" value="'.$vehiculos[$i]['matricula'].'" name="edit_matricula_'.($i+1).'">';
                        } else {
                            echo '<input class="input" id="edit_matricula_'.($i+1).'" type="text" name="edit_matricula_'.($i+1).'">';
                        }
                    echo '</div>';
                    echo '<br><br>';
                    echo '</div>';
                }
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input type="hidden" name="cod_subruta" value="'.$_SESSION['cod_subruta'].'">';
                ?>
                <div class="boton">
                    <input class="submit" type="submit" name="btn_sig_subr3" value="<?php echo terminar ?>">
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