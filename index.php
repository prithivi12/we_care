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
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@900&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="nav.css">
    </head>
    <body>
        <?php
            $api_url = 'https://corona.askbhunte.com/api/v1/data/nepal';
            $json_data = file_get_contents($api_url);
            $response_data = json_decode($json_data);
            
            $positive=$response_data->tested_positive;
            $recovered=$response_data->recovered;
            $deaths=$response_data->deaths;
        ?>
       <?php include('nav.php')?>
        <div id="search_body">
            <div id="search_body_doc">
                <p>Your Go To Healthcare</p>
                <p style="padding-bottom:15px">Book yourself an appointment</p>
                <button onclick="location.href = 'doctor.php'">Get Started</button>
            </div>
            <div id="search_body_container">
                <img src="icons/doc1.svg">
            </div>
        </div>
        <div class="info_body_holder" id="search_body_med">
                <img src="icons/Farmacy.svg">
                <div>
                    <p>Learn About Medicines</p>
                    <p>Expand your knowledge about your day to day medicines</p>
                    <button onclick="location.href = 'medicine.php'">Buy Medicines</button>
                </div>
         </div>
        <div style="background-color: #003049;">
            <div class="info_body_holder" id="search_body_hos">
                <div>
                    <p>Search Healthcare Around You</p>
                    <button onclick="location.href = 'hospital.php'">Find Out</button>
                </div>
                <img src="icons/doc2.png">
            </div>
        </div>
        <div style="background-color: white">
            <div class="info_body_holder" id="search_body_covid">
                <img src="icons/covid_icon.svg">
                <div class="search_body_covid_div">
                    <p class="search_body_covid_p">Get Covid Latest Data</p>
                    <div class="covid_index_data">
                        <div>
                            <p><b>Total cases</b></p>
                            <p><?php echo $positive?></p>
                        </div>
                        <div>
                            <p><b>Recovered</b></p>
                            <p><?php echo $recovered?></p>
                        </div>
                        <div>
                             <p><b>Deaths</b></p>
                            <p><?php echo $deaths?></p>
                        </div>
                    </div>
                    <button onclick="location.href = 'covid.php'">Check Out More</button>
                </div>
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