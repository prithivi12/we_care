<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="user-profile.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        session_start();
        $username=$_SESSION['username'];
        include_once('DbConfig.php');
        $con=new DbConfig();
        $getprofession=$con->connection->query("SELECT * from profession where username='$username'");
        $geteducation=$con->connection->query("SELECT * from education where username='$username'");
        $getwebsite=$con->connection->query("SELECT * from website where username='$username'");
        $getvideo=$con->connection->query("SELECT * from video where username='$username'");
        $getexperience=$con->connection->query("SELECT * from experience where username='$username'");
        $getmembership=$con->connection->query("SELECT * from membership where username='$username'");
        ?>
        <div id="navigation">
            <span id="logo">We Care.</span>
            <div class="nav_item">
                <span id="appoint">My Appointments</span>
                <span id="profile" class="active_link">My Profile</span>
                <span id="status">Status</span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $username?></span>
            </div>
        </div>
        <div id="menu_menu">
            <div id="menu_main">
                <p style="margin:0" class="app_header">Edit Details</p>
                <form method="POST">
                    <p>Fullname *</p>
                    <input type="text" name="name" required>
                    <p>NMC number *</p>
                    <input type="tel" name="nmc" required>
                    <p>Years of experience *</p>
                    <input type="tel" name="exp" required>
                    <p>Fb link *</p>
                    <input type="url" name="fblink" required>
                    <button name="edit" id="form_button">Edit</button>
                </form>
            </div>
            <div id="menu_side">
                <p class="app_header" style="text-align:center;margin:0">Add Extra Details</p>
                <div id="side_form">
                    <div class="side_add">
                        <span>Add Profession</span>
                        <input id="profession" type="text" name="addprofession">
                        <button onclick="addDetails('<?php echo $username?>','profession')" class="side_but"><i class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="side_add">
                        <span>Add Experience</span>
                        <input id="experience" type="text" name="addexp">
                        <button onclick="addDetails('<?php echo $username?>','experience')" class="side_but"><i class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="side_add">
                        <span>Add Education</span>
                        <input id="education" type="text" name="addedu">
                        <button onclick="addDetails('<?php echo $username?>','education')" class="side_but"><i class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="side_add">
                        <span>Add Membership</span>
                        <input id="membership" type="text" name="addmem">
                        <button onclick="addDetails('<?php echo $username?>','membership')" class="side_but"><i class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="side_add">
                        <span>Add Website</span>
                        <input id="website" type="url" name="addweb">
                        <button onclick="addDetails('<?php echo $username?>','website')" class="side_but"><i class="fa fa-plus"></i> Add URL</button>
                    </div>
                    <div class="side_add">
                        <span>Add Video</span>
                        <input id="video" type="url" name="addvid">
                        <button onclick="addDetails('<?php echo $username?>','video')" class="side_but"><i class="fa fa-plus"></i> Add URL</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="remove_details">
            <p class="app_header" style="text-align:center;margin:0">Remove Details</p>
            <div class="remove_items">
                <div class="remove_title">Profession</div>
                <div class="remove_item">
                <?php
                while($row=mysqli_fetch_array($getprofession)){
                ?>
                    <div id="pro<?php echo $row['0']?>" class="remove_single" onclick="removeDetails('profession',<?php echo $row['0']?>,'pro<?php echo $row['0']?>')"><i class="fa fa-times"></i> <?php echo $row['2']?></div>
                <?php
                }
                ?>
                </div>
            </div>
            <div class="remove_items">
                <div class="remove_title">Education</div>
                <div class="remove_item">
                <?php
                while($row=mysqli_fetch_array($geteducation)){
                ?>
                    <div id="edu<?php echo $row['0']?>" class="remove_single" onclick="removeDetails('education',<?php echo $row['0']?>,'edu<?php echo $row['0']?>')"><i class="fa fa-times"></i> <?php echo $row['2']?></div>
                <?php
                }
                ?>
                </div>
            </div>
            <div class="remove_items">
                <div class="remove_title">Experience</div>
                <div class="remove_item">
                <?php
                while($row=mysqli_fetch_array($getexperience)){
                ?>
                    <div id="exp<?php echo $row['0']?>" class="remove_single" onclick="removeDetails('experience',<?php echo $row['0']?>,'exp<?php echo $row['0']?>')"><i class="fa fa-times"></i> <?php echo $row['2']?></div>
                <?php
                }
                ?>
                </div>
            </div>
            <div class="remove_items">
                <div class="remove_title">Membership</div>
                <div class="remove_item">
                <?php
                while($row=mysqli_fetch_array($getmembership)){
                ?>
                    <div id="mem<?php echo $row['0']?>" class="remove_single" onclick="removeDetails('membership',<?php echo $row['0']?>,'mem<?php echo $row['0']?>')"><i class="fa fa-times"></i> <?php echo $row['2']?></div>
                <?php
                }
                ?>
                </div>
            </div>
            <div class="remove_items">
                <div class="remove_title">Video</div>
                <div class="remove_item">
                <?php
                while($row=mysqli_fetch_array($getvideo)){
                ?>
                    <div id="vid<?php echo $row['0']?>" class="remove_single" onclick="removeDetails('video',<?php echo $row['0']?>,'vid<?php echo $row['0']?>')"><i class="fa fa-times"></i> <?php echo $row['2']?></div>
                <?php
                }
                ?>
                </div>
            </div>
            <div class="remove_items">
                <div class="remove_title">Website</div>
                <div class="remove_item">
                <?php
                while($row=mysqli_fetch_array($getwebsite)){
                ?>
                    <div id="web<?php echo $row['0']?>" class="remove_single" onclick="removeDetails('website',<?php echo $row['0']?>,'web<?php echo $row['0']?>')"><i class="fa fa-times"></i> <?php echo $row['2']?></div>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </body>
    <script>
        document.getElementById('appoint').addEventListener('click',function(){
                window.location.assign('user.php');
            });
            document.getElementById('profile').addEventListener('click',function(){
                window.location.assign('user-profile.php');
            });
            document.getElementById('logo').addEventListener('click',function(){
                window.location.assign('index.php');
            });
            document.getElementById('status').addEventListener('click',function(){
                window.location.assign('docstatus.php');
            });
            function addDetails(user,hitype){
                var value=document.getElementById(hitype).value;
                document.getElementById(hitype).value="";
                var data={
                    username:user,
                    type:hitype,
                    text:value
                }
                $.post('adddetails.php',data);
                alert("Detail added");
            }
            function removeDetails(hitype,itemid,typeid){
                var data={
                    type:hitype,
                    id:itemid
                }
                $.post('removedetail.php',data);
                alert("Detail removed");
                document.getElementById(typeid).style.display="none";
            }
    </script>
    <?php
    if(isset($_POST['edit'])){
        $name=$_POST['name'];
        $nmc=$_POST['nmc'];
        $exp=$_POST['exp'];
        $fblink=$_POST['fblink'];
        $updateprofile=$con->connection->query("UPDATE signup SET name='$name',nmc='$nmc',yearofexp='$exp',facebooklink='$fblink' where username='$username'");
        if($updateprofile){
            ?>
            <script>
                alert("Profile updated");
            </script>
            <?php
        }
    }
    ?>
</html>