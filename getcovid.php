<?php
include_once('DbConfig.php');
$con=new DbConfig();
require_once 'simplehtmldom_1_9_1/simple_html_dom.php';
$url = "https://kathmandupost.com/covid19";
$internalErrors = libxml_use_internal_errors(true);
  $content = file_get_contents($url);
  //Contructs a DOM from the $content
  $dom = new DOMDocument('1.0', 'UTF-8');
  $dom->loadHTML($content);
  $i=0;
  $j=0;
  $result=array();
  $answer=array();
//collect all user’s reviews into an array
  foreach($dom->getElementsByTagName('td') as $ptag)
{
  $answer[$i]=$ptag->nodeValue;
  $i++;
}
for($i=0;$i<sizeof($answer);$i+=5){
  $name=$answer[$i];
  $confirmed=$answer[$i+1];
  $deaths=$answer[$i+2];
  $recovered=$answer[$i+3];
  $insert=$con->connection->query("UPDATE data set name='$name',confirmed='$confirmed',deaths='$deaths',recovered='$recovered' where name='$name'");
  $j++;
}
?>
<script>
window.location.assign("covid.php");
</script>