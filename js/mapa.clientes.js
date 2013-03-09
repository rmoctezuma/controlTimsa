var mexico = new google.maps.LatLng(22.850033, -101.6500523);
var map;

function initialize() {
  var mapDiv = document.getElementById('Mapa');
  var mapOptions = {
    zoom: 5,
    center: mexico,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(mapDiv, mapOptions);
}