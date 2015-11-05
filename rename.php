<?php

$csv_data = array_map('str_getcsv', file('top_1000_industries.csv'));

//replace all whitespaces with -
function replace_white($name) {
    $name = preg_replace("/[\s]/", "-", $name);
    return $name;
}

foreach($csv_data as $key => $datum){
    $name=replace_white($datum[0]);

    $src= "cleaned_1000/{$key}.png";
    $dest="images/{$name}.png";
    $cp_string="cp {$src} {$dest}";

    #exec($cp_string);
    #echo $cp_string;
    echo "<div style=\"background-color: #dfdfdf\">";
    echo "<h1>{$name} <i><small>row#{$key}</small></i></h1> <img src=\"{$dest}\">";
    echo "</div>";
    
}
?>