<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="team10.css?after" type="text/css"/>
<link href="http://fonts.googleapis.com/earlyaccess/notosanskr.css" rel="stylesheet">
</head>
<body>
<?php
    $mysqli=mysqli_connect("localhost", "team10", "team10", "team10");
      session_start(); 
         
      if(isset($_SESSION['id'])) { ?>
      <p align="right" style="font-size:20px; color:black"> 
     <button class="misc_btn" onclick="location.href='home.php'">HOME</button> 
     <button class="misc_btn" onclick="location.href='mypage.php'">MYPAGE</button>
     <button class="misc_btn" onclick="location.href='logout.php'">LOGOUT</button></p>
     <?php
      $id=$_SESSION['id'];
      $id_num_query="SELECT user_num FROM user WHERE user_id='$id'";
      $id_result =mysqli_fetch_array(mysqli_query($mysqli, $id_num_query));
      $id_num=$id_result['user_num'];
    }
    else {
      echo "<script> alert('로그인해주세요.');
      location.replace('login.html')</script>";
 } 

$place_name=$_POST['place_name'];
$address=$_POST['address'];

$district=$_POST['district'];
$cat_big=$_POST['cat_big'];

$cat_spec=$_POST['cat_spec'];
$tag=$_POST['tag'];
$img_url1=$_POST['img_url1'];
$img_url2=$_POST['img_url2'];


if($place_name==NULL|| $address==NULL|| $district==NULL|| $cat_big==NULL|| $cat_spec==NULL|| $tag==NULL|| $img_url1==NULL|| $img_url2==NULL)
{
	echo "<script> alert('Fill up all the blanks.');</script>";
	echo "<script> location.href='add_place.php' </script>";
	exit();
}

$mysqli=mysqli_connect("localhost", "team10","team10", "team10");
$add_query= "INSERT INTO place (place_name, new_address, cat_big_id, cat_spec,tag,img_url1,img_url2, district_id) VALUES ('$place_name', '$address', $cat_big, '$cat_spec', '$tag', '$img_url1', '$img_url2', $district)";
$do_query=mysqli_query($mysqli, $add_query);

if($do_query) {
    echo '<div style="background-color: #E6F1F3; text-align: center; padding: 50px 100px">';
    echo 'Thank you!<br><br>';
    echo '<img src="'.$img_url1.'" width="200px">';
    echo '<img src="'.$img_url2.'" width="200px"><br>';
    echo '<p align="center"><b>'.$place_name.'</b><br>';
    echo $address.'</p>';
    echo '<script>alert("New place is added to the table successfully!");</script>';   
?>
<button class="misc_btn" onclick="location.href='home.php'"><b>HOME</b></button><br></div>
<?php
}
?>

</body>
</html>
