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
          <div id="logout">
            <i class="fa fa-sign-out" style="color:black"></i>
         </div>
         <div id="navigation">
            <span id="logo"><a href="index.php">We Care.</a></span>
            <div class="nav_item">
                <span id="booking" class="active_link"><a href="admin-dash.php">Doctors</a></span>
                <span id="request"><a href="admin-request.php">New Request</a></span>
                <span id="medicine"><a href="admin-med.php">Medicine</a></span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $_SESSION['admin']?></span>
            </div>
        </div>
        <div id="search_doc">
            <form method="POST" action="admin-dash.php">
                <input name="name" type="text" placeholder="Search Doctors .."/>
            </form>
        </div>
        <div id="search_main">
            <?php
            if(isset($_GET['name'])){
                $name=$_GET['name'];
                $getdoctor=$con->connection->query("SELECT * from signup where name LIKE '%$name%'");
                while($row=mysqli_fetch_array($getdoctor)){
                    $id=$row['0'];
                    $name=$row['1'];
                    $username=$row['2'];
                ?>
            <div id="<?php echo $id?>" class="search_items">
                <img class="search_img" src="profileimage/rabin@gmail.com.jpg">
                <span><?php echo $name?></span>
                <span><span>NMC no: </span><?php echo $row['4']?></span>
                <span><?php echo $row['5']?><span> Years of exp</span></span>
                <i onclick="deleteUser('<?php echo $id?>')" class="fa fa-trash"></i>
            </div>
            <?php
            }
            }
            ?>
        </div>
    </body>
    <script>
         var logout=document.getElementById('logout');
            logout.addEventListener('click',function(){
                $.post('logout.php',"logout");
                window.location.assign('index.php');
            });
        function deleteUser(userid){
            var  del=confirm("Do you really want to delete this user?");
            if(del==true){
                    var data={
                    id:userid
                }
                $.post('removedoc.php',data);
                alert("User deleted");
                document.getElementById(userid).style.display="none";
            }
        }
    </script>
</html>