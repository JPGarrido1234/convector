<?php
require($_SERVER['DOCUMENT_ROOT']."/languages/idioma.php");
require($_SERVER['DOCUMENT_ROOT']."/"."languages/".$lang.".php");
require($_SERVER['DOCUMENT_ROOT']."/index.ui.php");
$url_localhost = "http://localhost:8001/";
?>
<!DOCTYPE html>
<html>
    <?php
    require("headers_footers/head.php");
    ?>
    <body>
        <?php
        require("headers_footers/header_inicio.php");
        ?>
        <section class="central">
            <div id="descripcion">
                <p><?php echo descripcion_larga ?></p>
            </div>
            <div id="inicio_sesion">
                <form class="formulario" id="form_inicio_sesion" method="POST" action="">
                    <div class="label_form">
                        <h4>&#9993;  <?php echo correo_electronico ?>:</h4>
                        <input class="input" type="email" name="email" required>
                    </div>
                    <div class="label_form">
                        <h4>&#9919;  <?php echo contrasena ?>:</h4>
                        <input class="input" type="password" name="password" required>
                    </div>
                    <input type="hidden" name="enviado" value="enviado"/>
                    <div class="boton" id="form_inicio_sesion_btn">
                        <input class="submit" type="submit" value="<?php echo acceso_M ?>">
                    </div>
                </form>
            </div>
        </section>
        <?php
        require("headers_footers/footer.php");
        ?>
    </body>
</html>