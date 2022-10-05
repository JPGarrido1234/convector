<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <?php
        require($_SERVER['DOCUMENT_ROOT']."/languages/idioma.php");
        require($_SERVER['DOCUMENT_ROOT']."/"."languages/".$lang.".php");
    ?>
    <head>
        <?php
            require($_SERVER['DOCUMENT_ROOT']."/headers_footers/head_maps.php");
        ?>
    </head>
    <?php
    require($_SERVER['DOCUMENT_ROOT']."/index.ui.php");

    if(!isset($_SESSION['ss_usuario'])){
        ?>
        <body>
            <?php
            require("headers_footers/header_inicio.php");
            ?>
            <section class="container">
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
                        <div style="color:red;" class="p-3 mb-2"><?php if(isset($msgLogin)){echo $msgLogin;} ?></div>
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
        <?php 
    }else if(!isset( $_SESSION['enviado'] ) && !isset($_GET['entidad']) && !isset($_SESSION['ss_usuario'])){
    ?>
    <body>
        <?php
        require("headers_footers/header_inicio.php");
        ?>
        <section class="container">
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
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
        <script>
            var bscoords = require('bscoords');
            bscoords.init({
                // API key to use OpenCellID
                'openCellIDApiKey': 'pk.bf5c70d45847fb80762bfd1dc8e26335',

                // socket timeout in milliseconds
                'timeout': 1000
            });
        </script>
    </body>
    <?php 
    }
    ?>
</html>
