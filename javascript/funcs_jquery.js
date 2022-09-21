$(document).ready(function(){

    // Actualiza dinámicamente las temperaturas predefinidas de productos en
    // el formulario de alta de carga
    $("#select_producto_alta_carga").change(function(){
        let array_producto = $("select[id=select_producto_alta_carga]").val().split("/");
        $("input[name=temp_max]").val(array_producto[1]);
        $("input[name=temp_min]").val(array_producto[2]);
    });

    // Actualiza dinámicamente las temperaturas predefinidas de produtos en
    // el formulario de editar carga
    $("#select_producto_editar_carga").change(function(){
        let array_producto = $("select[id=select_producto_editar_carga]").val().split("/");
        $("input[name=temp_max]").val(array_producto[1]);
        $("input[name=temp_min]").val(array_producto[2]);
    });

    // Actualiza dinámicamente el botón de registro del alta de dataloggers 
    // para técnicos en función de si se ha metido un código válido o no
    $("#cod_alta_dat_tec").on("change keyup paste", function(){
        bien = true;
        $("#dat_ex_tec").find("option").each(function(){
            if ( $(this).val() == $("#cod_alta_dat_tec").val() ) {
                $("#alta_dat_tec_btn").css("display", "none");
                $("#msg_inc_alta_dat_tec").css("display", "block");
                bien = false;
                return false;
            }
            if (bien) {
                $("#alta_dat_tec_btn").css("display", "flex");
                $("#msg_inc_alta_dat_tec").css("display", "none");
            }
        });
    });

    // Actualiza dinámicamente el botón de registro del alta de dataloggers 
    // para admins en función de si se ha metido un código válido o no
    $("#cod_alta_dat_adm").on("change keyup paste", function(){
        bien = true;
        $("#dat_ex_adm").find("option").each(function(){
            if ( $(this).val() == $("#cod_alta_dat_adm").val() ) {
                $("#alta_dat_adm_btn").css("display", "none");
                $("#msg_inc_alta_dat_adm").css("display", "block");
                bien = false;
                return false;
            }
            if (bien) {
                $("#alta_dat_adm_btn").css("display", "flex");
                $("#msg_inc_alta_dat_adm").css("display", "none");
            }
        });
    });

    // Animaciones para mensajes de éxito o error
    if ( $("#opcion5_admin").css("display") !== undefined || $("#opcion5_admin").css("display") !== "none" ) {
        setTimeout(function(){
            $("#opcion5_admin").fadeOut(3000);
        }, 1500);
    }

    if ( $("#opcion6_admin").css("display") !== undefined || $("#opcion6_admin").css("display") !== "none" ) {
        setTimeout(function(){
            $("#opcion6_admin").fadeOut(3000);
        }, 1500);
    }

});