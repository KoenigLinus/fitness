<?php
session_start();
if(isset($_SESSION["user_id"])){
    require_once("config.php");
   // header("location: nutzer_app_data.php");
}

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}


$split = $_POST['split'];
$exercises = $_POST['exercises'];
$setsArray = $_POST['sets'];
$repsArray = $_POST['reps'];
$weightArray = $_POST['weight'];

$sql = "INSERT INTO workout (split, zeit) VALUES (?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $split);

if ($stmt->execute()) {
    $workout_id = $stmt->insert_id;

    for ($i = 0; $i < count($exercises); $i++) {
        $exercise_id = $exercises[$i];
        $sets = $setsArray[$i];
        $reps = $repsArray[$i];
        $weight = $weightArray[$i];

        $sql = "INSERT INTO sets (reps, gewicht) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("ii", $reps, $weight);

        if ($stmt2->execute()) {
            $sets_id = $stmt2->insert_id;

            $sql2 = "INSERT INTO übungen_sets (übung_id, sets_id) VALUES (?, ?)";
            $stmt3 = $conn->prepare($sql2);
            $stmt3->bind_param("ii", $exercise_id, $sets_id);

            if (!$stmt3->execute()) {
                echo "Fehler: " . $stmt3->error;
            }
            $stmt3->close();
        } else {
            echo "Fehler: " . $stmt2->error;
        }
        $stmt2->close();


        $sql3 = "INSERT INTO workout_übungen (workout_id, übung_id) VALUES (?, ?)";
        $stmt4 = $conn->prepare($sql3);
        $stmt4->bind_param("ii", $workout_id, $exercise_id);

        if (!$stmt4->execute()) {
            echo "Fehler: " . $stmt4->error;
        }
        $stmt4->close();
    }
    echo "Workout erfolgreich eingetragen!";
} else {
    echo "Fehler: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>



