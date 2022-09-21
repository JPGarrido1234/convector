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
    $entidad = fx_recoger_info_entidad( $cn, $_GET['entidad'] );
    echo '<div class="titulo" id="titulo_informacion_entidad_superadmin">';
        echo '<h2>'.informacion_de_M.' '.strtoupper( $_GET['entidad'] ).'</h2>';
    echo '</div>';

    echo '<form class="formulario" id="form_info_entidad_admin" method="POST" action="">';
        echo '<input class="input" type="text" value="&#127963;  '.nombre_entidad.':     '.$entidad['nombre'].'" disabled>';
        echo '<input class="input" type="text" value="&#128712;  '.tipo.':        '.$entidad['tipo'].'" disabled>';
        echo '<input class="input" type="text" value="&#9872;  '.direccion_1.':     '.$entidad['direccion1'].'" disabled>';
        echo '<input class="input" type="text" value="&#9873;  '.direccion_2.':     '.$entidad['direccion2'].'" disabled>';
        echo '<input class="input" type="text" value="&#127968;&#65038;  '.poblacion.':     '.$entidad['poblacion'].'" disabled>';
        echo '<input class="input" type="text" value="&#127757;&#65038;  '.pais.':     '.$entidad['pais'].'" disabled>';
    echo '</form>';
    ?>

    <div class="titulo titulo_secundario titulo_filtros" id="titulo_info_empleados_admin">
        <h2><?php echo lista_empleados_M ?></h2>
    </div>

    <div class="filtros" id="menu_filtros_empleados_superadmin">
        <pre><?php echo filtros ?>:</pre>
        <ul class="menu menu_superior" id="menu_filtros_empleados_superadmin">
            <li><a href="javascript:cambiarFiltrosEmpleadosSuperadmin(1)"><?php echo administradores ?></a></li>
            <li><a href="javascript:cambiarFiltrosEmpleadosSuperadmin(2)"><?php echo tecnicos ?></a></li>
            <li><a href="javascript:cambiarFiltrosEmpleadosSuperadmin(0)"><?php echo borrar ?></a></li>
        </ul>
    </div>

    <div id="div_lista_empleados_completa_sa">
        <?php
        $usuarios = fx_recoger_usuarios_entidad( $cn, $entidad['nombre'] );
        $usuarios_admins = array();
        $usuarios_tecs = array();
        for ( $i = 0, $cant = count( $usuarios ); $i < $cant; ++$i ) {
            if ( $usuarios[$i]['rol'] == 'Administrador' ) {
                array_push( $usuarios_admins, $usuarios[$i] );
            } else {
                array_push( $usuarios_tecs, $usuarios[$i] );
            }
            echo '<div class="info_carga" onmouseover="mostrarDetalles(\'info_usu_sa_'.$i.
            '\')"'.' onmouseout="esconderDetalles(\'info_usu_sa_'.$i.'\')">';
            echo '<pre>'.$usuarios[$i]['nombre'].'          '.rol.': '.$usuarios[$i]['rol'].'</pre>';
            echo '</div>';

            echo '<div class="info_c" id="info_usu_sa_'.$i.'">';
            echo '<pre>'.email.': '.$usuarios[$i]['email'].'          '.cargo.': '.$usuarios[$i]['cargo'].'</pre>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="seccion_oculta" id="div_lista_empleados_admins_sa">
        <?php
        for ( $i = 0, $cant = count( $usuarios_admins ); $i < $cant; ++$i ) {
            echo '<div class="info_carga">';
            echo '<pre>'.$usuarios_admins[$i]['nombre'].'           '.email.': '.$usuarios_admins[$i]['email'].'            '.cargo.': '.$usuarios_admins[$i]['cargo'].'</pre>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="seccion_oculta" id="div_lista_empleados_tecs_sa">
        <?php
        for ( $i = 0, $cant = count( $usuarios_tecs ); $i < $cant; ++$i ) {
            echo '<div class="info_carga">';
            echo '<pre>'.$usuarios_tecs[$i]['nombre'].'           '.email.': '.$usuarios_tecs[$i]['email'].'            '.cargo.': '.$usuarios_tecs[$i]['cargo'].'</pre>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>