#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $tmname = $_POST['teamName'];
    $spt = $_POST['sport'];
    $aQuery = "SELECT * FROM Team WHERE teamName = '".$tmname."' AND sport = '".$spt."';";

    $result = mysqli_query($conn, $aQuery);
    if (mysqli_num_rows($result) > 0) {
       echo "<h2> Team successfully removed! </h2>";
       $stmt = $conn->prepare("DELETE FROM Team WHERE teamName = ? AND sport = ?");
       $stmt->bind_param("ss", $teamName, $sport);

       $teamName = $_POST['teamName'];
       $sport = $_POST['sport'];
       $stmt->execute();
    } else {
       echo "<h2> Team does not exist! </h2>";
    }

    $conn->close();
?>
</body>