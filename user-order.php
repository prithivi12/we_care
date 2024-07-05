<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="user-dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php 
            session_start();
            $username=$_SESSION['customer'];
            include_once('DbConfig.php');
            $con=new DbConfig();
         ?>
         <div id="logout">
            <i class="fa fa-sign-out" style="color:black"></i>
         </div>
         <div id="navigation">
            <span id="logo">We Care.</span>
            <div class="nav_item">
                <span id="booking">My Bookings</span>
                <span id="order" class="active_link">My Orders</span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $_SESSION['customer']?></span>
            </div>
        </div>
        <div id="order_items">
            <?php
                $getorder=$con->connection->query("SELECT * from orderhistory where username='$username'");
                while($row=mysqli_fetch_array($getorder)){
                    $getordernumber=$row['0'];
                    $getorderitem=$con->connection->query("SELECT * from orderitems where ordernumber='$getordernumber'");
            ?>
            <div class="order_single">
                <p class="">Order number : <span><?php echo $row['0']?></span></p>
                <div class="order_container">
                    <?php
                    while($rowrow=mysqli_fetch_array($getorderitem)){
                        ?>
                        <div class="cart_single">
                            <span><span><?php echo $rowrow['2']?></span>    x  <span><?php echo $rowrow['3']?></span></span><span style="color:#EA1C81">Rs <?php echo $rowrow['4']?>
                        </div>
                        <?php
                    }
                        ?>
                </div>
                <div style="width: 100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=200&amp;hl=en&amp;q=<?php echo $row['4']?>,<?php echo $row['5']?>+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
            </div>
            <?php
                }
            ?>
        </div>
        <script>
            document.getElementById('logo').addEventListener('click',function(){
                window.location.assign('index.php');
            });
            var logout=document.getElementById('logout');
            logout.addEventListener('click',function(){
                $.post('logout.php',"logout");
                window.location.assign('usersignin.php');
            });
            document.getElementById('order').addEventListener('click',function(){
                window.location.assign('user-order.php');
            });
            document.getElementById('booking').addEventListener('click',function(){
                window.location.assign('user-dashboard.php');
            });
        </script>
    </body>
</html>