<?php
include_once('DbConfig.php');
$con=new DbConfig();
$d=date('Y-m-d H:i:s');
if(isset($_POST['accept'])){
    $id=$_POST['id'];
    $accept=$con->connection->query("UPDATE booking SET active='1' where id='$id'");
    $user=$con->connection->query("select username from booking where id='$id'")->fetch_assoc()["username"];
    $notif=$con->connection->query("insert into notifications values('','$user','Appointment Accepted!','','$d' )");
}
else if(isset($_POST['reject'])){
    $id=$_POST['id'];
    $user=$con->connection->query("select username from booking where id='$id'")->fetch_assoc()["username"];
    $reject=$con->connection->query("DELETE from booking where id='$id'");
    $notif=$con->connection->query("insert into notifications values('','$user','Appointment Denied!','','$d' )");
}
?>