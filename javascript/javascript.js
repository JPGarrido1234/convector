/* =============================================================================
                            FUNCIONES SUPERADMIN
============================================================================== */
function cambiarMenuSuperadmin(num) {
    lista_entidades = document.getElementById("lista_entidades_superadmin");
    alta_entidades = document.getElementById("alta_entidad_superadmin");
    alta_admins = document.getElementById("alta_admin_superadmin");
    submenu_entidades = document.getElementById("submenu_entidad_superadmin");
    if (num == 1) {
        lista_entidades.style.display = 'block';
        alta_entidades.style.display = 'none';
        alta_admins.style.display = 'none';
    } else if (num == 2)  {
        lista_entidades.style.display = 'none';
        alta_entidades.style.display = 'block';
        alta_admins.style.display = 'none';
    } else if (num == 3) {
        lista_entidades.style.display = 'none';
        alta_entidades.style.display = 'none';
        alta_admins.style.display = 'block';
    }
    submenu_entidades.style.display = 'none';
    //history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
    document.getElementById("contenido_ajax_superadmin").innerHTML = "";
}
function desplegarSubmenuEntidadSuperadmin() {
    document.getElementById('submenu_entidad_superadmin').style.display = 'block';
    document.getElementById('lista_entidades_superadmin').style.display = 'none';

    b = document.getElementById('select_entidad_superadmin');
    entidad_sel = b.options[b.selectedIndex].value;

    opcion_0 = document.getElementById('opcion0_submenu_entidad_superadmin');
    opcion_0.innerHTML = entidad_sel.toUpperCase();
    //TODO: Pierde sesión al refrescar, ARREGLARLO
    history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')) + '?entidad=' + entidad_sel);
}
function desplegarBuscadorEntidadSuperadmin() {
    document.getElementById('submenu_entidad_superadmin').style.display = 'none';
    document.getElementById('lista_entidades_superadmin').style.display = 'block';
    //history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
    document.getElementById("contenido_ajax_superadmin").innerHTML = "";
}
function cambiarFiltrosEmpleadosSuperadmin(num) {
    usu_normal = document.getElementById("div_lista_empleados_completa_sa");
    usu_admins = document.getElementById("div_lista_empleados_admins_sa");
    usu_tecs = document.getElementById("div_lista_empleados_tecs_sa");
    if (num == 0) {
        usu_normal.style.display = 'block';
        usu_admins.style.display = 'none';
        usu_tecs.style.display = 'none';
    } else if (num == 1) {
        usu_normal.style.display = 'none';
        usu_admins.style.display = 'block';
        usu_tecs.style.display = 'none';
    } else if (num == 2) {
        usu_normal.style.display = 'none';
        usu_admins.style.display = 'none';
        usu_tecs.style.display = 'block';
    }
}
function cambiarFiltrosDataloggersSuperadmin(num) {
    dat_normal = document.getElementById("div_lista_dataloggers_completa_sa");
    dat_enuso = document.getElementById("div_lista_dataloggers_enuso_sa");
    dat_apagados = document.getElementById("div_lista_dataloggers_apagados_sa");
    if (num == 0) {
        dat_normal.style.display = 'block';
        dat_enuso.style.display = 'none';
        dat_apagados.style.display = 'none';
    } else if (num == 1) {
        dat_normal.style.display = 'none';
        dat_enuso.style.display = 'block';
        dat_apagados.style.display = 'none';
    } else if (num == 2) {
        dat_normal.style.display = 'none';
        dat_enuso.style.display = 'none';
        dat_apagados.style.display = 'block';
    }
}
function cambiarFiltrosCargasSuperadmin(num) {
    por_dat = document.getElementById("buscador_datalogger_filtros_superadmin");
    por_cont = document.getElementById("buscador_contenedor_filtros_superadmin");
    por_activo = document.getElementById("buscador_activo_filtros_superadmin");
    por_inactivo = document.getElementById("buscador_inactivo_filtros_superadmin");
    por_ubicacion = document.getElementById("buscador_ubicacion_filtros_superadmin");
    por_ubicacion_texto = document.getElementById("buscador_ubicacion_texto_filtros_superadmin");
    if (num == 1) {
        por_dat.style.display = 'block';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 2) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'block';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 3) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'block';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 4) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'block';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 5) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'block';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 6) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'block';
    } else if (num == 0) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
        recogerCargasSinFiltroSA();
    }
}
function cambiarFiltrosSubrutasSuperadmin(num) {
    por_dat = document.getElementById("buscador_datalogger_filtros_superadmin_subr");
    por_cont = document.getElementById("buscador_contenedor_filtros_superadmin_subr");
    por_activo = document.getElementById("buscador_activo_filtros_superadmin_subr");
    por_inactivo = document.getElementById("buscador_inactivo_filtros_superadmin_subr");
    por_ubicacion = document.getElementById("buscador_ubicacion_filtros_superadmin_subr");
    por_ubicacion_texto = document.getElementById("buscador_ubicacion_texto_filtros_superadmin_subr");
    if (num == 1) {
        por_dat.style.display = 'block';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 2) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'block';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 3) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'block';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 4) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'block';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 5) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'block';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 6) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'block';
    } else if (num == 0) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
        recogerSubrutasSinFiltroSA();
    }
}
/* =============================================================================
                            FUNCIONES ADMIN
============================================================================== */
function cambiarMenuAdmin(num) {
    submenu1 = document.getElementById("seccion_submenu_alta");
    submenu2 = document.getElementById("seccion_submenu_gestion");
    info_entidad = document.getElementById("seccion_info_entidad");
    //if(submenu1 != null && submenu2 != null && info_entidad != null){
        if (num == 1) {
            submenu1.style.display = 'block';
            submenu2.style.display = 'none';
            info_entidad.style.display = 'none';
            cambiarSubmenuGestionAdmin(0);
        } else if (num == 2) {
            submenu1.style.display = 'none';
            submenu2.style.display = 'block';
            info_entidad.style.display = 'none';
            cambiarSubmenuAltaAdmin(0);
        } else if (num == 3) {
            submenu1.style.display = 'none';
            submenu2.style.display = 'none';
            info_entidad.style.display = 'block';
            cambiarSubmenuAltaAdmin(0);
            cambiarSubmenuGestionAdmin(0);
        }
    //}
}
function cambiarSubmenuAltaAdmin(num) {
    alta_carga = document.getElementById("alta_carga_admin");
    alta_subruta = document.getElementById("alta_subruta_admin");
    alta_datalogger = document.getElementById("alta_datalogger_admin");
    alta_producto = document.getElementById("alta_producto_admin");
    alta_usuario = document.getElementById("alta_usuario_admin");
    if (num == 1) {
        alta_carga.style.display = 'block';
        alta_subruta.style.display = 'none';
        alta_datalogger.style.display = 'none';
        alta_producto.style.display = 'none';
        alta_usuario.style.display = 'none';
    } else if (num == 2) {
        alta_carga.style.display = 'none';
        alta_subruta.style.display = 'block';
        alta_datalogger.style.display = 'none';
        alta_producto.style.display = 'none';
        alta_usuario.style.display = 'none';
    } else if (num == 3) {
        alta_carga.style.display = 'none';
        alta_subruta.style.display = 'none';
        alta_datalogger.style.display = 'block';
        alta_producto.style.display = 'none';
        alta_usuario.style.display = 'none';
    } else if (num == 4) {
        alta_carga.style.display = 'none';
        alta_subruta.style.display = 'none';
        alta_datalogger.style.display = 'none';
        alta_producto.style.display = 'block';
        alta_usuario.style.display = 'none';
    } else if (num == 5) {
        alta_carga.style.display = 'none';
        alta_subruta.style.display = 'none';
        alta_datalogger.style.display = 'none';
        alta_producto.style.display = 'none';
        alta_usuario.style.display = 'block';
    } else if (num == 0) {
        alta_carga.style.display = 'none';
        alta_subruta.style.display = 'none';
        alta_datalogger.style.display = 'none';
        alta_producto.style.display = 'none';
        alta_usuario.style.display = 'none';
    }
}
function cambiarSubmenuGestionAdmin(num) {
    lista_cargas = document.getElementById("lista_cargas_admin");
    lista_subrutas = document.getElementById("lista_subrutas_admin");
    lista_dataloggers = document.getElementById("lista_dataloggers_admin");
    lista_productos = document.getElementById("lista_productos_admin");
    if (num == 1) {
        recogerCargasSinFiltro();
        lista_cargas.style.display = 'block';
        lista_subrutas.style.display = 'none';
        lista_dataloggers.style.display = 'none';
        lista_productos.style.display = 'none';
    } else if (num == 2) {
        recogerSubrutasSinFiltro();
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'block';
        lista_dataloggers.style.display = 'none';
        lista_productos.style.display = 'none';
    } else if (num == 3) {
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'none';
        lista_dataloggers.style.display = 'block';
        lista_productos.style.display = 'none';
        cambiarFiltrosDataloggersAdmin(0);
    } else if (num == 4) {
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'none';
        lista_dataloggers.style.display = 'none';
        lista_productos.style.display = 'block';
    } else if (num == 0) {
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'none';
        lista_dataloggers.style.display = 'none';
        lista_productos.style.display = 'none';
    }
}
function cambiarFiltrosDataloggersAdmin(num) {
    dat_normal = document.getElementById("div_lista_dataloggers_completa");
    dat_enuso = document.getElementById("div_lista_dataloggers_enuso");
    dat_apagados = document.getElementById("div_lista_dataloggers_apagados");
    if (num == 0) {
        dat_normal.style.display = 'block';
        dat_enuso.style.display = 'none';
        dat_apagados.style.display = 'none';
    } else if (num == 1) {
        dat_normal.style.display = 'none';
        dat_enuso.style.display = 'block';
        dat_apagados.style.display = 'none';
    } else if (num == 2) {
        dat_normal.style.display = 'none';
        dat_enuso.style.display = 'none';
        dat_apagados.style.display = 'block';
    }
}
function cambiarFiltrosEmpleadosAdmin(num) {
    usu_normal = document.getElementById("div_lista_empleados_completa");
    usu_admins = document.getElementById("div_lista_empleados_admins");
    usu_tecs = document.getElementById("div_lista_empleados_tecs");
    if (num == 0) {
        usu_normal.style.display = 'block';
        usu_admins.style.display = 'none';
        usu_tecs.style.display = 'none';
    } else if (num == 1) {
        usu_normal.style.display = 'none';
        usu_admins.style.display = 'block';
        usu_tecs.style.display = 'none';
    } else if (num == 2) {
        usu_normal.style.display = 'none';
        usu_admins.style.display = 'none';
        usu_tecs.style.display = 'block';
    }
}
function cambiarFiltrosCargasAdmin(num) {
    por_dat = document.getElementById("buscador_datalogger_filtros_admin");
    por_cont = document.getElementById("buscador_contenedor_filtros_admin");
    por_activo = document.getElementById("buscador_activo_filtros_admin");
    por_inactivo = document.getElementById("buscador_inactivo_filtros_admin");
    por_ubicacion = document.getElementById("buscador_ubicacion_filtros_admin");
    por_ubicacion_texto = document.getElementById("buscador_ubicacion_texto_filtros_admin");
    if (num == 1) {
        por_dat.style.display = 'block';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 2) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'block';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 3) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'block';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 4) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'block';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 5)  {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'block';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 6) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'block';
    } else if (num == 0) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
        recogerCargasSinFiltro();
    }
}
function cambiarFiltrosSubrutasAdmin(num) {
    por_dat = document.getElementById("buscador_datalogger_filtros_admin_subr");
    por_cont = document.getElementById("buscador_contenedor_filtros_admin_subr");
    por_activo = document.getElementById("buscador_activo_filtros_admin_subr");
    por_inactivo = document.getElementById("buscador_inactivo_filtros_admin_subr");
    por_ubicacion = document.getElementById("buscador_ubicacion_filtros_admin_subr");
    por_ubicacion_texto = document.getElementById("buscador_ubicacion_texto_filtros_admin_subr");
    if (num == 1) {
        por_dat.style.display = 'block';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 2) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'block';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 3) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'block';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 4) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'block';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 5)  {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'block';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 6)  {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'block';
    }  else if (num == 0) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
        recogerSubrutasSinFiltro();
    }
}
/* =============================================================================
                            FUNCIONES TÉCNICO
============================================================================== */
function cambiarOpcionesTecnico(num) {
    lista_cargas = document.getElementById("info_cargas_tecnico");
    lista_subrutas = document.getElementById("info_subrutas_tecnico");
    alta_datalogger = document.getElementById("alta_datalogger_tecnico");
    if (num == 1) {
        recogerCargasSinFiltroTEC();
        lista_cargas.style.display = 'block';
        lista_subrutas.style.display = 'none';
        alta_datalogger.style.display = 'none';
    } else if (num == 2) {
        recogerSubrutasSinFiltroTEC();
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'block';
        alta_datalogger.style.display = 'none';
    } else if (num == 3) {
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'none';
        alta_datalogger.style.display = 'block';
    } else if (num == 0) {
        lista_cargas.style.display = 'none';
        lista_subrutas.style.display = 'none';
        alta_datalogger.style.display = 'none';
    }
}
function cambiarFiltrosCargasTecnico(num) {
    por_dat = document.getElementById("buscador_datalogger_filtros_tecnico");
    por_cont = document.getElementById("buscador_contenedor_filtros_tecnico");
    por_activo = document.getElementById("buscador_activo_filtros_tecnico");
    por_inactivo = document.getElementById("buscador_inactivo_filtros_tecnico");
    por_ubicacion = document.getElementById("buscador_ubicacion_filtros_tecnico");
    por_ubicacion_texto = document.getElementById("buscador_ubicacion_texto_filtros_tecnico");
    if (num == 1) {
        por_dat.style.display = 'block';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 2) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'block';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 3) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'block';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 4) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'block';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 5) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'block';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 6) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'block';
    } else if (num == 0) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
        recogerCargasSinFiltroTEC();
    }
}
function cambiarFiltrosSubrutasTecnico(num) {
    por_dat = document.getElementById("buscador_datalogger_filtros_tecnico_subr");
    por_cont = document.getElementById("buscador_contenedor_filtros_tecnico_subr");
    por_activo = document.getElementById("buscador_activo_filtros_tecnico_subr");
    por_inactivo = document.getElementById("buscador_inactivo_filtros_tecnico_subr");
    por_ubicacion = document.getElementById("buscador_ubicacion_filtros_tecnico_subr");
    por_ubicacion_texto = document.getElementById("buscador_ubicacion_texto_filtros_tecnico_subr");
    if (num == 1) {
        por_dat.style.display = 'block';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 2) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'block';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 3) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'block';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 4) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'block';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 5)  {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'block';
        por_ubicacion_texto.style.display = 'none';
    } else if (num == 6)  {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'block';
    } else if (num == 0) {
        por_dat.style.display = 'none';
        por_cont.style.display = 'none';
        por_activo.style.display = 'none';
        por_inactivo.style.display = 'none';
        por_ubicacion.style.display = 'none';
        por_ubicacion_texto.style.display = 'none';
        recogerSubrutasSinFiltroTEC();
    }
}
/* =============================================================================
                            FUNCIONES ALTA SUBRUTAS
============================================================================== */
function anadirSubruta() {
    a = document.getElementById("sec_subruta");
    b = document.getElementById("menu_anadir_subruta");
    a.style.display = 'block';
    b.style.display = 'none';
}
/* =============================================================================
                            FUNCIONES DETALLES
============================================================================== */
function cambiarApartadoDetalleCarga(num) {
    lista_dataloggers = document.getElementById("lista_dataloggers_detalle_carga");
    lista_subrutas = document.getElementById("lista_subrutas_detalle_carga");
    lista_vehiculos = document.getElementById("lista_vehiculos_detalle_carga");
    lista_temperaturas = document.getElementById("lista_temperaturas_detalle_carga");
    lista_datos = document.getElementById("lista_datos_detalle_carga");
    grafica = document.getElementById("grafica_detalle_carga");
    if ( ( num == 1 && lista_dataloggers.style.display == 'block' ) || 
    ( num == 2 && lista_subrutas.style.display == 'block' ) || 
    ( num == 3 && lista_vehiculos.style.display == 'block' ) || 
    ( num == 4 && lista_temperaturas.style.display == 'block' ) ||
    ( num == 5 && lista_datos.style.display == 'block' ) || 
    ( num == 6 && grafica.style.display == 'block' ) ) {
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_subrutas = lista_subrutas.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
        lista_temperaturas = lista_temperaturas.style.display = 'none';
        lista_datos = lista_datos.style.display = 'none';
        grafica = grafica.style.display = 'none';
    } else if (num == 1) {
        lista_dataloggers = lista_dataloggers.style.display = 'block';
        lista_subrutas = lista_subrutas.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
        lista_temperaturas = lista_temperaturas.style.display = 'none';
        lista_datos = lista_datos.style.display = 'none';
        grafica = grafica.style.display = 'none';
    } else if (num == 2) {
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_subrutas = lista_subrutas.style.display = 'block';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
        lista_temperaturas = lista_temperaturas.style.display = 'none';
        lista_datos = lista_datos.style.display = 'none';
        grafica = grafica.style.display = 'none';
    } else if (num == 3) {
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_subrutas = lista_subrutas.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'block';
        lista_temperaturas = lista_temperaturas.style.display = 'none';
        lista_datos = lista_datos.style.display = 'none';
        grafica = grafica.style.display = 'none';
    } else if (num == 4) {
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_subrutas = lista_subrutas.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
        lista_temperaturas = lista_temperaturas.style.display = 'block';
        lista_datos = lista_datos.style.display = 'none';
        grafica = grafica.style.display = 'none';
    } else if (num == 5) {
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_subrutas = lista_subrutas.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
        lista_temperaturas = lista_temperaturas.style.display = 'none';
        lista_datos = lista_datos.style.display = 'block';
        grafica = grafica.style.display = 'none';
    } else if (num == 6) {
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_subrutas = lista_subrutas.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
        lista_temperaturas = lista_temperaturas.style.display = 'none';
        lista_datos = lista_datos.style.display = 'none';
        grafica = grafica.style.display = 'block';
    }
}
function cambiarApartadoDetalleSubruta(num) {
    lista_alertas = document.getElementById("lista_alertas_detalle_subruta");
    lista_dataloggers = document.getElementById("lista_dataloggers_detalle_subruta");
    lista_vehiculos = document.getElementById("lista_vehiculos_detalle_subruta");
    if ( ( num == 1 && lista_alertas.style.display == 'block' ) || 
    ( num == 2 && lista_dataloggers.style.display == 'block' ) || 
    ( num == 3 && lista_vehiculos.style.display == 'block') ) {
        lista_alertas = lista_alertas.style.display = 'none';
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
    } else if (num == 1) {
        lista_alertas = lista_alertas.style.display = 'block';
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
    } else if (num == 2) {
        lista_alertas = lista_alertas.style.display = 'none';
        lista_dataloggers = lista_dataloggers.style.display = 'block';
        lista_vehiculos = lista_vehiculos.style.display = 'none';
    } else if (num == 3) {
        lista_alertas = lista_alertas.style.display = 'none';
        lista_dataloggers = lista_dataloggers.style.display = 'none';
        lista_vehiculos = lista_vehiculos.style.display = 'block';
    }
}
function cambiarApartadoDetalleDatalogger(num) {
    lista_cargas = document.getElementById("lista_cargas_detalle_datalogger");
    lista_alertas = document.getElementById("lista_alertas_detalle_datalogger");
    if ( (num == 1 && lista_cargas.style.display == 'block') || 
    (num == 2 && lista_alertas.style.display == 'block') ) {
        lista_cargas.style.display = 'none';
        lista_alertas.style.display = 'none';
    } else if (num == 1) {
        lista_cargas.style.display = 'block';
        lista_alertas.style.display = 'none';
    } else if (num == 2) {
        lista_cargas.style.display = 'none';
        lista_alertas.style.display = 'block';
    }
}
/* =============================================================================
                            FUNCIONES LISTA CARGAS
============================================================================== */
function cambiarColorPrivi(id, lvl) {
    a = document.getElementById(id);
    if (lvl == 1) {
        a.style.backgroundColor = "rgb(160, 160, 248, 0.5)";
    } else if (lvl == 2) {
        a.style.backgroundColor = "rgb(160, 248, 160, 0.5)";
    } else if (lvl == 3) {
        a.style.backgroundColor = "rgb(248, 160, 160, 0.5)";
    }
}
/* =============================================================================
                            FUNCIONES EDITAR VEHÍCULOS
============================================================================== */
function desplegarNumeroVehiculos() {
    arraySeccionesVehiculos = [document.getElementById('seccion_vehiculo_1'), document.getElementById('seccion_vehiculo_2'), 
    document.getElementById('seccion_vehiculo_3'), document.getElementById('seccion_vehiculo_4'), 
    document.getElementById('seccion_vehiculo_5')];
    arrayValoresTipos = [document.getElementById('edit_tipo_1'), document.getElementById('edit_tipo_2'), 
    document.getElementById('edit_tipo_3'), document.getElementById('edit_tipo_4'), document.getElementById('edit_tipo_5')];
    arrayValoresMatriculas = [document.getElementById('edit_matricula_1'), document.getElementById('edit_matricula_2'), 
    document.getElementById('edit_matricula_3'), document.getElementById('edit_matricula_4'), document.getElementById('edit_matricula_5')];

    aux = document.getElementById('select_num_vehiculos');
    numSel = parseInt(aux.options[aux.selectedIndex].value);

    for ( i = 0; i < 5; i++ ) {
        if ( i < numSel ) {
            arraySeccionesVehiculos[i].style.display = 'block';
        } else {
            arraySeccionesVehiculos[i].style.display = 'none';
            arrayValoresTipos[i].value = "";
            arrayValoresMatriculas[i].value = "";
        }
    }

}
function desplegarNumeroVehiculosCarga() {
    arraySeccionesVehiculos = [document.getElementById('seccion_vehiculo_carga_1'), document.getElementById('seccion_vehiculo_carga_2'), 
    document.getElementById('seccion_vehiculo_carga_3'), document.getElementById('seccion_vehiculo_carga_4'), 
    document.getElementById('seccion_vehiculo_carga_5')];
    arrayValoresTipos = [document.getElementById('alta_tipo_1'), document.getElementById('alta_tipo_2'), 
    document.getElementById('alta_tipo_3'), document.getElementById('alta_tipo_4'), document.getElementById('alta_tipo_5')];
    arrayValoresMatriculas = [document.getElementById('alta_matricula_1'), document.getElementById('alta_matricula_2'), 
    document.getElementById('alta_matricula_3'), document.getElementById('alta_matricula_4'), document.getElementById('alta_matricula_5')];

    aux = document.getElementById('select_num_vehiculos_carga');
    numSel = parseInt(aux.options[aux.selectedIndex].value);

    for ( i = 0; i < 5; i++ ) {
        if ( i < numSel ) {
            arraySeccionesVehiculos[i].style.display = 'block';
        } else {
            arraySeccionesVehiculos[i].style.display = 'none';
            arrayValoresTipos[i].value = "";
            arrayValoresMatriculas[i].value = "";
        }
    }

}
function desplegarNumeroVehiculosEd() {
    arraySeccionesVehiculos = [document.getElementById('seccion_vehiculo_ed_1'), document.getElementById('seccion_vehiculo_ed_2'), 
    document.getElementById('seccion_vehiculo_ed_3'), document.getElementById('seccion_vehiculo_ed_4'), 
    document.getElementById('seccion_vehiculo_ed_5')];
    arrayValoresTipos = [document.getElementById('edit_tipo_ed_1'), document.getElementById('edit_tipo_ed_2'), 
    document.getElementById('edit_tipo_ed_3'), document.getElementById('edit_tipo_ed_4'), document.getElementById('edit_tipo_ed_5')];
    arrayValoresMatriculas = [document.getElementById('edit_matricula_ed_1'), document.getElementById('edit_matricula_ed_2'), 
    document.getElementById('edit_matricula_ed_3'), document.getElementById('edit_matricula_ed_4'), document.getElementById('edit_matricula_ed_5')];

    aux = document.getElementById('select_num_vehiculos_ed');
    numSel = parseInt(aux.options[aux.selectedIndex].value);

    for ( i = 0; i < 5; i++ ) {
        if ( i < numSel ) {
            arraySeccionesVehiculos[i].style.display = 'block';
        } else {
            arraySeccionesVehiculos[i].style.display = 'none';
            arrayValoresTipos[i].value = "";
            arrayValoresMatriculas[i].value = "";
        }
    }

}
/* =============================================================================
                            FUNCIONES GENERALES
============================================================================== */
function mostrarDetalles(id) {
    a = document.getElementById(id);
    a.style.display = 'block';
}
function esconderDetalles(id) {
    a = document.getElementById(id);
    a.style.display = 'none';
}