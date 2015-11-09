<?php

$csv_data = array_map('str_getcsv', file('/Users/devon/Documents/clients-ktc/top_1000_industries.csv'));

//replace all whitespaces with -
function replace_white($name) {
    $name = preg_replace("/[\s]/", "-", $name);
    $name = preg_replace("/'/", "", $name);
    return $name;
}

echo '<script type="text/javascript" src="jquery-1.11.3.min.js"></script>';
echo '<link text="text/css" rel="stylesheet" href="styles.css">';

foreach($csv_data as $key => $datum){
    $name=replace_white($datum[0]);

    $src= "C:/git-lyris/parse-data-dot-com/images/{$key}.png";
    $dest="C:/git-lyris/parse-data-dot-com/images/{$name}.png";
    $dest_url="images/{$key}.png";
    $cp_string="cp {$src} {$dest}";

    //$result = exec($cp_string);
    echo $cp_string . "\n<br>";
    echo $result;
    echo "<div class=\"logo logo{$key}\">";
    echo "<h1>{$name} <i><small>row#{$key}</small></i></h1> <img src=\"{$dest_url}\">";
    echo "</div>";
    
}
?>