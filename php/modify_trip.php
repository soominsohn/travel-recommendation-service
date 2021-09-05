<html>
<head>

<link rel="stylesheet" href="team10.css?after" type="text/css"/>

<style>
mark {
   background-color: #D5E0E3;
   color: black;
   opacity: 0.8;
   padding: 3px 3px;
}
</style>

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

<div style="background-color: #D8E9EE; font-size: 16px; margin: 50px; padding: 100px 250px; text-align: center">
<?php
$flag=0;
?>
<p align="center">
<?php

    $my_heart_query= "SELECT place_name FROM heart WHERE heart_id=$id_num";
    $my_result = mysqli_query($mysqli, $my_heart_query);
    $op_val = 0;
if ($flag == 0) {
    echo '<form method="post">';
    echo '<b><i>PLACE NAME&nbsp&nbsp&nbsp</i></b><select name ="place_name" class ="selectbox">';
    while ($my_row=mysqli_fetch_array($my_result)) {
      echo '<option value="'.$my_row['place_name'].'">'.$my_row['place_name'].'</option>';    
    }
    echo '</select><br><b><i>TRIP#&nbsp&nbsp&nbsp</i></b><select name = "trip_num" class ="selectbox">';
    for ($i=1; $i<=3; $i++) {    
       echo '<option value="'.$i.'">'.$i.'</option>'; }
    echo '</select><br><br>';
    echo '<button type="submit" class="misc_btn" name="modify"><i>MODIFY</i></button></form>';

   if(isset($_POST['modify'])) {
    $place_change=$_POST['place_name'];
    $trip_num_change=$_POST['trip_num'];
    $query="UPDATE heart SET trip_num='$trip_num_change' WHERE place_name='$place_change'";
    $do_query = mysqli_query($mysqli, $query);
    if($do_query) {
        echo '<div style="background-color: #F5F5F1; padding: 10px 20px">';
        echo 'Place Name:&nbsp&nbsp'.$place_change.'<br>Trip #&nbsp&nbsp'.$trip_num_change;
        echo '<script>alert("Change applied successfully.");</script>';
    }
  }
} 

?>





</div>
</body>
</html>