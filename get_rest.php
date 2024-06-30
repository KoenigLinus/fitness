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

// Splits vom letzten Workout in JSON ausgeben
$sql = "SELECT split, zeit FROM workout ORDER BY workout_id DESC;";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "Split" => $row["split"],
            "Zeit" => $row["zeit"],
        ];
    }
} else {
    $data["error"] = "0 results";
}

// Output JSON data
echo json_encode($data);
//echo json_encode($data, JSON_PRETTY_PRINT);

// Embed JSON data into JavaScript for logging to the browser console
//echo "<script>console.log(" . json_encode($data) . ");</script>";

$conn->close();
?>
