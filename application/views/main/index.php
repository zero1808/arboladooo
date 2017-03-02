<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title></title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.32.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.32.1/mapbox-gl.css' rel='stylesheet' />
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }
    </style>
</head>
<body>

<div id='map'></div>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiemVybzE4MDgiLCJhIjoiZTg2NDM0OTA3MjVkOGU3Y2NhNjZjZjcwODQxZjE2ZDUifQ.I-A617Tlx1D7maFxytd9IA';
var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/zero1808/cizqbrliu004x2smiby89aa8s', //stylesheet location
    center: [-74.50, 40], // starting position
    zoom: 9 // starting zoom
});
</script>

</body>
</html>