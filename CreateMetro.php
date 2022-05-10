#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<body>
<?php
    include 'open.php';
    $mname = $_POST['metroAreaName'];
    $yr = $_POST['year']."-01-01";
    $aQuery = "SELECT * FROM MetroArea WHERE metroAreaName = '".$mname."' AND `year` = '".$yr."';";

    $result = mysqli_query($conn, $aQuery);
    if (mysqli_num_rows($result) > 0) {
       echo "<h2> Metro Area already exists! Try Again </h2>";
    } else {
       echo "<h2> Successfully added a metro area! </h2>";
       $stmt = $conn->prepare("INSERT INTO MetroArea (metroAreaName, `year`, gdp, averageHousePrice, population) VALUES (?, ?, ?, ?, ?)");
       $stmt->bind_param("ssddd", $metroAreaName, $year, $gdp, $averageHousePrice, $population);

       $metroAreaName = $_POST['metroAreaName'];
       $year = $_POST['year']."-01-01";
       $gdp = $_POST['gdp'];
       $averageHousePrice = $_POST['averageHousePrice'];
       $population = $_POST['population'];
       $stmt->execute();
    }

    $conn->close();
?>
</body>