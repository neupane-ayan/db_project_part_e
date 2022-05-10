#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $pID = $_POST['playerID'];
    $spt = $_POST['sport'];
    $tmname = $_POST['teamName'];
    $yr = $_POST['year']."-01-01";
    $aQuery1 = "SELECT * FROM PlaysOn WHERE playerID = '".$pID."' AND sport = '".$spt."' AND teamName = '".$tmname."' AND `year` = '".$yr."';";
    $aQuery2 = "SELECT * FROM PlaysOn WHERE playerID = '".$pID."' AND sport = '".$spt."';";
    $aQuery3 = "SELECT * FROM Team WHERE teamName = '".$tmname."' AND sport = '".$spt."';";
    $aQuery4 = "SELECT * FROM MetroArea WHERE `year` = '".$yr."';";

    $result1 = mysqli_query($conn, $aQuery1);
    $result2 = mysqli_query($conn, $aQuery2);
    $result3 = mysqli_query($conn, $aQuery3);
    $result4 = mysqli_query($conn, $aQuery4);
    if (mysqli_num_rows($result3) == 0) {
       echo "<h2> Invalid Team! Try Again </h2>";
    } else if (mysqli_num_rows($result4) == 0) {
       echo "<h2> Invalid Year! Try Again </h2>";
    } else if (mysqli_num_rows($result1) > 0) {
       echo "<h2> Player successfully unregistered! </h2>";
       $stmt = $conn->prepare("DELETE FROM PlaysOn WHERE playerID = ? AND sport = ? AND teamName = ? AND `year` = ?");
       $stmt->bind_param("ssss", $playerID, $sport, $teamName, $year);
       
       $playerID = $_POST['playerID'];
       $sport = $_POST['sport'];
       $teamName = $_POST['teamName'];
       $year = $_POST['year']."-01-01";
       $stmt->execute();
       
       if (mysqli_num_rows($result2) == 1) {
          $stmt2 = $conn->prepare("DELETE FROM Player WHERE playerID = ? AND sport = ?");
	  $stmt2->bind_param("ss", $playerID, $sport);

	  $playerID = $_POST['playerID'];
	  $sport = $_POST['sport'];
	  $stmt2->execute();
       }
    } else {
       echo "<h2> Player not registered on this team this year! Try again </h2>";
    }

    $conn->close();
?>
</body>