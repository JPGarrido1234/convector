/* =============================================================================
                            FUNCIONES CARGAS
============================================================================== */
function abrirListaCargas() { // Superadmin
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("contenido_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "info_entidad/info_cargas.php?entidad=" + entidad, true);
    xmlhttp.send();
    recogerCargasSinFiltroSA2();
}
function recogerCargasSinFiltroSA2() {
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad, true);
    xmlhttp.send();
}
function recogerCargasSinFiltroSA() {
    var entidad = document.getElementById("valor_entidad").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad, true);
    xmlhttp.send();
}
function recogerCargasFiltroDataloggerSA() {
    var datalogger = document.getElementById("filtro_datalogger_cod_sa").value;
    if (datalogger !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad + "&dat_sa=" + datalogger, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroContenedorSA() {
    var contenedor = document.getElementById("filtro_contenedor_cod_sa").value;
    if (contenedor !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad + "&cont_sa=" + contenedor, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroActivoSA() {
    var fec1 = document.getElementById("filtro_activo_fecha1_sa").value;
    var fec2 = document.getElementById("filtro_activo_fecha2_sa").value;
    if (fec1 !== "" || fec2 !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad + "&fec1_sa=" + fec1 + "&fec2_sa=" + fec2, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroInactivoSA() {
    var fec3 = document.getElementById("filtro_inactivo_fecha3_sa").value;
    var fec4 = document.getElementById("filtro_inactivo_fecha4_sa").value;
    if (fec3 !== "" || fec4 !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad + "&fec3_sa=" + fec3 + "&fec4_sa=" + fec4, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroUbicacionSA() {
    var lat_or = document.getElementById("filtros_ubicacion_latitud_origen_sa").value;
    var long_or = document.getElementById("filtros_ubicacion_longitud_origen_sa").value;
    var lat_dest = document.getElementById("filtros_ubicacion_latitud_destino_sa").value;
    var long_dest = document.getElementById("filtros_ubicacion_longitud_destino_sa").value;
    if ( ( lat_or !== "" && long_or !== "" ) || ( lat_dest !== "" && long_dest !== "") ) {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad + "&lat_or_sa=" + lat_or +
        "&long_or_sa=" + long_or + "&lat_dest_sa="+ lat_dest + "&long_dest_sa=" + long_dest, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroUbicacionTextoSA() {
    var origen = document.getElementById("filtro_ubicacion_origen_sa").value;
    var destino = document.getElementById("filtro_ubicacion_destino_sa").value;
    if (origen !== "" || destino !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?ent=" + entidad + "&or_sa=" + origen + "&dest_sa=" + destino, true);
        xmlhttp.send();
    } 
}
function recogerCargasSinFiltro() { // Admin
    var usuario = document.getElementById("sesion_usuario").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario, true);
    xmlhttp.send();
}
function recogerCargasFiltroDatalogger() {
    var datalogger = document.getElementById("filtro_datalogger_cod").value;
    if (datalogger !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&dat=" + datalogger, true);
        xmlhttp.send();
    } 
}
function recogerCargasFiltroContenedor() {
    var contenedor = document.getElementById("filtro_contenedor_cod").value;
    if (contenedor !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&cont=" + contenedor, true);
        xmlhttp.send();
    } 
}
function recogerCargasFiltroActivo() {
    var fec1 = document.getElementById("filtro_activo_fecha1").value;
    var fec2 = document.getElementById("filtro_activo_fecha2").value;
    if (fec1 !== "" || fec2 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&fec1=" + fec1 + "&fec2=" + fec2, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroInactivo() {
    var fec3 = document.getElementById("filtro_inactivo_fecha3").value;
    var fec4 = document.getElementById("filtro_inactivo_fecha4").value;
    if (fec3 !== "" || fec4 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&fec3=" + fec3 + "&fec4=" + fec4, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroUbicacion() {
    var lat_or = document.getElementById("filtros_ubicacion_latitud_origen").value;
    var long_or = document.getElementById("filtros_ubicacion_longitud_origen").value;
    var lat_dest = document.getElementById("filtros_ubicacion_latitud_destino").value;
    var long_dest = document.getElementById("filtros_ubicacion_longitud_destino").value;
    if ( ( lat_or !== "" && long_or !== "" ) || ( lat_dest !== "" && long_dest !== "") ) {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&lat_or=" + lat_or +
        "&long_or=" + long_or + "&lat_dest=" + lat_dest + "&long_dest=" + long_dest, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroUbicacionTexto() {
    var origen = document.getElementById("filtro_ubicacion_origen").value;
    var destino = document.getElementById("filtro_ubicacion_destino").value;
    if (origen !== "" || destino !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&or=" + origen + "&dest=" + destino, true);
        xmlhttp.send();
    } 
}
function recogerCargasSinFiltroTEC() { // Técnico 
    var usuario = document.getElementById("sesion_usuario").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario, true);
    xmlhttp.send();
}
function recogerCargasFiltroDataloggerTEC() {
    var datalogger = document.getElementById("filtro_datalogger_cod_tec").value;
    if (datalogger !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&dat=" + datalogger, true);
        xmlhttp.send();
    } 
}
function recogerCargasFiltroContenedorTEC() {
    var contenedor = document.getElementById("filtro_contenedor_cod_tec").value;
    if (contenedor !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&cont=" + contenedor, true);
        xmlhttp.send();
    } 
}
function recogerCargasFiltroActivoTEC() {
    var fec1 = document.getElementById("filtro_activo_fecha1_tec").value;
    var fec2 = document.getElementById("filtro_activo_fecha2_tec").value;
    if (fec1 !== "" || fec2 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&fec1=" + fec1 + "&fec2=" + fec2, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroInactivoTEC() {
    var fec3 = document.getElementById("filtro_inactivo_fecha3_tec").value;
    var fec4 = document.getElementById("filtro_inactivo_fecha4_tec").value;
    if (fec3 !== "" || fec4 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&fec3=" + fec3 + "&fec4=" + fec4, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroUbicacionTEC() {
    var lat_or = document.getElementById("filtros_ubicacion_latitud_origen_tec").value;
    var long_or = document.getElementById("filtros_ubicacion_longitud_origen_tec").value;
    var lat_dest = document.getElementById("filtros_ubicacion_latitud_destino_tec").value;
    var long_dest = document.getElementById("filtros_ubicacion_longitud_destino_tec").value;
    if ( ( lat_or !== "" && long_or !== "" ) || ( lat_dest !== "" && long_dest !== "") ) {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&lat_or=" + lat_or +
        "&long_or=" + long_or + "&lat_dest=" + lat_dest + "&long_dest=" + long_dest, true);
        xmlhttp.send();
    }
}
function recogerCargasFiltroUbicacionTextoTEC() {
    var origen = document.getElementById("filtro_ubicacion_origen_tec").value;
    var destino = document.getElementById("filtro_ubicacion_destino_tec").value;
    if (origen !== "" || destino !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_cargas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_cargas.php?usu=" + usuario + "&or=" + origen + "&dest=" + destino, true);
        xmlhttp.send();
    } 
}
/* =============================================================================
                            FUNCIONES SUBRUTAS
============================================================================== */
function abrirListaSubrutas() { // Superadmin
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("contenido_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "info_entidad/info_subrutas.php?entidad=" + entidad, true);
    xmlhttp.send();
    recogerSubrutasSinFiltroSAux();
}
function recogerSubrutasSinFiltroSAux() {
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad, true);
    xmlhttp.send();
}
function recogerSubrutasSinFiltroSA() {
    var entidad = document.getElementById("valor_entidad").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad, true);
    xmlhttp.send();
}
function recogerSubrutasFiltroDataloggerSA() {
    var datalogger = document.getElementById("filtro_datalogger_cod_sa").value;
    if (datalogger !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad + "&dat_sa=" + datalogger, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroContenedorSA() {
    var contenedor = document.getElementById("filtro_contenedor_cod_sa").value;
    if (contenedor !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad + "&cont_sa=" + contenedor, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasFiltroActivoSA() {
    var fec1 = document.getElementById("filtro_activo_fecha1_sa").value;
    var fec2 = document.getElementById("filtro_activo_fecha2_sa").value;
    if (fec1 !== "" || fec2 !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad + "&fec1_sa=" + fec1 + "&fec2_sa=" + fec2, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroInactivoSA() {
    var fec3 = document.getElementById("filtro_inactivo_fecha3_sa").value;
    var fec4 = document.getElementById("filtro_inactivo_fecha4_sa").value;
    if (fec3 !== "" || fec4 !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad + "&fec3_sa=" + fec3 + "&fec4_sa=" + fec4, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroUbicacionSA() {
    var lat_or = document.getElementById("filtros_ubicacion_latitud_origen_sa").value;
    var long_or = document.getElementById("filtros_ubicacion_longitud_origen_sa").value;
    var lat_dest = document.getElementById("filtros_ubicacion_latitud_destino_sa").value;
    var long_dest = document.getElementById("filtros_ubicacion_longitud_destino_sa").value;
    if ( ( lat_or !== "" && long_or !== "" ) || ( lat_dest !== "" && long_dest !== "") ) {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad + "&lat_or_sa=" + lat_or +
        "&long_or_sa=" + long_or + "&lat_dest_sa=" + lat_dest + "&long_dest_sa=" + long_dest, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroUbicacionTextoSA() {
    var origen = document.getElementById("filtro_ubicacion_origen_subr_sa").value;
    var destino = document.getElementById("filtro_ubicacion_destino_subr_sa").value;
    if (origen !== "" || destino !== "") {
        var entidad = document.getElementById("valor_entidad").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_superadmin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?ent=" + entidad + "&or_sa=" + origen + "&dest_sa=" + destino, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasSinFiltro() { // Admin
    var usuario = document.getElementById("sesion_usuario").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario, true);
    xmlhttp.send();
}
function recogerSubrutasFiltroDatalogger() {
    var datalogger = document.getElementById("filtro_datalogger_cod_subr").value;
    if (datalogger !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&dat=" + datalogger, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasFiltroContenedor() {
    var contenedor = document.getElementById("filtro_contenedor_cod_subr").value;
    if (contenedor !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&cont=" + contenedor, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasFiltroActivo() {
    var fec1 = document.getElementById("filtro_activo_fecha1_subr").value;
    var fec2 = document.getElementById("filtro_activo_fecha2_subr").value;
    if (fec1 !== "" || fec2 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&fec1=" + fec1 + "&fec2=" + fec2, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroInactivo() {
    var fec3 = document.getElementById("filtro_inactivo_fecha3_subr").value;
    var fec4 = document.getElementById("filtro_inactivo_fecha4_subr").value;
    if (fec3 !== "" || fec4 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&fec3=" + fec3 + "&fec4=" + fec4, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroUbicacion() {
    var lat_or = document.getElementById("filtros_ubicacion_latitud_origen_subr").value;
    var long_or = document.getElementById("filtros_ubicacion_longitud_origen_subr").value;
    var lat_dest = document.getElementById("filtros_ubicacion_latitud_destino_subr").value;
    var long_dest = document.getElementById("filtros_ubicacion_longitud_destino_subr").value;
    if ( ( lat_or !== "" && long_or !== "" ) || ( lat_dest !== "" && long_dest !== "") ) {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&lat_or=" + lat_or +
        "&long_or=" + long_or + "&lat_dest=" + lat_dest + "&long_dest=" + long_dest, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroUbicacionTexto() {
    var origen = document.getElementById("filtro_ubicacion_origen_subr").value;
    var destino = document.getElementById("filtro_ubicacion_destino_subr").value;
    if (origen !== "" || destino !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_admin").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&or=" + origen + "&dest=" + destino, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasSinFiltroTEC() { // Técnico
    var usuario = document.getElementById("sesion_usuario").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario, true);
    xmlhttp.send();
}
function recogerSubrutasFiltroDataloggerTEC() {
    var datalogger = document.getElementById("filtro_datalogger_cod_subr").value;
    if (datalogger !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&dat=" + datalogger, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasFiltroContenedorTEC() {
    var contenedor = document.getElementById("filtro_contenedor_cod_subr").value;
    if (contenedor !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&cont=" + contenedor, true);
        xmlhttp.send();
    } 
}
function recogerSubrutasFiltroActivoTEC() {
    var fec1 = document.getElementById("filtro_activo_fecha1_subr").value;
    var fec2 = document.getElementById("filtro_activo_fecha2_subr").value;
    if (fec1 !== "" || fec2 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&fec1=" + fec1 + "&fec2=" + fec2, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroInactivoTEC() {
    var fec3 = document.getElementById("filtro_inactivo_fecha3_subr").value;
    var fec4 = document.getElementById("filtro_inactivo_fecha4_subr").value;
    if (fec3 !== "" || fec4 !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&fec3=" + fec3 + "&fec4=" + fec4, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroUbicacionTEC() {
    var lat_or = document.getElementById("filtros_ubicacion_latitud_origen_subr").value;
    var long_or = document.getElementById("filtros_ubicacion_longitud_origen_subr").value;
    var lat_dest = document.getElementById("filtros_ubicacion_latitud_destino_subr").value;
    var long_dest = document.getElementById("filtros_ubicacion_longitud_destino_subr").value;
    if ( ( lat_or !== "" && long_or !== "" ) || ( lat_dest !== "" && long_dest !== "") ) {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&lat_or=" + lat_or +
        "&long_or=" + long_or + "&lat_dest=" + lat_dest + "&long_dest=" + long_dest, true);
        xmlhttp.send();
    }
}
function recogerSubrutasFiltroUbicacionTextoTEC() {
    var origen = document.getElementById("filtro_ubicacion_origen_subr").value;
    var destino = document.getElementById("filtro_ubicacion_destino_subr").value;
    if (origen !== "" || destino !== "") {
        var usuario = document.getElementById("sesion_usuario").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("lista_subrutas_ajax_tecnico").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "filtros/lista_subrutas.php?usu=" + usuario + "&or=" + origen + "&dest=" + destino, true);
        xmlhttp.send();
    } 
}
/* =============================================================================
                            FUNCIONES DATALOGGERS
============================================================================== */
function recogerDataloggers() { // Superadmin 
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var usuario = document.getElementById("sesion_usuario").value;
    console.log(usuario);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("contenido_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "info_entidad/info_dataloggers.php?entidad=" + entidad + "&usu=" + usuario, true);
    xmlhttp.send();
}
/* =============================================================================
                            FUNCIONES PRODUCTOS
============================================================================== */
function recogerProductos() { // Superadmin 
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("contenido_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "info_entidad/info_productos.php?entidad=" + entidad, true);
    xmlhttp.send();
}
/* =============================================================================
                            FUNCIONES
============================================================================== */
function recogerInformacionEntidad() { // Superadmin 
    var entidad = new URLSearchParams(window.location.search).get('entidad');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("contenido_ajax_superadmin").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "info_entidad/info_entidad.php?entidad=" + entidad, true);
    xmlhttp.send();
}
