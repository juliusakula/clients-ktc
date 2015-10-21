<?php
include('images/CURLQuery.php');
$name = $_REQUEST['name'];
$id = $_REQUEST['id'];
get_company_image_from_string($name, $id);

?>