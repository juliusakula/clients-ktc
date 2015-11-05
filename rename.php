<?php

    $csv_data = array_map('str_getcsv', file('top_1000_industries.csv'));

    //replace all whitespaces with -
    function replace_white($name) {
        $name = preg_replace("/[\s]/", "-", $name);
        return $name;
    }


foreach($csv_data as $key => $datum){
    $name=$datum[0];
    echo "$key";
    echo "$row_name";



    $name=replace_white($name);

    $src= "cleaned_1000/{$key}.png";
    $dest="images/{$name}.png";


    $cp_string="cp {$src} {$dest}";

    exec($cp_string);

    echo $cp_string;

    echo $key . ":" . $datum[0] . "\n";

}

?>