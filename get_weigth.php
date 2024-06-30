<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nutzer_id = $_SESSION["nutzer_id"]; // Assuming the user ID is stored in the session

$sql = "SELECT gewicht, datum FROM nutzerapp
        JOIN nutzer_nutzerapp ON nutzerapp.nutzerapp_id = nutzer_nutzerapp.nutzerapp_id
        WHERE nutzer_nutzerapp.nutzer_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $nutzer_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

header("Content-Type: application/json");
echo json_encode($data);
?>
