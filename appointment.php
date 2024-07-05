<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body{
                padding:0;
                margin:0;
                font-family: 'Nunito', sans-serif;
                box-sizing: border-box;
                color: #242424;
                background-color: #F4F6FA;
            }
            #menu{
                box-sizing: border-box;
                padding-top:15px;
                padding-left:20px;
                height:50px;
                background-color:#242424;
            }  
            .app_header{
                padding-top:10px;
                font-weight:bold;
                font-size:1.3em;
                color:white;
                height:40px;
                background-color:#242424;
            }
            #menu_main{
                background-color:white;
                margin:auto;
                width:400px;
                text-align:center;
                padding-bottom:30px;
            }
            #form_button{
                font-weight: bold;
                border: transparent;
                border-radius: 5px;
                width: 100%;
                height: 40px;
                background-color:#D62828;
                color: white;
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            }
            input{
                height:30px;
                width:200px;
                border:none;
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            }
            #map{
                margin-top:10px;
                height: 200px;
                width:100% 
            }
        </style>  
    </head>
    <body>
        <?php
        session_start();
        if(!$_SESSION['customer']){
            ?>
            <script>
                alert("Please login first");
                window.location.assign("doctor.php");
            </script>
            <?php
        }
        include_once('DbConfig.php');
        $con=new DbConfig();
        ?>
        <div id="menu">
            <span style="color:white" onclick="goBack()"><i class="fa fa-angle-double-left"></i> <span>Go Back</span></span>
        </div>
        <div id="menu_main">
            <p class="app_header">Appointment</p>
            <form method="POST">
                <p>Fullname *</p>
                <input type="text" name="name" required>
                <p>Phone number *</p>
                <input type="tel" name="phone" required>
                <p>Date of appointment *</p>
                <input type="date" name="date" required>
                <p>Time *</p>
                <input type="time" name="time" required>
                <p>Your History *</p>
                <input style="width:90%;height:40px" type="text" name="history" required>
                <p>Your Current Symptoms *</p>
                <input style="width:90%;height:40px" type="text" name="symptoms" required>
                <input id="input_lat" name="lat" style="display:none" value="">
                <input id="input_lng" name="lng" style="display:none" value="">
                <div id="map"></div>
                <p style="color:#ababab;text-align:center">* Please pin your current location *</p>
                <button name="appoint" id="form_button">Appoint</button>
            </form>
        </div>
    </body>
    <script>
        function goBack(){
            window.location.assign("doctor.php");
        }
        var Icon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [15, 25],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [30,30]
        });
        getLocation();
        function getLocation() {
            if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
            } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
             }
        }
        function showPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            document.getElementById('input_lat').value=lat;
            document.getElementById('input_lng').value=lng;
            xzoom=17;
            map = L.map('map').setView([lat, lng],xzoom);
            var addmarker=L.marker([lat,lng], {icon: Icon}).addTo(map);
            // set map tiles source
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',maxZoom: 18,}).addTo(map);
            map.on('click', function(e) {
                map.removeLayer(addmarker);
                addmarker=L.marker([e.latlng.lat,e.latlng.lng], {icon: Icon}).addTo(map);
                document.getElementById('input_lat').value=e.latlng.lat;
                document.getElementById('input_lng').value=e.latlng.lng;
            });
        }
    </script>
    <?php
    if(isset($_POST['appoint'])){
        $docid=$_GET['id'];
        $username=$_SESSION['customer'];
        $fullname=$_POST['name'];
        $number=$_POST['phoner'];
        $time=$_POST['time'];
        $date=$_POST['date'];
        $lat=$_POST['lat'];
        $lng=$_POST['lng'];
        $history=$_POST['history'];
        $symptons=$_POST['symptoms'];
        $store=$con->connection->query("INSERT into booking value('','$username','$fullname','$number','$history','$time','$date','$lat','$lng','','$docid','$symptoms')");
        if($store){
            ?>
            <script>
                alert("Appointment Booked");
                window.location.assign('doctor.php');
            </script>
            <?php
        }
    }
    ?>
</html>