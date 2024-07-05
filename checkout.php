<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
        <link rel="stylesheet" href="checkout.css">
        <link rel="stylesheet" href="nav.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        include_once('DbConfig.php');
        $con=new DbConfig();
        include('nav.php');
        if(!$_SESSION['customer']){
            ?>
            <script>
                alert("please login first");
                window.location.assign('usersignin.php');
            </script>
            <?php
        }
        ?>
        <form class="checkout_main"  method="POST">
            <div class="checkout_first">
                <h4>Personal Details <span style="color:red">*</span></h4>
                <label>Full name <span style="color:red">*</span></label>
                <input class="input_style" name="fullname" required>
                <label>Phone number <span style="color:red">*</span></label>
                <input class="input_style" name="phonenumber" required>
                <input id="input_order" name="orderno" style="display:none" value="">
                <input id="input_lat" name="lat" style="display:none" value="">
                <input id="input_lng" name="lng" style="display:none" value="">
                <div id="map"></div>
                <p style="color:#ababab;text-align:center">* Please pin your current location *</p>
            </div>
            <div class="checkout_second">
                <h4>Your Order</h4>
                <div>
                    <div class="checkout_title"><span>PRODUCT</span><span>TOTAL</span></div>
                    <div id="checkout_items" class="checkout_items"></div>
                    <div class="checkout_title"><span>Total</span><span>Rs <span id="total_amt">0.0</span></span></div>
                </div>
                <div><button name="final_order" id="final_order">ORDER NOW</button></div>
            </div>
        </form>
    </body>
    <script>
        var ordernumber=Math.floor(Math.random() * Math.floor(1000000));
        document.getElementById('input_order').value=ordernumber;
        cart_items=document.getElementById('checkout_items');
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
        if(localStorage.length>0){
            getItems();
        }
        function getItems(){
            var total=0;
            for(var i=0, len=localStorage.length; i<len; i++) {
            var key = localStorage.key(i);
            if(!key.includes("cart")){
                continue;
            }
            if (typeof localStorage[key] !== "undefined"
            && localStorage[key] !== "undefined") {
                var value = JSON.parse(localStorage[key]);
            }
            else{
                continue;
            }
            var m_name=value[0];
            var m_quantity=value[1];
            var m_value=value[2];
            total+=parseInt(m_value);
            const cart_div=document.createElement('div');
            cart_div.className='cart_single';
            cart_div.setAttribute("id", key);
            cart_div.innerHTML=`<span><span>`+m_name+`</span>    x  <span>`+m_quantity+`</span></span><span style="color:#EA1C81">`+"Rs "+m_value;
            cart_items.appendChild(cart_div);
            }
            document.getElementById('total_amt').innerHTML=total;
        }
        function passVal(orderno,name,quantity,value){
                var data = {
                itemname:name,
                itemquantity:quantity,
                itemvalue:value,
                itemno:orderno
        };
        $.post("storeorder.php", data);
    }
    </script>
    <?php
    if(isset($_POST['final_order'])){
        $hiuser=$_SESSION['customer'];
        $orderno=$_POST['orderno'];
        $fullname=$_POST['fullname'];
        $phonenumber=$_POST['phonenumber'];
        $lat=$_POST['lat'];
        $lng=$_POST['lng'];
        $insert=$con->connection->query("INSERT into orderhistory value('$orderno','$hiuser','$fullname','$phonenumber','$lat','$lng')");
        ?>
        <script>
            for(var i=0, len=localStorage.length; i<len; i++) {
            var key = localStorage.key(i);
            if(!key.includes("cart")){
                continue;
            }
            if (typeof localStorage[key] !== "undefined"
            && localStorage[key] !== "undefined") {
                var value = JSON.parse(localStorage[key]);
            }
            else{
                continue;
            }
            var m_name=value[0];
            var m_quantity=value[1];
            var m_value=value[2];
            passVal(<?php echo $orderno ?>,m_name,m_quantity,m_value);
            }
            localStorage.clear();
            alert("Thank you for ordering");
            window.location.assign('medicine.php');
        </script>
        <?php
    }
    ?>
</html>