<?php
// Establish database connection (replace with your own connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
/*
if (!isset($_GET["nutzer_id"]) || !is_numeric($_GET["nutzer_id"])) {
    die(json_encode(["error" => "Invalid or missing nutzer_id"]));
}*/

//var_dump($_SESSION);

session_start();

$nutzer_id = $_GET["nutzer_id"]; // Assuming nutzer_id is passed as a GET parameter

echo "Nutzer ID: " . $nutzer_id . "<br>";

$sql = "SELECT workout.split, workout.zeit
        FROM workout
        INNER JOIN nutzer_workout ON workout.workout_id = nutzer_workout.workout_id
        INNER JOIN nutzer ON nutzer_workout.nutzer_id = nutzer.nutzer_id
        WHERE nutzer.nutzer_id = ?;";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die(json_encode(["error" => "Failed to prepare statement"]));
}

$stmt->bind_param("i", $nutzer_id);
$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    die(json_encode(["error" => "Query execution failed"]));
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "Split" => $row["split"],
        "Zeit" => $row["zeit"],
    ];
}

if (empty($data)) {
    die(
        json_encode([
            "error" => "No workouts found for user with ID: " . $nutzer_id,
        ])
    );
}

echo json_encode($data, JSON_PRETTY_PRINT);

$stmt->close();
$conn->close();

?>
