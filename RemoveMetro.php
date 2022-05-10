#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include = 'open.php';
    $mname = $_POST['metroAreaName'];
    $yr = $_POST['year']."-01-01";
    $aQuery1 = "SELECT * FROM MetroArea WHERE metroAreaName = '".$mname."' AND `year` = '".$yr."';";
    $aQuery2 = "SELECT * FROM Team WHERE metroAreaName = '".$mname."';";

    $result1 = mysqli_query($conn, $aQuery1);
    $result2 = mysqli_query($conn, $aQuery2);
    if (mysqli_num_rows($result2) > 0) {
       echo "<h2> Must remove/update all teams in this metro area first </h2>";
    } else if (mysqli_num_rows($result1) > 0) {
       echo "<h2> Metro Area successfully removed! </h2>";
       $stmt = $conn->prepare("DELETE FROM MetroaArea WHERE metroAreaName = ? AND `year` = ?");
       $stmt->bind_param("ss", $metroAreaName, $year);

       $metroAreaName = $_POST['metroAreaName'];
       $year = $_POST['year']."-01-01";
       $stmt->execute();
    } else {
       echo "<h2> Metro Area data not recorded this year! </h2>";
    }

    $conn->close();
?>
</body>