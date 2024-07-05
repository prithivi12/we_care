<?php
include_once("DbConfig.php");
$con=new DbConfig();
$id=$_POST['id'];
$insert=$con->connection->query("DELETE from signup where id='$id'");
?>