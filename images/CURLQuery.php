<?php
                             
                             
function get_url_contents($company_name) {
    $crl = curl_init();
    $url_company_name = urlencode($company_name);
    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    curl_setopt($crl, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q={$url_company_name}&imgsz=large");
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

    $ret = curl_exec($crl);
    curl_close($crl);
    $data = json_decode($ret);
    $img_urls = array();
    $img_names = array();
    foreach ($data->responseData->results as $result) {
        $img_urls[] = $result->url;
        $img_names[] = "C:/git-lyris/parse-data-dot-com/images/{$company_name}";
        $results[] = array('url' => $result->url, 'alt' => $result->title);
    }
    $url = $img_urls[0];
    $img = "{$img_names[0]}";
    
    file_put_contents($img, file_get_contents($url));
    var_dump($url);
    var_dump($img);
    return $ret;
}

//  $results = get_url_contents("walmart, inc");
//  print_r($results);

?>