<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="nav.css">
    </head>
    <body>
       <?php include('nav.php')?>
        <div id="search_body">
            <div id="search_body_container">
                <span style="font-family: 'Merriweather', serif;">Know Your Diseases Better</span>
                <span>We care about your wellbeing</span>
                <form id="search_form" method="POST">
                    <input type="text" name="disease"/>
                    <button name="search_dis" id="search_button"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </body>
    <?php
       if(isset($_POST['search_dis'])){
          ?>
          <script>
            window.location.assign("disease.php?disease=<?php echo $_POST['disease'] ?>");
          </script>
          <?php
       }
    ?>
</html>