<?php
require_once "config.php";

// Verbindung zur Datenbank herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

session_start();

// Sicherstellen, dass die Session-Variable gesetzt und gültig ist
if (!isset($_SESSION["nutzer_id"]) || !is_numeric($_SESSION["nutzer_id"])) {
    die(json_encode(["error" => "Nutzer-ID nicht gesetzt oder ungültig"]));
}

$nutzer_id = intval($_SESSION["nutzer_id"]);

// SQL-Abfrage, um die relevanten Daten aus den Tabellen workout und sets abzurufen
$sql = "
    SELECT w.zeit, w.split, (wu.sets * wu.reps * wu.gewicht) AS volumen
    FROM `workout` w
    JOIN `workout_übungen` wu ON wu.workout_id = w.workout_id
    JOIN `nutzer_workout` nw ON nw.workout_id = w.workout_id
    WHERE nw.nutzer_id = ?;";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die(json_encode(["error" => "Vorbereitung der Abfrage fehlgeschlagen"]));
}

$stmt->bind_param("i", $nutzer_id);
$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    die(json_encode(["error" => "Abfrageausführung fehlgeschlagen"]));
}

$data = [];

if ($result->num_rows > 0) {
    // Ausgabe der Ergebnisse und Berechnung des Volumens
    $data[] = [
        "zeit" => $row["zeit"],
        "split" => $row["split"],
        "volumen" => $row["volumen"],
    ];
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
