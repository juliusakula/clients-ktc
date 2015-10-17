<?php
# !http://stackoverflow.com/a/260609/3100494
# Simple DOM HTML
include('simple_dom_html.php');
ob_start();
include('top_200_links.html');
include('images/CURLQuery.php');
// Create DOM from that copypasta
$RAW_html = ob_get_clean();

#echo $RAW_html;
ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes !http://stackoverflow.com/a/5164954/3100494

$VERBOSE = 2;


$main_html = new simple_html_dom();
$main_html->load($RAW_html);

// Find the exact thing -- the links! (each row of the CSV) ------------------------------
$i =0;
$links = array();
foreach($main_html->find('tr > td > a') as $ele){
    global $links;
    $str = $ele->href;
    // Print it!
    #if($str == "Industries"){
    //print_r($i . ":{$str}<br>");
        #$industries = $html->find('.seo-company-info > table > tbody tr:nth-child(5) > .seo-company-data', $i)->innertext;
        
    #}
    array_push($links, $str);
    $i++; 
}

#var_dump($links);
// ---------------------------------------------------------------------------------------
$test_link = $links[0];
$J = 0;
$max_loop_count = 200;
$fp = fopen('top_200_industries.csv', 'w'); //fputcsv at the end of each loop
foreach($links as $link){
    if($J < $max_loop_count){
    ob_start();
// ---------------------------------------------------------------------------------------
    #echo $link . "<br>";

// ----------------- we 

#echo $test_link;

$html = new simple_html_dom();
$this_to_parse = "https://connect.data.com" . $link;
#echo $this_to_parse . "\n";

// DO NOT DDOS THESE PPL. Have been blacklisted from my home IP. As if there's no way around that, but still a P.I.T.A
$rand_seconds = rand(2, 13); // 2 to 13 second delay between requests. 1-10 is just as arbitrary
sleep($rand_seconds);
$dom = $html->load_file($this_to_parse);
if (!empty($dom)){
    #echo "Loaded file!<br>";
}                                                                                           

// Find the exact thing -- industries array --------------------------------------------
$i = 0;
$industries = '';
$location = '';
$name = '';
$website = '';
$size = '';
foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'5\') > .seo-company-label') as $ele){
    global $industries;
    $str = $ele->innertext;
    if($str == "Industries"){
        $industries = $html->find('.seo-company-info > table > tbody tr:nth-child(5) > .seo-company-data', $i)->innertext;
    }
    if($str == "Headquarters"){
        $location = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;    
    }
    if($str == "Name"){
        $name = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
        $name = str_replace(",", "", $name); //remove commas
    }
    if($str == "Website"){ 
        $website = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
        
    }
    if($str == "Employees"){ 
        $size = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
                                                                
        $size = ltrim(rtrim(preg_replace('/(\s)+/', ' ', html_entity_decode($size) ) ));
    }
    #echo $str . "\n";
    $i++; 
}
if ($VERBOSE > 0) echo $name;
// ---------------------------------------------------------------------------------------

// deal with location that we created above ^^;
$city_state_line = explode('\r\n',preg_replace('/(\s)+/', ' ', $location));
$city_state_line = explode('\r\n', $city_state_line[0]);
$city_state_line = preg_replace('/(\s)+/', ' ', $city_state_line[0]);
$city_state = explode('  ', $location);
$clean_city_states = array();
foreach($city_state as $asdf){
    if($asdf!==""){
        array_push($clean_city_states, $asdf);
    }
}
$city_and_state = explode(',', $clean_city_states[1]);
if(sizeof($city_and_state) < 2) {
    $city_and_state = explode(',', $clean_city_states[2]);
}
$state = trim($city_and_state[1]);
$city = trim($city_and_state[0]);
if ($VERBOSE > 0) echo ", " . $city;
if ($VERBOSE > 0) echo ", " . $state;
// ---------------------------------------------------------------------------------------

if ($VERBOSE > 0) echo ", " . $size;
// ---------------------------------------------------------------------------------------
    
// deal with industries that we created above ^^;
$exploded = explode(",", str_replace("<br/>", ",",str_replace("\t", "", str_replace("\n", "", $industries)) ));
$clean_industries = array();
foreach($exploded as $explosion){
    array_push($clean_industries, html_entity_decode(rtrim(  ltrim(preg_replace('/(\s)+/', ' ', $explosion)) )) ); # replace all multi-whitespace substrings with a single whitespace. trim whitespace from left and right. (leaves white space in "Shipping & Distribution")
}
if ($VERBOSE > 0) echo ", " . implode(", ", $clean_industries) . "\r\n";    
// ---------------------------------------------------------------------------------------

    fputcsv($fp, explode(",",ob_get_clean()) );
    get_company_image_from_string($name, $J);
    $J++;
    if($J % 10){
        sleep(rand(5, 10));
    }
    echo "<li>" . $J . ":" . $this_to_parse . "<br>";
    #break;
}}
fclose($fp);
echo "<h1>Now you should check <b>top_200_industries.csv<b></h1>";
exit();
      
?>