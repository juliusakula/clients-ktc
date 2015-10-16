<?php
# !http://stackoverflow.com/a/260609/3100494
# Simple DOM HTML
include('simple_dom_html.php');
ob_start();
include('top_200_links.html');
// Create DOM from that copypasta
$RAW_html = ob_get_clean();

#echo $RAW_html;
ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes !http://stackoverflow.com/a/5164954/3100494

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
$test_link = "http://connect.data.com" . $links[0];

echo $test_link;
$J = 0;
    if($J <= -1){
    $html = new simple_html_dom();
    $this_to_parse = "https://connect.data.com" . $test_link;
    echo $this_to_parse . "\n";
    
    // DO NOT DDOS THESE PPL. Have been blacklisted from my home IP. As if there's no way around that, but still a P.I.T.A
    $rand_seconds = rand(2, 13); // 2 to 13 second delay between requests. 1-10 is just as arbitrary
    sleep($rand_seconds);
    $dom = $html->load_file($this_to_parse);
    if (!empty($dom)){
        #echo "Loaded file!<br>";
    }                                                                                           

    // Find the exact thing -- industries array --------------------------------------------
    $i =0;
    $industries = '';
    foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'5\') > .seo-company-label') as $ele){
        global $industries;
        $str = $ele->innertext;
        if($str == "Industries"){
            $industries = $html->find('.seo-company-info > table > tbody tr:nth-child(5) > .seo-company-data', $i)->innertext;
            
        }
        echo $str;
        $i++; 
    }
#    echo $industries;
    $exploded = explode(",", str_replace("<br/>", ",",str_replace("\t", "", str_replace("\r\n", "", $industries)) ));
    $clean_industries = array();
    foreach($exploded as $explosion){
        array_push($clean_industries, rtrim(ltrim(preg_replace('/(\s)+/', ' ', $explosion)) ) ); # replace all multi-whitespace substrings with a single whitespace. trim whitespace from left and right. (leaves white space in "Shipping & Distribution")
    }
    var_dump($clean_industries);
    
    }
exit();        


# --
#ob_start();
$J = 0;
foreach($links as $link){
    if($J <= -1){
    $html = new simple_html_dom();
    $this_to_parse = "https://connect.data.com" . $link;
    echo $this_to_parse . "\n";
    
    // DO NOT DDOS THESE PPL. Have been blacklisted from my home IP. As if there's no way around that, but still a P.I.T.A
    $rand_seconds = rand(2, 13); // 2 to 13 second delay between requests. 1-10 is just as arbitrary
    sleep($rand_seconds);
    $dom = $html->load_file($this_to_parse);
    if (!empty($dom)){
        #echo "Loaded file!<br>";
    }                                                                                           

    // Find the exact thing -- industries array --------------------------------------------
    $i =0;
    $industries = '';
    foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'5\') > .seo-company-label') as $ele){
        global $industries;
        $str = $ele->innertext;
        // Print it!
        #print_r( "Industry " .$i . ": {$str}\n");
        if($str == "Industries"){
            $industries = $html->find('.seo-company-info > table > tbody tr:nth-child(5) > .seo-company-data', $i)->innertext;
            
        }
        $i++; 
    }
    echo $industries;

    $exploded = explode(",", str_replace("<br/>", ",",str_replace("\t", "", str_replace("\r\n", "", $industries)) ));
    $clean_industries = array();
    foreach($exploded as $explosion){
        #if(strpos($explosion, "<br") ){
            #echo "Yes.<br>";
        #}
        #echo "`" .$explosion . "`<br><br>";
        array_push($clean_industries, rtrim(ltrim(preg_replace('/(\s)+/', ' ', $explosion)) ) ); # replace all multi-whitespace substrings with a single whitespace. trim whitespace from left and right. (leaves white space in "Shipping & Distribution")
    }
    #var_dump($clean_industries);
    // ---------------------------------------------------------------------------------------

    // Find the exact thing -- city and state ------------------------------------------------
    $i =0;
    $location = '';
    foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'5\') > .seo-company-label') as $ele){
        global $location;
        $str = $ele->innertext;
        // Print it!
        if($str == "Headquarters"){
            #print_r($i . ":{$str}<br>");
            $location = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
            
        }
        $i++; 
    }
    #echo $location."<br>";
    $city_state_line = explode('\r\n',preg_replace('/(\s)+/', ' ', $location));
    #var_dump($city_state_line);
    $city_state_line = explode('\r\n', $city_state_line[0]);
    $city_state_line = preg_replace('/(\s)+/', ' ', $city_state_line[0]);
    #echo "<br><li>{$city_state_line}</li><br>";

    # Wow just get it done amiright
    $city_state = explode('  ', $location);
    $clean_city_states = array();
    foreach($city_state as $asdf){
        if($asdf!==""){ # ha
            array_push($clean_city_states, $asdf);
        }
    }
    #var_dump($clean_city_states);
    $city_and_state = explode(',', $clean_city_states[1]);

    if(sizeof($city_and_state) < 2) { #https://connect.data.com/company/view/oQVBQi9vhG_ExgSEbXZJDw/unitedhealth-group ! bug fix for 4 line address
        $city_and_state = explode(',', $clean_city_states[2]);
    }
    
    $state = trim($city_and_state[1]);
    $city = trim($city_and_state[0]);
     #var_dump($state);
     #var_dump($city);
    // ---------------------------------------------------------------------------------------

    // Find the exact thing -- company -------------------------------------------------------
    $i =0;
    $name = '';
    foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'0\') > .seo-company-label') as $ele){
        global $name;
        $str = $ele->innertext;
        // Print it!
        if($str == "Name"){
            #print_r($i . ":{$str}<br>");
            $name = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
            
        }
        $i++; 
    }
     #var_dump($name); 
    // ---------------------------------------------------------------------------------------

    // Find the exact thing -- website -------------------------------------------------------

    $i =0;
    $website = '';
    foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'0\') > .seo-company-label') as $ele){
        global $website;
        $str = $ele->innertext;
        // Print it!
        if($str == "Website"){
            #print_r($i . ":{$str}<br>"); 
            $website = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
            #print_r($i . ":{$website}<br>");
            
        }
        $i++; 
    }
     #var_dump($name); 
    // ---------------------------------------------------------------------------------------

    // Find the exact thing -- size -------------------------------------------------------

    $i =0;
    $size = '';
    foreach($html->find('.seo-company-info > table > tbody tr:nth-child(\'0\') > .seo-company-label') as $ele){
        global $size;
        $str = $ele->innertext;
        // Print it!
        if($str == "Employees"){
            #print_r($i . ":{$str}<br>"); 
            $size = $html->find('.seo-company-info > table > tbody tr:nth-child(3) > .seo-company-data', $i)->innertext;
            #print_r($i . ":{$size}<br>");
        }
        $i++; 
    }
     #var_dump($name); 
    // ---------------------------------------------------------------------------------------
    #company -!, city -!, state -!, size -!, website -!, logo_url, industries -!?
     $i = 0;
     $this_row_csv = array($name, $city, $state, $size, $website);
    foreach($clean_industries as $industry){
        array_push($this_row_csv, $industry);
        $i++;
    }

    echo implode($this_row_csv, ", ") . "\r\n";

    #print_r("state:{$state}<br>city:{$city}<br>name:{$name}");
    #var_dump($clean_industries); # to-do clean the clean_industries more. need to go through each and split it if it has a <br>
    $J++;
}}
#$csv_file = ob_get_clean();

$csv = array_map('str_getcsv', file('log.csv'));

var_dump($csv);
#echo $csv_file;

exit();
?>