<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Check if nutzer_id session variable is set
session_start();
if (!isset($_SESSION["nutzer_id"])) {
    // If nutzer_id is not set, return an error message
    header("Content-Type: application/json");
    echo json_encode(["error" => "Session not authenticated"]);
    exit(); // Stop script execution
}

// Extract user ID from session
$nutzer_id = $_SESSION["nutzer_id"];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to fetch splits and times for the user's latest workouts
$sql = "
SELECT w.split, w.zeit, n.f_name, n.l_name
FROM workout w
JOIN nutzerapp_workout nw ON w.workout_id = nw.workout_id
JOIN nutzerapp na ON na.nutzerapp_id = nw.nutzer_app_id
JOIN nutzer_nutzerapp nn ON nn.nutzerapp_id = na.nutzerapp_id
JOIN nutzer n ON n.nutzer_id = na.nutzer_id
WHERE n.nutzer_id = ?
AND (w.split, w.workout_id) IN (
    SELECT split, MAX(workout_id)
    FROM workout
    GROUP BY split
)
ORDER BY w.workout_id DESC;
";

//WHERE (split, workout_id) IN (SELECT split, MAX(workout_id) FROM workout GROUP BY split) ORDER BY workout_id DESC;

//$sql = "SELECT split, zeit FROM workout WHERE (split, workout_id) IN (SELECT split, MAX(workout_id) FROM workout GROUP BY split) ORDER BY workout_id DESC;";

// Prepare statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die(json_encode(["error" => "Failed to prepare statement"]));
}

// Bind parameter and execute statement
$stmt->bind_param("i", $nutzer_id); // "i" for integer, assuming nutzer_id is an integer
$stmt->execute();

// Get result
$result = $stmt->get_result();

$data = [];

// Fetch results into associative array
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "Split" => $row["split"],
        "Zeit" => $row["zeit"],
        "User" => $row["f_name"] . " " . $row["l_name"],
        "UserID" => $nutzer_id,
    ];
}

// Check if there are results
if (empty($data)) {
    // Fetch user name and ID for the error message
    $stmt_user = $conn->prepare(
        "SELECT f_name, l_name FROM nutzer WHERE nutzer_id = ?"
    );
    $stmt_user->bind_param("i", $nutzer_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user = $result_user->fetch_assoc();

    // Set error message with user information
    $data["error"] =
        "No workouts found for user: " .
        $user["f_name"] .
        " " .
        $user["l_name"];
}

// Output JSON data
echo json_encode($data);

// Close statements and connection
$stmt->close();
if (isset($stmt_user)) {
    $stmt_user->close();
}
$conn->close();

?>
