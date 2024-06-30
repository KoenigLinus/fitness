<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

// Datenbankverbindung herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Zufällige Zahl zwischen 45,3 und 76,4 generieren
$min = 45.3;
$max = 76.4;
$randomNumber = mt_rand($min * 10, $max * 10) / 10;

// Splits vom letzten Workout in JSON ausgeben
$sql = "SELECT split, zeit FROM workout ORDER BY workout_id DESC;";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data["Split"] = $row["split"];
    $data["Zeit"] = $row["zeit"];
    $data["Rest"] = $randomNumber;
} else {
    $data["error"] = "0 results";
}

echo json_encode($data, JSON_PRETTY_PRINT);

$conn->close();
?>
