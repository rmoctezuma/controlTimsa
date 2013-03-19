var mexico = new google.maps.LatLng(22.850033, -101.6500523);
var map;
var markerOptions;
var markersArray = [];
var infoWindow;

function initialize() {
  var mapDiv = document.getElementById('Mapa');
  var mapOptions = {
    zoom: 5,
    center: mexico,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(mapDiv, mapOptions);
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
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(map);

          google.maps.event.addListener(markersArray[i],'click', function(){
            if (!infoWindow) {
              infoWindow = new google.maps.InfoWindow();
            }
              
              var content = '<h5>' +  this.get("nombre") +  ' <img src = "' + this.getIcon().url +'" height="60" width="60" > </h5> ';

              infoWindow.setContent(content);

              infoWindow.open(map, this);
          });
      }
    }
  }
