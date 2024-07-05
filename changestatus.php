<?php
include_once('DbConfig.php');
$con=new DbConfig();
$status=$_POST['stat'];
$docusername=$_POST['username'];
$get=$con->connection->query("SELECT * from status where docusername='$docusername'");
$count=$get->num_rows;
if($count==0){
    $insert=$con->connection->query("INSERT into status values('','$docusername','$status')");
}
else{
    $update=$con->connection->query("UPDATE status SET status='$status' where docusername='$docusername' ");
}
?>