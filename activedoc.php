<?php
include_once('DbConfig.php');
$con=new DbConfig();
$docid=$_POST['id'];
$docusername=$_POST['username'];
$update=$con->connection->query("UPDATE signup set active='1' where id='$docid'");
$insert=$con->connection->query("INSERT into status values('','$docusername','on')");
$to = $docusername;
$subject = "Verification status";
$message = "<h2 style='color:green'>Verification status</h2>";
$message .= "<h1><span style='color:green'>Congratulations!</span> , Your profile verification on 'WeCare' has been approved.</h1>";
$header .= "Content-type: text/html\r\n";
$retval = mail ($to,$subject,$message,$header);
?>