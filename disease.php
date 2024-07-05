<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,500&family=Nunito&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="nav.css">
        <link rel="stylesheet" href="disease.css">
    </head>
    <?php
    if(isset($_POST['search_dis'])){
        $disease=$_POST['disease'];
        ?>
        <script>window.location.assign("disease.php?disease=<?php echo $disease;?>");</script>
        <?php
    }
    ?>
    <body>
        <?php
        include('nav.php');
        ?>
      <div id="main_body">
        <div id="search_body">
            <div id="label_form">
                <label>Disease</label>
                <div class="vl"></div>
            </div>
            <form id="search_form" method="POST">
                <input type="text" name="disease" placeholder="Type in disease name to get info (Try rabies)"/>
                <button name="search_dis" id="search_button"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <?php
            if(isset($_GET['disease'])){
                $disease=$_GET['disease'];
                $url="https://disease-info-api.herokuapp.com/diseases/".$disease.".json";
                //for not showing warning msg
                error_reporting(E_ERROR | E_PARSE);
                if(file_get_contents($url)===FALSE){
                    ?>
                    <script>
                        alert("Sorry couldnt find about it");
                    </script>
                    <?php
                }
                else{
                $getjson=json_decode(file_get_contents($url),true);
                $json=$getjson['disease'];
            ?>
        <div id="disease_details">
            <p id="disease_title"><?php echo $json['name']?></p>
            <div id="disease_info">
                <span id="update_status">
                    Status: 
                    <?php if($json['is_active']==true){
                    echo "active";}
                else{echo "inactive";}?></span>
                <span id="update_date">Updated at: <?php echo $json['data_updated_at']?></span>
            </div>
            <p class="disease_details"><?php echo implode(".",$json['facts'])?></p>
            <p class="disease_mini">Symptoms:</p>
            <p class="disease_details"><?php echo $json['symptoms']?></p>
            <p class="disease_mini">Transmission:</p>
            <p class="disease_details"><?php echo $json['transmission']?></p>
            <p class="disease_mini">Diagnosis:</p>
            <p class="disease_details"><?php echo $json['diagnosis']?></p>
            <p class="disease_mini">Prevention:</p>
            <p class="disease_details"><?php echo $json['prevention']?></p>
            <p class="disease_mini">Treatment:</p>
            <p class="disease_details"><?php echo $json['treatment']?></p>
        </div>
      </div>
      <?php }}?>
    </body>
</html>