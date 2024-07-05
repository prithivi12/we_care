<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="medicine.css">
        <link rel="stylesheet" href="nav.css">
    </head>
    <body>
        <?php 
        if(isset($_POST['search_med'])){
            $medicine=$_POST['medicine'];
            ?>
            <script>window.location.assign("medicine.php?medicine=<?php echo $medicine;?>");</script>
            <?php
        }
        include('nav.php');
        ?>
        <div id="cart_button">
            <i class="fa fa-shopping-cart"></i>
        </div>
        <div id="cart_container">
                <div id="cart_items">

                </div>
                <div>
                    <button id="final_buy" class="search_button"><i class="fa fa-shopping-cart"></i> Check out</button>
                </div>
        </div>
        <div id="search_body">
            <div id="label_form">
                <label>Medicine</label>
                <div class="vl"></div>
            </div>
            <form id="search_form" method="POST">
                <input type="text" name="medicine" placeholder="Search about the medicine or drug (Try sinex)"/>
                <button name="search_med" id="search_button"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <?php
            if(isset($_GET['medicine'])){
                include_once('DbConfig.php');
                $con=new DbConfig();
                $medicine=$_GET['medicine'];
                $url="https://api.fda.gov/drug/label.json?limit=1&search=".$medicine;
                $getmedicine=$con->connection->query("SELECT * from medicine where name LIKE '$medicine'");
                if(file_get_contents($url)===false){
                    ?>
                    <script>var data_or_not="yes";</script>
                    <div id="search_results">
                        <div class="search_item">
                            <div class="search_header">
                                <span id="header_uses" style="display:none">Uses</span>
                                <span id="header_direction" style="display:none">Direction</span>
                                <span id="header_precaution" style="display:none">Precautions</span>
                                <span id="header_ingredients" style="display:none">Ingredients</span>
                                <span class="header_active" id="header_images">Buy</span>
                            </div>
                            <div id="search_use" style="display:none" class="design">
                            </div>
                            <div id="search_direction" style="display:none" class="design">
                            </div>
                            <div id="search_caution" style="display:none" class="design">
                            </div>
                            <div id="search_ingredients" style="display:none" class="design">
                            </div>
                            <div id="search_cart" class="design active">
                            <?php
                            if($getmedicine->num_rows>0){
                                while($row=mysqli_fetch_array($getmedicine)){
                                    $med_name=$row['1'];
                                    $med_price=$row['2'];
                                }
                            }
                            ?>
                            <div id="cart_cart" style="display:grid" class="search_cart_cont">
                                <img class="search_image" src="medicine/<?php echo $med_name?>.jpg">
                                <div class="search_buy_detail">
                                    <span id="med_name" style="font-size:1.5em;font-weight:bold"><?php echo $med_name?></span>
                                    <span style="color:#D62828;font-size:1.2em;font-weight:bold">Rs. <span id="price" style="color:#D62828"> <?php echo $med_price?></span></span><br>
                                    <input id="quantity" type="number" value="1" name="quantity"><br>
                                    <div style="display:grid;justify-items:center"><button class="search_button" id="buy_item"><i class="fa fa-shopping-cart"></i> Add to cart</button></div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                <?php
                }
                else{
                $getjson=json_decode(file_get_contents($url),true);
                $json=$getjson['results'];
                $arrayLength = count($json);
                $i = 0;
                while($i<$arrayLength){
                    ?>
        <div id="search_results">
            <div class="search_item">
                <div class="search_header">
                    <span id="header_uses">Uses</span>
                    <span id="header_direction">Direction</span>
                    <span id="header_precaution">Precautions</span>
                    <span id="header_ingredients">Ingredients</span>
                    <span id="header_images">Buy</span>
                </div>
                <div id="search_use" class="design">
                    <h3>Uses</h3>
                    <p class="medicine_uses"><?php echo $json[$i]['purpose'][0]?></p><br/>
                    <h4>Indication & usage</h4>
                    <p class="medicine_uses"><?php echo $json[$i]['indications_and_usage'][0]?></p>
                </div>
                <div id="search_direction" class="design">
                    <h3>Direction</h3>
                    <p><?php echo $json[$i]['dosage_and_administration'][0]?></p>
                    <p style="color:#FF1A00" class="medicine_doc"><?php echo $json[$i]['ask_doctor'][0]?></p>
                </div>
                <div id="search_caution" class="design">
                    <h3>Precautions</h3>
                    <p><?php echo $json[$i]['when_using'][0]?></p>
                    <h4>Warning!</h4>
                    <p><?php echo $json[$i]['warnings'][0]?></p>
                    <p><?php echo $json[$i]['stop_use'][0]?></p>
                </div>
                <div id="search_ingredients" class="design">
                    <h3>Active Ingredients</h3>
                    <p class="medicine_element"><?php echo $json[$i]['active_ingredient'][0]?></p>
                    <h3>Inactive Ingredients</h3>
                    <p class="medicine_element"><?php echo $json[$i]['inactive_ingredient'][0]?></p>
                </div>
                <div id="search_cart" class="design">
                    <?php
                    if($getmedicine->num_rows>0){
                        while($row=mysqli_fetch_array($getmedicine)){
                            $med_name=$row['1'];
                            $med_price=$row['2'];
                        }
                    }
                    ?>
                    <div id="cart_cart" class="search_cart_cont">
                        <img class="search_image" src="medicine/<?php echo $med_name?>.jpg">
                        <div class="search_buy_detail">
                            <span id="med_name" style="font-size:1.5em;font-weight:bold"><?php echo $med_name?></span>
                            <span style="color:#D62828;font-size:1.2em;font-weight:bold">Rs. <span id="price" style="color:#D62828"> <?php echo $med_price?></span></span><br>
                            <input id="quantity" type="number" value="1" name="quantity"><br>
                            <div style="display:grid;justify-items:center"><button class="search_button" id="buy_item"><i class="fa fa-shopping-cart"></i> Add to cart</button></div>
                        </div>
                    </div>
                </div>
                <?php
                if($getmedicine->num_rows>0){
                   ?>
                   <script>
                       document.getElementById('cart_cart').style.display="grid";
                   </script>
                   <?php
                }
                    $i++;
                }
                ?>
                <script>var data_or_not="no";</script>
                <?php
            }
            }
            ?>
            </div>
        </div>
        <script>
            var uses=document.getElementById('header_uses');
            var direction=document.getElementById('header_direction');
            var caution=document.getElementById('header_precaution');
            var ingredients=document.getElementById('header_ingredients');
            var image=document.getElementById('header_images');
            var searchuse=document.getElementById("search_use");
            var searchdirection=document.getElementById("search_direction");
            var searchcaution=document.getElementById("search_caution");
            var searchingredients=document.getElementById("search_ingredients");
            var searchcart=document.getElementById("search_cart");
            var quantity=document.getElementById("quantity");
            var getprice=document.getElementById("price");
            var item_name=document.getElementById("med_name");
            var buy_item=document.getElementById("buy_item");
            var cart_items=document.getElementById("cart_items");
            var cart_container=document.getElementById("cart_container");
            var cart_button=document.getElementById("cart_button");
            var final_buy=document.getElementById("final_buy");
            buy_item.addEventListener('click',function(){
                var itemcount=Math.floor(Math.random() * Math.floor(1000000));
                var itemdetail = [];
                itemdetail[0] = item_name.innerHTML;
                itemdetail[1] = quantity.value;
                itemdetail[2] = getprice.innerHTML;
                localStorage.setItem("cart"+itemcount, JSON.stringify(itemdetail));
                getCartItems();
            });
            const fixedprice=getprice.innerHTML;
            quantity.addEventListener('input',function(){
                var getquantity=quantity.value;
                var resultprice=fixedprice*getquantity;
                getprice.innerHTML=resultprice;
            });
            if(data_or_not=="no"){
                setHeader(uses);
                setData(searchuse);
            }
            else{
                setHeader(image);
                setData(searchcart);
            }
            uses.addEventListener('click',function(){
                setHeader(uses);
                setData(searchuse);
            });
            direction.addEventListener('click',function(){
                setHeader(direction);
                setData(searchdirection);
            });
            caution.addEventListener('click',function(){
                setHeader(caution);
                setData(searchcaution);
            });
            ingredients.addEventListener('click',function(){
                setHeader(ingredients);
                setData(searchingredients);
            });
            image.addEventListener('click',function(){
                setHeader(image);
                setData(searchcart);
            });
            function setHeader(id){
                uses.classList.add("header_inactive");
                direction.classList.add("header_inactive");
                caution.classList.add("header_inactive");
                ingredients.classList.add("header_inactive");
                image.classList.add("header_inactive");
                id.classList.remove("header_inactive");
                id.classList.add("header_active");
            }
            function setData(id){
                searchuse.classList.remove("active");
                searchdirection.classList.remove("active");
                searchcaution.classList.remove("active");
                searchingredients.classList.remove("active");
                searchcart.classList.remove("active");
                id.classList.add("active");
            }
            cart_button.addEventListener('click',function(){
                if(cart_container.style.display=="none"){
                    cart_container.style.display="grid";
                }
                else{
                    cart_container.style.display="none";
                }
            });
            //finalorder
            final_buy.addEventListener('click',function(){
               window.location.assign("checkout.php");
            });
            //initally get cart items
            if(localStorage.length>0){
                getCartItems();
            }
            function getCartItems(){
            //set cart items
            //clear all item on table
            cart_items.innerHTML = '';
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
            const cart_div=document.createElement('div');
            cart_div.className='cart_single';
            cart_div.setAttribute("id", key);
            cart_div.innerHTML=`<img src="medicine/`+m_name+`.jpg" class="search_image"><span>`+m_name+`</span><span>`+m_quantity+`</span><span style="color:#D62828">`+"Rs "+m_value+`</span><span class="remove_but" style="font-size:0.8em;" onClick="removeItems('`+key+`')"><i class="fa fa-times-circle"></i></span>`;
            cart_items.appendChild(cart_div);
            }
            //
            }
            function removeItems(key){
                localStorage.removeItem(key);
                getCartItems();
            }
        </script>
    </body>
</html>