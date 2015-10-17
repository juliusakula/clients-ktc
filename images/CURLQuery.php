<?php
function getFileType($file){
    $path_chunks = explode("/", $file);
    $thefile = $path_chunks[count($path_chunks) - 1];
    $dotpos = strrpos($thefile, ".");
    return strtolower(substr($thefile, $dotpos + 1));
}
                             
function get_company_image_from_string($company_name, $row_number) {
    $crl = curl_init();
    $url_company_name = urlencode($company_name. " logo");
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
        $img_names[] = "C:/git-lyris/parse-data-dot-com/images/{$row_number}";
        $results[] = array('url' => $result->url, 'alt' => $result->title);
        
        $url = $result->url;
        $ftype = getFileType($url);
        #echo $ftype;
        $img = "C:/git-lyris/parse-data-dot-com/images/{$row_number}.{$ftype}";
        
        echo $url;
        #echo $img;
        if(strpos($url, "https") < 0 || strpos($ftype, "svg") < 0 || strpos($ftype, "f30352") < 0){
            continue;
        }
        else if(strpos($ftype, "jpg") >= 0 || strpos($ftype, "png") >= 0 || strpos($ftype, "gif") >= 0){
            try {
                echo "<-downloading..\n";
                if(file_put_contents($img, file_get_contents($url))){
                    break;
                }
                else{
                    continue;
                }
            }
            catch (Exception $e){
                continue;
            }
        }
        else{
            continue;
        }
    }
    #var_dump($url);
    #var_dump($img);
    return $ret;
}

//  $results = get_url_contents("walmart, inc");
//  print_r($results);

?>