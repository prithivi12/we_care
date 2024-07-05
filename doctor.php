<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="doctor.css">
        <link rel="stylesheet" href="nav.css">
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
        include_once('DbConfig.php');
        $con=new DbConfig();
        if(isset($_POST['search_doc'])){
            ?>
            <script>
                window.location.assign("doctor.php?name=<?php echo $_POST['doctor'] ?>");
            </script>
            <?php
            header("location:doctor.php?name=".$_POST['doctor']);
        }
        include('nav.php');
        ?>
        <div id="search_body">
            <div id="label_form">
                <label>Find Doctors<i class="fa fa-stethoscope"></i></label>
                <div class="vl"></div>
            </div>
            <form id="search_form" method="POST">
                <input type="text" name="doctor" placeholder="Search doctor by name"/>
                <button name="search_doc" id="search_button"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <div class="services">
            <div id="get_paediatrics">
                <img class="service_image" src="icons/child.svg"><br>
                <span class="service_text">Paediatrics</span>
            </div>
            <div id="get_rheumatology">
                <img class="service_image" src="icons/bone.svg"><br>
                <span class="service_text">Rheumatology</span>
            </div>
            <div id="get_urology">
                <img class="service_image" src="icons/kidney.svg"><br>
                <span class="service_text">Urology</span>
            </div>
            <div id="get_psychiatry">
                <img class="service_image" src="icons/brain.svg"><br>
                <span class="service_text">Psychiatry</span>
            </div>
            <div id="get_cardiology">
                <img class="service_image" src="icons/heart.svg"><br>
                <span class="service_text">Cardiology</span>
            </div>
            <div id="get_dentist">
                <img class="service_image" src="icons/dentist.svg"><br>
                <span class="service_text">Dentist</span>
            </div>
            <div id="get_gyneocology">
                <img class="service_image" src="icons/pregnant.svg"><br>
                <span class="service_text">Gyneocology</span>
            </div>
            <div id="get_surgeon">
                <img class="service_image" src="icons/doctor.svg"><br>
                <span class="service_text">Surgeon</span>
            </div>
            <div id="get_dermatologist">
                <img class="service_image" src="icons/skin.svg"><br>
                <span class="service_text">Dermatologist</span>
            </div>
            <div id="get_earnosethroat">
                <img class="service_image" src="icons/larynx.svg"><br>
                <span class="service_text">Ear nose throat</span>
            </div>
            <div id="get_physiotherapy">
                <img class="service_image" src="icons/no_service.png"><br>
                <span class="service_text">Physiotherapy</span>
            </div>
            <div id="get_neurologist">
                <img class="service_image" src="icons/no_service.png"><br>
                <span class="service_text">Neurologist</span>
            </div>
            <div id="get_endocrinology">
                <img class="service_image" src="icons/Endocrinology.png"><br>
                <span class="service_text">Endocrinology</span>
            </div>
            <div id="get_plasticsurgeon">
                <img class="service_image" src="icons/no_service.png"><br>
                <span class="service_text">Plastic surgeon</span>
            </div>
        </div>
        <div id="status_cont">
            <div id="status_info">
                <div><img src="icons/checked.png"><span>Available</span></div>
                <div><img src="icons/cancel.png"><span>Not Available</span></div>
            </div>
        </div>
        <div id="search_results">
        <?php
            if(isset($_GET['name'])){
                $name=$_GET['name'];
                $getdoctor=$con->connection->query("SELECT * from signup where name LIKE '%$name%' && active='1'");
                while($row=mysqli_fetch_array($getdoctor)){
                    $id=$row['0'];
                    $name=$row['1'];
                    $username=$row['2'];
                    $getprofession=$con->connection->query("SELECT * from profession where username='$username'");
                    $getstatus=$con->connection->query("SELECT status from status where docusername='$username'");
                    $row=mysqli_fetch_array($getstatus);
                    $icon="checked.png";
                    if($row[0]=="off"){
                        $icon="cancel.png";
                    }
                    ?>
                    <div class="search_items">
                        <div class="doc_image" style="background-image: url('profileimage/<?php echo $username?>.JPG')"></div>
                        <div class="doc_info_info">
                            <h3><span>Dr. </span><?php echo $name?><img class="img_status_style" src="icons/<?php echo $icon?>"></h3>
                            <p><?php 
                            while($prorow=mysqli_fetch_array($getprofession)){
                                echo $prorow['2']."  ";
                            }?></p>
                        </div>
                        <div class="doc_info_pro" onClick="getdocprofile('<?php echo $id?>')" style="cursor:pointer">
                            See Profile  <i class="fa fa-angle-double-right"></i>
                        </div>
                </div>
                <?php
                }
            }
            if(isset($_GET['profession'])){
                $profession=$_GET['profession'];
                $getdoctor=$con->connection->query("SELECT * from profession where profession LIKE '%$profession%'");
                while($row=mysqli_fetch_array($getdoctor)){
                    $username=$row['1'];
                    $profession=$row['2'];
                    $getname=$con->connection->query("SELECT * from signup where username='$username'");
                    $getstatus=$con->connection->query("SELECT status from status where docusername='$username'");
                    $row=mysqli_fetch_array($getstatus);
                    $icon="checked.png";
                    if($row[0]=="off"){
                        $icon="cancel.png";
                    }
                    while($prorow=mysqli_fetch_array($getname)){
                        $name=$prorow['1'];
                        $id=$prorow['0'];
                    }?>
                <div class="search_items">
                    <div class="doc_image" style="background-image: url('profileimage/<?php echo $username?>.JPG')"></div>
                        <div class="doc_info_info">
                            <h3><span>Dr. </span><?php echo $name?><img class="img_status_style" src="icons/<?php echo $icon?>"></h3>
                            <p><?php echo $profession?></p>
                        </div>
                        <div class="doc_info_pro" onClick="getdocprofile('<?php echo $id?>')" style="cursor:pointer">
                            See Profile  <i class="fa fa-angle-double-right"></i>
                        </div>
                </div>
                <?php
                }
            }
            ?>
        </div>
        <div id="doc_profile">
            <?php
            if(isset($_GET['profile'])){
                $proid=$_GET['profile'];
                $id=$con->connection->query("SELECT * from signup where id='$proid'");
                while($row=mysqli_fetch_array($id)){
                    $profile=$row['2'];
                }
                $getdoctor=$con->connection->query("SELECT * from signup where username='$profile'");
                $getdegree=$con->connection->query("SELECT * from degree where username='$profile'");
                $getdegree1=$con->connection->query("SELECT * from degree where username='$profile'");
                $getdetail=$con->connection->query("SELECT * from profile where username='$profile'");
                $getprofession=$con->connection->query("SELECT * from profession where username='$profile'");
                $getprofession1=$con->connection->query("SELECT * from profession where username='$profile'");
                $geteducation=$con->connection->query("SELECT * from education where username='$profile'");
                $getexperience=$con->connection->query("SELECT * from experience where username='$profile'");
                $getmembership=$con->connection->query("SELECT * from membership where username='$profile'");
                $getwebsite=$con->connection->query("SELECT * from website where username='$profile'");
                $getvideo=$con->connection->query("SELECT * from video where username='$profile'");
                while($doc=mysqli_fetch_array($getdoctor)){
                    $id=$doc['0'];
                    $name=$doc['1'];
                    $username=$doc['2'];
                    $nmc=$doc['4'];
                    $exp=$doc['5'];
                    $fblink=$doc['6'];
                    ?>
            <div class="doc_detail">
                <img style="height:100px;width:100px;border-radius:50%" class="doc_image" src="profileimage/<?php echo $username?>.JPG">
                <h3>Dr. <?php echo $name?></h3>
                <span><?php while($row=mysqli_fetch_array($getdegree)){echo $row['2'];}?></span><br>
                <span><?php while($row=mysqli_fetch_array($getprofession)){echo $row['2']."  ";}?></span><br>
                <span><i class="fa fa-history"></i> <?php echo $exp?> years of experience</span><br>
                <button style="background-color:#c80a61" class="doc_button"><i class="fa fa-calendar" style="color:white"></i><a style="text-decoration: none;color:white" href="appointment.php?id=<?php echo $id?>"> Book Appointment</a></button><br>
                <button style="background-color:#0570E6;" class="doc_button"><i class="fa fa-facebook"></i><a style="text-decoration: none;color:white" href="<?php echo $fblink?>"> Connect on facebook</a></button>
            </div>
            <div class="doc_info">
                <h2>Dr. <?php echo $name?></h2>
                <h4 style="color:#77777B"><?php while($row=mysqli_fetch_array($getdegree1)){echo $row['2'];}?></h4>
                <h5 style="color:#77777b">NMC Number - <?php echo $nmc?></h5>
                <p>
                <?php while($row=mysqli_fetch_array($getdetail)){echo $row['2'];}?>
                </p>
                <div class="doc_info_item">
                    <p style="font-weight:bold;">Speciality</p>
                    <div style="color:grey">
                    <?php while($row=mysqli_fetch_array($getprofession1)){
                        ?>
                        <p><i class="fa fa-caret-right"></i> <?php echo $row['2'];?></p>
                    <?php
                    }?>
                    </div>
                </div>
                <div class="doc_info_item">
                    <p style="font-weight:bold;">Education</p>
                    <div style="color:grey">
                        <?php while($row=mysqli_fetch_array($geteducation)){
                        ?>
                        <p><i class="fa fa-caret-right"></i> <?php echo $row['2'];}?></p>
                    </div>
                </div>
                <div class="doc_info_item">
                    <p style="font-weight:bold;">Experience</p>
                    <div style="color:grey">
                        <?php while($row=mysqli_fetch_array($getexperience)){
                        ?>
                        <p><i class="fa fa-caret-right"></i>  <?php echo $row['2'];}?></p>
                    </div>
                </div>
                <div class="doc_info_item">
                    <p style="font-weight:bold;">Memberships</p>
                    <div style="color:grey">
                        <?php while($row=mysqli_fetch_array($getmembership)){
                        ?>
                        <p><i class="fa fa-caret-right"></i>  <?php echo $row['2'];}?></p>
                    </div>
                </div>
                <div class="doc_info_item">
                    <p style="font-weight:bold;">Website</p>
                    <div style="color:grey">
                        <?php while($row=mysqli_fetch_array($getwebsite)){
                        ?>
                        <p><?php echo $row['2'];}?></p>
                    </div>
                </div>
                <div class="doc_info_video">
                    <p style="font-weight:bold;">His Videos</p>
                    <div style="color:grey">
                    <?php while($row=mysqli_fetch_array($getvideo)){
                        ?>
                    <iframe width="420" height="345" src="https://www.youtube.com/embed/<?php echo $row['2'];?>"></iframe><?php
                }
                ?>
                    </div>
                </div>
            </div><?php
                }
            }
            ?>
        </div>
        <script>
            var paediatrics=document.getElementById('get_paediatrics');
            var rheumatology=document.getElementById('get_rheumatology');
            var urology=document.getElementById('get_urology');
            var psychiatry=document.getElementById('get_psychiatry');
            var cardiology=document.getElementById('get_cardiology');
            var dentist=document.getElementById('get_dentist');
            var gyneocology=document.getElementById('get_gyneocology');
            var surgeon=document.getElementById('get_surgeon');
            var dermatologist=document.getElementById('get_dermatologist');
            var earnosethroat=document.getElementById('get_earnosethroat');
            var physiotherapy=document.getElementById('get_physiotherapy');
            var neurologist=document.getElementById('get_neurologist');
            var endocrinology=document.getElementById('get_endocrinology');
            var plasticsurgeon=document.getElementById('get_plasticsurgeon');
            paediatrics.addEventListener('click',function(){
                callProfession('paediatrics');
            });
            rheumatology.addEventListener('click',function(){
                callProfession('rheumatology');
            });
            urology.addEventListener('click',function(){
                callProfession('urology');
            });
            psychiatry.addEventListener('click',function(){
                callProfession('psychiatry');
            });
            cardiology.addEventListener('click',function(){
                callProfession('cardiology');
            });
            dentist.addEventListener('click',function(){
                callProfession('dentist');
            });
            gyneocology.addEventListener('click',function(){
                callProfession('gyneocology');
            });
            surgeon.addEventListener('click',function(){
                callProfession('surgeon');
            });
            dermatologist.addEventListener('click',function(){
                callProfession('dermatologist');
            });
            earnosethroat.addEventListener('click',function(){
                callProfession('ear nose throat')
            });
            physiotherapy.addEventListener('click',function(){
                callProfession('physiotherapy');
            });
            neurologist.addEventListener('click',function(){
                callProfession('neurologist');
            });
            endocrinology.addEventListener('click',function(){
                callProfession('endocrinology');
            });
            plasticsurgeon.addEventListener('click',function(){
                callProfession('plastic surgeon')
            });
            function callProfession(profession){
                window.location.assign('doctor.php?profession='+profession);
            }
            function getdocprofile(name){
                window.location.assign('doctor.php?profile='+name);
            }
        </script>
    </body>
</html>