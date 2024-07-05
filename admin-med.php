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
         ?>
         <div id="navigation">
            <span id="logo"><a href="index.php">We Care.</a></span>
            <div class="nav_item">
                <span id="booking"><a href="admin-dash.php">Doctors</a></span>
                <span id="request"><a href="admin-request.php">New Request</a></span>
                <span id="medicine" class="active_link"><a href="admin-med.php">Medicine</a></span>
            </div>
            <div id="logout_but">
                <i class="fa fa-user-circle"></i>
                <span><?php echo $_SESSION['admin']?></span>
            </div>
        </div>
        <div id="menu_main">
            <p class="app_header">Add Medicine</p>
            <form method="POST" enctype="multipart/form-data">
                <p>Medicine Name *</p>
                <input type="text" name="name" required>
                <p>Price *</p>
                <input type="number" name="price" required>
                <p>Sample Picture *</p>
                <input type="file" name="photo" id="file" class="inputfile" required>
                <label class="file_but" for="file"><i class="fa fa-download"></i> Choose a file</label>
                <button name="add" id="form_button">Add Medicine</button>
            </form>
        </div>
    </body>
    <?php
        if(isset($_POST['add'])){
            $name=$_POST['name'];
            $price=$_POST['price'];
            $photo_name = $_FILES['photo']['name'];
            $photo_size = $_FILES['photo']['size'];
            $photo_tmp = $_FILES['photo']['tmp_name'];
            $photo_type = $_FILES['photo']['type'];
            $explode_result=explode('.',$photo_name);
            $photo_ext=strtolower(end($explode_result));
            $extensions= array("jpeg","jpg","png");
            if(in_array($photo_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if($photo_size > 5097152) {
            $errors[]='File size must be less than 4 MB';
            }
            if(empty($errors)==true) {
            move_uploaded_file($photo_tmp,"medicine/".$name.".jpg");
              }
            $insert=$con->connection->query("INSERT into medicine values('','$name','$price')");
            if($insert){
                ?>
                <script>
                    alert("Medicine added successfully");
                </script>
                <?php
            }
        }
    ?>
</html>