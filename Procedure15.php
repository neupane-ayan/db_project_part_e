#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<?php
    include 'open.php';
    $aQuery = "CALL Procedure15()";
    $dataPoints = array();
    if ($result = mysqli_query($conn, $aQuery)) {
       	foreach($result as $row){
           array_push($dataPoints, array("label"=> $row["sport"], "y"=> $row["avg(gdp)"]));
    	}      
    }
    else {
         echo "<h2> ERROR: QUERY FAILED </h2>";
    }
    //close the connection opened by open.php since we no longer need access to dbase
    $conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Compare average metro-area GDP of NHL champions, NBA champions, NFL champions and MLB champions"
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
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>   