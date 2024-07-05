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
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "f5e40ead-81cc-4888-9eaf-a215d0424712",
      notifyButton: {
        enable: true,
      },
      allowLocalhostAsSecureOrigin: true,
    });
  });
</script>
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
            $getprofilenum=$con->connection->query("SELECT * from signup where username='$username'");
            while($row=mysqli_fetch_array($getprofilenum)){
                $profilenum=$row['9'];
                $docid=$row['0'];
            }
            if($profilenum==0){
                ?>
                <script>
                    window.location.assign("setupprofile.php");
                </script>
                <?php
            }
        ?>
        <div id="logout">
            <i class="fa fa-sign-out" style="color:black"></i>
         </div>
         <div id="navigation">
            <span id="logo">We Care.</span>
            <div class="nav_item">
                <span class="active_link" id="appoint">My Appointments</span>
                <span id="profile">My Profile</span>
                <span id="status">Status</span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $_SESSION['username']?></span>
            </div>
        </div>
        <div id="nav_nav">
            <span id="new_appoint" class="active_booking">New Appointments</span>
            <span id="old_appoint">Accepted Appointment</span>
        </div>
        <div class="new_appoint">
            <?php
            $getitems=$con->connection->query("SELECT * from booking where docid='$docid' AND active='0'");
            while($row=mysqli_fetch_array($getitems)){
            ?>
            <div id="<?php echo $row['0']?>" class="appoint_item">
                <span class="text">User Details</span>
                <div class="appoint_detail">
                    <div style="margin-left:10px">
                        <p><span>Fullname : <?php echo $row['2']?></span></p>
                        <p><span>Date : <?php echo $row['6']?></span></p>
                        <p><span>Time : <?php echo $row['5']?></span></p>
                        <p><span>Number : <?php echo $row['3']?></span></p>
                        <p><span>History : <?php echo $row['4']?></span></p>
                    </div>
                    <div style="width: 100%;height:100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;&amp;hl=en&amp;q=<?php echo $row['7']?>,<?php echo $row['8']?>+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
                </div>
                <div class="appoint_but">
                    <button style="color:white" onclick="acceptAppoint(<?php echo $row['0']?>)"><i class="fa fa-check" ></i> Accept</button>
                    <button style="color:white" onclick="rejectAppoint(<?php echo $row['0']?>)"><i class="fa fa-times" ></i> Reject</button>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
        <div class="new_appoint" style="display:none">
            <?php
            $getitems=$con->connection->query("SELECT * from booking where docid='$docid' AND active='1'");
            while($row=mysqli_fetch_array($getitems)){
            ?>
            <div id="<?php echo $row['0']?>" class="appoint_item">
                <span class="text">User Details</span>
                <div class="appoint_detail">
                    <div style="margin-left:10px">
                        <p><span>Fullname : <?php echo $row['2']?></span></p>
                        <p><span>Date : <?php echo $row['6']?></span></p>
                        <p><span>Time : <?php echo $row['5']?></span></p>
                        <p><span>Number : <?php echo $row['3']?></span></p>
                        <p><span>History : <?php echo $row['4']?></span></p>
                    </div>
                    <div style="width: 100%;height:100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;&amp;hl=en&amp;q=<?php echo $row['7']?>,<?php echo $row['8']?>+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
                </div>
                <div class="appoint_but">
                    <button style="color:white;grid-column:1/3" onclick="rejectAppoint(<?php echo $row['0']?>)"><i class="fa fa-times" ></i> Delete</button>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </body>
    <script>
         document.getElementById('logo').addEventListener('click',function(){
                window.location.assign('index.php');
            });
            var logout=document.getElementById('logout');
            logout.addEventListener('click',function(){
                $.post('logout.php',"logout");
                window.location.assign('signin.php');
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
            var new_app=document.getElementById('new_appoint');
            var old_app=document.getElementById('old_appoint');
            new_app.addEventListener('click',function(){
                new_app.classList.add("active_booking");
                old_app.classList.remove('active_booking');
                document.getElementsByClassName('new_appoint')[0].style.display="grid";
                document.getElementsByClassName('new_appoint')[1].style.display="none";
            });
            old_app.addEventListener('click',function(){
                old_app.classList.add("active_booking");
                new_app.classList.remove('active_booking');
                document.getElementsByClassName('new_appoint')[1].style.display="grid";
                document.getElementsByClassName('new_appoint')[0].style.display="none";
            });
            function acceptAppoint(appointid){
                var data={
                    accept:"accept",
                    id:appointid
                };
                $.post("handleappoint.php", data);
                document.getElementById(appointid).style.display="none";
            }
            function rejectAppoint(appointid){
                var data={
                    reject:"reject",
                    id:appointid
                };
                $.post("handleappoint.php", data);
                document.getElementById(appointid).style.display="none";
            }
    </script>
    <?php
            }
    ?>
</html>