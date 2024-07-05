<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="user.css">
    </head>
    <body>
        <?php
            session_start();
            if(!isset($_SESSION['username'])){
                header("location:signin.php");
            }
            else{
                include_once('DbConfig.php');
                $con=new DbConfig();
                $username=$_SESSION['username'];
                $getstatus=$con->connection->query("SELECT status from status where docusername='$username'");
                $row=mysqli_fetch_array($getstatus);
                $color1="white";
                $color2="white";
                if($row[0]==="on"){
                    $color1="#9ACD32";
                }
                else if($row[0]==="off"){
                    $color2="#FF6347";
                }
        ?>
        <div id="navigation">
            <span id="logo">We Care.</span>
            <div class="nav_item">
                <span id="appoint">My Appointments</span>
                <span id="profile">My Profile</span>
                <span id="profile" class="active_link">Status</span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $_SESSION['username']?></span>
            </div>
        </div>
        <div id="doc_status">
            <h2>Whats your status doc ?</h2>
            <div id="doc_status_first">
                <div>
                    <div class="doc_status_sec" id="doc_item_f" style="background-color:<?php echo $color1;?>" onclick="changeStatus('on','<?php echo $username?>')"><img class="doc_status_img" src="icons/status1.png"></div>
                    <p style="background-color:#4AB516;">Available</p>
                </div>
                <div>
                    <div class="doc_status_sec" id="doc_item_s" style="background-color:<?php echo $color2;?>" onclick="changeStatus('off','<?php echo $username?>')"><img class="doc_status_img" src="icons/status2.png"></div>
                    <p style="background-color:#F70800;">Not Available</p>
                </div>
            </div>
        </div>
        <script>
         document.getElementById('logo').addEventListener('click',function(){
                window.location.assign('index.php');
            });
            document.getElementById('appoint').addEventListener('click',function(){
                window.location.assign('user.php');
            });
            document.getElementById('profile').addEventListener('click',function(){
                window.location.assign('user-profile.php');
            });
            document.getElementById('status').addEventListener('click',function(){
                window.location.assign('docstatus.php');
            });
            function changeStatus(status,docusername){
                var data={
                    stat:status,
                    username:docusername
                }
                $.post('changestatus.php',data);
                alert("Status changed");
                window.location.assign('docstatus.php');
            }
    </script>
    <?php
            }
    ?>
    </body>