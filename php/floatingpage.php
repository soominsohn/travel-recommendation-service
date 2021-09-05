<?php
error_reporting(0);
$conn=mysqli_connect('localhost','team10','team10','team10');

date_default_timezone_set("Asia/Seoul");
$areaname = $_GET["area_name"];
echo $bigname1;
$district = $_GET["realname"];
$day = $_GET["day"];
$dateString = date("Y-m-d", time());
$thistime =date("H");
echo $thistime;
echo $dateString;
$weekString = array("일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일");
$today = $weekString[date('w', strtotime($dateString))];
echo $today;


$sql = "SELECT day, SUM(number) as NUM FROM floating WHERE district='$district' GROUP BY day ORDER BY day_num";

$sql2 = "SELECT DISTINCT hour, district, SUM(number) OVER (PARTITION BY hour ROWS BETWEEN 1 PRECEDING AND 1 FOLLOWING) AS NUM FROM floating WHERE day ='$day' AND district='$district'";

$sql3 = "SELECT hour, district, SUM(number) as NUM FROM floating WHERE day ='$today' AND hour='$thistime' GROUP BY district ORDER BY NUM desc";

$result=mysqli_query($conn,$sql);
$result2=mysqli_query($conn,$sql2);
$result3=mysqli_query($conn,$sql3);

//그래프 그리기위한 data들 array에 저장
$dataPoints = array();

  while($row=mysqli_fetch_assoc($result)){
   array_push($dataPoints, array("label"=> $row['day'], "y"=> $row['NUM']));
};


$dataPoints2=array();
  while($row2=mysqli_fetch_assoc($result2)){
    array_push($dataPoints2, array("label"=> $row2['hour'], "y"=> $row2['NUM']));
  }



  $dataPoints3 = array();
    while($row3=mysqli_fetch_assoc($result3)){
     array_push($dataPoints3, array("label"=> $row3['district'], "y"=> $row3['NUM']));
  };
  ?>


  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title>connect to db</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="design2.css">
    <style>
  			p { margin:20px 0px; }
  		</style>


<!-- graph 그리기위한 function -->
      <script>
    window.onload = function ()  {

      var chart1 = new CanvasJS.Chart("chartContainer1", {
        title: {
          text: "Floating Population in a week"
        },
        axisY: {
          title: "number of floating 인구"
        },
        data: [{
          type: "line",
          dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
      });

      var chart2 = new CanvasJS.Chart("chartContainer2", {
      	title: {
      		text: "Floating Population in 24 hour"
      	},
      	axisY: {
      		title: "number of floating population"
      	},
      	data: [{
      		type: "line",
      		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
      	}]
      });


      var chart3 = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Congestion chart in Seoul Now"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	}]
});
      chart1.render();
      chart2.render();
      chart3.render();
    }


      </script>

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

  </head>


  <body>

    <div class="container">
      <div class="information_now">

<!-- 현재시작 가장 혼잡한 구 확인-->
<?php


$sqlnow ="SELECT district,rank() over(order by SUM(number) desc) as district_rank FROM floating WHERE day ='$today' AND hour=$thistime GROUP BY district ORDER BY district_rank LIMIT 3";
$result4=mysqli_query($conn,$sqlnow);
echo $dateString." ";
echo $today." ";
 echo $thistime.":00 's ";
 ?> <h5>TOP3 Congestion District Now</h5>
 <div class="graph">
   <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
 </div><?php
?><div class="ranking_now">

<?php
   while($row4=mysqli_fetch_assoc($result4)){
     echo "<br>";
     echo "TOP".$row4['district_rank'].": ";
     echo $row4['district'];
     ?>
     <?php

   }?>

</div>


      </div>

<!-- 구 선택하기. -->
      <div class="ranking">
    <form id = "form" name ="form" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="select_area">
          <input class="btn1" type="submit" name="area_name" value="도심권">
          <input class="btn1" type="submit" name="area_name" value="서남권">
          <input class="btn1" type="submit" name="area_name" value="서북권">
          <input class="btn1" type="submit" name="area_name" value="동남권">
          <input class="btn1" type="submit" name="area_name" value="동북권">
      </div>
    </form>
<!-- 선택된 구의 가장 혼잡한 요일 확인하기. -->
    <form id="form1" name="form1" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <div class="district">
                  <select name = "realname">
                  <?php
                  $result=mysqli_query($conn,'SELECT DISTINCT district_name FROM district  JOIN area on district.area_id = area.area_id WHERE area_name="'.$areaname.'"');
                  while($row=mysqli_fetch_assoc($result)) {
                  ?>
                  <option value= "<?php echo $row['district_name']; ?>"><?php echo $row['district_name']; ?></option>
                  <?php

                }
                  ?>
                  </select>
                  <input class="btn2" type="submit" value="혼잡요일 확인하기 ">
                </div>


  <div class="container">
      <div class="graph">


    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>

<!-- 선택된 구의 가장 혼잡한 요일 TOP3 ranking. -->
    <div class="saysome"><?php echo $district?>'s TOP 3 CONGESTION DAY :  <?php
    $sqll = "SELECT day,rank() over(order by SUM(number) desc) as day_rank FROM floating WHERE district='$district' GROUP BY day ORDER BY day_rank LIMIT 3";

    $resultt=mysqli_query($conn,$sqll);
      while($roww=mysqli_fetch_assoc($resultt)){
        echo "<br>";
        echo "TOP".$roww['day_rank'].": ";
        echo $roww['day'].' ';

      };
    ?>
</div>
</div>
</div>
</div>


<br> <br>
<!-- 구 선택하는 form. -->
<div class="ranking">
    <form id = "form" name ="form" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="select_area">
        <input class="btn1" type="submit" name="area_name" value="도심권">
        <input class="btn1" type="submit" name="area_name" value="서남권">
        <input class="btn1" type="submit" name="area_name" value="서북권">
        <input class="btn1" type="submit" name="area_name" value="동남권">
        <input class="btn1" type="submit" name="area_name" value="동북권">
      </div>

    </form>
    <form id="form2" name="form2" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >

             <div class="district">
                  <select name = "realname">
                 <?php

                $result=mysqli_query($conn,'SELECT DISTINCT district_name FROM district JOIN area on district.area_id = area.area_id WHERE area_name="'.$areaname.'"');
                  while($row=mysqli_fetch_assoc($result)) {
                  ?>
              <option value= "<?php echo $row['district_name']; ?>"><?php echo $row['district_name']; ?></option>
                  <?php
                }
                  ?>
                </select>
<!-- 선택된 구의 요일 선택 -> 가장 혼잡한 시각 확인 가능. -->
                    <div class="area">
                        <input class="btn1" type="radio" name="day" value="월요일">월요일
                        <input class="btn1" type="radio" name="day" value="화요일">화요일
                        <input class="btn1" type="radio" name="day" value="수요일">수요일
                        <input class="btn1" type="radio" name="day" value="목요일">목요일
                        <input class="btn1" type="radio" name="day" value="금요일">금요일
                        <input class="btn1" type="radio" name="day" value="토요일">토요일
                        <input class="btn1" type="radio" name="day" value="일요일">일요일
                      </div>

                  <input class="btn2" type="submit" value="Find congestion hour">


  </div>
  <div class="graph">
    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

    <div class="saysome"><?php echo $district?>'s TOP 3 CONGESTION DAY IN <?php echo $day?>   <?php
    $sql6 = "SELECT hour,rank() over(order by SUM(number) desc) as hour_rank FROM floating WHERE district='$district' and day='$day' GROUP BY hour ORDER BY hour_rank LIMIT 3";

    $result6=mysqli_query($conn,$sql6);
      while($row6=mysqli_fetch_assoc($result6)){
        echo '<br>';
        echo 'TOP'.$row6['hour_rank'].': ';

        echo  $row6['hour'].'시';


      };

    ?>
</div>
  </div>

  <?php

  echo "";

  ?>

</div>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    </div>



  </body>
  </html>








?>
