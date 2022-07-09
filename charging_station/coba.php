<!DOCTYPE html>
<html>

<head>
  <title>Event Click LatLng</title>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <!-- jsFiddle will insert css and js -->
  <style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
      height: 50%;
      width: 50%;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>

</head>

<body>
  <div id="map"></div>

  <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRCx6iePzNGrTSl9VotojrZFRsH1BJwcs&callback=initMap&v=weekly&channel=2" async></script>
</body>
<script type="text/javascript">
  function initMap() {
    const myLatlng = {
      // ini adalah posisi awal lokasi pengecekan peta
      lat: -25.363,
      lng: 131.044
    };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 4,
      center: myLatlng,
    });
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "Click the map to get Lat/Lng!",
      position: myLatlng,
    });

    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
      // Close the current InfoWindow.
      infoWindow.close();
      // Create a new InfoWindow.
      infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
      });
      infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
      );
      infoWindow.open(map);
    });
  }
</script>

</html>