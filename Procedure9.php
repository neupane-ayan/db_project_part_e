#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2>Average gdp and population for each metro-area along with how many teams they have</h2>
<body>
<?php
    include 'open.php';
    $metroAreaName = $_POST['metroAreaName'];
    $aQuery = "CALL Procedure9('".$metroAreaName."');";
    
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
    }
    else {
         echo "<h2> ERROR: QUERY FAILED </h2>";
    }
    //close the connection opened by open.php since we no longer need access to dbase
    $conn->close();
?>
</body>