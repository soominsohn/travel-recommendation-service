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
 } ?>

<?php
    $district_query="SELECT * FROM district";
    $cat_big_query="SELECT * FROM cat_big";

    $result_district=mysqli_query($mysqli, $district_query);
    $result_cat_big=mysqli_query($mysqli, $cat_big_query);
?>


<div class="color_block" style="text-align: center; margin: 50px 100px; padding: 50px">
<form method="post" action="add_place_action.php">

<div><p id="add_place"><b><i>PLACE NAME&nbsp&nbsp</i></b>
<input type="text" name="place_name" class="loginbox"></p></div>

<div><p id="add_place"><b><i>PLACE ADDRESS&nbsp&nbsp</i></b>
<input type="text" name="address" class="loginbox"></p></div>

<div><p id="add_place"><b><i>구&nbsp&nbsp</i></b>
<select name="district" class="selectbox"></p></div>
<?php
while($row=mysqli_fetch_array($result_district)) {
    echo '<option value="'.$row['district_id'].'">'.$row['district_name'].'</option>';
}
?></select>

<div><p id="add_place"><b><i>분류&nbsp&nbsp</i></b>
<select name="cat_big" class="selectbox"></p></div>
<?php
while($row=mysqli_fetch_array($result_cat_big)) {
    echo '<option value="'.$row['id'].'">'.$row['cat_big'].'</option>';
}
?></select>

<div><p id="cat_spec"><b><i>상세분류&nbsp&nbsp</i></b>
<input type="text" name="cat_spec" class="loginbox"></p></div>

<div><p id="add_place"><b><i>TAG&nbsp&nbsp</i></b>
<input type="text" name="tag" class="loginbox"></p></div>

<div><p id="add_place"><b><i>IMG URL 1&nbsp&nbsp</i></b>
<input type="text" name="img_url1" class="loginbox"></p></div>

<div><p id="add_place"><b><i>IMG URL 2&nbsp&nbsp</i></b>
<input type="text" name="img_url2" class="loginbox"></p></div>

<br><button class="misc_btn" onclick="placerecommend.php"><b><i>ADD place</i></b></button>
</form>
</div>
</body>
</html>
