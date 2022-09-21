<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
require($_SERVER['DOCUMENT_ROOT']."/formularios/formularios_detalle_carga.php");
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
        <section class="menu_opciones_editar_subrutas_carga">
            <ul class="menu menu_superior" id="menu_opciones_editar_subrutas_carga">
                <li><a id="opcion1_editar_subrutas_carga" href="../inicio_admin.php"><?php echo volver ?></a></li>
                <li><a id="opcion2_editar_subrutas_carga" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
            </ul>
        </section>
        <!-- ======================================================================================================================================
                                                    LISTA PARA EDITAR SUBRUTAS DE LA CARGA
        ====================================================================================================================================== -->
        <section class="editar_carga_lista_subrutas">
            <div class="titulo" id="titulo_editar_carga_lista_subrutas">
                <?php
                echo '<h2>'.subrutas_carga.' '.$_SESSION['cod_carga'].'</h2>';
                ?>
            </div>
            <?php
            $subrutas = fx_recoger_subrutas_carga( $cn, $_SESSION['cod_carga'], $_SESSION['ss_usuario'] );
            if ( count( $subrutas ) != 0 ) {
                for ( $i = 0, $cant = count( $subrutas ); $i < $cant; ++$i ) {
                    echo '<div class="info_carga con_btn_inv" id="subr_editc_'.$subrutas[$i]['codigo'].'"'.
                    ' onmouseenter="cambiarColorPrivi(\'info_subr_editc_'.$subrutas[$i]['codigo'].'\', \''.$subrutas[$i]['lvl_privilegios'].'\')"'.
                    ' onmouseover="mostrarDetalles(\'info_subr_editc_'.$subrutas[$i]['codigo'].'\')"'.
                    ' onmouseout="esconderDetalles(\'info_subr_editc_'.$subrutas[$i]['codigo'].'\')">';
                        echo '<a id="subr_editc_'.$subrutas[$i]['codigo'].'" href="#">'.subruta.' '.$subrutas[$i]['codigo'].
                        ' - '.entidad.': '.$subrutas[$i]['entidad'].' - '.responsable.': '.$subrutas[$i]['responsable'].'</a>';
    
                        echo '<form class="formulario" id="form_lista_subrutas_editc_'.$subrutas[$i]['codigo'].'" method='.'"POST" action="">';
                            echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                            echo '<input type="hidden" name="cod_subruta" value="'.$subrutas[$i]['codigo'].'">';
                            echo '<input type="hidden" name="lvl_privilegios_subruta" value="'.$subrutas[$i]['lvl_privilegios'].'">';
                            echo '<input class="btn_inv" name="inv_btn_editc" type="submit">';
                        echo '</form>';
    
                    echo '</div>';
    
                    echo '<div class="info_c" id="info_subr_editc_'.$subrutas[$i]['codigo'].'">';
                        $producto = fx_recoger_producto_subruta( $cn, $subrutas[$i]['codigo'] );
                        $pre = '<pre>'.producto.': ';
                        if ( $producto != null ) {
                            $pre .= $producto.'         '.fecha_hora_inicio.': ';
                        } else {
                            $pre .= sin_establecer_m.'         '.fecha_hora_inicio.': ';
                        } if ( $subrutas[$i]['fecha_hora_inicio'] != null ) {
                            $pre .= $subrutas[$i]['fecha_hora_inicio'].'            '.fecha_hora_final.': ';
                        } else {
                            $pre .= sin_establecer_m.'         '.fecha_hora_final.': ';
                        } if ( $subrutas[$i]['fecha_hora_final'] != null ) {
                            $pre .= $subrutas[$i]['fecha_hora_final'].'</pre>';
                        } else {
                            $pre .= sin_establecer_m.'</pre>';
                        }
                        echo $pre;
                    echo '</div>';
                }
                echo '<div class="permisos">
                    <pre class="permisos_titulo">'.permisos.': </pre>
                    <div>
                        <img src="../images/cuadrado_rojo.png" alt="'.rojo.'">
                        <pre>'.ver_editar_borrar.'</pre>
                    </div>
                </div>';
            }
            ?>
            <form class="formulario" id="form_final_editar_cargas" method="POST" action="">
                <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
                <div class="boton" id="form_final_editar_cargas_btn">
                    <input class="submit" type="submit" name="btn_edit_final" value="<?php echo terminar ?>">
                </div>
            </form>
        </section>
        <?php
        require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
        ?>
    </body>
</html>