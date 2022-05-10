#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $tmname = $_POST['teamName'];
    $spt = $_POST['sport'];
    $mtr = $_POST['metroAreaName'];
    $aQuery1 = "SELECT * FROM Team WHERE teamName = '".$tmname."' AND sport = '".$spt."';";
    $aQuery2 = "SELECT * FROM MetroArea WHERE metroAreaName = '".$mtr."';";

    $result1 = mysqli_query($conn, $aQuery1);
    $result2 = mysqli_query($conn, $aQuery2);
    if (mysqli_num_rows($result1) > 0) {
       echo "<h2> Team already exists! Try again </h2>";
    } else {
       if (mysqli_num_rows($result2) > 0) {
       	  echo "<h2> Successfully added a team! </h2>";
          $stmt = $conn->prepare("INSERT INTO Team (teamName, sport, metroAreaName) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $teamName, $sport, $metroAreaName);

          $teamName = $_POST['teamName'];
          $sport = $_POST['sport'];
          $metroAreaName = $_POST['metroAreaName'];
          $stmt->execute();
       } else {
	  echo "<h2> Metro Area not registered! Try again </h2>";
       }
    }

    $conn->close();
?>
</body>