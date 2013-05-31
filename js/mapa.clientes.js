var mexico = new google.maps.LatLng(22.850033, -101.6500523);
var lazaro = new google.maps.LatLng(17.951602405802202, -102.19574004062497);
var map;
var markerOptions;
var markersArray = [];
var infoWindow;
var directionsService = new google.maps.DirectionsService();
var rendererOptions = {
  draggable: true
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
var sucursalActual;
var content;
var temporalMarker;
var geocoder = new google.maps.Geocoder();

function initialize() {
  var mapDiv = document.getElementById('Mapa');
  var mapOptions = {
    zoom: 5,
    center: mexico,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(mapDiv, mapOptions);
  directionsDisplay.setMap(map);
}
  /*

// Funcion agregar nueva sucursal de clientes. 

 google.maps.event.addListener(map,'click', function(event){
   placeMarker(event.latLng);
  });
  */
  function sucursalesClientes(imagen, sucursales, nombreSucursal ,id ){
    var marker = placeMarker(imagen, new google.maps.LatLng(sucursales[0], sucursales[1]),nombreSucursal, id);
    markersArray.push(marker);
  }

function placeMarker(imagen, location, nombreSucursal ,id) {
  var image = new google.maps.MarkerImage( imagen, null, null, null, new google.maps.Size(35, 35));

  var marker = new google.maps.Marker({
      position  : location,
      animation : google.maps.Animation.DROP,
      icon      : image
  });

  marker.set("value" , id);
  marker.set("nombre", nombreSucursal);

  return marker;
  }

  function clearOverlays(){
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(null);
      }
      markersArray = [];
    }
  }

  function showSucursales(){ 
    directionsDisplay.setMap(null);
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(map);

          google.maps.event.addListener(markersArray[i],'click', function(){
            if (!infoWindow) {
              infoWindow = new google.maps.InfoWindow();
            }
              directionsDisplay.setMap(null);

              parametros = {"key" : this.get("value")};
              var objeto = this;

              $.ajax({
                beforeSend: function(){
                },
                cache    : false,
                type     : "POST",
                dataType : "json",
                url      : "../includes/detalles.sucursal.php",
                data : parametros,
                success: function(response){
                  content = '<h5> <img src = "' + objeto.getIcon().url +'" height="60" width="60" >'+  objeto.get("nombre")+' </h5> <p>' + response.results + '</p> ';   
                   infoWindow.setContent(content);
                   infoWindow.open(map, objeto);              
                },
                error : function(xhr, ajaxOptions, thrownError){
                    alert("error, comprueba tu conexion a internet" + xhr.responseText);
                  content = '<h5>' +  objeto.get("nombre") +  ' <img src = "' + objeto.getIcon().url +'" height="60" width="60" > </h5> ';
                  infoWindow.setContent(content);
                   infoWindow.open(map, objeto);
                }
              });

              $('#Sucursal').show();
              sucursalActual = this;
              $('#DetallesRutas').attr("class", "btn");            
          });
      }
    }
  }

  function requestRoute(){
      var request = {
          origin      :  lazaro,
          destination :  sucursalActual.getPosition(),
          travelMode  :  google.maps.TravelMode.DRIVING
      };

      directionsService.route(request, function(result, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setMap(map);
            directionsDisplay.setDirections(result);
            $('#Rutas').empty();
            directionsDisplay.setPanel(document.getElementById("Rutas"));
          }
          else{
            $('#Rutas').empty();
            $('#Rutas').append('<h4> No se ha podido generar una ruta para esta ubicacion </h4>');
          }
        });
  }

  function removeRoute(){
    directionsDisplay.setMap(null);
  }

  function addNewListener(idCliente){
    google.maps.event.addListenerOnce(map,'click', function (evento){
         temporalMarker = new google.maps.Marker({
            position : evento.latLng,
            map      : map,
            draggable : true
        });

         temporalMarker.set("value" , idCliente);

          


         var html = "<h5> DATOS NUEVA SUCURSAL </h5> \
                       <form id='formSucursal' method='post' action='../includes/validar.cliente.php'> \
                        <input type='hidden' name='lat' value='" + getLatLongTemporal().lat() + "'> \
                        <input type='hidden' name='long' value='" + getLatLongTemporal().lng() + "'>\
                        <input type='hidden' name='cliente' value='" + getIdFromMarker() + "'>\
                        <tr><td><n </td><td> </td> </tr>\
                        <table>\
                        <tr>\
                          <td><label> Nombre </label></td> \
                          <td><input required name='nombre' type='text' id='nombre' placeholder='Nombre de la sucursal'> </td>\
                        </tr>\
                        <tr>\
                          <td><label>Telefono</label>\
                          <td><input required type='text' name='telefono' id='telefono' placeholder='Telefono de la sucursal'></td>\
                        </tr>\
                        </table>\
                          <label><b>Direccion</b></label>";
                 
          var contenidoHTML =  "<table>\
                                <tr>\
                                  <td><label>Calle</label></td>\
                                  <td><input required type='text' name='calle'></td>\
                                </tr>\
                                <tr>\
                                  <td><label>Numero</label></td>\
                                  <td><input required type='number' min='0' name='numero'></td>\
                                </tr>\
                                <tr>\
                                  <td><label>Colonia</label></td>\
                                  <td><input required type='text' name='colonia'></td>\
                                </tr>\
                                <tr>\
                                  <td><label>Loalidad</label></td>\
                                  <td><input required  type='text' name='localidad'></td>\
                                </tr>\
                                <tr>\
                                  <td><label>Ciudad</label></td>\
                                  <td><input required  type='text' name='ciudad'></td>\
                                </tr>\
                                <tr>\
                                  <td><label>Estado</label></td>\
                                  <td><input required  type='text' name='estado'></td>\
                                </tr>\
                                </table>";

          var html2 = "<hr style='height:70px; width: 280px'><input class='btn btn-primary' type='submit' value='Crear'>  </form>";

         geocoder.geocode({'latLng': temporalMarker.getPosition()}, function(result, status){
                  if(status == google.maps.GeocoderStatus.OK){

                      var contenidoNuevo = result[0].formatted_address;
                      var newhtml = ""; 

                      $.get("../includes/cuotas.sucursales.php",
                         function(data) {
                            newhtml =  html+ contenidoNuevo +   contenidoHTML +  data.respuesta + html2;
                            temporalInfoWindow = new google.maps.InfoWindow({
                            content : newhtml
                            });

                            temporalInfoWindow.open(map,temporalMarker);

                            parametros = {"value" : $('#cuotas').val()};
                            $.ajax({
                                beforeSend: function(){
                                },
                                cache: false,
                                type: "POST",
                                dataType:"json",
                                url:"../includes/precio.cuotaSucursal.php",
                                data: parametros,
                                success: function(response){
                                    if(response.resultado == false ){
                                      $('#detallesPrecios').empty();
                                      $('#detallesPrecios').append("<h4>Sin cuotas Disponibles</h4>");
                                      $('#newSucursal').attr('disabled', 'disabled');
                                      $('#newSucursal').addClass('disabled');
                                    }
                                    else{
                                      $('#detallesPrecios').empty();
                                      $('#detallesPrecios').append(response.resultado);
                                      $('#newSucursal').attr('disabled', false);
                                      $('#newSucursal').removeClass('disabled');
                                    }
                                },
                                error: function(xhr, ajaxOptions, thrownError){
                                    alert("error, comprueba tu conexion a internet" + xhr.responseText);
                                }
                            });  
                         }, "json");
                  }
                  else{
                    temporalInfoWindow = new google.maps.InfoWindow({
                            content : "<h4>Ubicacion no Valida</h4>"
                            });

                    temporalInfoWindow.open(map,temporalMarker);
                  }
          });

         google.maps.event.addListener(temporalMarker, 'click', function(){
              geocoder.geocode({'latLng': temporalMarker.getPosition()}, function(result, status){
                  if(status == google.maps.GeocoderStatus.OK){
                      contenidoNuevo = result[0].formatted_address;

                       $.get("../includes/cuotas.sucursales.php",
                         function(data) {
                            newhtml = html + contenidoNuevo  +  data.respuesta + html2;
                            temporalInfoWindow.setContent(newhtml);
                            temporalInfoWindow.open(map,temporalMarker);

                            parametros = {"value" : $('#cuotas').val()};
                            $.ajax({
                                beforeSend: function(){
                                },
                                cache: false,
                                type: "POST",
                                dataType:"json",
                                url:"../includes/precio.cuotaSucursal.php",
                                data: parametros,
                                success: function(response){
                                        if(response.resultado == false ){
                                          $('#detallesPrecios').empty();
                                          $('#detallesPrecios').append("<h4>Sin cuotas Disponibles</h4>");
                                          $('#newSucursal').attr('disabled', 'disabled');
                                          $('#newSucursal').addClass('disabled');
                                        }
                                        else{
                                          $('#detallesPrecios').empty();
                                          $('#detallesPrecios').append(response.resultado);
                                          $('#newSucursal').attr('disabled', false);
                                          $('#newSucursal').removeClass('disabled');
                                        }
                                },
                                error: function(xhr, ajaxOptions, thrownError){
                                    alert("error, comprueba tu conexion a internet" + xhr.responseText);
                                }
                            });  
                          }, "json");
                  }
                  else{
                     temporalInfoWindow.setContent("<h4>Ubicacion no Valida</h4>");
                  }
              });
         });

         google.maps.event.addListener(temporalMarker, 'dragend', function(){
              geocoder.geocode({'latLng': temporalMarker.getPosition()}, function(result, status){
                  if(status == google.maps.GeocoderStatus.OK){
                      contenidoNuevo = result[0].formatted_address;

                      $.get("../includes/cuotas.sucursales.php",
                         function(data) {
                            newhtml = html + contenidoNuevo  + contenidoHTML +  data.respuesta + html2;
                            temporalInfoWindow.setContent(newhtml);
                            temporalInfoWindow.open(map,temporalMarker);

                            parametros = {"value" : $('#cuotas').val()};
                            $.ajax({
                                beforeSend: function(){
                                },
                                cache: false,
                                type: "POST",
                                dataType:"json",
                                url:"../includes/precio.cuotaSucursal.php",
                                data: parametros,
                                success: function(response){
                                    if(response.resultado == false ){
                                      $('#detallesPrecios').empty();
                                      $('#detallesPrecios').append("<h4>Sin cuotas Disponibles</h4>");
                                      $('#newSucursal').attr('disabled', 'disabled');
                                      $('#newSucursal').addClass('disabled');
                                    }
                                    else{
                                      $('#detallesPrecios').empty();
                                      $('#detallesPrecios').append(response.resultado);
                                      $('#newSucursal').attr('disabled', false);
                                      $('#newSucursal').removeClass('disabled');
                                    }
                                },
                                error: function(xhr, ajaxOptions, thrownError){
                                    alert("error, comprueba tu conexion a internet" + xhr.responseText);
                                }
                            });  
                          }, "json"); 
                  }
                  else{
                     temporalInfoWindow.setContent("<h4>Ubicacion no Valida</h4>");
                  }
              }); 
         });

  });
}

  function removeListener(){
    google.maps.event.clearListeners(map, 'click');
    temporalMarker.setMap(null);
  }

  function buscarUbicacion(ubicacion){
      geocoder.geocode({'address' : ubicacion}, function(result, status){
        if(status = google.maps.GeocoderStatus.OK){
            map.setCenter(result[0].geometry.location);
            map.fitBounds(result[0].geometry.viewport);
        }
        else{
          alert("No se ha encontrado la localizacion");
        }
      });
  }

  function getIdFromMarker(){
    return temporalMarker.get('value');
  }

  function getLatLongTemporal(){
    return temporalMarker.getPosition();
  }

    function getLngTemporal(){
    return temporalMarker.getPosition().lng();
  }
