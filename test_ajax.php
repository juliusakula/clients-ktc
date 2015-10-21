<?php
$response = array();
if(!@$_REQUEST['my_query']){
    $response['success'] = false;
    $response['message'] = "You did not set 'my_query' GET parameter.";
}
else{
    $response['success'] = true;
    $response['message'] = $_REQUEST['my_query'];
}

echo json_encode($response);
?>