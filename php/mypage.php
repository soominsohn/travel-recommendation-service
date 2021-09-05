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
 }


    $heart_get = "SELECT * FROM heart WHERE heart_id='$id_num' ORDER BY trip_num";
    $myheart_result=mysqli_query($mysqli, $heart_get);

    
    $trip1_query="SELECT h.place_name, p.new_address, p.img_url1 FROM (SELECT * FROM heart WHERE trip_num=1) as h JOIN place AS p WHERE h.place_name=p.place_name;";
    $trip2_query="SELECT h.place_name, p.new_address, p.img_url1 FROM (SELECT * FROM heart WHERE trip_num=2) as h JOIN place AS p WHERE h.place_name=p.place_name;";
    $trip3_query="SELECT h.place_name, p.new_address, p.img_url1 FROM (SELECT * FROM heart WHERE trip_num=3) as h JOIN place AS p WHERE h.place_name=p.place_name;";
       
    $result1=mysqli_query($mysqli, $trip1_query);
    $result2=mysqli_query($mysqli, $trip2_query);
    $result3=mysqli_query($mysqli, $trip3_query);


?>
<h1><b>YOUR TRIP PLAN</b></h1>
    <button class="misc_btn" width="300px" onclick="location.href='modify_trip.php'"><b><i>Plan your trip HERE!</i></b></button>
</p>

<?php
if(isset($_POST['id_num']))
{ 
  $user_num=$_POST['id_num'];
}?>

<div class="trip_block" style="background-color: #E7F1F3">
    <h2>TRIP #1</h2>
    <table style="background-color: transparent; color: black; margin: 10px 10px; border-spacing:5px; text-align: center"><tr>
<?php 
       $t1=0;
       while ($row1=mysqli_fetch_array($result1)){
         echo '<td style="background-color: #F9F9F4; padding: 20px 40px">';
         echo '<img src='.$row1['img_url1'].' width=200px><br>';
         echo $row1['place_name'].'<br><p style="font-size:80%; opacity: 0.8">'.$row1['new_address'].'</td>';
         $t1++;
         if ($t1%3 ==0) echo '</tr><tr>';
      }
?></tr></table></div>
<div class="trip_block" style="background-color: #DCEAEE">
    <h2>TRIP #2</h2>
    <table style="background-color: transparent; color: black; margin: 10px 10px; border-spacing:5px; text-align: center"><tr>
<?php 
       $t2=0;
       while ($row2=mysqli_fetch_array($result2)){
         echo '<td style="background-color: #F9F9F4; padding: 20px 40px">';
         echo '<img src='.$row2['img_url1'].' width=200px><br>';
         echo $row2['place_name'].'<br><p style="font-size:80%; opacity: 0.8">'.$row2['new_address'].'</p></td>';
         $t2++;
         if ($t2%3 ==0) echo '</tr><tr>';
      } 
?></tr></table></div>
<div class="trip_block" style="background-color: #D6E5E9">
    <h2> TRIP #3</h2>
    <table style="background-color: transparent; color: black; margin: 10px 10px; border-spacing:5px; text-align: center"><tr>
<?php 
       $t3=0;
       while ($row3=mysqli_fetch_array($result3)){
         echo '<td style="background-color: #F9F9F4; padding: 20px 40px">';
         echo '<img src='.$row3['img_url1'].' width=200px><br>';
         echo $row3['place_name'].'<br><p style="font-size:80%; opacity: 0.8">'.$row3['new_address'].'</td>';
         $t2++;
         if ($t3%3 ==0) echo '</tr><tr>';
      } 
?></tr></table></div></p>



</body>
</html>


