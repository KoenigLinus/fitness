<?php
session_start();

if (!isset($_SESSION["nutzer_id"])) {
    header("Location: login.html");
    exit();
}

require_once "config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$nutzer_id = $_SESSION["nutzer_id"];

$split = $_POST["split"];
$exercises = $_POST["exercises"];
$setsArray = $_POST["sets"];
$repsArray = $_POST["reps"];
$weightArray = $_POST["weight"];

$sql = "INSERT INTO workout (split, zeit) VALUES (?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $split);

if ($stmt->execute()) {
    $workout_id = $stmt->insert_id;

    // Beziehung zw. Nutzer und Workout in `nutzer_workout` einfügen
    $sql_nutzer_workout =
        "INSERT INTO nutzer_workout (nutzer_id, workout_id) VALUES (?, ?)";
    $stmt_nutzer_workout = $conn->prepare($sql_nutzer_workout);
    $stmt_nutzer_workout->bind_param("ii", $nutzer_id, $workout_id);
    if (!$stmt_nutzer_workout->execute()) {
        echo "Fehler: " . $stmt_nutzer_workout->error;
        $stmt_nutzer_workout->close();
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt_nutzer_workout->close();

    for ($i = 0; $i < count($exercises); $i++) {
        $exercise_id = $exercises[$i];
        $sets = $setsArray[$i];
        $reps = $repsArray[$i];
        $weight = $weightArray[$i];

        // Insert directly into the workout_übungen table
        $sql3 =
            "INSERT INTO workout_übungen (workout_id, übung_id, reps, sets, gewicht) VALUES (?, ?, ?, ?, ?)";
        $stmt4 = $conn->prepare($sql3);
        $stmt4->bind_param(
            "iiiii",
            $workout_id,
            $exercise_id,
            $reps,
            $sets,
            $weight
        );

        if (!$stmt4->execute()) {
            echo "Fehler: " . $stmt4->error;
        }
        $stmt4->close();
    }
    echo "Workout erfolgreich eingetragen!";
    header("Location: index.php");
    exit();
} else {
    echo "Fehler: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
