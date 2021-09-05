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

<?php
  session_start();
  if(isset($_SESSION['id'])){
?>
<p align="right" style="font-size:20px; color:black"> 
<button class="misc_btn" onclick="location.href='home.php'">HOME</button>
<button class="misc_btn" onclick="location.href='mypage.php'">MYPAGE</button>
<button class="misc_btn" onclick="location.href='logout.php'">LOGOUT</button></p>
<?php
} else{
?>
<p align="right" style="font-size:20px; color:black">
<button class="misc_btn" onclick="location.href='home.php'">HOME</button>
<button class="misc_btn" onclick="location.href='login.html'">LOG-IN</button>
<button class="misc_btn" onclick="location.href='join.html'">JOIN</button> </p>
<?php
}
?>
<h2> <b>team10</b> </h2>
</head>


<body>
<table class="home_table">
<?php
$mysqli=mysqli_connect("localhost", "team10", "team10", "team10");?>

<tr>
<td rowspan=3>
<form method="get">
<div class="container1">
  <img src="seoul_map/서울.png" style="width: 700px">
  <button class="btn" style="top: 44%; left: 38%; width: 150px; height: 250px" type="submit" name="area" value="서북권"><mark>서북권</mark></button>
  <button class="btn" style="top: 50%; left: 55%; width: 120px; height: 200px" type="submit" name="area" value="도심권"><mark>도심권</mark></button>
  <button class="btn" style="top: 35%; left: 70%; width: 170px; height: 300px" type="submit" name="area" value="동북권"><mark>동북권</mark></button>
  <button class="btn" style="top: 75%; left: 35%; width: 300px; height: 150px" type="submit" name="area" value="서남권"><mark>서남권</mark></button>
  <button class="btn" style="top: 77%; left: 75%; width: 300px; height: 150px" type="submit" name="area" value="동남권"><mark>동남권</mark></button>

</div></form>
<?php
$x=0;
$y=0;
$area_name="";


if(isset($_GET['area'])) {
  $area_name=$_GET['area'];
  $x=1;
}

echo '</td></tr><br> <tr><td><div style="text-align: left; padding: 30px 50px">';

/*기본화면 많은순 5개*/

$rank_query="SELECT district_name, rank, num FROM (SELECT district_id, COUNT(*) as num, rank() over (ORDER BY num DESC) as rank from place GROUP BY cat_big_id) AS c JOIN district AS d ON c.district_id=d.district_id ORDER BY num DESC LIMIT 5";
$rank_result=$mysqli->query($rank_query);

if($x==0) {
echo '<h2> !!TOP 5!! </h2><br>';
while( $rank_row=mysqli_fetch_array($rank_result)){
   echo '('.$rank_row['rank'].')  '.$rank_row['district_name'].'   '.$rank_row['num'].'개<br>';
}
}

//권역별로 
$query="SELECT * FROM district WHERE area_id=(SELECT area_id FROM area WHERE area_name='$area_name')";
$dis_result=$mysqli->query($query);
echo '<h2>'.$area_name.'</h2>';
echo '<div style="text-align: right; float: right"><form action ="placerecommend.php" method="post">';
echo '<input type="submit" class="btn_dis" name="btn1" value="More Places!"></form>';
echo '<form action ="floatingpage.php" method="post">';
echo '<input type="submit" class="btn_dis" name="btn2" value="Check Congestion"></form>';
?>

<form method="post">
<?php
while ($row=mysqli_fetch_array($dis_result)){
  echo '<button class="btn_dis" type="submit" name="district" value="'.$row['district_id'].'">'.$row['district_name'].'</button>';
 }
?>
</div></td></tr>
</form>
<tr>
<td>
<div style="text-align: left; padding: 30px 50px">
<?php
$district_id ="";
$y=0;
if(isset($_POST['district'])) {
  $district_id=$_POST['district'];
  $y=1;
}

if($y==1) {
$query_dis = "SELECT cat_big_id, COUNT(*) as num FROM place WHERE district_id=$district_id GROUP BY cat_big_id";
$cat_result=mysqli_query($mysqli, $query_dis);
$count_query= "SELECT COUNT(*) as tot FROM place WHERE district_id=$district_id";
$count=mysqli_fetch_array(mysqli_query($mysqli, $count_query));
$tot=$count['tot'];

$cat_big_row="";

  while ($row=mysqli_fetch_array($cat_result)){
    $cat_query="SELECT cat_big FROM cat_big WHERE id=$row[cat_big_id]";
    $cat_big_row=mysqli_fetch_array(mysqli_query($mysqli, $cat_query));
    echo '<b>'.$cat_big_row['cat_big'].'</b>        '.$row['num'].'<br>';
  }
   echo '<h2>TOTAL:'.$tot.'</h2>';
}
?>

</div>
</td>
</tr>
</table>
</body>
</html>