<header>
    <div id="header_principal">
        <div id="seleccion_idioma_peq">
            <a href="?lang=en" title="<?php echo ingles ?>">EN</a>
             | 
            <a href="?lang=es" title="<?php echo espanol ?>">ES</a>
        </div>
        <div class="nombre_usuario">
            <h3><?php echo usuario ?>: <?php echo fx_recoger_nombre( $cn, $_SESSION['ss_usuario'] ); ?></h3>
        </div>
        <div class="nombre_usuario">
            <h3><?php echo entidad ?>:<?php echo fx_recoger_entidad( $cn, $_SESSION['ss_usuario'] ); ?></h3>
        </div>
        <div id="logo_ministerio_peq">
            <img title="cdti_logo" src="../images/CDTI.png" alt="<?php echo cdti_M ?>">
        </div>
        <div class="elemento_doble">
            <div id="avion_embebido">
                <div id="titulo_peq">
                    <h3><?php echo descripcion_M ?></h3>
                    <img title="avion_logo" id="avion_logo" src="../images/logo_avion_trans.png" alt="<?php echo logo ?>">
                </div>
            </div>
            <div id="logo_eurostars_peq">
                <img title="eurostars_logo" src="../images/eurostars.png" alt="<?php echo eurostars ?>">
            </div>
        </div>
    </div>
</header>