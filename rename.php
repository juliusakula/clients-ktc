<?php

$csv_data = array_map('str_getcsv', file('top_1000_industries.csv'));

foreach($csv_data as $key => $datum){
    $name=$datum[0];
    echo $key . ":" . $datum[0] . "\n";

}

?>