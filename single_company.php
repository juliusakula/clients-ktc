<?php
include('images/CURLQuery.php');
$id = $_REQUEST['id'];

$csv_data = array_map('str_getcsv', file('top_1000_industries.csv'));

foreach($csv_data as $key => $datum){
    if($key < $id) {
        echo $key;
        continue; // start from 352
    }
    echo "<br>" .$key . ":" . $datum[0] . "\n<br>";
    sleep(rand(5, 15));
    if($_REQUEST['extra']){
        $datum[0] .= " {$_REQUEST['extra']}";
    }
    get_company_image_from_string($datum[0], $key);
    exit();
}

?>