<?php 
include("config.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <title>Map with Driving Route from A to B</title>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <link rel="stylesheet" type="text/css" href="demo.css" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" type="text/css" href="../template.css" />
    <script type="text/javascript" src='../test-credentials.js'></script>    
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <style type="text/css">
      .directions li span.arrow {
        display:inline-block;
        min-width:28px;
        min-height:28px;
        background-position:0px;
        background-image: url("https://heremaps.github.io/maps-api-for-javascript-examples/map-with-route-from-a-to-b/img/arrows.png");
        position:relative;
        top:8px;
      }
      .directions li span.depart  {
        background-position:-28px;
      }
      .directions li span.rightturn  {
        background-position:-224px;
      }
      .directions li span.leftturn{
        background-position:-252px;
      }
      .directions li span.arrive  {
        background-position:-1288px;
      }
      </style>
  <script>window.ENV_VARIABLE = 'developer.here.com'</script>
  <script src='../iframeheight.js'></script>
  </head>
  <body id="markers-on-the-map">
    
    <div class="page-header">
        <h1>Map with Driving Route from A to B</h1>
        <p>Request a driving route from A to B and display it on the map</p>
    </div>
    <p>This example calculates the fastest car route from the <b>Charoda</b> 
      <i>(81.458008°N, 21.231903°E)</i> to <b>power house</b> 
      <i>(81.3759°N, 21.20812°E)</i>, and displays it on the map.</p>
    <div id="map"></div>
    <div id="panel"></div>
    
    
    <script type="text/javascript" src='map_test.js'></script>
  </body>
</html>