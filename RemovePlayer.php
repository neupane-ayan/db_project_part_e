#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2> Removed a player
</h2>
<body>
<?php
    include 'open.php';
    $pID = $_POST['playerID'];
    $spt = $_POST['sport'];
    $aQuery = "SELECT * FROM Player WHERE playerID = ".$pID." AND sport = ".spt.";";
    
    if ($result = mysqli_query($conn, $aQuery)) {
       echo "<h2> Player successfully removed! </h2>";
       $stmt = $conn->prepare("DELETE FROM Player WHERE playerID = ? AND sport = ?");
       $stmt->bind_param("ss", $playerID, $sport);

       $playerID = $_POST['playerID'];
       $sport = $_POST['sport'];
       $stmt->execute();
    } else {
       echo "<h2> Player does not exist! </h2>";
    }

    $conn->close();
?>
</body>