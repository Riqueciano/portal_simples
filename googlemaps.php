<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polygon</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
      <H2>CDA</H2>
      <div id="map" style="width:60%; height: 60%"></div>
    <script>

      // This example creates a simple polygon representing the Bermuda Triangle.

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: {lng: -38.1476105010897, lat: -9.78200468774451},
          mapTypeId: google.maps.MapTypeId.SATELLITE 
        });

////"MULTIPOLYGON((( , , , , )))"
  
        // Define the LatLng coordinates for the polygon's path.
        //lat lng
        var triangleCoords = [
          {lng: -38.1492656411517, lat: -9.77887877182165},
          {lng: -38.1470362445301, lat: -9.7793113041857},
          {lng: -38.1476105010897, lat: -9.78200468774451},
          {lng: -38.1488853580156, lat: -9.78249259212645}, 
          {lng: -38.1492656411517, lat: -9.77887877182165}, 
        ];

        // Construct the polygon.
        var bermudaTriangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35
        });
        bermudaTriangle.setMap(map);
        
        var triangleCoords2 = [
          {lng: -38.14, lat: -9.77887877182165},
          {lng: -38.5, lat: -9.7793113041857},
          {lng: -38.6, lat: -9.78200468774451},
          {lng: -38.8, lat: -9.78249259212645}, 
          {lng: -38.14, lat: -9.77887877182165}, 
        ];

      }
    </script>
    <script async defer
             src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQWduzEGmKnePgnGr77dFIUbEPayzxiZw&callback=initMap">
    </script>
  </body>
</html> 


<!DOCTYPE html>
<!--html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQWduzEGmKnePgnGr77dFIUbEPayzxiZw&callback=initMap"
    async defer></script>
  </body>
</html-->