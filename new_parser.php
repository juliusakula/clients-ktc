<?php
include('simple_dom_html.php');

#echo $RAW_html;
ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes !http://stackoverflow.com/a/5164954/3100494

$main_html = new simple_html_dom();
$main_html->load_file('top_200_links.html');

// Find the exact thing -- the links! (each row of the CSV) ------------------------------
$i =0;
$links = array();
foreach($main_html->find('tr > td > a') as $ele){
    global $links;
    $str = $ele->href;
    #echo $str;
    array_push($links, $str);
    $i++; 
}

var_dump($links);


exit();
$url = "http://connect.data.com/company/view/j0a9ZHSox7aucMJDFh9Gfw/wal-mart-stores";
$html = new simple_html_dom();
$dom = $html->load_file($url);
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
echo $industries;

?>