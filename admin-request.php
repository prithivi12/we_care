<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="admin-dash.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
    <?php 
            session_start();
            $username=$_SESSION['admin'];
            include_once('DbConfig.php');
            $con=new DbConfig();
            if(isset($_POST['name'])){
                $name=$_POST['name'];
                ?>
                <script>
                    window.location.assign("admin-dash.php?name=<?php echo $name ?>");
                </script>
                <?php
            }
         ?>
         <div id="navigation">
            <span id="logo"><a href="index.php">We Care.</a></span>
            <div class="nav_item">
                <span id="booking"><a href="admin-dash.php">Doctors</a></span>
                <span id="request" class="active_link"><a href="admin-request.php">New Request</a></span>
                <span id="medicine"><a href="admin-med.php">Medicine</a></span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $_SESSION['admin']?></span>
            </div>
        </div>
        <div id="verify_doc">
            <?php
            $getuser=$con->connection->query("SELECT * from signup where active='0' AND profile='1'");
            while($row=mysqli_fetch_array($getuser)){
            ?>
            <div id="<?php echo $row['0']?>" class="verify_doc_id">
                <div class="verify_main">
                    <div class="verify_sec">
                        <h3 style="text-align:center">Doctor Info</h3>
                        <img class="verify_profile" src="profileimage/<?php echo $row['2']?>.jpg">
                        <span><?php echo $row['1']?></span>
                        <span><span>NMC no : </span><?php echo $row['4']?></span>
                        <span><span>Years of exp : </span><?php echo $row['5']?></span>
                        <button onclick="location.href='<?php echo $row['6']?>'" type="button" class="button fb_but"><i class="fa fa-facebook-f"></i> Visit his facebook profile</button>
                    </div>
                    <div class="verifY_img">
                        <img class="verify_image" src="citizenship/<?php echo $row['2']?>.jpg">
                    </div>
                </div>
                <button class="button" onclick="verifyDoc('<?php echo $row['0']?>','<?php echo $row['2']?>')">Verify</button>
            </div>
            <?php
            }
            ?>
        </div>
    </body>
    <script>
        function verifyDoc(docid,docusername){
            var oops=confirm("Are you sure want to verify doctor?");
            if(oops==true){
                var data={
                id:docid,
                username:docusername
            }
            $.post('activedoc.php',data);
            document.getElementById(docid).style.display="none";
            alert("An email has been sent to user on completion of verification");
            }

        }
    </script>
</html>