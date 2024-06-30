<?php
// Datenbankverbindungsparameter
$servername = "localhost"; // oder 127.0.0.1
$username = "root";
$password = "";
$dbname = "fitness";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

header("Content-Type: application/json");
// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage, um zeit und split aus der Tabelle workout abzurufen
$sql = "SELECT zeit, split FROM workout;";
$result = $conn->query($sql);

$data = [];

echo "<script>console.log('" . addslashes($result) . "');</script>";

if ($result->num_rows > 0) {
    // Ausgabe der Ergebnisse
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode(["message" => "Keine Ergebnisse gefunden."]);
    exit();
}

// Ausgabe als JSON
echo json_encode($data);

// Verbindung schließen
$conn->close();
?>
