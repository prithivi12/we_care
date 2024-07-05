<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="nav.css">
        <link rel="stylesheet" href="loginsel.css">
    </head>
    <body>
        <?php
            include('nav.php');
        ?>
        <div id="selection_container">
            <div><img id="selection_img" src="icons/loginsel.png"></div>
            <div style="color:#FF1A00;font-weight:bold;font-size:1.4em;">Login As</div>
            <div id="selection_main">
                <div>
                    <img src="icons/docdoc.svg">
                    <button class="but_but" onclick="getLogin('doctor')">As a Doctor</button>
                </div>
                <div>
                    <img src="icons/broken.svg">
                    <button class="but_but" onclick="getLogin('patient')">As a Patient</button>
                </div>
            </div>
        </div>
    </body>
    <script>
        function getLogin(value){
            if(value=='doctor'){
                window.location.assign("signin.php");
            }
            else{
                window.location.assign("usersignin.php");
            }
        }
    </script>
</html>