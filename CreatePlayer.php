#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2> Add a new player
</h2>
<body>
<?php
    include 'open.php';

    $stmt = $conn->prepare("INSERT INTO Player (playerID, sport, playerName, hallOfFame) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $playerID, $sport, $playerName, $hallOfFame);

    $playerID = $_POST['playerID'];
    $sport = $_POST['sport'];
    $playerName = $_POST['playerName'];
    $hallOfFame = $_POST['hallOfFame'];
    $stmt->execute();

    $conn->close();
?>
</body>