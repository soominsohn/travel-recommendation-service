<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="team10.css?after" type="text/css"/>
<link href="http://fonts.googleapis.com/earlyaccess/notosanskr.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
$res=session_destroy();
if($res){
	echo "<script> location.href='home.php' </script>";
}
?>
</body>
</html>