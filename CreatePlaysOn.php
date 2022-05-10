#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $pID = $_POST['playerID'];
    $spt = $_POST['sport'];
    $tmname = $_POST['teamName'];
    $yr = $_POST['year']."-01-01";
    $aQuery1 = "SELECT * FROM PlaysOn WHERE playerID = '".$pID."' AND sport = '".$spt."' AND teamName = '".$tmname."' AND `year` = '".$yr."';";
    $aQuery2 = "SELECT * FROM Player WHERE playerID = '".$pID."' AND sport = '".$spt."';";
    $aQuery3 = "SELECT * FROM Team WHERE teamName = '".$tmname."' AND sport = '".$spt."';";
    $aQuery4 = "SELECT * FROM MetroArea WHERE `year` = '".$yr."';";

    $result1 = mysqli_query($conn, $aQuery1);
    $result2 = mysqli_query($conn, $aQuery2);
    $result3 = mysqli_query($conn, $aQuery3);
    $result4 = mysqli_query($conn, $aQuery4);
    if (mysqli_num_rows($result1) > 0) {
       echo "<h2> Player is already registered on this team that year </h2>";
    } else if (mysqli_num_rows($result3) == 0) {
       echo "<h2> Invalid Team! Try Again </h2>";
    } else if (mysqli_num_rows($result4) == 0) {
       echo "<h2> Invalid Year! Try Again </h2>";
    } else {
       echo "<h2> Successful player registration! </h2>";
       $stmt = $conn->prepare("INSERT INTO PlaysOn (playerID, sport, teamName, `year`) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("ssss", $playerID, $sport, $teamName, $year);

       $playerID = $_POST['playerID'];
       $sport = $_POST['sport'];
       $teamName = $_POST['teamName'];
       $year = $_POST['year']."-01-01";
       $stmt->execute();

       if (mysqli_num_rows($result2) == 0) {
          $stmt2 = $conn->prepare("INSERT INTO Player (playerID, sport, playerName, hallOfFame) VALUES (?, ?, ?, ?)");
	  $stmt2->bind_param("sssi", $playerID, $sport, $playerName, $hallOfFame);

	  $playerId = $_POST['playerID'];
	  $sport = $_POST['sport'];
	  $playerName = $_POST['playerName'];
	  $hallOfFame = 0;
	  $stmt2->execute();
       }
    }

    $conn->close();
?>
</body>