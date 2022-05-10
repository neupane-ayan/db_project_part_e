#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2>Average GDP for metro-areas that have at least [number] of championships<body>
<?php
    include 'open.php';
    $numChmp = $_POST['numChmp'];
    $dataPoints = array();
    $aQuery = "CALL Procedure14('".$numChmp."');";
    if ($result = mysqli_query($conn, $aQuery)) {
       echo "<table border=\"2px solid black\">";

          // output a row of table headers
	      echo "<tr>";
	      // collect an array holding all attribute names in $result
	      $flist = $result->fetch_fields();
          // output the name of each attribute in flist
	      foreach($flist as $fname){
	         echo "<th>".$fname->name."</th>";
	      }
	      echo "</tr>";

          // output a row of table for each row in result, using flist names
          // to obtain the appropriate attribute value for each column
	      foreach($result as $row){

              // reset the attribute names array
    	      $flist = $result->fetch_fields(); 
	          echo "<tr>";
	          foreach($flist as $fname){
                      echo "<td>".$row[$fname->name]."</td>";
              }
  	          echo "</tr>";
	      }
	      echo "</table>";
	      foreach($result as $row){
              array_push($dataPoints, array("label"=> $row["metroAreaName"], "y"=> $row["avggdp"]));
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
var nChmp = <?php echo $numChmp; ?>; 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: "Average GDP for metro-areas that have at least " + nChmp  + " championships"
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