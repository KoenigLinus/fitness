<?php
require_once "config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung ok?
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

session_start();

// ist die _SESSION fine?
if (!isset($_SESSION["nutzer_id"]) || !is_numeric($_SESSION["nutzer_id"])) {
    die(json_encode(["error" => "Nutzer-ID nicht gesetzt oder ungültig"]));
}

// nutzer auf der superglobal _SESSION holen
$nutzer_id = intval($_SESSION["nutzer_id"]);

//sql abfrage
$sql = "SELECT w.zeit, w.split, (wu.sets * wu.reps * wu.gewicht) AS volumen
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

// hier werden die results aufgeteilt
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "zeit" => $row["zeit"],
            "split" => $row["split"],
            "volumen" => $row["volumen"],
        ];
    }
} else {
    echo json_encode(["message" => "Keine Ergebnisse gefunden."]);
    exit();
}

header("Content-Type: application/json");
// export als json
echo json_encode($data);

// Verbindung schließen
$conn->close();
?>
