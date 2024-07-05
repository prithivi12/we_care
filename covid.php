<!DOCTYPE html>
<html>
<?php
$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
$mainurl='https://data.askbhunte.com/api/v1/';
$districts_url = $mainurl.'districts';
$api_url = 'https://corona.askbhunte.com/api/v1/data/nepal';
$json_dis = file_get_contents($districts_url,false,$context);
$response_dis= json_decode($json_dis);
$json_data = file_get_contents($api_url,false,$context);
$response_data = json_decode($json_data);
$positive=$response_data->tested_positive;
$recovered=$response_data->recovered;
$deaths=$response_data->deaths;
$sum_url = $mainurl.'covid/summary';
$json_sum = file_get_contents($sum_url,false,$context);
$response_sum= json_decode($json_sum);
$array=array();
$i=0;
//----------------
    $cases_obj = new stdClass();
    $deaths_obj = new stdClass();
    $recovered_obj = new stdClass();
    $context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));    
    $sum_url = $mainurl.'covid/summary';
    $json_sum = file_get_contents($sum_url,false,$context);
    $response_sum= json_decode($json_sum,true);
    $response_cases=$response_sum['district']['cases'];
    $response_deaths=$response_sum['district']['deaths'];
    $response_recovered=$response_sum['district']['recovered'];
    foreach($response_cases as $row){
        $cases_obj->{$row['district']}=$row['count'];
    }
    foreach($response_deaths as $row){
        $deaths_obj->{$row['district']}=$row['count'];
    }
    foreach($response_recovered as $row){
        $recovered_obj->{$row['district']}=$row['count'];
    }
    //---------------
foreach($response_dis as $row){
    $id=$row->id;
    $array[$i]['id']=$id;
	$array[$i]['name']=$row->title;
	$array[$i]['lng']=$row->centroid->coordinates['0'];
    $array[$i]['lat']=$row->centroid->coordinates['1'];
    if(property_exists($cases_obj,$id)){
        $array[$i]['confirmed']=$cases_obj->$id;
    } 
    else{
        $array[$i]['confirmed']="0";
    }
    if(property_exists($recovered_obj,$id)){
        $array[$i]['recovered']=$recovered_obj->$id;
    } 
    else{
        $array[$i]['recovered']="0";
    }
    if(property_exists($deaths_obj,$id)){
        $array[$i]['deaths']=$deaths_obj->$id;    
    } 
    else{
        $array[$i]['deaths']="0";   
     }
    $i++;
}
?>
<head>
	<title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="covid.css">
    <link rel="stylesheet" type="text/css" href="nav.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
</head>
<body>
    <?php include('nav.php');?>
	   <div id="map"></div>
	   <div style="display: none;" id="myArray">
	   <?php 
	   for ($i = 0; $i < sizeof($array); $i++) {
        echo '<span class="name">'.$array[$i]['name'].'</span>';
        echo '<span class="confirmed">'.$array[$i]['confirmed'].'</span>';
        echo '<span class="deaths">'.$array[$i]['deaths'].'</span>';
        echo '<span class="recovered">'.$array[$i]['recovered'].'</span>';
        echo '<span class="lat">'.$array[$i]['lat'].'</span>';
        echo '<span class="lng">'.$array[$i]['lng'].'</span>';
	   }
	   ?>
        </div>
        <div id="nepal_info">
            <div id="nepal_info_header">
                <img id="nepal_flag" src="nepal.svg"/>
                <span>Nepal</span>
            </div>
            <hr>
            <div class="nepal_info_comp">
                <span class="nepal_info_title">Total Cases: </span>
                <span id="nepal_info_tcase" class="nepal_info_value"><?php echo $positive?></span>
            </div>
            <div class="nepal_info_comp">
                <span class="nepal_info_title">Total Deaths: </span>
                <span id="nepal_info_tdeath" class="nepal_info_value"><?php echo $deaths?></span>
            </div>
            <div class="nepal_info_comp">
                <span class="nepal_info_title">Total recovered: </span>
                <span id="nepal_info_treco" class="nepal_info_value"><?php echo $recovered?></span>
            </div>
        </div>
        <div id="indicator">
            <span id="indicator_title" class="indicator_span">Indicator</span>
            <span class="indicator_span">
                <img class="indicator_icon" src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png"/>
                <span class="indicator_text">: < 50</span>
            </span>
            <span class="indicator_span">
                <img class="indicator_icon" src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png"/>
                <span class="indicator_text">: 50 < 100</span>
            </span>
            <span class="indicator_span">
                <img class="indicator_icon" src="https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png"/>
                <span class="indicator_text">: > 100</span>
            </span>
        </div>
  <script>
    // position we will use later
    var lat = 27.9447;
    var lon = 84.2279;
    // initialize map
    if ( window.screen.width < 600) {
        var xzoom=7;
    }
        else{
            var xzoom=7.5;
        }
    map = L.map('map').setView([lat, lon], xzoom);
    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 18,
    }).addTo(map);
    var names = document.getElementsByClassName("name");
    var confirmed = document.getElementsByClassName("confirmed");
    var deaths = document.getElementsByClassName("deaths");
    var recovered = document.getElementsByClassName("recovered");
    var lat = document.getElementsByClassName("lat");
    var lng = document.getElementsByClassName("lng");
	for (var i = 0; i < names.length; i++) {
        //color of marker
        var numbers=confirmed[i].innerHTML;
        if(numbers<50){
        var Icon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [15, 25],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [30,30]
        });
    }
    else if(numbers>50 && numbers<100){
        var Icon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [15, 25],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [30,30]
        });
    }
    else{
        var Icon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [15, 25],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [30,30]
        });
    }
		// add marker to the map
		j= L.marker([lat[i].innerHTML,lng[i].innerHTML],{icon:Icon}).addTo(map);
    // add popup to the marker
   		p = new L.Popup({ autoClose: false, closeOnClick: false })
                .setContent("<b>"+names[i].innerHTML+"</b></br>Cases: "+confirmed[i].innerHTML+"</br>Deaths: "+deaths[i].innerHTML+"</br>Recovered: "+recovered[i].innerHTML)
                .setLatLng([lat[i].innerHTML,lng[i].innerHTML]);
                if(i%10==1 && window.screen.width>600){
                	 j.bindPopup(p).openPopup();
                }
                else{
                	j.bindPopup(p);
                }
   		j++;
	}
  </script>
</body>