<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Citra Radar Cuaca</title>
    <!-- <h1>Citra Radar Cuaca BMKG - Kalimantan Barat (Supadio)</h1>  -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""
    />
   <script src="leaflet.ajax.js"></script>
    <!-- css header -->
    <style type="text/css">
      body {
        padding: 0;
        margin: 0;
        font-family: "Roboto", sans-serif;
      }
      #map {
        height: 100vh;
        width: 100%;
      }
      header {
        position: absolute;
        top: 10px;
        left: 60px;
        z-index: 1000;
        background: #fffd;
        padding: 10px 20px;
        width: calc(100% - 180px);
      }
      header h1 {
        padding: 0;
        margin: 0 0 5px;
        font-size: 22px;
      }
      header p {
        padding: 0;
        margin: 0;
        font-size: 14px;
      }
      header .select {
        position: absolute;
        right: 20px;
        top: 1rem;
      }
      header .select > select {
        font-size: 1rem;
        padding: 0.5rem;
        border: 1px solid #ddd !important;
      }

      

      header .slideContainer {
        
      }


    </style>
  </head>
  <body>
    <!-- header -->
    <header>
      <div class="title">
        <h1>Citra Radar Cuaca BMKG - Kalimantan Barat (Supadio)</h1>
        <p>Date : <span class="tanggal"></span></p>
      </div>
      <div class="select">
        <select name="select-tanggal"></select>
      </div>
      <!-- time slider -->
      <dav class="slideContainer">
        <input type="range" min="1" max="100" value="1" id="myRange" class="slider">
      </div>
      <button id="play">Play</button><button id="stop">Stop</button>
    </header>
    <div id="map">
      <div id='#center'></div>
    </div>

    </style>
  </head>

  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script
    src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""
  ></script>//

  <script src="leaflet.ajax.js"></script>
  <script src="jquery-3.6.0.min.js"></script>


  <script>
     // tampilan map
     let mbAttr =
        'Map data &copy; <a href="https://www.openstreetmap.org/#map=7/-0.747/107.314&layers=C">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
      let mbUrl =
        "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoieWFpbGhhbWVrYSIsImEiOiJja3l3NWhiMzkwM2p2Mm90YjhvZGQyMnU1In0.-gzzuWKJRND-m6V2QzHQTA";
      let apiUrl =
        "https://raw.githubusercontent.com/OriFahrul/xml-data/main/data.xml";
      let light = L.tileLayer(mbUrl, {
        id: "mapbox/light-v9",
        tileSize: 512,
        zoomOffset: -1,
        attribution: mbAttr,
      });
      let dark = L.tileLayer(mbUrl, {
        id: "mapbox/dark-v9",
        tileSize: 512,
        zoomOffset: -1,
        attribution: mbAttr,
      });
      let TinggiPuncakAwan = L.tileLayer(mbUrl, {
        id: "mapbox/light-v9",
        tileSize: 512,
        zoomOffset: -1,
        attribution: mbAttr,
      });
      let Reflektivitas = L.tileLayer(mbUrl, {
        id: "mapbox/light-v9",
        tileSize: 512,
        zoomOffset: -1,
        attribution: mbAttr,
      });
      let markersLayers = new L.LayerGroup();
      let map = L.map("map", { layers: light }).setView([-0.085497, 109.317730], 9);

      let baseLayers = {
        Light: light,
        Dark: dark,
        TinggiPuncakAwan: TinggiPuncakAwan,
        Reflektivitas: Reflektivitas,

      };
    
    // Function
    function popUp(f, l) {
      var out = [];
      if (f.properties) {
        for (key in f.properties) {
          out.push(key + ": " + f.properties[key]);
        }
        l.bindPopup(out.join("<br />"));
      }
    }
    // control layer
    L.control.layers(baseLayers).addTo(map);
    // coba
    // var videoUrls = [
    //     'https://www.mapbox.com/bites/00188/patricia_nasa.webp',
    //     'https://www.mapbox.com/bites/00188/patricia_nasa.mp4'
    // ];

    // var bounds = L.latLngBounds([[ -0.8, 26.5], [ 0, 193]]);

    // var videoOverlay = L.videoOverlay( videoUrls, bounds, {
    //     opacity: 100
    // }).addTo(map);
    // Batas data video

    // Radar
    L.tileLayer = L.imageOverlay('radar/citraaa.gif',[[0.360330, 108.826427], [-1.177844, 110.103116]],{opacity:50}).addTo(map);
    // Radar
    objOverlays = {
      "Chapultepec Image": L.tileLayer
    };
    // payung
    var warning = L.control({ position: "topleft" });
      warning.onAdd = function (map) {
        var div = L.DomUtil.create("div", "myclass");
        div.innerHTML =
          '<img onclick="marning()" onmouseover="" style="cursor: pointer; width:35px; height:45px; margin:-2px;"src="radar/payung.png">';
        return div;
      };
      warning.addTo(map);
    // logo bmkg
    var logo = L.control({position: 'topright'});
    logo.onAdd = function(map){
	  var div = L.DomUtil.create('div', 'myclass');
	  div.innerHTML= '<span id="updatetime" style="float:right;background-color:#fff;"></span><img style="height: 11vh" src="radar/bmkg.png">';
	  return div;
}
logo.addTo(map);
    // polygon kalimantan barat
    var polygonPontianak = new L.GeoJSON.AJAX(
      ["pontianak.geojson"],
      {
        onEachFeature: popUp, 
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3        
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["kuburaya.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["mempawah.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["singkawang.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["bengkayang.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["sambas.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["landak.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["melawi.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["kapuas hulu.geojson"],
      {
        onEachFeature: popUp,
        cradius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["kayong utara.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["ketapang.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["sanggau.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["sekadau.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    var polygon = new L.GeoJSON.AJAX(
      ["sintang.geojson"],
      {
        onEachFeature: popUp,
        radius: 8,
        fillColor: "#0010ef",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.3
      }
    ).addTo(map);
    // entitas change icon marker
    // var tLS = new L.GeoJSON.AJAX(["rumah saya.geojson"], {
    //         pointToLayer: function(feature, latlng) {
    //             var smallIcon = new L.Icon({
    //                 iconSize: [450, 450],
    //                 iconAnchor: [13, 27],
    //                 popupAnchor: [1, -24],
    //                 opacity: 100,
    //                 iconUrl: 'radar/radar.gif'
    //             });
    //             return L.marker(latlng, {
    //                 icon: smallIcon
    //             });
    //         },
    //         onEachFeature: popUp,
    //     }).addTo(map);


        // var crosshairIcon = L.icon({
        //     iconSize: [400, 400],
        //     iconAnchor: [13, 27],
        //     popupAnchor: [1, -24],
        //     opacity: 100,
        //     iconUrl: 'radar/citraaa.gif'
        // });

        // crosshair = new L.marker(map.getCenter(), {icon: crosshairIcon, clickable:false});
        // crosshair.addTo(map);

        // map.on('', function(e) {
        //   crosshair.setLatLng(map.getCenter());
        // });

        // // map.setZoomAround
        

        
        // $('#center').text(formatPoint(map.getCenter(),'4326'));




        // var coba = new L.GeoJSON.AJAX(["pontianak.geojson"], {
        //     pointToLayer: function(feature, latlng) {
        //         var smallIcon = new L.Icon({
        //             iconSize: [1000, 1000],
        //             iconAnchor: [13, 27],
        //             popupAnchor: [1, -24],
        //             opacity: 100,
        //             iconUrl: 'radar/citraa.png'
        //         });
        //         return L.marker(latlng, {
        //             icon: smallIcon
        //         });
        //     },
        //     onEachFeature: popUp,
        // }).addTo(map)

        // var tLS = new L.GeoJSON.AJAX(["rumah saya.geojson"], {
        //     pointToLayer: function(feature, latlng) {  
        //       var smallIcon = new L.Icon({
        //             iconSize: [30, 30],
        //             iconAnchor: [13, 27],
        //             popupAnchor: [1, -24],
        //             iconUrl: 'img/rumah.png'
        //         });
        //         return L.marker(latlng, {
        //             icon: smallIcon
        //         });
        //     },
        //     onEachFeature: popUp,
        // }).addTo(map)
  </script>
</html>
