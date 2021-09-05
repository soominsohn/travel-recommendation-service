<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>connect to db</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="design.css">
  <style>
			p { margin:20px 0px; }
		</style>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>

        <script>
            // wait for the DOM to be loaded
            $(document).ready(function() {
                // bind 'myForm' and provide a simple callback function
                $('#myForm').ajaxForm(function() {
                    alert("Thank you for your comment!");
                });
            });
        </script>

        <?php
          session_start();
          if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        ?>
        <p align="right" style="font-size:20px; color:black">
        <button class="misc_btn" onclick="location.href='home.php'">HOME</button>
        <button class="misc_btn" onclick="location.href='mypage.php'">MYPAGE</button>
        <button class="misc_btn" onclick="location.href='logout.php'">LOGOUT</button></p>
        <?php
        } else{
        ?>
        <p align="right" style="font-size:20px; color:black">
        <button class="misc_btn" onclick="location.href='login.html'">LOG-IN</button>
        <button class="misc_btn" onclick="location.href='join.html'">JOIN</button> </p>
        <?php
        }
        ?>

</head>
<body>




<h2>Trip recommending</h2>


<!-- db 연결을 위한 form -->
<?php
  $conn=mysqli_connect('localhost','team10','team10','team10');
  error_reporting(0);
?>
<div class="container">
  <div class="recommend">
<!-- district 목록 뽑아오기 위한 form -->
<form id = "form" name ="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


<div class="select_area">
    <input class="misc_btn" type="submit" name="area_name" value="도심권">
    <input class="misc_btn" type="submit" name="area_name" value="서남권">
    <input class="misc_btn" type="submit" name="area_name" value="서북권">
    <input class="misc_btn" type="submit" name="area_name" value="동남권">
    <input class="misc_btn" type="submit" name="area_name" value="동북권">
  </div>

</form>

<!-- area에 따른 district 출력! -->
<?php
    $areaname = $_POST["area_name"];
    ?>
<form id="form1" name="form1" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
            <div class="district">
              <select name = "district">
              <?php
              $result=mysqli_query($conn,'SELECT DISTINCT district_name FROM district  JOIN area on district.area_id = area.area_id WHERE area_name="'.$areaname.'"');
              while($row=mysqli_fetch_assoc($result)) {
              ?>
              <option value= "<?php echo $row['district_name']; ?>"><?php echo $row['district_name']; ?></option>
              <?php

            }
              ?>
              </select>
            </div>
<!-- 여행 카테고리 선택란. -->
            <div>
                  <div class="col">
                    <p>Choose your trip category!</p>
                    <div class="btn-group-toggle" data-toggle="buttons">
              <?php
              $result2=mysqli_query($conn,'SELECT cat_big FROM cat_big');
              while($row2=mysqli_fetch_assoc($result2)) {
              ?>
              <label class="btn btn-outline-dark">
              <input type="checkbox"  name="bigcategory[]" value="<?php echo $row2['cat_big']; ?>"><?php echo $row2['cat_big']; ?>
              	</label>
              <?php
            }
            ?>
          </div>
        </div>


<input class="misc_btn" type="submit" value="추천 여행지 찾기 ">
<p align="right"></form>
<form method="get" action="add_place.php">
<p align="right">
<button type="submit" class="misc_btn" text-align="center"><i><b>Add more places<br>HERE!</b></i></button></p>
</form>
            </div>
        
      </div>

<?php
	$district = $_POST["district"];
  $bigcategory = $_POST["bigcategory"];
?>


<div>
  <br><br>

  <!-- 여행정보들 출력! -->
<?php

 echo "These are our recommending trip place";
 if (!empty($bigcategory)) {
   foreach ($bigcategory as $value) {
 $result3=mysqli_query($conn,"SELECT * FROM place
join district on district.district_id = place.district_id
join cat_big on cat_big.id = place.cat_big_id
WHERE district_name ='$district' AND cat_big = '$value'");
 while($row3=mysqli_fetch_assoc($result3)) {

   ?> <div class="contents">
     <div class = "row">
       <div class = "column">
     <img id="img" class="img" onerror="this.src='ImageNotFound.jpg'" alt="" width="250" src=<?php
     echo $row3['img_url1'];
     ?>></div>
     <div class="column">

     <div class="title"><?php
     $place_name = $row3['place_name'];
   echo $row3['place_name'];?></div>
   <div class ="cat">category: <?php
   echo $row3['cat_big'].">";
   echo $row3['cat_spec'];
   ?><br><?php
   echo $row3['tag'];
?></div><div class="address"> address: <?php
   echo $row3['new_address'];
   ?></div> <br>

   <form id ="heart" name="heart" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

     <input type = "hidden" value = "<?php echo $place_name;?>" name = "heart_place_name">
     <input class="btn3" type = "submit" name="send_place2" value="heart">

   </form>


     <br>
     <!-- 해쉬태그 출력하기 -->
     <div class="hashtag">hashtag:
     <?php
     $result4=mysqli_query($conn,"SELECT tag FROM user_tag WHERE place_name='$place_name'");
     while($row4=mysqli_fetch_assoc($result4)){
       echo $row4['tag'];
     }
     ?>




<!-- 해쉬태그 clear하기 -->
     <form id ="form6" name="form6" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
       <input type = "hidden" value = <?php echo $place_name;?> name = "delete_district">
       <input class="btn5" type = "submit" name="send_place2" value="clear hashtag">
     </form>

<!-- 해쉬태그 추가하기 -->
<form id="form5" name="form5" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
   <input type"text" name = "new_tag"> plus your hash tag!
   <input type = "hidden" value = <?php echo $place_name;?> name = "my_district">
   <input class="btn4" type="submit" name="send_place" value="plus hashtag">

</form>
</div>

</div>
</div>
</div>
   <br><?php
 }}}
?>

<?php
if(isset($_POST['heart_place_name'])){
$place_name_heart = $_POST['heart_place_name'];
$result6=mysqli_query($conn,"SELECT user_num FROM user WHERE user_id='$id'");
while($row6=mysqli_fetch_assoc($result6)){
  $user_num=$row6['user_num'];
  mysqli_query($conn,"INSERT INTO heart(place_name,heart_id,trip_num) VALUES('$place_name_heart',$user_num,1)");
}

}
?>

<?php
if(isset($_POST['new_tag'])){
$hello = $_POST['new_tag'];
$recvplace= $_POST['my_district'];
$result6 =mysqli_query($conn,"SELECT tag FROM user_tag where place_name='$recvplace'");
while($row=mysqli_fetch_assoc($result6)){
$new_tag = $row['tag']." #".$hello;


mysqli_query($conn,"UPDATE user_tag SET tag = '$new_tag' where place_name='$recvplace'");

}}
?>

<?php

if(isset($_POST['delete_district'])){
$recvplace= $_POST['delete_district'];
echo "clear all hashtags";
mysqli_query($conn,"DELETE FROM user_tag where place_name='$recvplace'");
mysqli_query($conn,"INSERT INTO user_tag VALUES('$recvplace',null)");
mysqli_query($conn,"COMMIT");
}
?>



</div>


<br>
<br>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
