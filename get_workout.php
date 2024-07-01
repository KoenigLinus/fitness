<?php
session_start();

// Assuming user_id is stored in session
if (!isset($_SESSION["nutzer_id"])) {
    echo json_encode(["message" => "User ID not set in session."]);
    exit();
}

$nutzer_id = $_SESSION["nutzer_id"];

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

// SQL-Abfrage, um zeit und split aus der Tabelle workout für den spezifischen user_id abzurufen
$sql = "SELECT zeit, split FROM workout WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $nutzer_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

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
header("Content-Type: application/json");
echo json_encode($data);

// Verbindung schließen
$conn->close();
?>
