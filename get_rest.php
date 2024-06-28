<?php
// Datenbankverbindung herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Zufällige Zahl zwischen 45,3 und 76,4 generieren
$min = 45.3;
$max = 76.4;
$randomNumber = rand($min * 10, $max * 10) / 10;
echo "Random Number: " . $randomNumber . "<br>";

// Splits vom letzten Workout in JSON ausgeben
$sql = "SELECT split FROM workout ORDER BY workout_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ausgabe der Daten jeder Zeile
    while ($row = $result->fetch_assoc()) {
        $lastWorkoutSplit = $row["split"];
    }
    $jsonOutput = json_encode(
        ["lastWorkoutSplit" => $lastWorkoutSplit],
        JSON_PRETTY_PRINT
    );
    echo "Last Workout Split in JSON format:<br>" . $jsonOutput;
} else {
    echo "0 results";
}

$conn->close();
?>
