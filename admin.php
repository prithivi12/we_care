<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="nav.css">
        <script type="text/javascript" src="adminkey.js"></script>
    </head>
    <body>
        <?php include('nav.php')?>
    </body>
    <script>
        var person = prompt("Get back !!!");
        if(new AdminKey(person).checkKey()){

        }
        else{
            window.location.assign('index.php');
        }
    </script>
</html>