<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="team10.css?after" type="text/css"/>
<link href="http://fonts.googleapis.com/earlyaccess/notosanskr.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
$id=$_POST['my_id'];
$pw=$_POST['my_password'];

$mysqli=mysqli_connect("localhost", "team10", "team10", "team10");
if (!$mysqli){
	die("Connection failed: ".mysqli_connect_error());
}

$check="SELECT * FROM user WHERE user_id='$id'";
$result=$mysqli-> query($check);   

/*password check*/
$num=mysqli_num_rows($result);
if($num==1){
	$row=mysqli_fetch_array($result);
	if($row['user_pw']==$pw){
		$_SESSION['id']=$id;
		if(isset($_SESSION['id'])){
		echo "<script> alert('Login successful!.');
			location.replace('home.php')</script>";

		}
		else{
		echo"error";
		}
	}
	else{
	echo "<script> alert('Wrong ID or Password! Please try again.');</script>";
	echo "<script> location.href='login.html' </script>";
	}
}
else{
	echo "<script> alert('Wrong ID or Password! Please try again.');</script>";
	echo "<script> location.href='login.html' </script>";
}
?>
</body>
</html>

