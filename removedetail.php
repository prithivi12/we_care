<?php
include_once("DbConfig.php");
$con=new DbConfig();
$eventid=$_POST['id'];
$type=$_POST['type'];
$insert=$con->connection->query("DELETE from $type where id='$eventid'");
?>