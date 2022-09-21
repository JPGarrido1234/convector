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
    $cargas = fx_recoger_cargas_entidad( $cn, $_GET['entidad'] );
    echo '<div class="titulo" id="titulo_info_cargas_entidad_superadmin">';
        echo '<h2>'.lista_cargas_de_M.' '.strtoupper( $_GET['entidad'] ).'</h2>';
    echo '</div>';
    ?>

    <div class="tiene_filtros" id="filtros_lista_cargas_superadmin"> <!-- Filtros --> 
        <div class="filtros" id="menu_filtros_lista_cargas_superadmin">
            <pre><?php echo filtros ?>:</pre>
            <ul class="menu menu_superior" id="menu_filtros_cargas_superadmin">
                <li><a id="opcion1_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(1)"><?php echo id_datalogger ?></a></li>
                <li><a id="opcion2_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(2)"><?php echo codigo_contenedor ?></a></li>
                <li><a id="opcion3_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(3)"><?php echo activos_entre_fechas ?></a></li>
                <li><a id="opcion4_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(4)"><?php echo inactivos_entre_fechas ?></a></li>
                <li><a id="opcion5_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(5)"><?php echo coordenadas ?></a></li>
                <li><a id="opcion6_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(6)"><?php echo ubicacion ?></a></li>
                <li><a id="opcion7_filtro_cargas_sa" href="javascript:cambiarFiltrosCargasSuperadmin(0)"><?php echo borrar ?></a></li>
            </ul>
        </div>
        <input type="hidden" id="sesion_usuario" value="<?php echo $_SESSION['ss_usuario'] ?>">
        <input type="hidden" id="valor_entidad" value="<?php echo $_GET['entidad'] ?>">
        <div class="seccion_oculta" id="buscador_datalogger_filtros_superadmin">
            <input class="input_filtros" id="filtro_datalogger_cod_sa" type="text" name="id_dat">
            <input class="submit_filtros" onclick="recogerCargasFiltroDataloggerSA()" type="submit" name="filtros_dat_btn" value="&#8618;">
        </div>
        <div class="seccion_oculta" id="buscador_contenedor_filtros_superadmin">
            <input class="input_filtros" id="filtro_contenedor_cod_sa" type="text" name="id_cont">
            <input class="submit_filtros" onclick="recogerCargasFiltroContenedorSA()" type="submit" name="filtros_cont_btn" value="&#8618;">
        </div>
        <div class="seccion_oculta" id="buscador_activo_filtros_superadmin">
            <label><?php echo inicio ?>:</label>
            <input class="input_filtros" id="filtro_activo_fecha1_sa" type="date" name="fec_1">
            <label class="label_filtros"><?php echo finale ?>:</label>
            <input class="input_filtros" id="filtro_activo_fecha2_sa" type="date" name="fec_2">
            <input class="submit_filtros" onclick="recogerCargasFiltroActivoSA()" type="submit" name="filtros_activo_btn" value="&#8618;">
        </div>
        <div class="seccion_oculta" id="buscador_inactivo_filtros_superadmin">
            <label><?php echo inicio ?>:</label>
            <input class="input_filtros" id="filtro_inactivo_fecha3_sa" type="date" name="fec_3">
            <label class="label_filtros"><?php echo finale ?>:</label>
            <input class="input_filtros" id="filtro_inactivo_fecha4_sa" type="date" name="fec_4">
            <input class="submit_filtros" onclick="recogerCargasFiltroInactivoSA()" type="submit" name="filtros_inactivo_btn" value="&#8618;">
        </div>
        <div class="seccion_oculta" id="buscador_ubicacion_filtros_superadmin">
            <label><?php echo latitud_origen ?>:</label>
            <input class="input_filtros" id="filtros_ubicacion_latitud_origen_sa" type="number" step="any" name="lat_or">
            <label class="label_filtros"><?php echo longitud_origen ?>:</label>
            <input class="input_filtros" id="filtros_ubicacion_longitud_origen_sa" type="number" step="any" name="long_or">
            <label class="label_filtros"><?php echo latitud_destino ?>:</label>
            <input class="input_filtros" id="filtros_ubicacion_latitud_destino_sa" type="number" step="any" name="lat_dest">
            <label class="label_filtros"><?php echo longitud_destino ?>:</label>
            <input class="input_filtros" id="filtros_ubicacion_longitud_destino_sa" type="number" step="any" name="long_dest">
            <input class="submit_filtros" onclick="recogerCargasFiltroUbicacionSA()" type="submit" name="filtros_ubicacion_btn" value="&#8618;">
        </div>
        <div class="seccion_oculta" id="buscador_ubicacion_texto_filtros_superadmin">
            <label><?php echo ciudad_pais_origen ?>:</label>
            <input class="input_filtros" id="filtro_ubicacion_origen_sa" type="text" name="ubi_or">
            <label class="label_filtros"><?php echo ciudad_pais_destino ?>:</label>
            <input class="input_filtros" id="filtro_ubicacion_destino_sa" type="text" name="ubi_dest">
            <input class="submit_filtros" onclick="recogerCargasFiltroUbicacionTextoSA()" type="submit" name="filtros_ubicacion_texto_btn" value="&#8618;">
        </div>
    </div>

    <section id="lista_cargas_ajax_superadmin"></section>
</body>
</html>