#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $pID = $_POST['playerID'];
    $spt = $_POST['sport'];
    $aQuery = "SELECT * FROM Player WHERE playerID = '".$pID."' AND sport = '".$spt."';";

    $result = mysqli_query($conn, $aQuery);
    if (mysqli_num_rows($result) > 0) {
       echo "<h2> Player already exists! Try Again </h2>";
    } else {
       echo "<h2> Successfully added a player! </h2>";
       $stmt = $conn->prepare("INSERT INTO Player (playerID, sport, playerName, hallOfFame) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("sssi", $playerID, $sport, $playerName, $hallOfFame);

       $playerID = $_POST['playerID'];
       $sport = $_POST['sport'];
       $playerName = $_POST['playerName'];
       $hallOfFame = $_POST['hallOfFame'];
       $stmt->execute();
    }

    $conn->close();
?>
</body>