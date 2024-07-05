<?php
include_once('DbConfig.php');
$con=new DbConfig();
$orderno=$_POST['itemno'];
$name=$_POST['itemname'];
$quantity=$_POST['itemquantity'];
$price=$_POST['itemvalue'];
$insert=$con->connection->query("INSERT into orderitems value('','$orderno','$name','$quantity','$price')");
?>