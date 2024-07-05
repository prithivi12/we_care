<?php
    $cases_obj = new stdClass();
    $deaths_obj = new stdClass();
    $recovered_obj = new stdClass();
    $context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));    
    $sum_url = 'https://data.nepalcorona.info/api/v1/covid/summary';
    $json_sum = file_get_contents($sum_url,false,$context);
    $response_sum= json_decode($json_sum,true);
    $response_cases=$response_sum['district']['cases'];
    $response_deaths=$response_sum['district']['deaths'];
    $response_recovered=$response_sum['district']['recovered'];
    foreach($response_cases as $row){
        $cases_obj->{$row['district']}=$row['count'];
    }
    foreach($response_deaths as $row){
        $deaths_obj->{$row['district']}=$row['count'];
    }
    foreach($response_recovered as $row){
        $recovered_obj->{$row['district']}=$row['count'];
    }
?>