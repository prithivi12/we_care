<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="sign.css">
        <link rel="stylesheet" href="nav.css">
    </head>
    <body>
        <?php 
        include_once('DbConfig.php');
        $con=new DbConfig();
        if(isset($_POST['signup'])){
            header("location:usersignup.php");
        }
        include('nav.php'); 
        ?>
        <div class="container">
            <div class="sign">
                <img style="width:50%" class="sign_image" src="icons/broken.svg"/>
                <div class="sign_main">
                    <i style="color:red" class="fa fa-heartbeat"></i><span class="logo"> WE CARE</span>
                    <h2>Log In</h2>
                    <div class="sign_form">
                        <form method="POST">
                            <div id="sign_email" class="sign_input_dis inactive_input">
                                <span><i class="fa fa-at fa-2x" style="color:#ababab"></i></span>
                                <div>
                                    <p>Email</p>
                                    <input id="input_email" type="email" name="email" placeholder="Enter email" required>
                                </div>
                                
                            </div>
                            <div id="sign_password" class="sign_input_dis inactive_input">
                                <span><i class="fa fa-lock fa-2x" style="color:#ababab;"></i></span>
                                <div>
                                    <p>Password</p>
                                    <input id="input_pass" type="password" name="password" placeholder="Your Password" required>
                                </div>
                            </div>
                            <div class="sign_button">
                                <button name="signup" class="inactive" formnovalidate>Sign Up</button>
                                <button name="signin" class="active">Login In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('input_email').addEventListener('focus',function(){
                document.getElementById('sign_email').classList.remove('inactive_input');
                document.getElementById('sign_email').classList.add('active_input');
            });
            document.getElementById('input_email').addEventListener('blur',function(){
                document.getElementById('sign_email').classList.remove('active_input');
                document.getElementById('sign_email').classList.add('inactive_input');
            });
            document.getElementById('input_pass').addEventListener('focus',function(){
                document.getElementById('sign_password').classList.remove('inactive_input');
                document.getElementById('sign_password').classList.add('active_input');
            });
            document.getElementById('input_pass').addEventListener('blur',function(){
                document.getElementById('sign_password').classList.remove('active_input');
                document.getElementById('sign_password').classList.add('inactive_input');
            });
        </script>
        <?php
        if(isset($_POST['signin'])){
            $username=$_POST['email'];
            $password=$_POST['password'];
            $checkuser=$con->connection->query("SELECT * from usersignup where username='$username' and password='$password'");
            if($checkuser->num_rows!=0){
                $_SESSION['customer']=$username;
                ?>
                <script>window.location.assign("user-dashboard.php");</script>
                <?php
            }
            else{
                ?>
                <script>alert("Username or password doesnt match")</script>
                <?php
            }
        }
        ?>
    </body>
</html>