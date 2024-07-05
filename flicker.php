<?php
require_once 'flickr/phpFlickr.php';
$search=$_REQUEST['search'];
$api='744923fa1c140b23f51094e9ebea72fc';
$secret='7ebca60756046bcd';
$flickr=new phpFlickr($api,$secret,true);
$photo=$flickr->photos_search(array('text' => $search,'per_page' => '50','content_type' => '1'));
echo json_encode($photo["photo"]);
?>