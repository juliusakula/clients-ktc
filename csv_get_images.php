<?php
include('images/CURLQuery.php');

ini_set('max_execution_time', 30000); //3000 seconds = 50 minutes !http://stackoverflow.com/a/5164954/3100494

$csv_data = array_map('str_getcsv', file('top_1000_industries.csv'));

foreach($csv_data as $key => $datum){
    //if($key <= 351) continue; // start from 352
    echo $key . ":" . $datum[0] . "\n";
    sleep(rand(5,15));
    get_company_image_from_string($datum[0], $key, "png transparent background");
    if($key % 10 == 0){
        sleep(10);
    }
    if($key % 60 == 0){
        sleep(60);
    }
}

?>