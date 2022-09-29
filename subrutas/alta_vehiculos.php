<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/header_principal.php");
?>
<section id="menu_opciones_alta_vehiculos">
    <ul class="menu menu_superior" id="menu_opciones_alta_vehiculos">
        <li>
            <a id="opcion1_alta_vehiculos" href="#">
            <?php
            echo '<form class="formulario form2" id="form_volver_detalle_carga" method="POST" action="">';
                echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
                echo '<input class="submit_esp" name="inv_btn_volver" type="submit" value="'.volver.'">';
            echo '</form>';
            ?>
            </a>
        </li>
        <li><a id="opcion2_alta_vehiculos" href="../index.php"><?php echo cerrar_sesion; session_destroy(); ?></a></li>
    </ul>
</section>
<section id="alta_vehiculos_subruta">
    <div class="titulo" id="titulo_alta_vehiculos_subruta">
        <?php
        echo '<h2>'.vehiculos_subruta.' '.$_SESSION['cod_subruta'].'</h2>';
        ?>
    </div>
    <form class="formulario" id="form_alta_vehiculos_subruta" method="POST" action="">
        <?php
        $num_vehiculos = $_SESSION['num_vehiculos'];
        if ( $num_vehiculos == null ) {
            $num_vehiculos = 5;
        }
        for ( $i = 0; $i < $num_vehiculos; ++$i ) {
            echo '<div class="label_form" id="label_vehiculo_'.$i.'">';
                echo '<h4>&#128666;&#65038;  '.tipo_vehiculo.' '.($i+1).':</h4>';
                echo '<input class="input" type="text" name="tipo_'.$i.'">';
            echo '</div>';
            echo '<div class="label_form">';
                echo '<h4>&#1011'.($i+2).';  '.matricula.':</h4>';
                echo '<input class="input" type="text" name="matricula_'.$i.'">';
            echo '</div>';
            if ( $i != $num_vehiculos - 1 ) {
                echo '<br><br><br>';
            } else {
                echo '<br>';
            }
        }
        echo '<input type="hidden" name="session" value="'.$_SESSION['ss_usuario'].'">';
        echo '<input type="hidden" name="cod_subruta" value="'.$_SESSION['cod_subruta'].'">';
        echo '<input type="hidden" name="num_vehiculos" value="'.$_SESSION['num_vehiculos'].'">';
        ?>
        <div class="boton">
            <input class="submit" type="submit" name="alta_vehiculos_subruta_btn" value="<?php echo crear_M ?>">
        </div>
    </form>
</section>
<?php
require($_SERVER['DOCUMENT_ROOT']."/headers_footers/footer.php");
?>