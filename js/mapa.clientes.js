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
  marker.set("nombre", nombreSucursal)

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
                  content = '<h5>' +  objeto.get("nombre") +  ' <img src = "' + objeto.getIcon().url +'" height="60" width="60" > </h5> <h5>' + response.results + '</h5> ';   
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
