<?php
// Datenbankverbindungsparameter
$servername = "localhost"; // oder 127.0.0.1
$username = "root";
$password = "";
$dbname = "fitness";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage, um die relevanten Daten aus den Tabellen workout und sets abzurufen
$sql = "
    SELECT w.zeit, w.split, s.reps, s.gewicht, (s.reps * s.gewicht) AS volumen
    FROM workout w
    JOIN sets s ON w.workout_id = s.workout_id
";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    // Ausgabe der Ergebnisse und Berechnung des Volumens
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode(["message" => "Keine Ergebnisse gefunden."]);
    exit();
}

// Ausgabe als JSON
header("Content-Type: application/json");
echo json_encode($data);

// Verbindung schließen
$conn->close();
?>
