<?php
require_once($_SERVER['DOCUMENT_ROOT']."/bd/cn.php");
require_once($_SERVER['DOCUMENT_ROOT']."/bd/clases.php");
require_once($_SERVER['DOCUMENT_ROOT']."/languages/es.php");
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
    <?php
    echo '<div class="titulo" id="titulo_info_dataloggers_entidad_superadmin">';
        echo '<h2>'.lista_dataloggers_de_M.' '.strtoupper( $_GET['entidad'] ).'</h2>';
    echo '</div>';
    ?>
    <div class="filtros" id="filtros_lista_dataloggers_superadmin">
        <pre><?php echo filtros ?>:</pre>
        <ul class="menu menu_superior" id="menu_filtros_dataloggers_superadmin">
            <li><a href="javascript:cambiarFiltrosDataloggersSuperadmin(1)"><?php echo en_uso ?></a></li>
            <li><a href="javascript:cambiarFiltrosDataloggersSuperadmin(2)"><?php echo apagado ?></a></li>
            <li><a href="javascript:cambiarFiltrosDataloggersSuperadmin(0)"><?php echo borrar ?></a></li>
        </ul>
    </div>
    <div id="div_lista_dataloggers_completa_sa">
        <?php
        $dataloggers = fx_recoger_dataloggers_entidad( $cn, $_GET['entidad'] );
        $dataloggers_enuso = array();
        $dataloggers_apagados = array();
        for ( $i = 0, $cant = count( $dataloggers ); $i < $cant; ++$i ) {
            if ( $dataloggers[$i]['estado'] == 'En uso' ) {
                array_push( $dataloggers_enuso, $dataloggers[$i] );
            } else if ( $dataloggers[$i]['estado'] == 'Apagado' ) {
                array_push( $dataloggers_apagados, $dataloggers[$i] );
            }
            echo '<div class="info_carga con_btn_inv" onmouseover="mostrarDetalles(\'info_dat_sa_'.$dataloggers[$i]['codigo'].
            '\')"'.' onmouseout="esconderDetalles(\'info_dat_sa_'.$dataloggers[$i]['codigo'].'\')">';
            echo '<pre>'.datalogger.' '.$dataloggers[$i]['codigo'].'            '.estado.': '.$dataloggers[$i]['estado'].'</pre>';
            
            echo '<form class="formulario" id="form_lista_dataloggers_superadmin_'.$dataloggers[$i]['codigo'].'" method="POST" action="">';
                echo '<input type="hidden" name="session_datalogger" value="'.$_GET['usu'].'">';
                echo '<input type="hidden" name="codigo_datalogger" value="'.$dataloggers[$i]['codigo'].'">';
                echo '<input type="hidden" name="entidad_datalogger" value="'.$_GET['entidad'].'">';
                echo '<input type="hidden" name="tipo" value="dataloger">';
                echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
            echo '</form>';
            
            echo '</div>';
            
            echo '<div class="info_c" id="info_dat_sa_'.$dataloggers[$i]['codigo'].'">';
            $enlace = fx_recoger_ultimo_enlace( $cn, $dataloggers[$i]['codigo'] );
            if ( $dataloggers[$i]['estado'] != "Apagado" ) {
                echo '<pre>'.carga_actual.': '.$enlace['carga'].' - '.contenedor.': '.$enlace['contenedor'].'</pre>';
            } elseif ( $enlace['carga'] != null ) {
                echo '<pre>'.ultima_carga.': '.$enlace['carga'].' - '.contenedor.': '.$enlace['contenedor'].'</pre>';
            } else {
                echo '<pre>'.datalogger_sin_cargas_registradas.'</pre>';
            }
            echo '</div>';
        }
        ?>
    </div>
    <div class="seccion_oculta" id="div_lista_dataloggers_enuso_sa">
        <?php
        for ( $i = 0, $cant = count( $dataloggers_enuso ); $i < $cant; ++$i ) {
            $enlace2 = fx_recoger_ultimo_enlace( $cn, $dataloggers_enuso[$i]['codigo'] );
            echo '<div class="info_carga con_btn_inv">';
            echo '<pre>'.datalogger.' '.$dataloggers_enuso[$i]['codigo'].'            '.carga_actual.': '.$enlace2['carga'].
            '           '.contenedor.': '.$enlace2['contenedor'].'</pre>';
            
            echo '<form class="formulario" id="form_lista_dataloggers_enuso_superadmin_'.$dataloggers_enuso[$i]['codigo'].'" method="POST" action="">';
                echo '<input type="hidden" name="session_datalogger" value="'.$_GET['usu'].'">';
                echo '<input type="hidden" name="codigo_datalogger" value="'.$dataloggers_enuso[$i]['codigo'].'">';
                echo '<input type="hidden" name="entidad_datalogger" value="'.$_GET['entidad'].'">';
                echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
            echo '</form>';
            
            echo '</div>';
        }
        ?>
    </div>
    <div class="seccion_oculta" id="div_lista_dataloggers_apagados_sa">
        <?php
        for ( $i = 0, $cant = count( $dataloggers_apagados ); $i < $cant; ++$i ) {
            $enlace3 = fx_recoger_ultimo_enlace( $cn, $dataloggers_apagados[$i]['codigo'] );
            echo '<div class="info_carga con_btn_inv">';
            if ( $enlace3['carga'] != null ) {
                echo '<pre>'.datalogger.' '.$dataloggers_apagados[$i]['codigo'].'            '.ultima_carga.': '.$enlace3['carga'].
                '            '.contenedor.': '.$enlace3['contenedor'].'</pre>';
            } else {
                echo '<pre>'.datalogger.' '.$dataloggers_apagados[$i]['codigo'].'            '.datalogger_sin_cargas_registradas.'</pre>';
            }

            echo '<form class="formulario" id="form_lista_dataloggers_apagados_superadmin_'.$dataloggers_apagados[$i]['codigo'].'" method="POST" action="">';
                echo '<input type="hidden" name="session_datalogger" value="'.$_GET['usu'].'">';
                echo '<input type="hidden" name="codigo_datalogger" value="'.$dataloggers_apagados[$i]['codigo'].'">';
                echo '<input type="hidden" name="entidad_datalogger" value="'.$_GET['entidad'].'">';
                echo '<input class="btn_inv" name="inv_btn_push_dat" type="submit">';
            echo '</form>';

            echo '</div>';
        }
        ?>
    </div>
</body>
</html>