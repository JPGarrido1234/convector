let map;
const labels = "AB";
let labelIndex = 0;
var markers = [];
var dirs = [];

function initMap() { // Mapa de alta de carga    
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 40.472222, lng: -3.560833},
        zoom: 6,
    });

    google.maps.event.addListener(map, "click", (event) => {
        if (markers.length == 2) {
            labelIndex = 0;
            markers[0].setMap(null);
            markers[1].setMap(null);
            markers = [];
            dirs = [];
            document.getElementById("nombre_origen_carga_input").value = "";
            document.getElementById("nombre_destino_carga_input").value = "";
            history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
        } else {
            addMarker(event.latLng, map);
            labelIndex++;
            geocoder.geocode(
                { location: event.latLng },
                (
                    resultsM = google.maps.GeocoderResult,
                    statusM = google.maps.GeocoderStatus
                ) => {
                    if ( statusM === 'OK' ) {
                        if ( resultsM[0] ) {
                            address_components = resultsM[0].address_components;
                            components = {};
                            jQuery.each(address_components, function(k, v1) {jQuery.each(v1.types, function(k2, v2) {components[v2]=v1.long_name});});

                            if (components.locality) {
                                city = components.locality;
                            }
                            if (!city) {
                                city = components.administrative_area_level_1;
                            }
                            if (components.country) {
                                country = components.country;
                            }
                            dirs.push(city + ", " + country);
                            if (dirs.length == 2) {
                                document.getElementById("nombre_origen_carga_input").value = dirs[0];
                                document.getElementById("nombre_destino_carga_input").value = dirs[1];
                            }
                        }
                    }
                }
            )
        } if (markers.length == 2) {
            history.pushState(null, '', location.href + '?pos1=' + markers[0].getPosition() + '&pos2=' + markers[1].getPosition());
        }
    });
}
function initMap2() {
    map = new google.maps.Map(document.getElementById('map2'), {
        center: {lat: 40.472222, lng: -3.560833},
        zoom: 6,
    });

    google.maps.event.addListener(map, "click", (event) => {
        if (markers.length == 2) {
            labelIndex = 0;
            markers[0].setMap(null);
            markers[1].setMap(null);
            markers = [];
            history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
        } else {
            addMarker(event.latLng, map);
            labelIndex++;
        } if (markers.length == 2) {
            history.pushState(null, '', location.href + '?pos1=' + markers[0].getPosition() + '&pos2=' + markers[1].getPosition());
        }
    });
}
function initMapStatic() {
    lat_or = parseFloat( document.getElementById("lat_or_hid").value );
    long_or = parseFloat( document.getElementById("long_or_hid").value );
    lat_dest = parseFloat( document.getElementById("lat_dest_hid").value );
    long_dest = parseFloat( document.getElementById("long_dest_hid").value );

    bounds = new google.maps.LatLngBounds();
    bounds.extend({lat: lat_or, lng: long_or});
    bounds.extend({lat: lat_dest, lng: long_dest});

    map = new google.maps.Map(document.getElementById("map3"), {
        center: bounds.getCenter(),
        zoom: 1,
    });

    map.fitBounds(bounds);
    addMarker({lat: lat_or, lng: long_or}, map); labelIndex++;
    addMarker({lat: lat_dest, lng: long_dest}, map);
}
function initMapStatic2() {
    lat_or = parseFloat( document.getElementById("lat_or_hid").value );
    long_or = parseFloat( document.getElementById("long_or_hid").value );
    lat_dest = parseFloat( document.getElementById("lat_dest_hid").value );
    long_dest = parseFloat( document.getElementById("long_dest_hid").value );

    bounds = new google.maps.LatLngBounds();
    bounds.extend({lat: lat_or, lng: long_or});
    bounds.extend({lat: lat_dest, lng: long_dest});

    map = new google.maps.Map(document.getElementById("map6"), {
        center: bounds.getCenter(),
        zoom: 1,
    });

    map.fitBounds(bounds);
    addMarker({lat: lat_or, lng: long_or}, map); labelIndex++;
    addMarker({lat: lat_dest, lng: long_dest}, map);
}
function initMap4() {
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map4'), {
        center: {lat: 40.472222, lng: -3.560833},
        zoom: 6,
    });

    google.maps.event.addListener(map, "click", (event) => {
        if (markers.length == 2) {
            labelIndex = 0;
            markers[0].setMap(null);
            markers[1].setMap(null);
            markers = [];
            dirs = [];
            document.getElementById("nombre_origen_subruta_input").value = "";
            document.getElementById("nombre_destino_subruta_input").value = "";
            history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
        } else {
            addMarker(event.latLng, map);
            labelIndex++;
            geocoder.geocode(
                { location: event.latLng },
                (
                    resultsM = google.maps.GeocoderResult,
                    statusM = google.maps.GeocoderStatus
                ) => {
                    if ( statusM === 'OK' ) {
                        if ( resultsM[0] ) {
                            address_components = resultsM[0].address_components;
                            components = {};
                            jQuery.each(address_components, function(k, v1) {jQuery.each(v1.types, function(k2, v2) {components[v2]=v1.long_name});});

                            if (components.locality) {
                                city = components.locality;
                            }
                            if (!city) {
                                city = components.administrative_area_level_1;
                            }
                            if (components.country) {
                                country = components.country;
                            }
                            dirs.push(city + ", " + country);
                            if (dirs.length == 2) {
                                document.getElementById("nombre_origen_subruta_input").value = dirs[0];
                                document.getElementById("nombre_destino_subruta_input").value = dirs[1];
                            }
                        }
                    }
                }
            )
        } if (markers.length == 2) {
            history.pushState(null, '', location.href + '?pos1=' + markers[0].getPosition() + '&pos2=' + markers[1].getPosition());
        }
    });
}
function initMap5() {
    lat_or = parseFloat( document.getElementById("lat_or_hid").value );
    if ( !isNaN(lat_or) ) {
        long_or = parseFloat( document.getElementById("long_or_hid").value );
        lat_dest = parseFloat( document.getElementById("lat_dest_hid").value );
        long_dest = parseFloat( document.getElementById("long_dest_hid").value );
        isnull = false;
    } else {
        lat_or = parseFloat(40.4165);
        long_or =  parseFloat(-3.70256);
        lat_dest = parseFloat(52.236005);
        long_dest = parseFloat(21.012604);
        isnull = true;
    }

    bounds = new google.maps.LatLngBounds();
    bounds.extend({lat: lat_or, lng: long_or});
    bounds.extend({lat: lat_dest, lng: long_dest});

    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map5'), {
        center: bounds.getCenter(),
        zoom: 1,
    });

    map.fitBounds(bounds);
    if (!isnull) {
        addMarker({lat: lat_or, lng: long_or}, map); labelIndex++;
        addMarker({lat: lat_dest, lng: long_dest}, map); labelIndex++;
    }

    google.maps.event.addListener(map, "click", (event) => {
        if (markers.length == 2) {
            labelIndex = 0;
            markers[0].setMap(null);
            markers[1].setMap(null);
            markers = [];
            dirs = [];
            document.getElementById("nombre_origen_carga_editar_input").value = "";
            document.getElementById("nombre_destino_carga_editar_input").value = "";
            history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
        } else {
            addMarker(event.latLng, map);
            labelIndex++;
            geocoder.geocode(
                { location: event.latLng },
                (
                    resultsM = google.maps.GeocoderResult,
                    statusM = google.maps.GeocoderStatus
                ) => {
                    if ( statusM === 'OK' ) {
                        if ( resultsM[0] ) {
                            address_components = resultsM[0].address_components;
                            components = {};
                            jQuery.each(address_components, function(k, v1) {jQuery.each(v1.types, function(k2, v2) {components[v2]=v1.long_name});});

                            if (components.locality) {
                                city = components.locality;
                            }
                            if (!city) {
                                city = components.administrative_area_level_1;
                            }
                            if (components.country) {
                                country = components.country;
                            }
                            dirs.push(city + ", " + country);
                            if (dirs.length == 2) {
                                document.getElementById("nombre_origen_carga_editar_input").value = dirs[0];
                                document.getElementById("nombre_destino_carga_editar_input").value = dirs[1];
                            }
                        }
                    }
                }
            )
        } if (markers.length == 2) {
            history.pushState(null, '', location.href + '?pos1=' + markers[0].getPosition() + '&pos2=' + markers[1].getPosition());
        }
    });
}
function initMap7() {
    lat_or = parseFloat( document.getElementById("lat_or_hid_subr").value );
    if ( !isNaN(lat_or) ) {
        long_or = parseFloat( document.getElementById("long_or_hid_subr").value );
        lat_dest = parseFloat( document.getElementById("lat_dest_hid_subr").value );
        long_dest = parseFloat( document.getElementById("long_dest_hid_subr").value );
        isnull = false;
    } else {
        lat_or = parseFloat(40.4165);
        long_or =  parseFloat(-3.70256);
        lat_dest = parseFloat(52.236005);
        long_dest = parseFloat(21.012604);
        isnull = true;
    }

    bounds = new google.maps.LatLngBounds();
    bounds.extend({lat: lat_or, lng: long_or});
    bounds.extend({lat: lat_dest, lng: long_dest});

    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map7'), {
        center: bounds.getCenter(),
        zoom: 1,
    });

    map.fitBounds(bounds);
    if (!isnull) {
        addMarker({lat: lat_or, lng: long_or}, map); labelIndex++;
        addMarker({lat: lat_dest, lng: long_dest}, map); labelIndex++;
    }

    google.maps.event.addListener(map, "click", (event) => {
        if (markers.length == 2) {
            labelIndex = 0;
            markers[0].setMap(null);
            markers[1].setMap(null);
            markers = [];
            dirs = [];
            document.getElementById("nombre_origen_subruta_editar_input").value = "";
            document.getElementById("nombre_destino_subruta_editar_input").value = "";
            history.pushState(null, '', location.href.substring(0, location.href.indexOf('?')));
        } else {
            addMarker(event.latLng, map);
            labelIndex++;
            geocoder.geocode(
                { location: event.latLng },
                (
                    resultsM = google.maps.GeocoderResult,
                    statusM = google.maps.GeocoderStatus
                ) => {
                    if ( statusM === 'OK' ) {
                        if ( resultsM[0] ) {
                            address_components = resultsM[0].address_components;
                            components = {};
                            jQuery.each(address_components, function(k, v1) {jQuery.each(v1.types, function(k2, v2) {components[v2]=v1.long_name});});

                            if (components.locality) {
                                city = components.locality;
                            }
                            if (!city) {
                                city = components.administrative_area_level_1;
                            }
                            if (components.country) {
                                country = components.country;
                            }
                            dirs.push(city + ", " + country);
                            if (dirs.length == 2) {
                                document.getElementById("nombre_origen_subruta_editar_input").value = dirs[0];
                                document.getElementById("nombre_destino_subruta_editar_input").value = dirs[1];
                            }
                        }
                    }
                }
            )
        } if (markers.length == 2) {
            history.pushState(null, '', location.href + '?pos1=' + markers[0].getPosition() + '&pos2=' + markers[1].getPosition());
        }
    });
}
function initMapAlertas(){
    map = new google.maps.Map(document.getElementById('mapAlertas'), {
        center: {lat: 40.472222, lng: -3.560833},
        zoom: 6,
    });
}
function addMarker(location, map) {
    var marker = new google.maps.Marker( {
        position: location,
        label: labels[labelIndex],
        map: map,
        });
    markers.push(marker);
}