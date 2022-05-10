#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2> Average GDP of championship winning Metro-Areas every year</h2>
<body>
<?php
    include 'open.php';
    $aQuery = "CALL Procedure3ALL();";

    $dataPoints = array();
    if ($result = mysqli_query($conn, $aQuery)) {
        foreach($result as $row){
           $lbl = substr($row["year"], 0, 4);
           array_push($dataPoints, array("x"=> $lbl, "y"=> $row["avg(gdp)"]));

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
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Average GDP of championship winning teams"
	},
	axisY: {
		title: "GDP in Millions of $USD"
	},
	data: [{
		type: "spline",
		markerSize: 5,
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
