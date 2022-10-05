<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST['codigo_carga']) && !isset($_POST['cod_subruta']) && !isset($_POST['codigo_datalogger'])){
    require("headers_footers/header_principal.php");
}
        
 if(!isset($_POST['codigo_carga']) && !isset($_POST['cod_subruta']) && !isset($_POST['codigo_datalogger'])){ ?>
<section class="menu_opciones_superadmin">
    <ul class="menu menu_superior" id="menu_superadmin">
        <li><a id="opcion1_superadmin" href="javascript:cambiarMenuSuperadmin(1)"><?php echo informacion_entidades ?></a></li>
        <li><a id="opcion2_superadmin" href="javascript:cambiarMenuSuperadmin(2)"><?php echo alta_entidades ?></a></li>
        <li><a id="opcion3_superadmin" href="javascript:cambiarMenuSuperadmin(3)"><?php echo alta_administradores ?></a></li>
        <li><a id="opcion4_superadmin" href="index.php"><?php echo cerrar_sesion; if(isset($_SESSION)){session_destroy();} ?></a></li>
    </ul>
</section>
<section style="color:green;">
<?php if(isset($msgNotice)){ ?>
    <span><?php echo $msgNotice; ?></span>
<?php } ?>
</section>
<?php } ?>
<section class="seccion_oculta" id="lista_entidades_superadmin">
    <div class="busqueda_entidad">
        <label><?php echo entidad ?>:</label>
        <form id="form_info_entidad" method="POST" action="javascript:desplegarSubmenuEntidadSuperadmin()">
            <select name="select_entidad_superadmin" id="select_entidad_superadmin">
                <?php
                $entidades = fx_recoger_entidades( $cn );
                for ( $i = 0, $cant = count( $entidades ); $i < $cant; ++$i ) {
                    echo '<option value="'.$entidades[ $i ][ 'name' ].'">'.$entidades[ $i ][ 'name' ].'  -  '.$entidades[ $i ][ 'type' ].'</option>';
                }
                ?>
            </select>
            <div id="info_entidad_btn">
                <input class="submit" type="submit" value="<?php echo buscar ?>">
            </div>
        </form>
    </div>
</section>
<section class="seccion_oculta" id="submenu_entidad_superadmin">
    <input type="hidden" id="sesion_usuario" value="<?php echo $_SESSION['ss_usuario'] ?>">
    <ul class="menu submenu_superior" id="submenu_entidad_superadmin">
        <li><a class="opcion0_menu" id="opcion0_submenu_entidad_superadmin" href="javascript:desplegarBuscadorEntidadSuperadmin()"></a></li>
        <li><a id="opcion1_submenu_entidad_superadmin" onclick="abrirListaCargas()" href="#"><?php echo lista_cargas ?></a></li>
        <li><a id="opcion2_submenu_entidad_superadmin" onclick="abrirListaSubrutas()" href="#"><?php echo lista_subrutas ?></a></li>
        <li><a id="opcion3_submenu_entidad_superadmin" onclick="recogerDataloggers()" href="#"><?php echo lista_dataloggers ?></a></li>
        <li><a id="opcion4_submenu_entidad_superadmin" onclick="recogerProductos()" href="#"><?php echo lista_productos ?></a></li>
        <li><a id="opcion5_submenu_entidad_superadmin" onclick="recogerInformacionEntidad()" href="#"><?php echo informacion_entidad ?></a></li>
    </ul>
</section>
<section id="contenido_ajax_superadmin">
</section>
<section class="seccion_oculta" id="alta_entidad_superadmin">
    <div class="titulo" id="titulo_alta_entidad">
        <h2><?php echo alta_entidad_M ?></h2>
    </div>
    <form class="formulario" id="form_alta_entidad" method="POST" action="">
        <div class="label_form">
            <h4>&#127963;  <?php echo nombre_entidad ?>:</h4>
            <input class="input" type="text" name="nombre_entidad" id="alta_ent_nomb" required>
        </div>
        <div class="label_form">
            <h4>&#128712;  <?php echo tipo ?>:</h4>
            <select name="tipo" id="alta_ent_tipo" required>
                <option value=""><?php echo selecciona_tipo ?></option>
                <option value="Transportista"><?php echo transportista ?></option>
                <option value="Productor"><?php echo productor ?></option>
                <option value="Operador Logístico"><?php echo operador_logistico ?></option>
                <option value="Distribuidor"><?php echo distribuidor ?></option>
            </select>
        </div>
        <div class="label_form">
            <h4>&#9872;  <?php echo direccion_1 ?>:</h4>
            <input class="input" type="text" name="direccion1" id="alta_ent_dire" required>
        </div>
        <div class="label_form">
            <h4>&#9873;  <?php echo direccion_2 ?>:</h4>
            <input class="input" type="text" name="direccion2">
        </div>
        <div class="label_form">
            <h4>&#127757;&#65038;  <?php echo pais ?>:</h4>
            <select name="pais" id="alta_ent_pais" required>
                <?php include("general/paises.php"); ?>
            </select>
        </div>
        <div class="label_form">
            <h4>&#127968;&#65038;  <?php echo poblacion ?>:</h4>
            <input class="input" type="text" name="poblacion" id="alta_ent_pobl" required>
        </div>
        <br><br><br><br>
        <div class="label_form">
            <h4>&#128104;&#65038;  <?php echo nombre_administrador ?>:</h4>
            <input class="input" type="text" name="nombre_admin" required>
        </div>
        <div class="label_form">
            <h4>&#127891;&#65038;  <?php echo cargo ?>:</h4>
            <input class="input" type="text" name="cargo1" required>
        </div>
        <div class="label_form">
            <h4>&#9993;  <?php echo correo_electronico ?>:</h4>
            <input class="input" type="email" name="email1" required>
        </div>
        <div class="label_form">
            <h4>&#9919;  <?php echo contrasena_provisional ?>:</h4>
            <input class="input" type="password" name="password1" required>
        </div>
        <input type="hidden" name="rol1" value="Administrador">
        <input type="hidden" name="session" value=<?php echo $_SESSION['ss_usuario'] ?>>
        <div class="boton" id="alta_entidad_btn">
            <input class="submit" type="submit" name="alta_ent_sa_btn" value="<?php echo registrar_entidad ?>">
        </div>
    </form>
</section>
<section class="seccion_oculta" id="alta_admin_superadmin">
    <div class="titulo" id="titulo_alta_admin">
        <h2><?php echo alta_administrador_M ?></h2>
    </div>
    <?php
    $entidades = fx_recoger_entidades( $cn );
    ?>
    <form class="formulario" id="form_alta_admin" method="POST" action="">
        <div class="label_form">
            <h4>&#127963;  <?php echo entidad ?>:</h4>
            <select name="entidad2" required>
                <option value=""><?php echo selecciona_entidad ?></option>
                <?php for ( $i = 0, $cant = count( $entidades ); $i < $cant; ++$i ) {
                        echo '<option value="'.$entidades[$i]['name'].'">'.$entidades[$i]['name'].'</option>';
                    } ?>
            </select>
        </div>
        <div class="label_form">
            <h4>&#128104;&#65038;  <?php echo nombre_administrador ?>:</h4>
            <input class="input" type="text" name="nombre_admin2" required>
        </div>
        <div class="label_form">
            <h4>&#127891;&#65038;  <?php echo cargo ?>:</h4>
            <input class="input" type="text" name="cargo2" required>
        </div>
        <div class="label_form">
            <h4>&#9993;  <?php echo correo_electronico ?>:</h4>
            <input class="input" type="email" name="email2" required>
        </div>
        <div class="label_form">
            <h4>&#9919;  <?php echo contrasena_provisional ?>:</h4>
            <input class="input" type="password" name="password2" required>
        </div>
        <input type="hidden" name="session2" value=<?php echo $_SESSION['ss_usuario'] ?>>
        <div class="boton" id="alta_admin_btn">
            <input class="submit" type="submit" name="alta_admin_sa_btn" value="<?php echo registrar_administrador ?>">
        </div>
    </form>
</section>
<?php
if(!isset($_POST['enviado'])){
    if(!isset($_POST['codigo_carga']) && !isset($_POST['cod_subruta']) && !isset($_POST['codigo_datalogger'])){
        require("headers_footers/footer.php");
    }
}
?> 

                        