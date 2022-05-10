#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $numTeams = $_POST['numTeams'];
    $aQuery = "CALL Procedure4('".$numTeams."');";
    echo "<h1>Metro-Areas have at least ".$numTeams." teams with at least a 50% win percentage each year (gdp, average house price and population)</h1><br>";
    $dataPoints = array();
    $dataPoints2 = array();
    $dataPoints3 = array();
    if ($result = mysqli_query($conn, $aQuery)) {
       	foreach($result as $row){
	   $lbl = $row["metroAreaName"].substr($row["year"], 0, 4);
           array_push($dataPoints, array("label"=> $lbl, "y"=> $row["gdp"]));
	   array_push($dataPoints2, array("label"=> $lbl, "y"=> $row["averageHousePrice"]));
	   array_push($dataPoints3, array("label"=> $lbl, "y"=> $row["population"]));
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
var numTeams = <?php echo $numTeams; ?>;  
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "GDP"
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
                text: "Average House Price"
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
var chart3 = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title: {
                text: "Population"
        },
        axisY: {
                includeZero: true,
                title: "avg house population in thousands of people"
        },
        data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        }]
});
chart3.render();
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<br>
<div id="chartContainer2" style="height: 300px; width: 100%;"></div>
<br>
<div id="chartContainer3" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>