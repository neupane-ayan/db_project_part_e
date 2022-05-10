#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2>The gdp and averageHouse price of any metro-areas having at least [number] of hall-of-fame caliber players the same year
</h2>
<body>
<?php
    include 'open.php';
    $numHoF = $_POST['numHoF'];
    $aQuery = "CALL Procedure12(".$numHoF.");";
    $dataPoints = array();
    $dataPoints2 = array();
    if ($result = mysqli_query($conn, $aQuery)) {
       	foreach($result as $row){
	   $lbl = $row["metroAreaName"].substr($row["year"], 0, 4);
           array_push($dataPoints, array("label"=> $lbl, "y"=> $row["gdp"]));
	   array_push($dataPoints2, array("label"=> $lbl, "y"=> $row["averageHousePrice"]));
	}      
    }
    else {
         echo "<h2> ERROR: QUERY FAILED </h2>";
    }
    //close the connection opened by open.php since we no longer need access to dbase
    $conn->close();
?>
</body>


<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
var numHoF = <?php echo $numHoF; ?>;  
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "GDP of metro-areas having at least " +numHoF+ " hall-of-fame caliber players the same year"
	},
	axisY: {
	        includeZero: true,
		title: "GDP in Millions of $USD"
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title: {
                text: "Average house price of metro-areas having at least " +numHoF+ " hall-of-fame caliber players the same year\
"
        },
        axisY: {
	        includeZero: true,
                title: "avg house price in thousands of $USD"
        },
        data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
});
chart2.render(); 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 420px; width: 100%;"></div>
<br>
<div id="chartContainer2" style="height: 420px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>

