<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

// connection (mit mexikanischem Akzent bitte `:)`)
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

session_start();

$nutzer_id = $_SESSION["nutzer_id"]; 

$sql = "SELECT w.split, w.zeit
FROM workout w
INNER JOIN (
    SELECT split, MAX(zeit) AS max_zeit
    FROM workout
    GROUP BY split
) latest_workouts ON w.split = latest_workouts.split AND w.zeit = latest_workouts.max_zeit
INNER JOIN nutzer_workout nw ON w.workout_id = nw.workout_id
INNER JOIN nutzer n ON nw.nutzer_id = n.nutzer_id
WHERE n.nutzer_id = ?
ORDER BY w.zeit DESC;";


$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die(json_encode(["error" => "Failed to prepare statement"]));
}

// ? ist dann halt die nutzer_id
$stmt->bind_param("i", $nutzer_id);
$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    die(json_encode(["error" => "Query execution failed"]));
}

$data = [];

// aufteilen und formatieren
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

// export als json
echo json_encode($data, JSON_PRETTY_PRINT);

$stmt->close();
$conn->close();

?>
