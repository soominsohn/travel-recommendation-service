﻿<!DOCTYPE html>
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
$pwc=$_POST['my_password2'];
$name=$_POST['my_name'];

if($pw!=$pwc){
	echo "<script> alert('Password check error. Please try again.');</script>";
	echo "<script> location.href='join.html' </script>";
	exit();
}

if(strlen($pw)<7||strlen($pw)>12){
	echo "<script> alert('Please check the length.');</script>";
	echo "<script> location.href='join.html' </script>";
	exit();
}

if($id==NULL|| $pw==NULL|| $name==NULL){
	echo "<script> alert('Fill up all the blanks.');</script>";
	echo "<script> location.href='join.html' </script>";
	exit();
}

$mysqli=mysqli_connect("localhost", "team10","team10", "team10");
$check ="SELECT * FROM user WHERE user_id='$id'";
$result=$mysqli->query($check);
$num=mysqli_num_rows($result);
if($num==1){
	echo "<script> alert('Oops! Someone is already using the id! Please enter again.');</script>";
	echo "<script> location.href='join.html' </script>";
	exit();
}
$password=$pw;
$query="INSERT INTO user (user_id, user_pw, user_nick) VALUES('".$id."', '".$password."', '".$name."')";
$signup=mysqli_query($mysqli, $query);
if($signup){
	echo "<script> alert('Member join successful!');</script>";
	echo "<script> location.href='home.php' </script>";
}
?>
</body>
</html>