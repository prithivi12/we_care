<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Lato&family=Playfair+Display&family=Roboto:wght@900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="user.css">
    </head>
    <body>
        <?php
        session_start();
        include_once('DbConfig.php');
        $con=new DbConfig();
        ?>
        <span id="goback" style="position:relative;top:15px;left:15px">
            <i class="fa fa-angle-double-left" style="color:#268EA5"></i><span style="color:#268EA5;font-weight:bold"> Go back</span>
        </span>
        <div id="background">
        </div>
        <div id="main_body">
            <h1 style="color:#268EA5;padding-left:15%">Setup Profile</h1>
            <form id="setup_form" method="POST" enctype="multipart/form-data">
                <img id="doc_svg" src="icons/doctor_profile.svg">
                <div>
                    <div id="sign_deg" class="sign_input_dis inactive_input">
                        <span><i class="fa fa-graduation-cap" style="color:#ababab;"></i></span>
                        <div>
                        <p>Degree *</p>
                        <input id="input_deg" type="text" name="deg" placeholder="Your degree" required>
                        </div>
                     </div>
                     <div id="sign_nmc" class="sign_input_dis inactive_input">
                        <span><i class="fa fa-hashtag" style="color:#ababab;"></i></span>
                        <div>
                        <p>NMC *</p>
                        <input id="input_nmc" type="number" name="nmc" placeholder="NMC" required>
                        </div>
                     </div>
                     <div id="sign_exp" class="sign_input_dis inactive_input">
                        <span><i class="fa fa-calendar" style="color:#ababab;"></i></span>
                        <div>
                        <p>Your Experience</p>
                        <input id="input_exp" type="number" name="exp" placeholder="Experience" required>
                        </div>
                     </div>
                     <div id="sign_fb" class="sign_input_dis inactive_input">
                        <span><i class="fa fa-facebook-square" style="color:#ababab;"></i></span>
                        <div>
                        <p>Your Facebook link</p>
                        <input id="input_fb" type="text" name="fblink" placeholder="Url link of your fb acc">
                        </div>
                     </div>
                     <div id="sign_profilepic" class="picpic">
                        <div>
                            <input type="file" name="photo" class="inputfile">
                            <label class="file_but" for="file"><i class="fa fa-user-circle"></i> Choose profile picture..</label>
                        </div>
                     </div>
                     <div id="sign_registration" class="picpic">
                        <div>
                            <input type="file" name="registration" class="inputfile">
                            <label class="file_but" for="file"><i class="fa fa-address-card"></i> Choose Verification card</label>
                        </div>
                     </div>
                     <div style="display:grid; justify-items:center;">
                        <button name="saveprofile">Save Profile</button>
                     </div>
                </div>
            </form>
        </div>
    </body>
    <script>
            document.getElementById('goback').addEventListener('click',function(){
                window.location.assign('index.php');
            });
             document.getElementById('input_deg').addEventListener('focus',function(){
                document.getElementById('sign_deg').classList.remove('inactive_input');
                document.getElementById('sign_deg').classList.add('active_input');
            });
            document.getElementById('input_deg').addEventListener('blur',function(){
                document.getElementById('sign_deg').classList.remove('active_input');
                document.getElementById('sign_deg').classList.add('inactive_input');
            });
            document.getElementById('input_nmc').addEventListener('focus',function(){
                document.getElementById('sign_nmc').classList.remove('inactive_input');
                document.getElementById('sign_nmc').classList.add('active_input');
            });
            document.getElementById('input_nmc').addEventListener('blur',function(){
                document.getElementById('sign_nmc').classList.remove('active_input');
                document.getElementById('sign_nmc').classList.add('inactive_input');
            });
            document.getElementById('input_exp').addEventListener('focus',function(){
                document.getElementById('sign_exp').classList.remove('inactive_input');
                document.getElementById('sign_exp').classList.add('active_input');
            });
            document.getElementById('input_exp').addEventListener('blur',function(){
                document.getElementById('sign_exp').classList.remove('active_input');
                document.getElementById('sign_exp').classList.add('inactive_input');
            });
            document.getElementById('input_fb').addEventListener('focus',function(){
                document.getElementById('sign_fb').classList.remove('inactive_input');
                document.getElementById('sign_fb').classList.add('active_input');
            });
            document.getElementById('input_fb').addEventListener('blur',function(){
                document.getElementById('sign_fb').classList.remove('active_input');
                document.getElementById('sign_fb').classList.add('inactive_input');
            });
        </script>
    <?php
    if(isset($_POST['saveprofile'])){
        $username=$_SESSION['username'];
        $degree=$_POST['deg'];
        $nmc=$_POST['nmc'];
        $exp=$_POST['exp'];
        $fblink=$_POST['fblink'];
        $photo_name = $_FILES['photo']['name'];
      	$photo_size = $_FILES['photo']['size'];
      	$photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_type = $_FILES['photo']['type'];
        $cit_name = $_FILES['registration']['name'];
      	$cit_size = $_FILES['registration']['size'];
      	$cit_tmp = $_FILES['registration']['tmp_name'];
      	$cit_type = $_FILES['registration']['type'];
      	$explode_result=explode('.',$photo_name);
        $photo_ext=strtolower(end($explode_result));
        $explode_result1=explode('.',$cit_name);
      	$cit_ext=strtolower(end($explode_result1));
      	$extensions= array("jpeg","jpg","png");
      	if(in_array($photo_ext,$extensions)=== false and in_array($cit_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      	}
      	if($photo_size > 5097152 and $cit_size>5097152) {
         $errors[]='File size must be less than 4 MB';
      	}
      	if(empty($errors)==true) {
         move_uploaded_file($photo_tmp,"profileimage/".$username.".jpg");
         move_uploaded_file($cit_tmp,"citizenship/".$username.".jpg");
      	}
          $insert=$con->connection->query("UPDATE signup SET nmc='$nmc',yearofexp='$exp',facebooklink='$fblink',profile='1' where username='$username'");
          $insertdegree=$con->connection->query("INSERT into degree values('','$username','$degree')");
          if($insert and $insertdegree){
              ?>
              <script>
                  window.location.assign("user.php");
              </script>
              <?php
          }
    }
    ?>
</html>