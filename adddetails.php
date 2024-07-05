<?php
include_once('DbConfig.php');
$con=new DbConfig();
$username=$_POST['username'];
$type=$_POST['type'];
$text=$_POST['text'];
$insert=$con->connection->query("INSERT into $type value('','$username','$text')");
?>