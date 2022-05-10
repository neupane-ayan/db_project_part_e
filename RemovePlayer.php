#RON PRESCOTT: rpresco3, AYAN NEUPANE: aneupan1

<h2> Removed a player
</h2>
<body>
<?php
    include 'open.php';

    $stmt = $conn->prepare("DELETE FROM Player WHERE playerID = ? AND sport = ?");
    $stmt->bind_param("ss", $playerID, $sport);

    $playerID = $_POST['playerID'];
    $sport = $_POST['sport'];
    $stmt->execute();

    $conn->close();
?>
</body>