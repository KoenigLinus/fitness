<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$nutzer_id = $_SESSION["nutzer_id"] ?? null; 

// Debuggin war mein Leben 
if (!$nutzer_id) {
    die("User ID not found in session.");
}

$sql = "SELECT gewicht, datum
        FROM nutzerapp
        JOIN nutzer_nutzerapp ON nutzerapp.nutzerapp_id = nutzer_nutzerapp.nutzerapp_id
        WHERE nutzer_nutzerapp.nutzer_id = ?
        ORDER BY datum ASC"; 

// ganz ganz viel debugging

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $nutzer_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Get result failed: " . $stmt->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "gewicht" => $row["gewicht"],
        "datum" => $row["datum"],
    ];
}

$stmt->close();
$conn->close();

header("Content-Type: application/json");
//export as json - toll
echo json_encode($data);
?>
